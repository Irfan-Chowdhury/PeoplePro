<?php

namespace App\Http\Controllers;

use App\Http\traits\ENVFilePutContent;
use App\Http\traits\JSONFileTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;


class DeveloperSectionController extends Controller
{
    use ENVFilePutContent, JSONFileTrait;

    public function index()
    {
        if(config('auto_update.product_mode')!=='DEVELOPER'){
            abort(404);
        }
        $general = $this->readJSONData('track/general.json');
        $control = $this->readJSONData('track/control.json');
        return view('developer_section.index',compact('general','control'));
    }

    public function submit(Request $request)
    {
        $general =[
            "product_mode"=> env('PRODUCT_MODE'),
            "version"     => $request->version,
            "bug_no"      => $request->bug_no,
            "minimum_required_version" => $request->minimum_required_version,
        ];

        $this->dataWriteInENVFile('VERSION',$request->version);
        $this->dataWriteInENVFile('BUG_NO',$request->bug_no);

        $control =[
            'version_upgrade'=>[
                'latest_version_upgrade_enable'    => $request->latest_version_upgrade_enable ? true : false,
                'latest_version_db_migrate_enable' => $request->latest_version_db_migrate_enable ? true : false,
                'version_upgrade_base_url'         => $request->version_upgrade_base_url,
            ],
            'bug_update'=>[
                'bug_update_enable'     => $request->bug_update_enable ? true : false,
                'bug_db_migrate_enable' => $request->bug_db_migrate_enable ? true : false,
                'bug_update_base_url'   => $request->bug_update_base_url,
            ]
        ];

        // Write Array in JSON File
        $this->wrtieDataInJSON($general, 'track/general.json');
        $this->wrtieDataInJSON($control ,'track/control.json');


        $this->setSuccessMessage(__('Data Submited Successfully'));
        return redirect()->back();
    }
}


// return
//     [

//         'product_mode' => env('PRODUCT_MODE'),
//         'version' => env('VERSION'),
//         'bug_no' => env('BUG_NO'),
//         'test' => '5',
//     ];
