"use strict";

var calendar;
var calendarEl = document.getElementById("common-calendar"); // Use a single calendar element

$(document).ready(function () {
    // Default to the current month
    let selectedDate = moment().format("YYYY-MM-DD");

    // Initialize Calendar on First Load
    let activeTab = $("ul.nav-tabs .active a").attr("href"); // Get current active tab
    let tabType = getTabType(activeTab); // Determine cardiology or cardiothoracic
    initCalendar(tabType, selectedDate);

    // When user switches tabs
    $("a[data-bs-toggle='tab']").on("shown.bs.tab", function (e) {
        let newTab = $(e.target).attr("href"); // Get new active tab ID
        let tabType = getTabType(newTab); // Determine which tab is active
        initCalendar(tabType, selectedDate); // Reload calendar with new data
    });
});

/**
 * Get tab type based on tab ID
 * @param {string} tabId 
 * @returns {string} "cardiology" or "cardiothoracic"
 */
function getTabType(tabId) {
    if (tabId === "#cardiology-tab") return "cardiology";
    if (tabId === "#cardiothoracic-tab") return "cardiothoracic";
    return "cardiology"; // Default
}

/**
 * Initialize the FullCalendar with the correct data source
 * @param {string} tabType - "cardiology" or "cardiothoracic"
 * @param {string} selectedDate - The default selected date
 */
function initCalendar(tabType, selectedDate) {
    if (calendar) {
        calendar.destroy(); // Destroy existing calendar instance
    }

    calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "",
        },
        initialDate: selectedDate,
        navLinks: true,
        selectable: true,
        eventStartEditable: false,
        droppable: false,
        selectMirror: true,
        editable: true,
        events: function (fetchInfo, successCallback, failureCallback) {
            let url =
                tabType === "cardiology"
                    ? config.routes.oncallassignment.cardiology.getlist
                    : config.routes.oncallassignment.cardiothoracic.getlist;

            $.ajax({
                url: url,
                method: "GET",
                success: function (data) {
                    if (data.status === "success") {
                        let events = formatEvents(data.response, tabType);
                        successCallback(events);
                    } else {
                        failureCallback(new Error("Failed to fetch events"));
                    }
                },
                error: function (err) {
                    console.error("Error fetching data:", err);
                    failureCallback(err);
                },
            });
        },
        eventClick: function (info) {
            let id = info.event.extendedProps.id;
            let date = info.event.extendedProps.oncallDate;
            let sso = info.event.extendedProps.sso;

            if (tabType === "cardiology") {
                $("#occdid").val(id);
                $("#updatecdoncalldate").val(date);
                $("#updatecdstaff").val(sso).trigger("change");
                $("#updatecd-modal").modal("show");
            } else {
                $("#occtid").val(id);
                $("#updatectoncalldate").val(date);
                $("#updatectstaff").val(sso).trigger("change");
                $("#updatect-modal").modal("show");
            }
        },
    });

    calendar.render();
}

/**
 * Format events based on tab type
 * @param {Array} data - API response
 * @param {string} tabType - "cardiology" or "cardiothoracic"
 * @returns {Array} Formatted event objects
 */
function formatEvents(data, tabType) {
    const positionHierarchy =
        tabType === "cardiology"
            ? {
                  consultant: 0,
                  firstcall: 1,
                  secondcall: 2,
                  cardiologist: 3,
                  mo: 4,
                  ep: 5,
              }
            : {
                  consultant: 0,
                  firstcall: 1,
                  secondcall: 2,
                  thirdcall: 3,
                  icuam: 4,
                  icupm: 5,
              };

    const positionLabels =
        tabType === "cardiology"
            ? {
                  consultant: "Cons",
                  firstcall: "1st",
                  secondcall: "2nd",
                  cardiologist: "Cardio",
                  mo: "MO",
                  ep: "EP",
              }
            : {
                  consultant: "Cons",
                  firstcall: "1st",
                  secondcall: "2nd",
                  thirdcall: "3rd",
                  icuam: "ICU AM",
                  icupm: "ICU PM",
              };

    return data
        .sort((a, b) => {
            let indexA = positionHierarchy[a.position_type] ?? 99;
            let indexB = positionHierarchy[b.position_type] ?? 99;
            return indexA - indexB;
        })
        .map((item) => {
            let color;
            switch (item.position_type) {
                case "consultant":
                    color = "#87CEFA";
                    break;
                case "firstcall":
                    color = "#7FFFD4";
                    break;
                case "secondcall":
                    color = "#AFEEEE";
                    break;
                case "thirdcall":
                    color = "#40E0D0";
                    break;
                case "cardiologist":
                case "icuam":
                    color = "#F5FFFA";
                    break;
                case "mo":
                case "icupm":
                    color = "#EEE8AA";
                    break;
                default:
                    color = "#F0E68C";
            }

            return {
                title: `${positionLabels[item.position_type]}: ${item.name}`,
                start: item.oncall_date,
                backgroundColor: color,
                borderColor: color,
                textColor: "black",
                allDay: true,
                extendedProps: {
                    positionType: item.position_type,
                    sso: item.user_sso_id,
                    id: item.id,
                    oncallDate: item.oncall_date,
                },
            };
        });
}
