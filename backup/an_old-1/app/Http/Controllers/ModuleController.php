<?php

namespace App\Http\Controllers;

use App\Http\traits\ENVFilePutContent;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use ZipArchive;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ModuleController extends Controller
{
    use ENVFilePutContent;

    public function saasInstallStep1()
    {
        return view('addons.saas.index');
    }
    public function saasInstallStep2()
    {
        return view('addons.saas.step_2');
    }
    public function saasInstallStep3()
    {
        return view('addons.saas.step_3');
    }


    public function saasInstallProcess(Request $request)
    {
        $validator = $this->checkValidation($request);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        $isPurchaseVerified = true; //self::purchaseVerify($request->purchasecode);
        if (!$isPurchaseVerified) {
            return redirect()->back()->withErrors(['errors' => ['Wrong Purchase Code !']]);
        }
        $envPath = base_path('.env');
        if (!file_exists($envPath))
            return redirect()->back()->withErrors(['errors' => ['.env file does not exist.']]);
        elseif (!is_readable($envPath))
            return redirect()->back()->withErrors(['errors' => ['.env file is not readable.']]);
        elseif (!is_writable($envPath))
            return redirect()->back()->withErrors(['errors' => ['.env file is not writable.']]);
        else {

            $data = self::fileReceivedFromAuthorServer();

            // $data = [
            //     'isReceived' => true,
            //     'remoteFileName' => 'peopleprosaas.zip',
            // ];

            if(!$data['isReceived']) {
                return redirect()->back()->withErrors(['errors' => ['The file transfer has failed. Please try again later.']]);
            }

            self::fileUnzipAndDeleteManage($data);
            $this->envSetDatabaseCredentials($request);
            self::switchToNewDatabaseConnection();
            self::migrateCentralDatabase();
            self::seedCentralDatabase();

            return redirect('http://'.$request->central_domain.'/saas-install/step-4');

        }
    }


    protected static function checkValidation(Request $request): object
    {
        return Validator::make($request->all(),[
            'purchasecode' => 'required',
            'cpanel_api_key' => 'required',
            'cpanel_username' => 'required',
            'central_domain' => 'required',
            'db_prefix' => 'required',
            'db_host' => 'required',
            'db_port' => 'required',
            'db_name' => 'required',
            'db_username' => 'required',
            'db_password' => 'required',
        ]);
    }

    protected static function purchaseVerify(string $purchaseCode): bool
    {
        $url = 'https://peopleprohrm.com/purchaseverify/';
        $post_string = 'purchasecode='.urlencode($purchaseCode);
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        $object = new \stdClass();
        $object = json_decode(strip_tags($result));
        curl_close($ch);

        return $object->codecheck;
    }

    public function saasInstallStep4()
    {
        return view('addons.saas.step_4');
    }


    // public function index()
    // {

    //     // return 566;
    //     $data = self::fileReceivedFromAuthorServer();
    //     return $data;
    //     // $data = [
    //     //     'isReceived' => true,
    //     //     'remoteFileName' => 'peopleprosaas.zip',
    //     // ];

    //     // if($data['isReceived']) {
    //     //     self::databaseMigrateRollback();

    //     //     self::fileUnzipAndDeleteManage($data);

    //     //     $this->envSetDatabaseCredentials();

    //     //     self::migrateCentralDatabase();

    //     //     self::seedCentralDatabase();
    //     // }

    //     return redirect('http://'.env('CENTRAL_DOMAIN'))->with(['success' => 'Welcome to SaaS Application']);

    // }


    protected static function fileReceivedFromAuthorServer(): array
    {
        $remoteFileURL  = "https://peopleprohrm.com/peopleprosaas.zip";
        $remoteFileName = pathinfo($remoteFileURL)['basename'];
        $localFile = base_path('/'.$remoteFileName);
        $isCopied = copy($remoteFileURL, $localFile);

        return [
            'isReceived' => $isCopied,
            'remoteFileName' => $remoteFileName,
        ];
    }

    protected static function databaseMigrateRollback(): void
    {
        Artisan::call('migrate:rollback --path=database/migrations/modify');
        Artisan::call('migrate:rollback --path=database/migrations/primary');
    }


    protected static function fileUnzipAndDeleteManage(array $data): void
    {
        if ($data['isReceived']) {

            self::baseDirectoryDelete();
            self::baseFileDelete();

            $zip = new ZipArchive;
            self::unzipAndDeleteProcessing($zip, 'vendorSAAS.zip');
            self::unzipAndDeleteProcessing($zip, $data['remoteFileName']);
       }
    }

    protected static function baseDirectoryDelete(): void
    {
        $baseDirectories = [
            'app',
            'bootstrap',
            'config',
            'database',
            'logo',
            'public',
            'resources',
            'routes',
            'storage',
            'tests',
            'track',
            'vendor',
        ];

        foreach ($baseDirectories as $value) {
            $directoryPath = base_path($value);
            File::deleteDirectory($directoryPath);
        }
    }
    protected static function baseFileDelete(): void
    {
        $baseFiles = [
            'README.md',
            'artisan',
            'composer.json',
            'composer.lock',
            'package.json',
            'package-lock.json',
            'phpunit.xml',
            'pint.json',
            'server.php',
            'webpack.mix.js',
            '.editorconfig',
            '.env.example',
            '.gitattributes',
            '.gitignore',
            '.htaccess',
            '.styleci.yml'
        ];

        foreach ($baseFiles as $file) {
            File::delete(base_path("/$file"));
        }
    }

    protected static function unzipAndDeleteProcessing($zip, string $fileName): void
    {
        $file = base_path($fileName);
        $res = $zip->open($file);
        if ($res === TRUE) {
           $zip->extractTo(base_path());
           $zip->close();

           // ****** Delete Zip File ******
           File::delete($file);
        }
    }

    protected function envSetDatabaseCredentials($request): void
    {
        // $this->dataWriteInENVFile('CPANEL_API_KEY', $request->cpanel_api_key);
        // $this->dataWriteInENVFile('CPANEL_USER_NAME', $request->cpanel_username);
        // $this->dataWriteInENVFile('CENTRAL_DOMAIN', $request->central_domain);
        // $this->dataWriteInENVFile('DB_PREFIX', $request->db_prefix);
        // $this->dataWriteInENVFile('DB_CONNECTION', 'peopleprosaas_landlord');
        // $this->dataWriteInENVFile('DB_HOST', $request->db_host);
        // $this->dataWriteInENVFile('DB_PORT', $request->db_port);
        // $this->dataWriteInENVFile('DB_DATABASE', null);
        // $this->dataWriteInENVFile('LANDLORD_DB', $request->db_name);
        // $this->dataWriteInENVFile('DB_USERNAME', $request->db_username);
        // $this->dataWriteInENVFile('DB_PASSWORD', $request->db_password);


        // Testing
        $this->dataWriteInENVFile('CPANEL_API_KEY', 'ZV3SP9ZVBG5F5S5OF812AEHKAZ0NIUBU');
        $this->dataWriteInENVFile('CPANEL_USER_NAME', 'smarthishab');
        $this->dataWriteInENVFile('CENTRAL_DOMAIN', 'peopleprotestsaas.test');
        $this->dataWriteInENVFile('DB_PREFIX', 'saas_');
        $this->dataWriteInENVFile('DB_CONNECTION', 'peopleprosaas_landlord');
        $this->dataWriteInENVFile('DB_HOST', 'localhost');
        $this->dataWriteInENVFile('DB_PORT', '3306');
        $this->dataWriteInENVFile('DB_DATABASE', null);
        $this->dataWriteInENVFile('DB_USERNAME', 'root');
        $this->dataWriteInENVFile('DB_PASSWORD', 'irfan95');
        $this->dataWriteInENVFile('LANDLORD_DB', 'peoplepro_extrem');
    }

    public function switchToNewDatabaseConnection(): void
    {
        DB::purge('mysql');
        // $connection = DB::connection('mysql');
        // $connection->reconnect(); // Reconnect to the new connection
        // $connection->setPdo($connection->getRawPdo());

        Config::set('database.connections.mysql.host', 'localhost');
        Config::set('database.connections.mysql.database', 'peoplepro_extrem');
        Config::set('database.connections.mysql.username', 'root');
        Config::set('database.connections.mysql.password', 'irfan95');
    }

    protected static function migrateCentralDatabase(): void
    {
        Artisan::call('migrate --path=database/migrations/landlord');
    }

    protected static function seedCentralDatabase(): void
    {
        Artisan::call('db:seed');
    }
}





