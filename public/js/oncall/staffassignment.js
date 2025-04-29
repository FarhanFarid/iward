$(document).ready(function () {

    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        let targetTab = $(e.target).attr("href"); // Get the target tab ID
        
        if (targetTab === "#sa") {
            setTimeout(function () {
                let selectedDate = $("#sacalendardate").val();
                initCalendar(selectedDate); // Reinitialize the calendar
            }, 100); // Small delay to ensure the tab transition is complete

            "use strict";

            var calendar;
            var calendarEl = document.getElementById('sa-calendar');
        
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
                        const selectedLocation = $('#salocation').val();
        
                        if (!selectedLocation) {
                            successCallback([]);
                            return;
                        }
        
                        $.ajax({
                            url: config.routes.oncallassignment.sa.getlist,
                            method: 'GET',
                            data: {
                                salocation: selectedLocation
                            },
                            success: function (data) {
                                if (data.status === 'success') {
                                    const positionHierarchy = {
                                        "tlam": 0, "tlpm": 1, "tloncall": 2,
                                        "iam": 3, "ipm": 4, "ioncall": 5,
                                        "medam": 6, "medpm": 7, "medoncall": 8,
                                        "runam": 9, "runpm": 10, "runoncall": 11,
                                        "obsam": 9, "obspm": 10, "obsoncall": 11
                                    };
        
                                    const positionLabels = {
                                        "tlam": "TL AM", "tlpm": "TL PM", "tloncall": "TL Oncall",
                                        "iam": "INC AM", "ipm": "INC PM", "ioncall": "INC Oncall",
                                        "medam": "MED AM", "medpm": "MED PM", "medoncall": "MED Oncall",
                                        "runam": "RUN AM", "runpm": "RUN PM", "runoncall": "RUN Oncall",
                                        "obsam": "OBS AM", "obspm": "OBS PM", "obsoncall": "OBS Oncall"

                                    };
        
                                    let events = data.response
                                        .sort((a, b) => (positionHierarchy[a.position_type] ?? 99) - (positionHierarchy[b.position_type] ?? 99))
                                        .map(item => {
                                            let color;
                                            switch (item.position_type) {
                                                case 'tlam':
                                                case 'tlpm':
                                                case 'tloncall':
                                                    color = '#87CEFA'; break;
                                                case 'iam':
                                                case 'ipm':
                                                case 'ioncall':
                                                    color = '#7FFFD4'; break;
                                                case 'medam':
                                                case 'medpm':
                                                case 'medoncall':
                                                    color = '#AFEEEE'; break;
                                                case 'runam':
                                                case 'runpm':
                                                case 'runoncall':
                                                    color = '#40E0D0'; break;
                                                case 'obsam':
                                                case 'obspm':
                                                case 'obsoncall':
                                                    color = '#F5FFFA'; break;
                                                default:
                                                    color = '#F0E68C';
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
                        let id = info.event.extendedProps.id;
                        let date = info.event.extendedProps.oncallDate;
                        let sso = info.event.extendedProps.sso;
        
                        $("#ocsaid").val(id);
                        $("#updatesaoncalldate").val(date);
                        $("#updatesastaff").val(sso).trigger("change");
        
                        $('#updatesa-modal').modal('show');
                    }
                });
        
                calendar.render();
            }
        
            // Setup AJAX CSRF
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        
            // Default to today
            let today = moment().format('YYYY-MM-DD');
            $("#sacalendardate").val(today);
        
            // Wait for tab transition
            setTimeout(function () {
                initCalendar(today);
            }, 200); // Maybe increase delay a bit if needed
        
            // On location or date change
            $("#salocation, #sacalendardate").on("change", function () {
                let selectedDate = $("#sacalendardate").val(); // Get value from date input only
                initCalendar(selectedDate);
            });

            $('.assign-sa').on('click', function() {

                $('#assignsa-modal').modal('show');

            });

            $('.save-ocsa').on('click', async function() {

                var form        = $(this).parent().parent().find('form#oncallsaform');
                var formData    = await getAllInput(form);
                var data        = processSerialize(formData);
                var url         = config.routes.oncallassignment.sa.save;

                // console.log(data);

                $.ajax({
                    url: url,
                    type: "POST",
                    dataType: "json",
                    data: data,
                    beforeSend: function(){
                        $("#loading-overlay").show();
                    },
                    success: function(data) {
                        $("#loading-overlay").hide();
                        Swal.fire({
                            title: "Success!",
                            text: "Successfully Saved!",
                            icon: "success",
                            buttonsStyling: false,
                            showConfirmButton: false,
                            timer: 3000
                        });

                        setTimeout(function() {
                            calendar.refetchEvents();
                            $('#assignsa-modal').modal('hide');
                        }, 1000);
                    },
                    error: function(xhr, status, error) {
                        toastr.error('Error saving reaction: ' + error, {timeOut: 5000});
                    }
                });

            });

            $('.update-ocsa').on('click', async function() {

                var form        = $(this).parent().parent().find('form#updateoncallsaform');
                var formData    = await getAllInput(form);
                var data        = processSerialize(formData);
                var url         = config.routes.oncallassignment.sa.update;

                $.ajax({
                    url: url,
                    type: "POST",
                    dataType: "json",
                    data: data,
                    beforeSend: function(){
                        $("#loading-overlay").show();
                    },
                    success: function(data) {
                        $("#loading-overlay").hide();
                        Swal.fire({
                            title: "Success!",
                            text: "Successfully Updated!",
                            icon: "success",
                            buttonsStyling: false,
                            showConfirmButton: false,
                            timer: 3000
                        });

                        setTimeout(function() {
                            calendar.refetchEvents();
                            $('#updatesa-modal').modal('hide');
                        }, 1000);
                    },
                    error: function(xhr, status, error) {
                        toastr.error('Error saving reaction: ' + error, {timeOut: 5000});
                    }
                });

            });

            //Checking Date CT
            //Consulltant start
            $('#tloncallend').prop('disabled', true);
            $('#tloncallstart').on('change', function() {
                let startDate = $(this).val();
                if (startDate) {
                    $('#tloncallend').prop('disabled', false);
                    $('#tloncallend').attr('min', startDate);
                } else {
                    $('#tloncallend').val('').prop('disabled', true);
                }
            });

            $('#tloncallend').on('change', function() {
                let startDate = $('#tloncallstart').val();
                let endDate = $(this).val();
                if (endDate < startDate) {
                    alert("End date cannot be before the start date!");
                    $(this).val('');
                }
            });
            //Consulltant end

            //Firstcall start
            $('#ioncallend').prop('disabled', true);
            $('#ioncallstart').on('change', function() {
                let startDate = $(this).val();
                if (startDate) {
                    $('#ioncallend').prop('disabled', false);
                    $('#ioncallend').attr('min', startDate);
                } else {
                    $('#ioncallend').val('').prop('disabled', true);
                }
            });

            $('#ioncallend').on('change', function() {
                let startDate = $('#ioncallstart').val();
                let endDate = $(this).val();
                if (endDate < startDate) {
                    alert("End date cannot be before the start date!");
                    $(this).val('');
                }
            });
            //Firstcall end

            //Thirdcall start
            $('#medoncallend').prop('disabled', true);
            $('#medoncallstart').on('change', function() {
                let startDate = $(this).val();
                if (startDate) {
                    $('#medoncallend').prop('disabled', false);
                    $('#medoncallend').attr('min', startDate);
                } else {
                    $('#medoncallend').val('').prop('disabled', true);
                }
            });

            $('#medoncallend').on('change', function() {
                let startDate = $('#medoncallstart').val();
                let endDate = $(this).val();
                if (endDate < startDate) {
                    alert("End date cannot be before the start date!");
                    $(this).val('');
                }
            });
            //Thirdcall end

            //ICUAM start
            $('#runoncallend').prop('disabled', true);
            $('#runoncallstart').on('change', function() {
                let startDate = $(this).val();
                if (startDate) {
                    $('#runoncallend').prop('disabled', false);
                    $('#runoncallend').attr('min', startDate);
                } else {
                    $('#runoncallend').val('').prop('disabled', true);
                }
            });

            $('#runoncallend').on('change', function() {
                let startDate = $('#runoncallstart').val();
                let endDate = $(this).val();
                if (endDate < startDate) {
                    alert("End date cannot be before the start date!");
                    $(this).val('');
                }
            });
            //ICUAM end

            //ICUPM start
            $('#obsoncallend').prop('disabled', true);
            $('#obsoncallstart').on('change', function() {
                let startDate = $(this).val();
                if (startDate) {
                    $('#obsoncallend').prop('disabled', false);
                    $('#obsoncallend').attr('min', startDate);
                } else {
                    $('#obsoncallend').val('').prop('disabled', true);
                }
            });

            $('#obsoncallend').on('change', function() {
                let startDate = $('#obsoncallstart').val();
                let endDate = $(this).val();
                if (endDate < startDate) {
                    alert("End date cannot be before the start date!");
                    $(this).val('');
                }
            });
            //ICUPM end
            //Checking Date CT End 
        }
    }); 
});
