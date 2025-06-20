function initAnaesTab() {
    "use strict";

    let calendar;
    const calendarEl = document.getElementById('anaes-calendar');

    function initCalendar(selectedDate) {
        if (!calendarEl) return;

        if (calendar) calendar.destroy();

        calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: ''
            },
            initialDate: selectedDate || moment().format('YYYY-MM-DD'),
            navLinks: true,
            selectable: true,
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
                                    return (positionHierarchy[a.position_type] ?? 99) - (positionHierarchy[b.position_type] ?? 99);
                                })
                                .map(item => {
                                    const color = {
                                        consultant: '#87CEFA',
                                        sr: '#7FFFD4',
                                        sricu: '#AFEEEE',
                                        mo: '#40E0D0'
                                    }[item.position_type] || '#F0E68C';

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
                    error: failureCallback
                });
            },
            eventClick: function(info) {
                const { id, oncallDate, sso } = info.event.extendedProps;
                $("#ocanaesid").val(id); 
                $("#updateanaesoncalldate").val(oncallDate);
                $("#updateanaesstaff").val(sso).trigger("change");
                $('#updateanaes-modal').modal('show');
            }
        });

        calendar.render();
    }

    // Default date and event listeners
    const today = moment().format('YYYY-MM-DD');
    $("#anaescalendardate").val(today);
    initCalendar(today);

    $("#anaescalendardate").on("change", function () {
        initCalendar($(this).val());
    });

    $('.assign-anaes').on('click', function() {
        $('#assignanaes-modal').modal('show');
    });

    $('.save-ocanaes').on('click', async function() {
        const form = $('#oncallanaesform');
        const data = processSerialize(await getAllInput(form));
        const url = config.routes.oncallassignment.anaes.save;

        $.ajax({
            url,
            type: "POST",
            dataType: "json",
            data,
            beforeSend: () => $("#loading-overlay").show(),
            success: function() {
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
                    $('#assignanaes-modal').modal('hide');
                }, 1000);
            },
            error: function(xhr, status, error) {
                toastr.error('Error saving: ' + error, {timeOut: 5000});
            }
        });
    });

    $('.update-ocanaes').on('click', async function() {
        const form = $('#updateoncallanaesform');
        const data = processSerialize(await getAllInput(form));
        const url = config.routes.oncallassignment.anaes.update;

        $.ajax({
            url,
            type: "POST",
            dataType: "json",
            data,
            beforeSend: () => $("#loading-overlay").show(),
            success: function() {
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
                    $('#updateanaes-modal').modal('hide');
                }, 1000);
            },
            error: function(xhr, status, error) {
                toastr.error('Error updating: ' + error, {timeOut: 5000});
            }
        });
    });

    // Helper for range validation
    function bindDateValidation(start, end) {
        $(end).prop('disabled', true);
        $(start).on('change', function () {
            const val = $(this).val();
            if (val) {
                $(end).prop('disabled', false).attr('min', val);
            } else {
                $(end).val('').prop('disabled', true);
            }
        });

        $(end).on('change', function () {
            if ($(this).val() < $(start).val()) {
                alert("End date cannot be before the start date!");
                $(this).val('');
            }
        });
    }

    bindDateValidation('#anaesconsoncallstart', '#anaesconsoncallend');
    bindDateValidation('#anaessroncallstart', '#anaessroncallend');
    bindDateValidation('#anaessricuoncallstart', '#anaessricuoncallend');
    bindDateValidation('#anaesmooncallstart', '#anaesmooncallend');
}