// public function boot(): void
// {
//     if (Schema::hasTable('general_settings')) {
//         $generalSetting = LandlordGeneralSetting::latest()->first();
//         view()->composer([
//             'landlord.public-section.layouts.master',
//             'landlord.public-section.pages.landing-page.index',
//             'landlord.public-section.pages.renew.contact_for_renewal',
//             'landlord.super-admin.pages.dashboard.index',
//             'landlord.super-admin.partials.header',
//             'landlord.super-admin.auth.login',
//             'documentation-landlord.index',
//         ], function ($view) use ($generalSetting) {
//             $view->with('generalSetting', $generalSetting);
//         });
//     }
//     else if(Schema::hasTable('general_settings')) {
//         $general_settings = TenantGeneralSetting::latest()->first();

//         view()->composer([
//             'layout.main',
//         ], function ($view) use ($general_settings) {
//             $view->with('general_settings', $general_settings);
//         });
//     }
// }













// $envPath = base_path('.env');
// $pattern = array(
//     '/CPANEL_API_KEY=.*/i',
//     '/CPANEL_USER_NAME=.*/i',
//     '/CENTRAL_DOMAIN=.*/i',
//     '/DB_PREFIX=.*/i',
//     '/DB_HOST=.*/i',
//     '/LANDLORD_DB=.*/i',
//     '/DB_CONNECTION=.*/i',
//     '/DB_DATABASE=.*/i',
//     '/DB_USERNAME=.*/i',
//     '/DB_PASSWORD=.*/i',
//     '/USER_VERIFIED=.*/i'
// );
// $replace = array(
//     'CPANEL_API_KEY=ZV3SP9ZVBG5F5S5OF812AEHKAZ0NIUBU',
//     'CPANEL_USER_NAME=smarthishab',
//     'CENTRAL_DOMAIN=peopleprotestsaas.test',
//     'DB_PREFIX=saas_',
//     'DB_HOST=localhost',
//     'LANDLORD_DB=peoplepro_extrem',
//     'DB_CONNECTION=peopleprosaas_landlord',
//     'DB_DATABASE=',
//     'DB_USERNAME=root',
//     'DB_PASSWORD=irfan95',
//     'USER_VERIFIED=1');
// file_put_contents($envPath, preg_replace($pattern, $replace, file_get_contents($envPath)));




                // $this->dataWriteInENVFile('CPANEL_API_KEY', 'XYZ');
                // $this->dataWriteInENVFile('CPANEL_USER_NAME', 'LionCoders');
                // $this->dataWriteInENVFile('CENTRAL_DOMAIN', 'peopleprotestsaas.test');
                // $this->dataWriteInENVFile('DB_PREFIX', 'saas_');
                // $this->dataWriteInENVFile('DB_CONNECTION', 'peopleprosaas_landlord');
                // $this->dataWriteInENVFile('DB_HOST', 'localhost');
                // $this->dataWriteInENVFile('DB_PORT', '3306');
                // $this->dataWriteInENVFile('DB_DATABASE', null);
                // $this->dataWriteInENVFile('LANDLORD_DB', $db_name);
                // $this->dataWriteInENVFile('DB_USERNAME', $db_user);
                // $this->dataWriteInENVFile('DB_PASSWORD', $db_password);













