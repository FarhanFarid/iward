$(document).ready(function () {

    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        let targetTab = $(e.target).attr("href"); // Get the target tab ID
        
        if (targetTab === "#pchc") {
            setTimeout(function () {
                let selectedDate = $("#pchccalendardate").val();
                initCalendar(selectedDate); // Reinitialize the calendar
            }, 100); // Small delay to ensure the tab transition is complete

            "use strict";

            var calendar;
            var calendarEl = document.getElementById('pchc-calendar');

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
                            url: config.routes.oncallassignment.pchc.getlist,
                            method: 'GET',
                            success: function(data) {
                                if (data.status === 'success') {
                                    const positionHierarchy = {
                                        "consultant": 0, 
                                        "firstcall": 1,
                                        "secondcall": 2,
                                        "cardiologist": 3,
                                        "mo": 4,
                                    };
                
                                    const positionLabels = {
                                        "consultant": "Cons",
                                        "firstcall": "1st",
                                        "secondcall": "2nd",
                                        "cardiologist": "Cardio",
                                        "mo": "MO",
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
                    
                        // console.log("Event ID:", sso);
                        // console.log("Event Name:", date);

                        $("#ocpchcid").val(id); 
                        $("#updatepchconcalldate").val(date);
                        $("#updatepchcstaff").val(sso).trigger("change");  

                        $('#updatepchc-modal').modal('show');

                    }
                });
                
                calendar.render();
                
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Set default date to today on page load
            let today = moment().format('YYYY-MM-DD');
            $("#pchccalendardate").val(today);
            initCalendar(today); // Initialize the calendar with today's date

            // Update calendar when date changes
            $("#pchccalendardate").on("change", function () {
                let selectedDate = $(this).val();
                initCalendar(selectedDate); // Reinitialize the calendar with the selected date
            });


            $('.assign-pchc').on('click', function() {

                $('#assignpchc-modal').modal('show');

            });

            $('.save-ocpchc').on('click', async function() {

                var form        = $(this).parent().parent().find('form#oncallpchcform');
                var formData    = await getAllInput(form);
                var data        = processSerialize(formData);
                var url         = config.routes.oncallassignment.pchc.save;

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
                            $('#assignpchc-modal').modal('hide');
                        }, 1000);
                    },
                    error: function(xhr, status, error) {
                        toastr.error('Error saving reaction: ' + error, {timeOut: 5000});
                    }
                });

            });

            $('.update-ocpchc').on('click', async function() {

                var form        = $(this).parent().parent().find('form#updateoncallpchcform');
                var formData    = await getAllInput(form);
                var data        = processSerialize(formData);
                var url         = config.routes.oncallassignment.pchc.update;

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
                            $('#updatepchc-modal').modal('hide');
                        }, 1000);
                    },
                    error: function(xhr, status, error) {
                        toastr.error('Error saving reaction: ' + error, {timeOut: 5000});
                    }
                });

            });

            //Checking Date CT
            //Consulltant start
            $('#pchcconsoncallend').prop('disabled', true);
            $('#pchcconsoncallstart').on('change', function() {
                let startDate = $(this).val();
                if (startDate) {
                    $('#pchcconsoncallend').prop('disabled', false);
                    $('#pchcconsoncallend').attr('min', startDate);
                } else {
                    $('#pchcconsoncallend').val('').prop('disabled', true);
                }
            });

            $('#pchcconsoncallend').on('change', function() {
                let startDate = $('#pchcconsoncallstart').val();
                let endDate = $(this).val();
                if (endDate < startDate) {
                    alert("End date cannot be before the start date!");
                    $(this).val('');
                }
            });
            //Consulltant end

            //Firstcall start
            $('#pchccardiooncallend').prop('disabled', true);
            $('#pchccardiooncallstart').on('change', function() {
                let startDate = $(this).val();
                if (startDate) {
                    $('#pchccardiooncallend').prop('disabled', false);
                    $('#pchccardiooncallend').attr('min', startDate);
                } else {
                    $('#pchccardiooncallend').val('').prop('disabled', true);
                }
            });

            $('#pchccardiooncallend').on('change', function() {
                let startDate = $('#pchccardiooncallstart').val();
                let endDate = $(this).val();
                if (endDate < startDate) {
                    alert("End date cannot be before the start date!");
                    $(this).val('');
                }
            });
            //Firstcall end

            //Secondcall start
            $('#pchcfirstoncallend').prop('disabled', true);
            $('#pchcfirstoncallstart').on('change', function() {
                let startDate = $(this).val();
                if (startDate) {
                    $('#pchcfirstoncallend').prop('disabled', false);
                    $('#pchcfirstoncallend').attr('min', startDate);
                } else {
                    $('#pchcfirstoncallend').val('').prop('disabled', true);
                }
            });

            $('#pchcfirstoncallend').on('change', function() {
                let startDate = $('#pchcfirstoncallstart').val();
                let endDate = $(this).val();
                if (endDate < startDate) {
                    alert("End date cannot be before the start date!");
                    $(this).val('');
                }
            });
            //Secondcall end

            //Thirdcall start
            $('#pchcseconcallend').prop('disabled', true);
            $('#pchcseconcallstart').on('change', function() {
                let startDate = $(this).val();
                if (startDate) {
                    $('#pchcseconcallend').prop('disabled', false);
                    $('#pchcseconcallend').attr('min', startDate);
                } else {
                    $('#pchcseconcallend').val('').prop('disabled', true);
                }
            });

            $('#pchcseconcallend').on('change', function() {
                let startDate = $('#pchcseconcallstart').val();
                let endDate = $(this).val();
                if (endDate < startDate) {
                    alert("End date cannot be before the start date!");
                    $(this).val('');
                }
            });
            //Thirdcall end

            //ICUAM start
            $('#pchcmooncallend').prop('disabled', true);
            $('#pchcmooncallstart').on('change', function() {
                let startDate = $(this).val();
                if (startDate) {
                    $('#pchcmooncallend').prop('disabled', false);
                    $('#pchcmooncallend').attr('min', startDate);
                } else {
                    $('#pchcmooncallend').val('').prop('disabled', true);
                }
            });

            $('#pchcmooncallend').on('change', function() {
                let startDate = $('#pchcmooncallstart').val();
                let endDate = $(this).val();
                if (endDate < startDate) {
                    alert("End date cannot be before the start date!");
                    $(this).val('');
                }
            });
            //ICUAM end
            //Checking Date CT End 
        }

    }); 
});
