$(document).ready(function () {

    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        let targetTab = $(e.target).attr("href"); // Get the target tab ID
        
        if (targetTab === "#ert") {
            setTimeout(function () {
                let selectedDate = $("#ertcalendardate").val();
                initCalendar(selectedDate); // Reinitialize the calendar
            }, 100); // Small delay to ensure the tab transition is complete

            "use strict";

            var calendar;
            var calendarEl = document.getElementById('ert-calendar');
        
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
                        const selectedLocation = $('#ertlocation').val();
        
                        if (!selectedLocation) {
                            successCallback([]);
                            return;
                        }
        
                        $.ajax({
                            url: config.routes.oncallassignment.ert.getlist,
                            method: 'GET',
                            data: {
                                ertlocation: selectedLocation
                            },
                            success: function (data) {
                                if (data.status === 'success') {
                                    const positionHierarchy = {
                                        "ioam": 0, "iopm": 1, "iooncall": 2,
                                        "fwam": 3, "fwpm": 4, "fwoncall": 5,
                                        "fsam": 6, "fspm": 7, "fsoncall": 8,
                                        "rsam": 9, "rspm": 10, "rsoncall": 11
                                    };
        
                                    const positionLabels = {
                                        "ioam": "IO AM", "iopm": "IO PM", "iooncall": "IO Oncall",
                                        "fwam": "FW AM", "fwpm": "FW PM", "fwoncall": "FW Oncall",
                                        "fsam": "FS AM", "fspm": "FS PM", "fsoncall": "FS Oncall",
                                        "rsam": "RS AM", "rspm": "RS PM", "rsoncall": "RS Oncall"
                                    };
        
                                    let events = data.response
                                        .sort((a, b) => (positionHierarchy[a.position_type] ?? 99) - (positionHierarchy[b.position_type] ?? 99))
                                        .map(item => {
                                            let color;
                                            switch (item.position_type) {
                                                case 'ioam':
                                                case 'iopm':
                                                case 'iooncall':
                                                    color = '#87CEFA'; break;
                                                case 'fwam':
                                                case 'fwpm':
                                                case 'fwoncall':
                                                    color = '#7FFFD4'; break;
                                                case 'fsam':
                                                case 'fspm':
                                                case 'fsoncall':
                                                    color = '#AFEEEE'; break;
                                                case 'rsam':
                                                case 'rspm':
                                                case 'rsoncall':
                                                    color = '#40E0D0'; break;
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
        
                        $("#ocertid").val(id);
                        $("#updateertoncalldate").val(date);
                        $("#updateertstaff").val(sso).trigger("change");
        
                        $('#updateert-modal').modal('show');
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
            $("#ertcalendardate").val(today);
        
            // Wait for tab transition
            setTimeout(function () {
                initCalendar(today);
            }, 200); // Maybe increase delay a bit if needed
        
            // On location or date change
            $("#ertlocation, #ertcalendardate").on("change", function () {
                let selectedDate = $("#ertcalendardate").val(); // Get value from date input only
                initCalendar(selectedDate);
            });

            $('.assign-ert').on('click', function() {

                $('#assignert-modal').modal('show');

            });

            $('.save-ocert').on('click', async function() {

                var form        = $(this).parent().parent().find('form#oncallertform');
                var formData    = await getAllInput(form);
                var data        = processSerialize(formData);
                var url         = config.routes.oncallassignment.ert.save;

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
                            $('#assignert-modal').modal('hide');
                        }, 1000);
                    },
                    error: function(xhr, status, error) {
                        toastr.error('Error saving reaction: ' + error, {timeOut: 5000});
                    }
                });

            });

            $('.update-ocert').on('click', async function() {

                var form        = $(this).parent().parent().find('form#updateoncallertform');
                var formData    = await getAllInput(form);
                var data        = processSerialize(formData);
                var url         = config.routes.oncallassignment.ert.update;

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
                            $('#updateert-modal').modal('hide');
                        }, 1000);
                    },
                    error: function(xhr, status, error) {
                        toastr.error('Error saving reaction: ' + error, {timeOut: 5000});
                    }
                });

            });

            //Checking Date CT
            //Consulltant start
            $('#iooncallend').prop('disabled', true);
            $('#iooncallstart').on('change', function() {
                let startDate = $(this).val();
                if (startDate) {
                    $('#iooncallend').prop('disabled', false);
                    $('#iooncallend').attr('min', startDate);
                } else {
                    $('#iooncallend').val('').prop('disabled', true);
                }
            });

            $('#iooncallend').on('change', function() {
                let startDate = $('#iooncallstart').val();
                let endDate = $(this).val();
                if (endDate < startDate) {
                    alert("End date cannot be before the start date!");
                    $(this).val('');
                }
            });
            //Consulltant end

            //Firstcall start
            $('#fwoncallend').prop('disabled', true);
            $('#fwoncallstart').on('change', function() {
                let startDate = $(this).val();
                if (startDate) {
                    $('#fwoncallend').prop('disabled', false);
                    $('#fwoncallend').attr('min', startDate);
                } else {
                    $('#fwoncallend').val('').prop('disabled', true);
                }
            });

            $('#fwoncallend').on('change', function() {
                let startDate = $('#fwoncallstart').val();
                let endDate = $(this).val();
                if (endDate < startDate) {
                    alert("End date cannot be before the start date!");
                    $(this).val('');
                }
            });
            //Firstcall end

            //Secondcall start
            $('#fsoncallend').prop('disabled', true);
            $('#fsoncallstart').on('change', function() {
                let startDate = $(this).val();
                if (startDate) {
                    $('#fsoncallend').prop('disabled', false);
                    $('#fsoncallend').attr('min', startDate);
                } else {
                    $('#fsoncallend').val('').prop('disabled', true);
                }
            });

            $('#fsoncallend').on('change', function() {
                let startDate = $('#fsoncallstart').val();
                let endDate = $(this).val();
                if (endDate < startDate) {
                    alert("End date cannot be before the start date!");
                    $(this).val('');
                }
            });
            //Secondcall end

            //Thirdcall start
            $('#rsoncallend').prop('disabled', true);
            $('#rsoncallstart').on('change', function() {
                let startDate = $(this).val();
                if (startDate) {
                    $('#rsoncallend').prop('disabled', false);
                    $('#rsoncallend').attr('min', startDate);
                } else {
                    $('#rsoncallend').val('').prop('disabled', true);
                }
            });

            $('#rsoncallend').on('change', function() {
                let startDate = $('#rsoncallstart').val();
                let endDate = $(this).val();
                if (endDate < startDate) {
                    alert("End date cannot be before the start date!");
                    $(this).val('');
                }
            });
            //Thirdcall end
            //Checking Date CT End 
        }
    }); 
});
