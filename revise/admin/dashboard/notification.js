
/************************************************
                     Version Upgrade
*************************************************/

// Version Upgrade Notification
const loadVersionUpgradeData = () => {
    let url = `${demoURL}/fetch-data-upgrade`;
    fetch(url)
    .then(res => res.json())
    .then(data => displayUpgradeNotification(data));
}

let fetchApiData;
const displayUpgradeNotification = (data) => {

        // Test (Removed Later)
    let demoVersionNumber = "111";
    let clientVersionNumber = "111";
    let minimumRequiredVersion = "109";
    let clientBugNo = "1018";

    if (clientVersionNumber >= minimumRequiredVersion && latestVersionUpgradeEnable===true && productMode==='DEMO') {
        // Announce
        if (demoVersionNumber > clientVersionNumber) {
            $('#alertSection').removeClass('d-none');
            $('#newVersionNo').text(demoVersionString);
            $('#announce').removeClass('d-none');
        }
        // Congratulation
        else if (localStorage.getItem('version_upgrade_status')=='done' && (demoVersionNumber === clientVersionNumber)) {
            // console.log(sessionStorage.getItem('version_upgrade_status'));
            $('#alertSection').removeClass('d-none').addClass('alert-info');
            $('#congratulation').removeClass('d-none');
        }
    }
}

loadVersionUpgradeData();


/************************************************
                     Auto Bug Fixed
*************************************************/


// Auto Bug Notification
const loadBugsInfo = () => {
    let url = `${demoURL}/fetch-data-bugs`;
    fetch(url)
    .then(res => res.json())
    .then(data => displayBugNotification(data));
}


let fetchBugApiData;
const displayBugNotification = (data) => {

    // Test (Removed Later)
    let demoVersionNumber = "111";
    let clientVersionNumber = "111";
    let minimumRequiredVersion = "109";
    let clientBugNo = "1018";

    if (clientVersionNumber >= minimumRequiredVersion && demoVersionNumber == clientVersionNumber && bugUpdateEnable==true && productMode=='DEMO') {
        // Alert
        if (demoBugNo > clientBugNo) {
            $('#alertBugSection').removeClass('d-none');
            $('#alertBug').removeClass('d-none');
        }
        // Congratulation
        else if (localStorage.getItem('bug_status')=='done' && (clientBugNo === demoBugNo)) {
            console.log(localStorage.getItem('bug_status'));
            $('#alertBugSection').removeClass('d-none').css("background-color", "rgb(212,237,218)");
            $('#congratulationBug').removeClass('d-none');
        }
    }
}

loadBugsInfo();



/******************************************************************
        String to Number Conversion of Version from env
*******************************************************************/

// const stringToNumberConvert = dataString => {
//     const myArray = dataString.split(".");
//     let versionString = "";
//     myArray.forEach(element => {
//         versionString += element;
//     });
//     let versionConvertNumber = parseInt(versionString);
//     return versionConvertNumber;
// }


$('#closeButtonUpgrade').on('click',function(){
    localStorage.removeItem('version_upgrade_status');
});
$('#closeButtonBugUpdate').on('click',function(){
    localStorage.removeItem('bug_status');
});
