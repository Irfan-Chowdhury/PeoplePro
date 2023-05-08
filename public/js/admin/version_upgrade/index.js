/************************************************
        Common General Data
*************************************************/

// const demoURL = 'http://peopleprohrm/demo/api'; //Demo Link
// const demoURL = 'http://localhost/peoplepro/api'; //Demo Link
const demoURL = 'https://peopleprohrm.com/peoplepro/api'; //Demo Link
let fetchGeneralApiData;
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

const displayGeneralData = data => {
    fetchGeneralApiData    = data;
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

loadGeneralData();



/************************************************
        Version Upgrade API Data Load
*************************************************/

const loadVersionUpgradeData = () => {
    let url = `${demoURL}/fetch-data-upgrade`; //Demo Link
    fetch(url)
    .then(res => res.json())
    .then(data => displayVersionUpgradeData(data))
}

let fetchVersionUpgradeApiData;
const displayVersionUpgradeData = upgradeApiData => {

    // Test (Removed Later)
    // let demoVersionNumber = "111";
    // let clientVersionNumber = "110";
    // let minimumRequiredVersion = "109";


    if (clientVersionNumber >= minimumRequiredVersion && latestVersionUpgradeEnable===true && productMode==='DEMO') {
        if (demoVersionNumber > clientVersionNumber) {
            $('#newVersionSection').removeClass('d-none');
            $('#newVersionNo').text(demoVersionString);
            const dataLogs = upgradeApiData.log;
            const logUL = document.getElementById('logUL');
            dataLogs.forEach(element => {
                console.log(element.text);
                const logLI = document.createElement('li');
                logLI.classList.add('list-group-item');
                logLI.innerText = element.text;
                logUL.appendChild(logLI);
            });
            fetchVersionUpgradeApiData = upgradeApiData;
        }else if(demoVersionNumber === clientVersionNumber){
            $('#oldVersionSection').removeClass('d-none');
            return;
        }else{
            return;
        }
    }
}

loadVersionUpgradeData();


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


/******************************************************************
        Upgrade
*******************************************************************/


$('#upgrade').on('click', function(e){
    e.preventDefault();
    $('#spinner').removeClass('d-none');
    $('#upgrade').text('Upgrading...');
    $.post({
        url: versionUpgradeURL,
        type: "POST",
        data: {data:fetchVersionUpgradeApiData, general: fetchGeneralApiData},
        error: function(response){
            console.log(response.responseJSON.error[0]);
            const html = `
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <p> <strong>Error !!! </strong> ${response.responseJSON.error[0]} </p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>`;

            $('#errorMessage').fadeIn("slow").html(html);
            $('#spinner').addClass('d-none');
            $('#upgrade').text('Upgrade');
        },
        success: function (data) {
            console.log(data);
            if (data == 'success') {
                localStorage.setItem('version_upgrade_status','done');
                $('#spinner').addClass('d-none');
                $('#upgrade').text('Upgrade');
                window.location.href = redirectURL;
            }

        }
    })

})
