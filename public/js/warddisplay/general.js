$(document).ready(function () {

    // console.log('hello');
    setInterval(function() {
        $("#cardiothoracic-section").load("/refresh-cardiothoracic");
    }, 5000); // Reload every 5 seconds

});