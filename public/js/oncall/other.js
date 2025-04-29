$(document).ready(function () {

    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        let targetTab = $(e.target).attr("href"); // Get the target tab ID
        
        if (targetTab === "#other") {
            setTimeout(function () {
                let selectedDate = $("#othercalendardate").val();
                initCalendar(selectedDate); // Reinitialize the calendar
            }, 100); // Small delay to ensure the tab transition is complete

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
                    events: function(fetchInfo, successCallback, failureCallback) {
                        $.ajax({
                            url: config.routes.oncallassignment.other.getlist,
                            method: 'GET',
                            success: function(data) {
                                if (data.status === 'success') {
                                    const positionHierarchy = {
                                        "perfusionist": 0, 
                                        "dietitian": 1,
                                        "physiotherapist": 2,
                                        "resplab": 3,
                                        "cvt": 4,
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

                        $("#ocothid").val(id); 
                        $("#updateothoncalldate").val(date);
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

            // Set default date to today on page load
            let today = moment().format('YYYY-MM-DD');
            $("#othcalendardate").val(today);
            initCalendar(today); // Initialize the calendar with today's date

            // Update calendar when date changes
            $("#othcalendardate").on("change", function () {
                let selectedDate = $(this).val();
                initCalendar(selectedDate); // Reinitialize the calendar with the selected date
            });


            $('.assign-oth').on('click', function() {

                $('#assignoth-modal').modal('show');

            });

            $('.save-ocoth').on('click', async function() {

                var form        = $(this).parent().parent().find('form#oncallotherform');
                var formData    = await getAllInput(form);
                var data        = processSerialize(formData);
                var url         = config.routes.oncallassignment.other.save;

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
                            $('#assignoth-modal').modal('hide');
                        }, 1000);
                    },
                    error: function(xhr, status, error) {
                        toastr.error('Error saving reaction: ' + error, {timeOut: 5000});
                    }
                });

            });

            $('.update-ocoth').on('click', async function() {

                var form        = $(this).parent().parent().find('form#updateoncallotherform');
                var formData    = await getAllInput(form);
                var data        = processSerialize(formData);
                var url         = config.routes.oncallassignment.other.update;

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
                            $('#updateoth-modal').modal('hide');
                        }, 1000);
                    },
                    error: function(xhr, status, error) {
                        toastr.error('Error saving reaction: ' + error, {timeOut: 5000});
                    }
                });

            });

            //Checking Date CT
            //Consulltant start
            $('#othperfoncallend').prop('disabled', true);
            $('#othperfoncallstart').on('change', function() {
                let startDate = $(this).val();
                if (startDate) {
                    $('#othperfoncallend').prop('disabled', false);
                    $('#othperfoncallend').attr('min', startDate);
                } else {
                    $('#othperfoncallend').val('').prop('disabled', true);
                }
            });

            $('#othperfoncallend').on('change', function() {
                let startDate = $('#othperfoncallstart').val();
                let endDate = $(this).val();
                if (endDate < startDate) {
                    alert("End date cannot be before the start date!");
                    $(this).val('');
                }
            });
            //Consulltant end

            //Firstcall start
            $('#othdietoncallend').prop('disabled', true);
            $('#othdietoncallstart').on('change', function() {
                let startDate = $(this).val();
                if (startDate) {
                    $('#othdietoncallend').prop('disabled', false);
                    $('#othdietoncallend').attr('min', startDate);
                } else {
                    $('#othdietoncallend').val('').prop('disabled', true);
                }
            });

            $('#othdietoncallend').on('change', function() {
                let startDate = $('#othdietoncallstart').val();
                let endDate = $(this).val();
                if (endDate < startDate) {
                    alert("End date cannot be before the start date!");
                    $(this).val('');
                }
            });
            //Firstcall end

            //Secondcall start
            $('#othphysiooncallend').prop('disabled', true);
            $('#othphysiooncallstart').on('change', function() {
                let startDate = $(this).val();
                if (startDate) {
                    $('#othphysiooncallend').prop('disabled', false);
                    $('#othphysiooncallend').attr('min', startDate);
                } else {
                    $('#othphysiooncallend').val('').prop('disabled', true);
                }
            });

            $('#othphysiooncallend').on('change', function() {
                let startDate = $('#othphysiooncallstart').val();
                let endDate = $(this).val();
                if (endDate < startDate) {
                    alert("End date cannot be before the start date!");
                    $(this).val('');
                }
            });
            //Secondcall end

            //Thirdcall start
            $('#othlaboncallend').prop('disabled', true);
            $('#othlaboncallstart').on('change', function() {
                let startDate = $(this).val();
                if (startDate) {
                    $('#othlaboncallend').prop('disabled', false);
                    $('#othlaboncallend').attr('min', startDate);
                } else {
                    $('#othlaboncallend').val('').prop('disabled', true);
                }
            });

            $('#othlaboncallend').on('change', function() {
                let startDate = $('#othlaboncallstart').val();
                let endDate = $(this).val();
                if (endDate < startDate) {
                    alert("End date cannot be before the start date!");
                    $(this).val('');
                }
            });
            //Thirdcall end

            //ICUAM start
            $('#othcvtoncallend').prop('disabled', true);
            $('#othcvtoncallstart').on('change', function() {
                let startDate = $(this).val();
                if (startDate) {
                    $('#othcvtoncallend').prop('disabled', false);
                    $('#othcvtoncallend').attr('min', startDate);
                } else {
                    $('#othcvtoncallend').val('').prop('disabled', true);
                }
            });

            $('#othcvtoncallend').on('change', function() {
                let startDate = $('#othcvtoncallstart').val();
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
