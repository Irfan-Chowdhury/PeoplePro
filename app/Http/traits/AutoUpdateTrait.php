<?php
namespace App\Http\traits;

use Illuminate\Support\Facades\File;

trait AutoUpdateTrait{

    public function general()
    {
        $demoURL = 'http://localhost/peoplepro/api'; //Demo Link

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $demoURL.'/fetch-data-general',
        ]);
        $response = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($response, false);

        $productMode = $data->general->product_mode;

        $clientVersionNumber = $this->stringToNumberConvert(config('auto_update.version'));
        // $clientVersionNumber = 120; // have to change when testing on bug 119,120

        $clientBugNo = intval(config('auto_update.bug_no'));
        $demoVersionString      = $data->general->demo_version;
        $demoVersionNumber      = $this->stringToNumberConvert($demoVersionString);

        $demoBugNo              = $data->general->demo_bug_no;
        // $demoBugNo              = 1021;

        $minimumRequiredVersion = $this->stringToNumberConvert($data->general->minimum_required_version);
        $latestVersionUpgradeEnable   = $data->general->latest_version_upgrade_enable;
        $latestVersionDBMigrateEnable = $data->general->latest_version_db_migrate_enable;
        $bugUpdateEnable        = $data->general->bug_update_enable;

        $alertBugEnable = false;
        $alertVersionUpgradeEnable = false;

        // echo $minimumRequiredVersion.'</br>';
        // echo $demoVersionNumber.'</br>';
        // echo $clientVersionNumber.'</br>';
        // echo $demoBugNo.'</br>';
        // echo $clientBugNo.'</br>';
        // echo $bugUpdateEnable.'</br>';
        // echo $productMode.'</br>';
        // return;
        // echo $clientVersionNumber.'</br>';
        // echo $minimumRequiredVersion.'</br>';
        // echo $latestVersionUpgradeEnable.'</br>';
        // echo $productMode.'</br>';
        // echo $demoVersionNumber.'</br>';

        if ($clientVersionNumber >= $minimumRequiredVersion && $demoVersionNumber === $clientVersionNumber && $demoBugNo > $clientBugNo && $bugUpdateEnable ===true && $productMode==='DEMO') {
            $alertBugEnable = true;
        }
        if ($clientVersionNumber >= $minimumRequiredVersion && $latestVersionUpgradeEnable===true && $productMode==='DEMO' && $demoVersionNumber > $clientVersionNumber) {
            $alertVersionUpgradeEnable = true;
        }

        $returnData = [];
        $returnData['alertBugEnable'] = $alertBugEnable;
        $returnData['alertVersionUpgradeEnable'] = $alertVersionUpgradeEnable;

        return $returnData;
    }

    private function stringToNumberConvert($dataString) {
        $myArray = explode(".", $dataString);
        $versionString = "";
        foreach($myArray as $element) {
          $versionString .= $element;
        }
        $versionConvertNumber = intval($versionString);
        return $versionConvertNumber;
    }
}
