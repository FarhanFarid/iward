$(document).ready(function () {
    let isCardiologyLoaded = false;
    let isCardiothoracicLoaded = false;

    // 🔸 Initialize cardiothoracic calendar immediately on page load
    let selectedDate = $("#ctcalendardate").val();
    initCardiothoracicCalendar(selectedDate);
    isCardiothoracicLoaded = true;

    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        let targetTab = $(e.target).attr("href");

        if (targetTab === "#cardiology" && !isCardiologyLoaded) {
            let selectedDate = $("#cdcalendardate").val();
            initCardiologyCalendar(selectedDate);
            isCardiologyLoaded = true;
        }

        if (targetTab === "#cardiothoracic" && !isCardiothoracicLoaded) {
            let selectedDate = $("#ctcalendardate").val();
            initCardiothoracicCalendar(selectedDate);
            isCardiothoracicLoaded = true;
        }
    });
});
