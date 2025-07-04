$(document).ready(function () {
    var tablebed = $('#patient-table').DataTable({
        lengthMenu: [15, 20, 30, 50],
        dom: 'rtipl',
        scrollX: "300px",
        data: [],
        columnDefs: [
            {targets: '_all', className: 'text-center' }
        ],
        columns: [
            { 
                data: 'bedno',
                render: function(data, type, row) {
                    return '<span style="font-weight: 500;">'+ row.bedno +'</span>';
                }
            },
            { 
                data: 'mrn',
                render: function(data, type, row) {
                    return '<span style="font-weight: 500;">'+ row.mrn +'</span>';
                }
            },
            { 
                data: 'episodeno',
                render: function(data, type, row) {
                    return '<span style="font-weight: 500;">'+ row.episodeno +'</span>';
                }
            },
            { 
                data: 'name',
                render: function(data, type, row) {
                    return '<span style="font-weight: 500;">'+ row.name +'</span>';
                }
            },
            { 
                data: 'admdate',
                render: function(data, type, row) {
                    return '<span style="font-weight: 500;">'+ row.admdate +'</span>';
                }
            },
            {
                data: null,
                className: 'text-center',
                render: function (data, type, row) {
                    return `<button class="btn btn-sm btn-primary add-flag-btn" data-mrn="${row.mrn}" data-name="${row.name}">Add Flag</button>`;                    
                }
            }
        ]
    });

    $('#patmanagelocation').on('change', function () {
        let wardCode = $(this).val();
        var url = config.routes.patient.getWardPatientList;
    
        if (!wardCode) {
            tablebed.clear().draw();
            return;
        }
    
        $.ajax({
            url: url,
            method: 'GET',
            data: { wardcode: wardCode },
    
            success: function (data) {
                let rows = Object.values(data.data || []);    
                let filteredRows = rows.filter(row => row.mrn && row.mrn.trim() !== "");
                tablebed.clear().rows.add(filteredRows).draw();
            },
    
            error: function (err) {
                console.error("Error fetching data", err);
            }
        });
    });

    $('#nbm').on('change', function () {
        if ($('#nbm').is(':checked')) {
            $('#nbm_remark').closest('.row').show();
        } else {
            $('#nbm_remark').closest('.row').hide();
        }
    });

    $('#fasting').on('change', function () {
        if ($('#fasting').is(':checked')) {
            $('#fasting_remark').closest('.row').show();
        } else {
            $('#fasting_remark').closest('.row').hide();
        }
    });

    $('#procedure').on('change', function () {
        if ($(this).is(':checked')) {
            $('#procedure_remark_wrapper').show();
    
            // If no existing repeater input, add one default input
            if ($('#procedure_remark_wrapper .procedure_remark_group').length === 0) {
                $('#procedure_remark_wrapper').append(generateProcedureInput('', false));
            }
    
        } else {
            $('#procedure_remark_wrapper').hide().empty();
        }
    });

    function generateProcedureInput(value = '', isFinancial = false) {
        return `
            <div class="row mb-2 procedure_remark_group align-items-center">
                <div class="col-md-8 d-flex align-items-center gap-2 flex-wrap">
                    <input class="form-control form-control-sm procedure_remark_input" 
                           type="text" name="procedure_remark[]" 
                           maxlength="50" value="${value}" placeholder="Enter procedure">
    
                    <div class="form-check form-switch d-flex align-items-center">
                        <input class="form-check-input me-1" type="checkbox" 
                               name="financial_switch[]" ${isFinancial ? 'checked' : ''}>
                        <label class="form-check-label ms-1">Financial Clearance</label>
                    </div>
    
                    <button type="button" class="btn btn-light btn-sm add-procedure-btn" title="Add">
                        <i class="fas fa-plus"></i>
                    </button>
                    <small class="text-muted count-label ms-2">0 / 50</small>

                </div>
            </div>
        `;
    }

    $('#procedure_remark').on('input', function () {
        var maxLength = 50;
        var currentLength = $(this).val().length;
    
        // Enforce max length (in case someone pastes over the limit)
        if (currentLength > maxLength) {
            $(this).val($(this).val().substring(0, maxLength));
            currentLength = maxLength;
        }
    
        $('#procedure_remark_count').text(currentLength + ' / ' + maxLength);
    });

    $('#nbm_remark').on('input', function () {
        var maxLength = 50;
        var currentLength = $(this).val().length;
    
        // Enforce max length (in case someone pastes over the limit)
        if (currentLength > maxLength) {
            $(this).val($(this).val().substring(0, maxLength));
            currentLength = maxLength;
        }
    
        $('#nbm_remark_count').text(currentLength + ' / ' + maxLength);
    });

    $('#fasting_remark').on('input', function () {
        var maxLength = 50;
        var currentLength = $(this).val().length;
    
        if (currentLength > maxLength) {
            $(this).val($(this).val().substring(0, maxLength));
            currentLength = maxLength;
        }
    
        $('#fasting_remark_count').text(currentLength + ' / ' + maxLength);
    });

    function populatePatientFlagForm(data) {
        if (!data || !data.response) return;
    
        const response = data.response;
    
        // Set all base flags
        const checkboxFields = [
            'nbm', 'fasting', 'procedure', 'financial', 'fall_risk',
            'heart_failure', 'respi', 'nephro', 'neuro',
            'gastro', 'ent', 'infdisease', 'dildnr', 'high_risk'
        ];
    
        checkboxFields.forEach(field => {
            const value = response[field];
            const checkbox = $('#' + field.replace(/_/g, ''));
            if (checkbox.length) checkbox.prop('checked', value === 1);
        });
    
        $('#nbm_remark').val(response.nbm_remark || '');
        $('#fasting_remark').val(response.fasting_remark || '');
    
        // Reset and repopulate procedure_remark_wrapper
        $('#procedure_remark_wrapper').empty();
    
        if (response.procedure_list && response.procedure_list.length > 0) {
            response.procedure_list.forEach((proc, index) => {
                const remark = proc.procedure ?? '';
                const financial = proc.financial == 1 ? 'checked' : '';
    
                const row = `
                    <div class="row mb-2 procedure_remark_group align-items-center">
                        <div class="col-md-8 d-flex align-items-center gap-2 flex-wrap">
                            <input class="form-control form-control-sm procedure_remark_input" type="text" name="procedure_remark[]" maxlength="50" value="${remark}" placeholder="Enter procedure">
    
                            <div class="form-check form-switch d-flex align-items-center">
                                <input class="form-check-input me-1" type="checkbox" name="financial_switch[${index}]" ${financial}>
                                <label class="form-check-label ms-1">Financial Clearance</label>
                            </div>
    
                            <button type="button" class="btn btn-light btn-sm ${index === 0 ? 'add-procedure-btn' : 'remove-procedure-btn'}" title="${index === 0 ? 'Add' : 'Remove'}">
                                <i class="fas fa-${index === 0 ? 'plus' : 'minus'}"></i>
                            </button>
                            <small class="text-muted count-label ms-2">${remark.length} / 50</small>
                        </div>
                    </div>
                `;
    
                $('#procedure_remark_wrapper').append(row);
            });
        }
    
        // Rebind add/remove events if needed
        bindProcedureRepeaterEvents();
    
        // Trigger dependent fields
        $('#nbm').trigger('change');
        $('#fasting').trigger('change');
        $('#procedure').trigger('change');
    }

    function bindProcedureRepeaterEvents() {
        $('#procedure_remark_wrapper').off('click', '.add-procedure-btn').on('click', '.add-procedure-btn', function () {
            const index = $('#procedure_remark_wrapper .procedure_remark_group').length;
    
            const newRow = `
                <div class="row mb-2 procedure_remark_group align-items-center">
                    <div class="col-md-8 d-flex align-items-center gap-2 flex-wrap">
                        <input class="form-control form-control-sm procedure_remark_input" type="text" name="procedure_remark[]" maxlength="50" placeholder="Enter procedure">
                        
                        <div class="form-check form-switch d-flex align-items-center">
                            <input class="form-check-input me-1" type="checkbox" name="financial_switch[${index}]">
                            <label class="form-check-label ms-1">Financial Clearance</label>
                        </div>
    
                        <button type="button" class="btn btn-light btn-sm remove-procedure-btn" title="Remove">
                            <i class="fas fa-minus"></i>
                        </button>
                        <small class="text-muted count-label ms-2">0 / 50</small>
                    </div>
                </div>
            `;
            $('#procedure_remark_wrapper').append(newRow);
        });
    
        $('#procedure_remark_wrapper').off('click', '.remove-procedure-btn').on('click', '.remove-procedure-btn', function () {
            $(this).closest('.procedure_remark_group').remove();
        });
    }
    

    function resetPatientFlagForm() {
        // Uncheck all checkboxes
        const checkboxFields = [
            'nbm', 'fasting', 'procedure', 'financial', 'fall_risk',
            'heart_failure', 'respi', 'nephro', 'neuro',
            'gastro', 'ent', 'infdisease', 'dildnr', 'high_risk'
        ];
    
        checkboxFields.forEach(field => {
            $('#' + field.replace(/_/g, '')).prop('checked', false);
        });
    
        // Clear input fields
        $('#nbm_remark').val('');
        $('#fasting_remark').val('');
    
        // Clear all dynamic procedure remarks
        $('#procedure_remark_wrapper').empty();
    
        // Trigger change for dependent visibility
        $('#nbm').trigger('change');
        $('#fasting').trigger('change');
        $('#procedure').trigger('change');
    }
    

    $('#patient-table tbody').on('click', '.add-flag-btn', function () {
        var mrn     = $(this).data('mrn');
        var name    = $(this).data('name');
        var url     = config.routes.patient.getPatientFlag;

        resetPatientFlagForm();

        $.ajax({
            url: url,
            type: "GET",
            dataType: "json",
            data: {mrn: mrn},

            success: function(data) {

                populatePatientFlagForm(data);
                $('#mrn').val(mrn);
                $('#name').val(name);
                $('#patientflag-modal').modal('show');
                
            },
            error: function(xhr, status, error) {
                toastr.error('Error saving reaction: ' + error, {timeOut: 5000});
            }
        });
    });

    $('.save-patientflag').on('click', async function() {

        var form        = $(this).parent().parent().find('form#patientflagform');
        var formData    = await getAllInput(form);
        var data        = processSerialize(formData);
        var url         = config.routes.patient.savePatientFlag;

        const isNbmChecked = $('#nbm').is(':checked');
        const isFastingChecked = $('#fasting').is(':checked');
        // const isProcedureChecked = $('#procedure').is(':checked');

        const nbmRemark = $('#nbm_remark').val();
        const fastingRemark = $('#fasting_remark').val();
        const procedureRemark = $('#procedure_remark').val();

        if (isNbmChecked && nbmRemark.trim() === '') {
            toastr.error('Please provide NBM date.', { timeOut: 3000 });
            return;
        }
        if (isFastingChecked && fastingRemark.trim() === '') {
            toastr.error('Please provide Fasting date.', { timeOut: 3000 });
            return;
        }
        // if (isProcedureChecked && procedureRemark.trim() === '') {
        //     toastr.error('Please provide Procedure remark.', { timeOut: 3000 });
        //     return;
        // }

        console.log(data);
        
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
                
                if (typeof patientTable !== 'undefined') {
                    patientTable.ajax.reload(null, false); 
                }
            
                $('#patientflag-modal').modal('hide');
            },
            error: function(xhr, status, error) {
                toastr.error('Error saving reaction: ' + error, {timeOut: 5000});
            }
        });
    });

    // Add new row
    let procedureIndex = 1;
    $(document).on('click', '.add-procedure-btn', function () {
        const newRow = $(`
            <div class="row mb-2 procedure_remark_group align-items-center">
                <div class="col-md-8 d-flex align-items-center gap-2 flex-wrap">
                    <input class="form-control form-control-sm procedure_remark_input" 
                        type="text" name="procedure_remark[${procedureIndex}]" maxlength="50" placeholder="Enter procedure">

                    <div class="form-check form-switch d-flex align-items-center">
                        <input class="form-check-input me-1" type="checkbox" 
                            name="financial_switch[${procedureIndex}]">
                        <label class="form-check-label ms-1">Financial Clearance</label>
                    </div>

                    <button type="button" class="btn btn-light btn-sm remove-procedure-btn" title="Remove">
                        <i class="fas fa-minus"></i>
                    </button>
                    <small class="text-muted count-label ms-2">0 / 50</small>

                </div>
            </div>
        `);

        $('#procedure_remark_wrapper').append(newRow);
        procedureIndex++;
    });

    // Remove row
    $(document).on('click', '.remove-procedure-btn', function () {
        $(this).closest('.procedure_remark_group').remove();
    });

    // Character counter
    $(document).on('input', '.procedure_remark_input', function () {
        const count = $(this).val().length;
        $(this).closest('.procedure_remark_group').find('.count-label').text(`${count} / 50`);
    });

    toggleProcedureRemarkWrapper();

    $('#procedure').on('change', function () {
        toggleProcedureRemarkWrapper();
    });

    function toggleProcedureRemarkWrapper() {
        if ($('#procedure').is(':checked')) {
            $('#procedure_remark_wrapper').slideDown();
        } else {
            $('#procedure_remark_wrapper').slideUp();
        }
    }

});
