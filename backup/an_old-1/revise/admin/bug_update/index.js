/************************************************
        Common General Data
*************************************************/

// const demoURL = 'https://peopleprohrm.com/demo/api'; //Demo Link
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
        Bug API Data Load
*************************************************/



const loadBugsInfo = () => {
    let url = `${demoURL}/fetch-data-bugs`; //Demo Link
    fetch(url)
    .then(res => res.json())
    .then(data => displayBugInfo(data));
}


let fetchBugApiData;
const displayBugInfo = bugInfoData => {
    // if (clientVersionNumber >= minimumRequiredVersion && demoVersionNumber === clientVersionNumber && demoBugNo > clientBugNo && bugUpdateEnable ===true && productMode==='DEMO') {
    //     $('#noBug').addClass('d-none');
    //     $('#bugSection').removeClass('d-none');
    // }
    fetchBugApiData = bugInfoData;
}

const stringToNumberConvert = dataString => {
    const myArray = dataString.split(".");
    let versionString = "";
    myArray.forEach(element => {
        versionString += element;
    });
    let versionConvertNumber = parseInt(versionString);
    return versionConvertNumber;
}

loadBugsInfo();


/************************************************
        Bug Update
*************************************************/

$('#update').on('click', function(e){
    e.preventDefault();
    $('#spinner').removeClass('d-none');
    $('#update').text('Updating...');
    $.post({
        url: bugUpdateURL,
        data: {data:fetchBugApiData, general:fetchGeneralApiData},
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
            $('#update').text('update');
        },
        success: function (data) {
            console.log(data);
            // return;
            if (data == 'success') {
                localStorage.setItem('bug_status','done');
                $('#spinner').addClass('d-none');
                $('#update').text('update');
                window.location.href = redirectURL;
            }
        }
    })
})





