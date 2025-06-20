function initNursemanagerTab() {
    "use strict";

    var calendar;
    var calendarEl = document.getElementById('nursemanager-calendar');

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
            events: function(fetchInfo, successCallback, failureCallback) {
                $.ajax({
                    url: config.routes.oncallassignment.nursemanager.getlist,
                    method: 'GET',
                    success: function(data) {
                        if (data.status === 'success') {
                            const positionHierarchy = {
                                "firstcall": 0, 
                                "secondcall": 1,
                                "weekendam": 2,
                                "weekendpm": 3,
                                "oncall": 4,
                            };
        
                            const positionLabels = {
                                "firstcall": "1st",
                                "secondcall": "2nd",
                                "weekendam": "AM",
                                "weekendpm": "PM",
                                "oncall": "OC",
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
                                    case 'firstcall': color = '#87CEFA'; break;
                                    case 'secondcall': color = '#7FFFD4'; break;
                                    case 'weekendam': color = '#AFEEEE'; break;
                                    case 'weekendpm': color = '#40E0D0'; break;
                                    case 'oncall': color = '#F5FFFA'; break;
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
                    error: function(err) {
                        console.error("Error fetching data:", err);
                        failureCallback(err);
                    }
                });
            },

            eventClick: function(info) {
                let { id, oncallDate, sso } = info.event.extendedProps;
                $("#ocnmid").val(id); 
                $("#updatenmoncalldate").val(oncallDate);
                $("#updatenmstaff").val(sso).trigger("change");  
                $('#updatenm-modal').modal('show');
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
    $("#nmcalendardate").val(today);
    initCalendar(today);

    $("#nmcalendardate").on("change", function () {
        let selectedDate = $(this).val();
        initCalendar(selectedDate);
    });

    $('.assign-nm').on('click', function () {
        $('#assignnm-modal').modal('show');
    });

    $('.save-ocnm').on('click', async function () {
        const form = $('#oncallnursemanagerform');
        var formData = await getAllInput(form);
        var data = processSerialize(formData);
        var url = config.routes.oncallassignment.nursemanager.save;

        $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            data: data,
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
                    $('#assignnm-modal').modal('hide');
                }, 1000);
            },
            error: function (xhr, status, error) {
                toastr.error('Error saving reaction: ' + error, { timeOut: 5000 });
            }
        });
    });

    $('.update-ocnm').on('click', async function () {
        const form = $('#updateoncallnursemanagerform');
        var formData = await getAllInput(form);
        var data = processSerialize(formData);
        var url = config.routes.oncallassignment.nursemanager.update;

        $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            data: data,
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
                    $('#updatenm-modal').modal('hide');
                }, 1000);
            },
            error: function (xhr, status, error) {
                toastr.error('Error saving reaction: ' + error, { timeOut: 5000 });
            }
        });
    });

    const datePairs = [
        ['nmfirstoncallstart', 'nmfirstoncallend'],
        ['nmseconcallstart', 'nmseconcallend'],
        ['nmamoncallstart', 'nmamoncallend'],
        ['nmpmoncallstart', 'nmpmoncallend'],
        ['nmoncallstart', 'nmoncallend']
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
