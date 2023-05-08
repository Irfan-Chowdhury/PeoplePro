<?php

namespace App\Http\Controllers;

use App\Http\traits\AutoUpdateTrait;
use App\Http\traits\ENVFilePutContent;
use App\Http\traits\JSONFileTrait;
use Illuminate\Http\Request;
use Exception;
use ZipArchive;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class ClientAutoUpdateController extends Controller
{
    use ENVFilePutContent, JSONFileTrait, AutoUpdateTrait;

    public function newVersionReleasePage()
    {
        $autoUpdateData = $this->general();
        $getVersionUpgradeDetails = $this->getVersionUpgradeDetails();
        $alertVersionUpgradeEnable = $autoUpdateData['alertVersionUpgradeEnable'];
        return view('version_upgrade.index', compact('getVersionUpgradeDetails','alertVersionUpgradeEnable'));
    }

    // Client
    public function bugUpdatePage()
    {
        $autoUpdateData = $this->general();
        $getBugUpdateDetails = $this->getBugUpdateDetails();
        $bugNotificationEnable = $autoUpdateData['alertBugEnable'];
        return view('bug_update.index', compact('getBugUpdateDetails','bugNotificationEnable'));
    }

    // Action on Client Server
    public function versionUpgrade(Request $request){
        return $this->actionTransfer('version_upgrade');
    }

    // Action apply on Client Server
    public function bugUpdate(Request $request){
        return $this->actionTransfer('bug_update');
    }

    protected function actionTransfer($action_type)
    {
        $track_files_arr = $this->getVersionUpgradeDetails();

        $general = $this->general();
        $track_general_arr = $general['generalData']->general;


        // $track_files_arr   = json_decode(json_encode($request->data), FALSE);
        // $track_general_arr = json_decode(json_encode($request->general), FALSE);

        // return response()->json($track_files_arr);
        // return response()->json($track_general_arr);



        if($action_type =='version_upgrade'){
            $sessionType = 'versionUpgrated';
            $base_url = 'https://peopleprohrm.com/version_upgrade_files/'; //$this->version_upgrade_base_url;
        }else if($action_type == 'bug_update') {
            $sessionType = 'bugUpdated';
            $base_url = 'https://peopleprohrm.com/bug_update_files/'; //$this->bug_update_base_url;
        }


        // Chack all Before Execute
        if ($track_files_arr && $track_general_arr) {
            foreach ($track_files_arr->files as $value) {
                $remote_file_url  = $base_url.$value->file_name;
                $array = @get_headers($remote_file_url);
                $string = $array[0];
                if(!strpos($string, "200")) {
                    return response()->json(['error' => ['Something problem. Please contact with support team.']],404);
                }
            }
        }

        // Start Execute
        try{
            if ($track_files_arr && $track_general_arr) {
                foreach ($track_files_arr->files as $value) {
                    $remote_file_url  = $base_url.$value->file_name;
                    $remote_file_name = pathinfo($remote_file_url)['basename'];
                    $local_file = base_path('/'.$remote_file_name);
                    $copy = copy($remote_file_url, $local_file);
                    if ($copy) {
                        // ****** Unzip ********
                        $zip = new ZipArchive;
                        $file = base_path($remote_file_name);
                        $res = $zip->open($file);
                        if ($res === TRUE) {
                            $zip->extractTo(base_path('/'));
                            $zip->close();

                            // ****** Delete Zip File ******
                            File::delete($remote_file_name);
                        }
                    }
                }

                if($action_type =='version_upgrade'){
                    $this->dataWriteInENVFile('VERSION',$track_general_arr->demo_version);
                }else if($action_type == 'bug_update') {
                    $this->dataWriteInENVFile('BUG_NO',$track_general_arr->demo_bug_no);
                }

                if (($action_type =='version_upgrade' && $track_general_arr->latest_version_db_migrate_enable==true) || ($action_type == 'bug_update' && $track_general_arr->general->bug_db_migrate_enable==true) ){
                    Artisan::call('migrate');
                }
                Artisan::call('optimize:clear');
                Session::put($sessionType, 'success');

                return redirect()->back();
            }
        }
        catch(Exception $e) {
            return response()->json(['error' => [$e->getMessage()]],404);
        }
    }
}
