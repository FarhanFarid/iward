function initOtherTab() {
    "use strict";

    var calendar;
    var calendarEl = document.getElementById('oth-calendar');

    function initCalendar(selectedDate) {
        if (calendar) {
            calendar.destroy();
        }

        calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: ''
            },
            initialDate: selectedDate || moment().format('YYYY-MM-DD'),
            navLinks: true,
            selectable: true,
            eventStartEditable: false,
            droppable: false,
            selectMirror: true,
            editable: true,
            events: function (fetchInfo, successCallback, failureCallback) {
                $.ajax({
                    url: config.routes.oncallassignment.other.getlist,
                    method: 'GET',
                    success: function (data) {
                        if (data.status === 'success') {
                            const positionHierarchy = {
                                "perfusionist": 0,
                                "dietitian": 1,
                                "physiotherapist": 2,
                                "resplab": 3,
                                "cvt": 4
                            };

                            const positionLabels = {
                                "perfusionist": "Perf",
                                "dietitian": "Diet",
                                "physiotherapist": "Physio",
                                "resplab": "Lab",
                                "cvt": "CVT"
                            };

                            let events = data.response
                                .sort((a, b) => {
                                    let indexA = positionHierarchy[a.position_type] ?? 99;
                                    let indexB = positionHierarchy[b.position_type] ?? 99;
                                    return indexA - indexB;
                                })
                                .map(item => {
                                    let color;
                                    switch (item.position_type) {
                                        case 'perfusionist': color = '#87CEFA'; break;
                                        case 'dietitian': color = '#7FFFD4'; break;
                                        case 'physiotherapist': color = '#AFEEEE'; break;
                                        case 'resplab': color = '#40E0D0'; break;
                                        case 'cvt': color = '#F5FFFA'; break;
                                        default: color = '#F0E68C';
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
                                            sso: item.user_cp_id,
                                            id: item.id,
                                            oncallDate: item.oncall_date
                                        }
                                    };
                                });

                            successCallback(events);
                        } else {
                            failureCallback(new Error('Failed to fetch events'));
                        }
                    },
                    error: function (err) {
                        console.error("Error fetching data:", err);
                        failureCallback(err);
                    }
                });
            },

            eventClick: function (info) {
                let { id, oncallDate, sso } = info.event.extendedProps;

                $("#ocothid").val(id);
                $("#updateothoncalldate").val(oncallDate);
                $("#updateothstaff").val(sso).trigger("change");

                $('#updateoth-modal').modal('show');
            }
        });

        calendar.render();
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let today = moment().format('YYYY-MM-DD');
    $("#othcalendardate").val(today);
    initCalendar(today);

    $("#othcalendardate").on("change", function () {
        let selectedDate = $(this).val();
        initCalendar(selectedDate);
    });

    $('.assign-oth').on('click', function () {
        $('#assignoth-modal').modal('show');
    });

    $('.save-ocoth').on('click', async function () {
        const form = $('#oncallotherform');
        var formData = await getAllInput(form);
        var data = processSerialize(formData);
        var url = config.routes.oncallassignment.other.save;

        $.ajax({
            url,
            type: "POST",
            dataType: "json",
            data,
            beforeSend: function () {
                $("#loading-overlay").show();
            },
            success: function () {
                $("#loading-overlay").hide();
                Swal.fire({
                    title: "Success!",
                    text: "Successfully Saved!",
                    icon: "success",
                    showConfirmButton: false,
                    timer: 3000
                });

                setTimeout(function () {
                    calendar.refetchEvents();
                    $('#assignoth-modal').modal('hide');
                }, 1000);
            },
            error: function (xhr, status, error) {
                toastr.error('Error saving reaction: ' + error, { timeOut: 5000 });
            }
        });
    });

    $('.update-ocoth').on('click', async function () {
        const form = $('#updateoncallotherform');
        var formData = await getAllInput(form);
        var data = processSerialize(formData);
        var url = config.routes.oncallassignment.other.update;

        console.log(data);

        $.ajax({
            url,
            type: "POST",
            dataType: "json",
            data,
            beforeSend: function () {
                $("#loading-overlay").show();
            },
            success: function () {
                $("#loading-overlay").hide();
                Swal.fire({
                    title: "Success!",
                    text: "Successfully Updated!",
                    icon: "success",
                    showConfirmButton: false,
                    timer: 3000
                });

                setTimeout(function () {
                    calendar.refetchEvents();
                    $('#updateoth-modal').modal('hide');
                }, 1000);
            },
            error: function (xhr, status, error) {
                toastr.error('Error saving reaction: ' + error, { timeOut: 5000 });
            }
        });
    });

    const datePairs = [
        ['othperfoncallstart', 'othperfoncallend'],
        ['othdietoncallstart', 'othdietoncallend'],
        ['othphysiooncallstart', 'othphysiooncallend'],
        ['othlaboncallstart', 'othlaboncallend'],
        ['othcvtoncallstart', 'othcvtoncallend']
    ];

    datePairs.forEach(([startId, endId]) => {
        const $start = $('#' + startId);
        const $end = $('#' + endId);

        $end.prop('disabled', true);

        $start.on('change', function () {
            const val = $(this).val();
            if (val) {
                $end.prop('disabled', false).attr('min', val);
            } else {
                $end.prop('disabled', true).val('');
            }
        });

        $end.on('change', function () {
            const startVal = $start.val();
            const endVal = $(this).val();
            if (endVal < startVal) {
                alert("End date cannot be before the start date!");
                $(this).val('');
            }
        });
    });
}
