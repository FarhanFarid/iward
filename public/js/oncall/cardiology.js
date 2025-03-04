$(document).ready(function () {

    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        let targetTab = $(e.target).attr("href"); // Get the target tab ID
        
        if (targetTab === "#cardiology") {
            setTimeout(function () {
                let selectedDate = $("#cdcalendardate").val();
                initCalendar(selectedDate); // Reinitialize the calendar
            }, 100); // Small delay to ensure the tab transition is complete
        }
    });

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

    // Set default date to today on page load
    let today = moment().format('YYYY-MM-DD');
    $("#cdcalendardate").val(today);
    initCalendar(today); // Initialize the calendar with today's date

    // Update calendar when date changes
    $("#cdcalendardate").on("change", function () {
        let selectedDate = $(this).val();
        initCalendar(selectedDate); // Reinitialize the calendar with the selected date
    });


    $('.assign-cd').on('click', function() {

        $('#assigncd-modal').modal('show');

    });

    $('.save-occd').on('click', async function() {

        var form        = $(this).parent().parent().find('form#oncallcardiologyform');
        var formData    = await getAllInput(form);
        var data        = processSerialize(formData);
        var url         = config.routes.oncallassignment.cardiology.save;

        $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            data: data,
            // beforeSend: function(){
            //     $("#loading-overlay").show();
            // },
            success: function(data) {

                Swal.fire({
                    title: "Success!",
                    text: "Successfully Saved!",
                    icon: "success",
                    buttonsStyling: false,
                    showConfirmButton: false,
                    timer: 3000
                });

                setTimeout(function() {
                    location.reload();
                }, 3000);
            },
            error: function(xhr, status, error) {
                toastr.error('Error saving reaction: ' + error, {timeOut: 5000});
            }
        });

    });

    $('.update-occd').on('click', async function() {

        var form        = $(this).parent().parent().find('form#updateoncallcardiologyform');
        var formData    = await getAllInput(form);
        var data        = processSerialize(formData);
        var url         = config.routes.oncallassignment.cardiology.update;

        console.log(data);
        console.log(url);


        $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            data: data,
            // beforeSend: function(){
            //     $("#loading-overlay").show();
            // },
            success: function(data) {

                Swal.fire({
                    title: "Success!",
                    text: "Successfully Updated!",
                    icon: "success",
                    buttonsStyling: false,
                    showConfirmButton: false,
                    timer: 3000
                });

                setTimeout(function() {
                    location.reload();
                }, 3000);
            },
            error: function(xhr, status, error) {
                toastr.error('Error saving reaction: ' + error, {timeOut: 5000});
            }
        });

    });

    //Checking Date CT
    //Consulltant start
    $('#cdconsoncallend').prop('disabled', true);
    $('#cdconsoncallstart').on('change', function() {
        let startDate = $(this).val();
        if (startDate) {
            $('#cdconsoncallend').prop('disabled', false);
            $('#cdconsoncallend').attr('min', startDate);
        } else {
            $('#cdconsoncallend').val('').prop('disabled', true);
        }
    });

    $('#cdconsoncallend').on('change', function() {
        let startDate = $('#cdconsoncallstart').val();
        let endDate = $(this).val();
        if (endDate < startDate) {
            alert("End date cannot be before the start date!");
            $(this).val('');
        }
    });
    //Consulltant end

    //Firstcall start
    $('#cdcardiooncallend').prop('disabled', true);
    $('#cdcardiooncallstart').on('change', function() {
        let startDate = $(this).val();
        if (startDate) {
            $('#cdcardiooncallend').prop('disabled', false);
            $('#cdcardiooncallend').attr('min', startDate);
        } else {
            $('#cdcardiooncallend').val('').prop('disabled', true);
        }
    });

    $('#cdcardiooncallend').on('change', function() {
        let startDate = $('#cdcardiooncallstart').val();
        let endDate = $(this).val();
        if (endDate < startDate) {
            alert("End date cannot be before the start date!");
            $(this).val('');
        }
    });
    //Firstcall end

    //Secondcall start
    $('#cdfirstoncallend').prop('disabled', true);
    $('#cdfirstoncallstart').on('change', function() {
        let startDate = $(this).val();
        if (startDate) {
            $('#cdfirstoncallend').prop('disabled', false);
            $('#cdfirstoncallend').attr('min', startDate);
        } else {
            $('#cdfirstoncallend').val('').prop('disabled', true);
        }
    });

    $('#cdfirstoncallend').on('change', function() {
        let startDate = $('#cdfirstoncallstart').val();
        let endDate = $(this).val();
        if (endDate < startDate) {
            alert("End date cannot be before the start date!");
            $(this).val('');
        }
    });
    //Secondcall end

    //Thirdcall start
    $('#cdseconcallend').prop('disabled', true);
    $('#cdseconcallstart').on('change', function() {
        let startDate = $(this).val();
        if (startDate) {
            $('#cdseconcallend').prop('disabled', false);
            $('#cdseconcallend').attr('min', startDate);
        } else {
            $('#cdseconcallend').val('').prop('disabled', true);
        }
    });

    $('#cdseconcallend').on('change', function() {
        let startDate = $('#cdseconcallstart').val();
        let endDate = $(this).val();
        if (endDate < startDate) {
            alert("End date cannot be before the start date!");
            $(this).val('');
        }
    });
    //Thirdcall end

    //ICUAM start
    $('#cdmooncallend').prop('disabled', true);
    $('#cdmooncallstart').on('change', function() {
        let startDate = $(this).val();
        if (startDate) {
            $('#cdmooncallend').prop('disabled', false);
            $('#cdmooncallend').attr('min', startDate);
        } else {
            $('#cdmooncallend').val('').prop('disabled', true);
        }
    });

    $('#cdmooncallend').on('change', function() {
        let startDate = $('#cdmooncallstart').val();
        let endDate = $(this).val();
        if (endDate < startDate) {
            alert("End date cannot be before the start date!");
            $(this).val('');
        }
    });
    //ICUAM end

    //ICUPM start
    $('#cdeponcallend').prop('disabled', true);
    $('#cdeponcallstart').on('change', function() {
        let startDate = $(this).val();
        if (startDate) {
            $('#cdeponcallend').prop('disabled', false);
            $('#cdeponcallend').attr('min', startDate);
        } else {
            $('#cdeponcallend').val('').prop('disabled', true);
        }
    });

    $('#cdeponcallend').on('change', function() {
        let startDate = $('#cdeponcallstart').val();
        let endDate = $(this).val();
        if (endDate < startDate) {
            alert("End date cannot be before the start date!");
            $(this).val('');
        }
    });
    //ICUPM end
    //Checking Date CT End  
});
