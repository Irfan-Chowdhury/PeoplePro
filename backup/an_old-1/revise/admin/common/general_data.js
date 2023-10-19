/************************************************
        Common General Data
*************************************************/
// const demoURL = 'https://peopleprohrm.com/demo/api'; //Demo Link
// const demoURL = 'http://localhost/peoplepro/api'; //Demo Link
const demoURL = 'https://peopleprohrm.com/peoplepro/api'; //Demo Link
let productMode;
let clientVersionNumber;
let clientBugNo;
let demoVersionString;
let demoVersionNumber;
let demoBugNo;
let minimumRequiredVersion;
let latestVersionUpgradeEnable;
let latestVersionDBMigrateEnable;
let bugUpdateEnable;
let bugDBMigrateEnable;

const loadGeneralData = () => {
    let url = `${demoURL}/fetch-data-general`;
    fetch(url)
    .then(res => res.json())
    .then(data => displayGeneralData(data));
}

loadGeneralData();


const displayGeneralData = data => {
    console.log(data);
    console.log(clientCurrrentVersion);

    productMode            = data.general.product_mode;
    clientVersionNumber    = stringToNumberConvert(clientCurrrentVersion);
    clientBugNo            = parseInt(clientCurrrentBugNo);
    demoVersionString      = data.general.demo_version;
    demoVersionNumber      = stringToNumberConvert(demoVersionString);
    demoBugNo              = data.general.demo_bug_no;
    minimumRequiredVersion = stringToNumberConvert(data.general.minimum_required_version);
    latestVersionUpgradeEnable   = data.general.latest_version_upgrade_enable;
    latestVersionDBMigrateEnable = data.general.latest_version_db_migrate_enable;
    bugUpdateEnable        = data.general.bug_update_enable;
    bugDBMigrateEnable     = data.general.bug_db_migrate_enable;
}


/******************************************************************
        String to Number Conversion of Version from env
*******************************************************************/

const stringToNumberConvert = dataString => {
    const myArray = dataString.split(".");
    let versionString = "";
    myArray.forEach(element => {
        versionString += element;
    });
    let versionConvertNumber = parseInt(versionString);
    return versionConvertNumber;
}


