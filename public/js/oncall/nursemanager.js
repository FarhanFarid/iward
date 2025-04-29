$(document).ready(function () {

    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        let targetTab = $(e.target).attr("href"); // Get the target tab ID
        
        if (targetTab === "#nursemanager") {
            setTimeout(function () {
                let selectedDate = $("#nmcalendardate").val();
                initCalendar(selectedDate); // Reinitialize the calendar
            }, 100); // Small delay to ensure the tab transition is complete
        

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

                        $("#ocnmid").val(id); 
                        $("#updatenmoncalldate").val(date);
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

            $('.save-ocnm').on('click', async function() {

                var form        = $(this).parent().parent().find('form#oncallnursemanagerform');
                var formData    = await getAllInput(form);
                var data        = processSerialize(formData);
                var url         = config.routes.oncallassignment.nursemanager.save;

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
                            $('#assignnm-modal').modal('hide');
                        }, 1000);
                    },
                    error: function(xhr, status, error) {
                        toastr.error('Error saving reaction: ' + error, {timeOut: 5000});
                    }
                });

            });

            $('.update-ocnm').on('click', async function() {

                var form        = $(this).parent().parent().find('form#updateoncallnursemanagerform');
                var formData    = await getAllInput(form);
                var data        = processSerialize(formData);
                var url         = config.routes.oncallassignment.nursemanager.update;

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
                            $('#updatenm-modal').modal('hide');
                        }, 1000);
                    },
                    error: function(xhr, status, error) {
                        toastr.error('Error saving reaction: ' + error, {timeOut: 5000});
                    }
                });

            });

            // Set default date to today on page load
            let today = moment().format('YYYY-MM-DD');
            $("#nmcalendardate").val(today);
            initCalendar(today); // Initialize the calendar with today's date

            // Update calendar when date changes
            $("#nmcalendardate").on("change", function () {
                let selectedDate = $(this).val();
                initCalendar(selectedDate); // Reinitialize the calendar with the selected date
            });


            $('.assign-nm').on('click', function() {

                $('#assignnm-modal').modal('show');

            });

            //Checking Date NM Start
            //Firstcall start
            $('#nmfirstoncallend').prop('disabled', true);
            $('#nmfirstoncallstart').on('change', function() {
                let startDate = $(this).val();
                if (startDate) {
                    $('#nmfirstoncallend').prop('disabled', false);
                    $('#nmfirstoncallend').attr('min', startDate);
                } else {
                    $('#nmfirstoncallend').val('').prop('disabled', true);
                }
            });

            $('#nmfirstoncallend').on('change', function() {
                let startDate = $('#nmfirstoncallstart').val();
                let endDate = $(this).val();
                if (endDate < startDate) {
                    alert("End date cannot be before the start date!");
                    $(this).val('');
                }
            });
            //Firstcall end

            //Secondcall start
            $('#nmseconcallend').prop('disabled', true);
            $('#nmseconcallstart').on('change', function() {
                let startDate = $(this).val();
                if (startDate) {
                    $('#nmseconcallend').prop('disabled', false);
                    $('#nmseconcallend').attr('min', startDate);
                } else {
                    $('#nmseconcallend').val('').prop('disabled', true);
                }
            });

            $('#nmseconcallend').on('change', function() {
                let startDate = $('#nmseconcallstart').val();
                let endDate = $(this).val();
                if (endDate < startDate) {
                    alert("End date cannot be before the start date!");
                    $(this).val('');
                }
            });
            //Secondcall end

            //WeekendAm start
            $('#nmamoncallend').prop('disabled', true);
            $('#nmamoncallstart').on('change', function() {
                let startDate = $(this).val();
                if (startDate) {
                    $('#nmamoncallend').prop('disabled', false);
                    $('#nmamoncallend').attr('min', startDate);
                } else {
                    $('#nmamoncallend').val('').prop('disabled', true);
                }
            });

            $('#nmamoncallend').on('change', function() {
                let startDate = $('#nmamoncallstart').val();
                let endDate = $(this).val();
                if (endDate < startDate) {
                    alert("End date cannot be before the start date!");
                    $(this).val('');
                }
            });
            //WeekendAm end

            //WeekendPm start
            $('#nmpmoncallend').prop('disabled', true);
            $('#nmpmoncallstart').on('change', function() {
                let startDate = $(this).val();
                if (startDate) {
                    $('#nmpmoncallend').prop('disabled', false);
                    $('#nmpmoncallend').attr('min', startDate);
                } else {
                    $('#nmpmoncallend').val('').prop('disabled', true);
                }
            });

            $('#nmpmoncallend').on('change', function() {
                let startDate = $('#nmpmoncallstart').val();
                let endDate = $(this).val();
                if (endDate < startDate) {
                    alert("End date cannot be before the start date!");
                    $(this).val('');
                }
            });
            //WeekendPm end

            //Oncall start
            $('#nmoncallend').prop('disabled', true);
            $('#nmoncallstart').on('change', function() {
                let startDate = $(this).val();
                if (startDate) {
                    $('#nmoncallend').prop('disabled', false);
                    $('#nmoncallend').attr('min', startDate);
                } else {
                    $('#nmoncallend').val('').prop('disabled', true);
                }
            });

            $('#nmoncallend').on('change', function() {
                let startDate = $('#nmoncallstart').val();
                let endDate = $(this).val();
                if (endDate < startDate) {
                    alert("End date cannot be before the start date!");
                    $(this).val('');
                }
            });
            //Oncall end
            //Checking Date NM End 
        }
    }); 
});