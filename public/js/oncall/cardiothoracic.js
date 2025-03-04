$(document).ready(function () {
    "use strict";

    var calendar;
    var calendarEl = document.getElementById('cardiothoracic-calendar');

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
                    url: config.routes.oncallassignment.cardiothoracic.getlist,
                    method: 'GET',
                    success: function(data) {
                        if (data.status === 'success') {
                            const positionHierarchy = {
                                "consultant": 0, 
                                "firstcall": 1,
                                "secondcall": 2,
                                "thirdcall": 3,
                                "icuam": 4,
                                "icupm": 5
                            };
        
                            const positionLabels = {
                                "consultant": "Cons",
                                "firstcall": "1st",
                                "secondcall": "2nd",
                                "thirdcall": "3rd",
                                "icuam": "ICU AM",
                                "icupm": "ICU PM"
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
                                    case 'thirdcall': color = '#40E0D0'; break;
                                    case 'icuam': color = '#F5FFFA'; break;
                                    case 'icupm': color = '#EEE8AA'; break;
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

                $("#occtid").val(id); 
                $("#updatectoncalldate").val(date);
                $("#updatectstaff").val(sso).trigger("change");  

                $('#updatect-modal').modal('show');

            }
        });
        
        calendar.render();
        
    }


    // Set default date to today on page load
    let today = moment().format('YYYY-MM-DD');
    $("#ctcalendardate").val(today);
    initCalendar(today); // Initialize the calendar with today's date

    // Update calendar when date changes
    $("#ctcalendardate").on("change", function () {
        let selectedDate = $(this).val();
        initCalendar(selectedDate); // Reinitialize the calendar with the selected date
    });


    $('.assign-ct').on('click', function() {

        $('#assignct-modal').modal('show');

    });

    $('.save-occt').on('click', async function() {

        var form        = $(this).parent().parent().find('form#oncallcardiothoracicform');
        var formData    = await getAllInput(form);
        var data        = processSerialize(formData);
        var url         = config.routes.oncallassignment.cardiothoracic.save;

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

    $('.update-occt').on('click', async function() {

        var form        = $(this).parent().parent().find('form#updateoncallcardiothoracicform');
        var formData    = await getAllInput(form);
        var data        = processSerialize(formData);
        var url         = config.routes.oncallassignment.cardiothoracic.update;

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
    $('#oncallendcons').prop('disabled', true);
    $('#oncallstartcons').on('change', function() {
        let startDate = $(this).val();
        if (startDate) {
            $('#oncallendcons').prop('disabled', false);
            $('#oncallendcons').attr('min', startDate);
        } else {
            $('#oncallendcons').val('').prop('disabled', true);
        }
    });

    $('#oncallendcons').on('change', function() {
        let startDate = $('#oncallstartcons').val();
        let endDate = $(this).val();
        if (endDate < startDate) {
            alert("End date cannot be before the start date!");
            $(this).val('');
        }
    });
    //Consulltant end

    //Firstcall start
    $('#oncallendfirst').prop('disabled', true);
    $('#oncallstartfirst').on('change', function() {
        let startDate = $(this).val();
        if (startDate) {
            $('#oncallendfirst').prop('disabled', false);
            $('#oncallendfirst').attr('min', startDate);
        } else {
            $('#oncallendfirst').val('').prop('disabled', true);
        }
    });

    $('#oncallendfirst').on('change', function() {
        let startDate = $('#oncallstartfirst').val();
        let endDate = $(this).val();
        if (endDate < startDate) {
            alert("End date cannot be before the start date!");
            $(this).val('');
        }
    });
    //Firstcall end

    //Secondcall start
    $('#oncallendsec').prop('disabled', true);
    $('#oncallstartsec').on('change', function() {
        let startDate = $(this).val();
        if (startDate) {
            $('#oncallendsec').prop('disabled', false);
            $('#oncallendsec').attr('min', startDate);
        } else {
            $('#oncallendsec').val('').prop('disabled', true);
        }
    });

    $('#oncallendsec').on('change', function() {
        let startDate = $('#oncallstartsec').val();
        let endDate = $(this).val();
        if (endDate < startDate) {
            alert("End date cannot be before the start date!");
            $(this).val('');
        }
    });
    //Secondcall end

    //Thirdcall start
    $('#oncallendthird').prop('disabled', true);
    $('#oncallstartthird').on('change', function() {
        let startDate = $(this).val();
        if (startDate) {
            $('#oncallendthird').prop('disabled', false);
            $('#oncallendthird').attr('min', startDate);
        } else {
            $('#oncallendthird').val('').prop('disabled', true);
        }
    });

    $('#oncallendthird').on('change', function() {
        let startDate = $('#oncallstartthird').val();
        let endDate = $(this).val();
        if (endDate < startDate) {
            alert("End date cannot be before the start date!");
            $(this).val('');
        }
    });
    //Thirdcall end

    //ICUAM start
    $('#oncallendicuam').prop('disabled', true);
    $('#oncallstarticuam').on('change', function() {
        let startDate = $(this).val();
        if (startDate) {
            $('#oncallendicuam').prop('disabled', false);
            $('#oncallendicuam').attr('min', startDate);
        } else {
            $('#oncallendicuam').val('').prop('disabled', true);
        }
    });

    $('#oncallendicuam').on('change', function() {
        let startDate = $('#oncallstarticuam').val();
        let endDate = $(this).val();
        if (endDate < startDate) {
            alert("End date cannot be before the start date!");
            $(this).val('');
        }
    });
    //ICUAM end

    //ICUPM start
    $('#oncallendicupm').prop('disabled', true);
    $('#oncallstarticupm').on('change', function() {
        let startDate = $(this).val();
        if (startDate) {
            $('#oncallendicupm').prop('disabled', false);
            $('#oncallendicupm').attr('min', startDate);
        } else {
            $('#oncallendicupm').val('').prop('disabled', true);
        }
    });

    $('#oncallendicupm').on('change', function() {
        let startDate = $('#oncallstarticupm').val();
        let endDate = $(this).val();
        if (endDate < startDate) {
            alert("End date cannot be before the start date!");
            $(this).val('');
        }
    });
    //ICUPM end
    //Checking Date CT End  
});
