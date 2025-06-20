function initSaTab() {
    "use strict";

    let calendar;
    let calendarEl = document.getElementById('sa-calendar');

    function renderCalendar(selectedDate) {
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
            eventStartEditable: false,
            selectMirror: true,
            droppable: false,
            events: function (fetchInfo, successCallback, failureCallback) {
                const selectedLocation = $('#salocation').val();
                if (!selectedLocation) return successCallback([]);

                $.ajax({
                    url: config.routes.oncallassignment.sa.getlist,
                    method: 'GET',
                    data: { salocation: selectedLocation },
                    success: function (data) {
                        if (data.status !== 'success') return failureCallback();

                        const positionHierarchy = {
                            "tlam": 0, "tlpm": 1, "tloncall": 2,
                            "iam1": 3, "ipm1": 4, "ioncall1": 5,
                            "iam2": 6, "ipm2": 7, "ioncall2": 8,
                            "iam3": 9, "ipm3": 10, "ioncall3": 11,
                            "iam4": 12, "ipm4": 13, "ioncall4": 14,
                            "iam5": 15, "ipm5": 16, "ioncall5": 17,
                            "iam6": 18, "ipm6": 19, "ioncall6": 20,
                            "medam1": 21, "medpm1": 22, "medoncall1": 23,
                            "medam2": 24, "medpm2": 25, "medoncall2": 26,
                            "medam3": 27, "medpm3": 28, "medoncall3": 29,
                            "medam4": 48, "medpm4": 49, "medoncall4": 50,
                            "runam1": 30, "runpm1": 31, "runoncall1": 32,
                            "runam2": 33, "runpm2": 34, "runoncall2": 35,
                            "runam3": 36, "runpm3": 37, "runoncall3": 38,
                            "runam4": 39, "runpm4": 40, "runoncall4": 41,
                            "runam5": 42, "runpm5": 43, "runoncall5": 44,
                            "runam6": 45, "runpm6": 46, "runoncall6": 47,
                        };

                        const positionLabels = {
                            "tlam": "TL AM", "tlpm": "TL PM", "tloncall": "TL Oncall",
                            "iam1": "INC AM 1", "ipm1": "INC PM 1", "ioncall1": "INC Oncall 1",
                            "iam2": "INC AM 2", "ipm2": "INC PM 2", "ioncall2": "INC Oncall 2",
                            "iam3": "INC AM 3", "ipm3": "INC PM 3", "ioncall3": "INC Oncall 3",
                            "iam4": "INC AM 4", "ipm4": "INC PM 4", "ioncall4": "INC Oncall 4",
                            "iam5": "INC AM 5", "ipm5": "INC PM 5", "ioncall5": "INC Oncall 5",
                            "iam6": "INC AM 6", "ipm6": "INC PM 6", "ioncall6": "INC Oncall 6",
                            "medam1": "MED AM 1", "medpm1": "MED PM 1", "medoncall1": "MED Oncall 1",
                            "medam2": "MED AM 2", "medpm2": "MED PM 2", "medoncall2": "MED Oncall 2",
                            "medam3": "MED AM 3", "medpm3": "MED PM 3", "medoncall3": "MED Oncall 3",
                            "medam4": "MED AM 4", "medpm4": "MED PM 4", "medoncall4": "MED Oncall 4",
                            "runam1": "RUN AM 1", "runpm1": "RUN PM 1", "runoncall1": "RUN Oncall 1",
                            "runam2": "RUN AM 2", "runpm2": "RUN PM 2", "runoncall2": "RUN Oncall 2",
                            "runam3": "RUN AM 3", "runpm3": "RUN PM 3", "runoncall3": "RUN Oncall 3",
                            "runam4": "RUN AM 4", "runpm4": "RUN PM 4", "runoncall4": "RUN Oncall 4",
                            "runam5": "RUN AM 5", "runpm5": "RUN PM 5", "runoncall5": "RUN Oncall 5",
                            "runam6": "RUN AM 6", "runpm6": "RUN PM 6", "runoncall6": "RUN Oncall 6",
                        };

                        const events = data.response
                            .sort((a, b) => (positionHierarchy[a.position_type] ?? 99) - (positionHierarchy[b.position_type] ?? 99))
                            .map(item => {
                                let color;
                                switch (item.position_type) {
                                    case 'tlam': case 'tlpm': case 'tloncall': color = '#87CEFA'; break;
                                    case 'iam1': case 'iam2': case 'iam3': case 'iam4': case 'iam5': case 'iam6':
                                    case 'ipm1': case 'ipm2': case 'ipm3': case 'ipm4': case 'ipm5': case 'ipm6': 
                                    case 'ioncall1': case 'ioncall2': case 'ioncall3': case 'ioncall4': case 'ioncall5': case 'ioncall6':  
                                    color = '#7FFFD4';
                                    break;
                                    case 'medam1': case 'medam2': case 'medam3': case 'medam4': 
                                    case 'medpm1': case 'medpm2': case 'medpm3': case 'medpm4': 
                                    case 'medoncall1': case 'medoncall2': case 'medoncall3': case 'medoncall4': 
                                    color = '#AFEEEE';
                                    break;
                                    case 'runam1': case 'runam2': case 'runam3': case 'runam4': case 'runam5': case 'runam6': 
                                    case 'runpm1': case 'runpm2': case 'runpm3': case 'runpm4': case 'runpm5': case 'runpm6': 
                                    case 'runoncall1': case 'runoncall2': case 'runoncall3': case 'runoncall4': case 'runoncall5': case 'runoncall6': 
                                    color = '#40E0D0'; 
                                    break;
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
                    },
                    error: failureCallback
                });
            },
            eventClick: function (info) {
                const { id, oncallDate, sso } = info.event.extendedProps;
                $("#ocsaid").val(id);
                $("#updatesaoncalldate").val(oncallDate);
                $("#updatesastaff").val(sso).trigger("change");
                $('#updatesa-modal').modal('show');
            }
        });

        calendar.render();
    }

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    const today = moment().format('YYYY-MM-DD');
    $("#sacalendardate").val(today);
    renderCalendar(today);

    $("#salocation, #sacalendardate").on("change", () => {
        renderCalendar($("#sacalendardate").val());
    });

    $('.assign-sa').on('click', () => $('#assignsa-modal').modal('show'));

    $('.save-ocsa').on('click', async function () {
        const form = $('#oncallsaform');
        const data = processSerialize(await getAllInput(form));
        const url = config.routes.oncallassignment.sa.save;

        $.ajax({
            url, type: "POST", dataType: "json", data,
            beforeSend: () => $("#loading-overlay").show(),
            success: () => {
                $("#loading-overlay").hide();
                Swal.fire({ title: "Success!", text: "Successfully Saved!", icon: "success", showConfirmButton: false, timer: 3000 });
                setTimeout(() => {
                    calendar.refetchEvents();
                    $('#assignsa-modal').modal('hide');
                }, 1000);
            },
            error: (xhr, status, error) => {
                toastr.error('Error saving reaction: ' + error, { timeOut: 5000 });
            }
        });
    });

    $('.update-ocsa').on('click', async function () {
        const form = $('#updateoncallsaform');
        const data = processSerialize(await getAllInput(form));
        const url = config.routes.oncallassignment.sa.update;

        $.ajax({
            url, type: "POST", dataType: "json", data,
            beforeSend: () => $("#loading-overlay").show(),
            success: () => {
                $("#loading-overlay").hide();
                Swal.fire({ title: "Success!", text: "Successfully Updated!", icon: "success", showConfirmButton: false, timer: 3000 });
                setTimeout(() => {
                    calendar.refetchEvents();
                    $('#updatesa-modal').modal('hide');
                }, 1000);
            },
            error: (xhr, status, error) => {
                toastr.error('Error saving reaction: ' + error, { timeOut: 5000 });
            }
        });
    });

    const validateDateRange = (startId, endId) => {
        const $start = $('#' + startId);
        const $end = $('#' + endId);

        $end.prop('disabled', true);

        $start.on('change', () => {
            const val = $start.val();
            $end.prop('disabled', !val).attr('min', val || '');
            if (!val) $end.val('');
        });

        $end.on('change', () => {
            if ($end.val() < $start.val()) {
                alert("End date cannot be before the start date!");
                $end.val('');
            }
        });
    };

    // Apply validation
    [
        ['tloncallstart', 'tloncallend'],
    ].forEach(([start, end]) => validateDateRange(start, end));

    for (let i = 1; i <= 6; i++) {
        const startSelector = '#ioncallstart' + i;
        const endSelector = '#ioncallend' + i;

        // Disable end input initially
        $(endSelector).prop('disabled', true);

        // When start date changes
        $(startSelector).on('change', function () {
            let startDate = $(this).val();
            if (startDate) {
                $(endSelector).prop('disabled', false);
                $(endSelector).attr('min', startDate);
            } else {
                $(endSelector).val('').prop('disabled', true);
            }
        });

        // Validate end date
        $(endSelector).on('change', function () {
            let startDate = $(startSelector).val();
            let endDate = $(this).val();
            if (endDate < startDate) {
                alert("End date cannot be before the start date!");
                $(this).val('');
            }
        });
    }

    for (let i = 1; i <= 6; i++) {
        const startSelector = '#runoncallstart' + i;
        const endSelector = '#runoncallend' + i;

        // Disable end input initially
        $(endSelector).prop('disabled', true);

        // When start date changes
        $(startSelector).on('change', function () {
            let startDate = $(this).val();
            if (startDate) {
                $(endSelector).prop('disabled', false);
                $(endSelector).attr('min', startDate);
            } else {
                $(endSelector).val('').prop('disabled', true);
            }
        });

        // Validate end date
        $(endSelector).on('change', function () {
            let startDate = $(startSelector).val();
            let endDate = $(this).val();
            if (endDate < startDate) {
                alert("End date cannot be before the start date!");
                $(this).val('');
            }
        });
    }

    for (let i = 1; i <= 6; i++) {
        const startSelector = '#medoncallstart' + i;
        const endSelector = '#medoncallend' + i;

        // Disable end input initially
        $(endSelector).prop('disabled', true);

        // When start date changes
        $(startSelector).on('change', function () {
            let startDate = $(this).val();
            if (startDate) {
                $(endSelector).prop('disabled', false);
                $(endSelector).attr('min', startDate);
            } else {
                $(endSelector).val('').prop('disabled', true);
            }
        });

        // Validate end date
        $(endSelector).on('change', function () {
            let startDate = $(startSelector).val();
            let endDate = $(this).val();
            if (endDate < startDate) {
                alert("End date cannot be before the start date!");
                $(this).val('');
            }
        });
    }

     // Show next Incharge section
     $('.show-next-incharge').on('click', function () {
        const next = $(this).data('next');
        $('#incharge-' + next).show();
    });

    // Hide current Incharge section and clear fields
    $('.hide-prev-incharge').on('click', function () {
        const prev = $(this).data('prev');
        const section = $('#incharge-' + prev);
        section.find('select, input').val('').trigger('change');
        section.hide();
    });

    // Show next Medication section
    $('.show-next-medication').on('click', function () {
        const next = $(this).data('next');
        $('#medication-' + next).show();
    });

    // Hide current Medication section and clear fields
    $('.hide-prev-medication').on('click', function () {
        const prev = $(this).data('prev');
        const section = $('#medication-' + prev);
        section.find('select, input').val('').trigger('change');
        section.hide();
    });

    $('.show-next-runner').on('click', function () {
        const next = $(this).data('next');
        $('#runner-' + next).show();
    });

    // Hide current Runner and clear inputs
    $('.hide-prev-runner').on('click', function () {
        const prev = $(this).data('prev');
        const section = $('#runner-' + prev);
        section.find('select, input').val('').trigger('change');
        section.hide();
    });
}
