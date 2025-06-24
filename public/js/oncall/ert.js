function initErtTab() {
    "use strict";

    let calendar;
    let calendarEl = document.getElementById('ert-calendar');

    function renderCalendar(selectedDate) {
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
            editable: true,
            eventStartEditable: false,
            selectMirror: true,
            droppable: false,
            events: function (fetchInfo, successCallback, failureCallback) {
                const selectedLocation = $('#ertlocation').val();

                if (!selectedLocation) {
                    successCallback([]);
                    return;
                }

                $.ajax({
                    url: config.routes.oncallassignment.ert.getlist,
                    method: 'GET',
                    data: { ertlocation: selectedLocation },
                    success: function (data) {
                        if (data.status === 'success') {

                            console.log(data);
                            const hierarchy = {
                                "ioam": 0, "iopm": 1, "iooncall": 2,
                                "fwam": 3, "fwpm": 4, "fwoncall": 5,
                                "fsam": 6, "fspm": 7, "fsoncall": 8,
                                "rsam1": 9, "rspm1": 10, "rsoncall1": 11,
                                "rsam2": 12, "rspm2": 13, "rsoncall2": 14,
                                "rsam3": 15, "rspm3": 16, "rsoncall3": 17,
                                "rsam4": 18, "rspm4": 19, "rsoncall4": 20
                            };

                            const labels = {
                                "ioam": "IO AM", "iopm": "IO PM", "iooncall": "IO Oncall",
                                "fwam": "FW AM", "fwpm": "FW PM", "fwoncall": "FW Oncall",
                                "fsam": "FS AM", "fspm": "FS PM", "fsoncall": "FS Oncall",
                                "rsam1": "RS AM 1", "rspm1": "RS PM 1", "rsoncall1": "RS Oncall 1",
                                "rsam2": "RS AM 2", "rspm2": "RS PM 2", "rsoncall2": "RS Oncall 2",
                                "rsam3": "RS AM 3", "rspm3": "RS PM 3", "rsoncall3": "RS Oncall 3",
                                "rsam4": "RS AM 4", "rspm4 4": "RS PM 4", "rsoncall4 4": "RS Oncall 4"
                            };

                            let events = data.response
                                .sort((a, b) => (hierarchy[a.position_type] ?? 99) - (hierarchy[b.position_type] ?? 99))
                                .map(item => {
                                    let color;
                                    switch (item.position_type) {
                                        case 'ioam': case 'iopm': case 'iooncall':
                                            color = '#87CEFA'; break;
                                        case 'fwam': case 'fwpm': case 'fwoncall':
                                            color = '#7FFFD4'; break;
                                        case 'fsam': case 'fspm': case 'fsoncall':
                                            color = '#AFEEEE'; break;
                                        case 'rsam1': case 'rspm1': case 'rsoncall1':
                                        case 'rsam2': case 'rspm2': case 'rsoncall2':
                                        case 'rsam3': case 'rspm3': case 'rsoncall3':
                                        case 'rsam4': case 'rspm4': case 'rsoncall4':
                                            color = '#40E0D0'; break;
                                        default:
                                            color = '#F0E68C';
                                    }

                                    return {
                                        title: `${labels[item.position_type]}: ${item.name}`,
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
            eventClick: function (info) {
                const { id, oncallDate, sso } = info.event.extendedProps;
                $("#ocertid").val(id);
                $("#updateertoncalldate").val(oncallDate);
                $("#updateertstaff").val(sso).trigger("change");
                $('#updateert-modal').modal('show');
            }
        });

        calendar.render();
    }

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // Init with today's date
    const today = moment().format('YYYY-MM-DD');
    $("#ertcalendardate").val(today);
    renderCalendar(today);

    // Change listener for date/location
    $("#ertlocation, #ertcalendardate").on("change", function () {
        const date = $("#ertcalendardate").val();
        renderCalendar(date);
    });

    $('.assign-ert').on('click', function () {
        $('#assignert-modal').modal('show');
    });

    $('.save-ocert').on('click', async function () {
        const form = $('#oncallertform');
        const data = processSerialize(await getAllInput(form));
        const url = config.routes.oncallassignment.ert.save;

        const location = $('#ertwardlocation').val();

        if (location.trim() === '') {
            toastr.error('Please select location.', { timeOut: 3000 });
            return;
        }

        $.ajax({
            url, type: "POST", dataType: "json", data,
            beforeSend: () => $("#loading-overlay").show(),
            success: () => {
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
                    $('#assignert-modal').modal('hide');
                }, 1000);
            },
            error: (xhr, status, error) => {
                toastr.error('Error saving reaction: ' + error, { timeOut: 5000 });
            }
        });
    });

    $('.update-ocert').on('click', async function () {
        const form = $('#updateoncallertform');
        const data = processSerialize(await getAllInput(form));
        const url = config.routes.oncallassignment.ert.update;

        $.ajax({
            url, type: "POST", dataType: "json", data,
            beforeSend: () => $("#loading-overlay").show(),
            success: () => {
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
                    $('#updateert-modal').modal('hide');
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
        ['iooncallstart', 'iooncallend'],
        ['fwoncallstart', 'fwoncallend'],
        ['fsoncallstart', 'fsoncallend']
    ].forEach(([start, end]) => validateDateRange(start, end));

    for (let i = 1; i <= 4; i++) {
        const startSelector = '#rsoncallstart' + i;
        const endSelector = '#rsoncallend' + i;

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

    $('.show-next').on('click', function () {
        let nextId = $(this).data('next');
        $('#rescue-squad-' + nextId).slideDown();
    });

    $('.hide-prev').on('click', function () {
        let prevId = $(this).data('prev');
        let $section = $('#rescue-squad-' + prevId);
        $section.slideUp().find('input').val('');
        $section.find('select').val('').trigger('change');
    });

    $('.select2-field').select2({
        width: '100%',
        dropdownParent: $('#assignert-modal')
    });
}
