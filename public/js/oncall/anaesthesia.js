$(document).ready(function () {

    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        let targetTab = $(e.target).attr("href"); // Get the target tab ID
        
        if (targetTab === "#anaes") {
            setTimeout(function () {
                let selectedDate = $("#anaescalendardate").val();
                initCalendar(selectedDate); // Reinitialize the calendar
            }, 100); // Small delay to ensure the tab transition is complete

            "use strict";

            var calendar;
            var calendarEl = document.getElementById('anaes-calendar');

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
                            url: config.routes.oncallassignment.anaes.getlist,
                            method: 'GET',
                            success: function(data) {
                                if (data.status === 'success') {
                                    const positionHierarchy = {
                                        "consultant": 0, 
                                        "sr": 1,
                                        "sricu": 2,
                                        "mo": 3,
                                    };
                
                                    const positionLabels = {
                                        "consultant": "Cons",
                                        "sr": "SR",
                                        "sricu": "SR ICU",
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
                                            case 'sr': color = '#7FFFD4'; break;
                                            case 'sricu': color = '#AFEEEE'; break;
                                            case 'mo': color = '#40E0D0'; break;
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

                        $("#ocanaesid").val(id); 
                        $("#updateanaesoncalldate").val(date);
                        $("#updateanaesstaff").val(sso).trigger("change");  

                        $('#updateanaes-modal').modal('show');

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
            $("#anaescalendardate").val(today);
            initCalendar(today); // Initialize the calendar with today's date

            // Update calendar when date changes
            $("#anaescalendardate").on("change", function () {
                let selectedDate = $(this).val();
                initCalendar(selectedDate); // Reinitialize the calendar with the selected date
            });


            $('.assign-anaes').on('click', function() {

                $('#assignanaes-modal').modal('show');

            });

            $('.save-ocanaes').on('click', async function() {

                var form        = $(this).parent().parent().find('form#oncallanaesform');
                var formData    = await getAllInput(form);
                var data        = processSerialize(formData);
                var url         = config.routes.oncallassignment.anaes.save;

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
                            $('#assignanaes-modal').modal('hide');
                        }, 1000);
                    },
                    error: function(xhr, status, error) {
                        toastr.error('Error saving reaction: ' + error, {timeOut: 5000});
                    }
                });
            });

            $('.update-ocanaes').on('click', async function() {

                var form        = $(this).parent().parent().find('form#updateoncallanaesform');
                var formData    = await getAllInput(form);
                var data        = processSerialize(formData);
                var url         = config.routes.oncallassignment.anaes.update;

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
                            $('#updateanaes-modal').modal('hide');
                        }, 1000);
                    },
                    error: function(xhr, status, error) {
                        toastr.error('Error saving reaction: ' + error, {timeOut: 5000});
                    }
                });

            });

            //Checking Date CT
            //Consulltant start
            $('#anaesconsoncallend').prop('disabled', true);
            $('#anaesconsoncallstart').on('change', function() {
                let startDate = $(this).val();
                if (startDate) {
                    $('#anaesconsoncallend').prop('disabled', false);
                    $('#anaesconsoncallend').attr('min', startDate);
                } else {
                    $('#anaesconsoncallend').val('').prop('disabled', true);
                }
            });

            $('#anaesconsoncallend').on('change', function() {
                let startDate = $('#anaesconsoncallstart').val();
                let endDate = $(this).val();
                if (endDate < startDate) {
                    alert("End date cannot be before the start date!");
                    $(this).val('');
                }
            });
            //Consulltant end

            //Firstcall start
            $('#anaessroncallend').prop('disabled', true);
            $('#anaessroncallstart').on('change', function() {
                let startDate = $(this).val();
                if (startDate) {
                    $('#anaessroncallend').prop('disabled', false);
                    $('#anaessroncallend').attr('min', startDate);
                } else {
                    $('#anaessroncallend').val('').prop('disabled', true);
                }
            });

            $('#anaessroncallend').on('change', function() {
                let startDate = $('#anaessroncallstart').val();
                let endDate = $(this).val();
                if (endDate < startDate) {
                    alert("End date cannot be before the start date!");
                    $(this).val('');
                }
            });
            //Firstcall end

            //Secondcall start
            $('#anaessricuoncallend').prop('disabled', true);
            $('#anaessricuoncallstart').on('change', function() {
                let startDate = $(this).val();
                if (startDate) {
                    $('#anaessricuoncallend').prop('disabled', false);
                    $('#anaessricuoncallend').attr('min', startDate);
                } else {
                    $('#anaessricuoncallend').val('').prop('disabled', true);
                }
            });

            $('#anaessricuoncallend').on('change', function() {
                let startDate = $('#anaessricuoncallstart').val();
                let endDate = $(this).val();
                if (endDate < startDate) {
                    alert("End date cannot be before the start date!");
                    $(this).val('');
                }
            });
            //Secondcall end

            //Thirdcall start
            $('#anaesmooncallend').prop('disabled', true);
            $('#anaesmooncallstart').on('change', function() {
                let startDate = $(this).val();
                if (startDate) {
                    $('#anaesmooncallend').prop('disabled', false);
                    $('#anaesmooncallend').attr('min', startDate);
                } else {
                    $('#anaesmooncallend').val('').prop('disabled', true);
                }
            });

            $('#anaesmooncallend').on('change', function() {
                let startDate = $('#anaesmooncallstart').val();
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
