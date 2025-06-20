function initCardiologyTab() {
    "use strict";

    var calendar;
    var calendarEl = document.getElementById('cardiology-calendar');

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
                    url: config.routes.oncallassignment.cardiology.getlist,
                    method: 'GET',
                    success: function(data) {
                        if (data.status === 'success') {
                            const positionHierarchy = {
                                "consultant": 0, 
                                "firstcall": 1,
                                "secondcall": 2,
                                "cardiologist": 3,
                                "mo": 4,
                                "ep": 5
                            };

                            const positionLabels = {
                                "consultant": "Cons",
                                "firstcall": "1st",
                                "secondcall": "2nd",
                                "cardiologist": "Cardio",
                                "mo": "MO",
                                "ep": "EP"
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
                                    case 'consultant': color = '#87CEFA'; break;
                                    case 'firstcall': color = '#7FFFD4'; break;
                                    case 'secondcall': color = '#AFEEEE'; break;
                                    case 'cardiologist': color = '#40E0D0'; break;
                                    case 'mo': color = '#F5FFFA'; break;
                                    case 'ep': color = '#EEE8AA'; break;
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
                let id = info.event.extendedProps.id;
                let date = info.event.extendedProps.oncallDate;
                let sso = info.event.extendedProps.sso; 

                $("#occdid").val(id); 
                $("#updatecdoncalldate").val(date);
                $("#updatecdstaff").val(sso).trigger("change");  

                $('#updatecd-modal').modal('show');
            }
        });

        calendar.render();
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Default calendar date to today
    let today = moment().format('YYYY-MM-DD');
    $("#cdcalendardate").val(today);
    initCalendar(today);

    $("#cdcalendardate").on("change", function () {
        let selectedDate = $(this).val();
        initCalendar(selectedDate);
    });

    $('.assign-cd').on('click', function () {
        $('#assigncd-modal').modal('show');
    });

    $('.save-occd').on('click', async function () {
        const form = $('#oncallcardiologyform');
        let formData = await getAllInput(form);
        let data     = processSerialize(formData);
        let url      = config.routes.oncallassignment.cardiology.save;

        $.ajax({
            url,
            type: "POST",
            dataType: "json",
            data,
            beforeSend: function() {
                $("#loading-overlay").show();
            },
            success: function(data) {
                $("#loading-overlay").hide();
                Swal.fire({
                    title: "Success!",
                    text: "Successfully Saved!",
                    icon: "success",
                    showConfirmButton: false,
                    timer: 3000
                });
                setTimeout(() => {
                    calendar.refetchEvents();
                    $('#assigncd-modal').modal('hide');
                }, 1000);
            },
            error: function(xhr, status, error) {
                toastr.error('Error saving: ' + error, { timeOut: 5000 });
            }
        });
    });

    $('.update-occd').on('click', async function () {
        const form = $('#updateoncallcardiologyform');

        let formData = await getAllInput(form);
        let data     = processSerialize(formData);
        let url      = config.routes.oncallassignment.cardiology.update;

        $.ajax({
            url,
            type: "POST",
            dataType: "json",
            data,
            beforeSend: function() {
                $("#loading-overlay").show();
            },
            success: function(data) {
                $("#loading-overlay").hide();
                Swal.fire({
                    title: "Success!",
                    text: "Successfully Updated!",
                    icon: "success",
                    showConfirmButton: false,
                    timer: 3000
                });
                setTimeout(() => {
                    calendar.refetchEvents();
                    $('#updatecd-modal').modal('hide');
                }, 1000);
            },
            error: function(xhr, status, error) {
                toastr.error('Error updating: ' + error, { timeOut: 5000 });
            }
        });
    });

    // Date validation — apply for all position types
    const datePairs = [
        ['cdconsoncallstart', 'cdconsoncallend'],
        ['cdcardiooncallstart', 'cdcardiooncallend'],
        ['cdfirstoncallstart', 'cdfirstoncallend'],
        ['cdseconcallstart', 'cdseconcallend'],
        ['cdmooncallstart', 'cdmooncallend'],
        ['cdeponcallstart', 'cdeponcallend']
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
