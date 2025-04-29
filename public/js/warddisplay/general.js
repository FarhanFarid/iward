$(document).ready(function () {

    // console.log('hello');
    setInterval(function() {
        $("#cardiothoracic-section").load("/refresh/cardiothoracic");
    }, 5000); // Reload every 5 seconds

    setInterval(function() {
        $("#cardiology-section").load("/refresh/cardiology");
    }, 5000); // Reload every 5 seconds

    setInterval(function() {
        $("#nursemanager-section").load("/refresh/nursemanager");
    }, 5000); // Reload every 5 seconds

    setInterval(function() {
        $("#anaesthesia-section").load("/refresh/anaesthesia");
    }, 5000); // Reload every 5 seconds

    setInterval(function() {
        $("#pchc-section").load("/refresh/pchc");
    }, 5000); // Reload every 5 seconds

    setInterval(function() {
        $("#other-section").load("/refresh/other");
    }, 5000); // Reload every 5 seconds

    setInterval(function() {
        $("#ert-section").load("/refresh/ert?ward=" + ward);
    }, 5000); // Reload every 5 seconds

    setInterval(function() {
        $("#sa-section").load("/refresh/sa?ward=" + ward);
    }, 5000); // Reload every 5 seconds
});