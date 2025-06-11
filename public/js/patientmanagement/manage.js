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
        if ($('#procedure').is(':checked')) {
            $('#procedure_remark').closest('.row').show();
        } else {
            $('#procedure_remark').closest('.row').hide();
        }
    });

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
    
        console.log(response);

        // Populate checkboxes
        const checkboxFields = [
            'nbm', 'fasting', 'procedure', 'financial', 'fall_risk',
            'heart_failure', 'respi', 'nephro', 'neuro',
            'gastro', 'ent', 'infdisease', 'dildnr', 'high_risk'
        ];
    
        checkboxFields.forEach(field => {
            const value = response[field];
            const checkbox = $('#' + field.replace(/_/g, ''));
    
            if (checkbox.length) {
                checkbox.prop('checked', value === 1);
            }
        });
    
        $('#nbm_remark').val(response.nbm_remark || '');
        $('#fasting_remark').val(response.fasting_remark || '');
        $('#procedure_remark').val(response.procedure_remark || '');

        $('#nbm').trigger('change');
        $('#fasting').trigger('change');
        $('#procedure').trigger('change');
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
        $('#procedure_remark').val('');
    
        // Hide dependent input fields if they're controlled by switches
        $('#nbm').trigger('change');
        $('#fasting').trigger('change');
        $('#procedure').trigger('change');
    }

    $('#patient-table tbody').on('click', '.add-flag-btn', function () {
        var mrn     = $(this).data('mrn');
        var name    = $(this).data('name');
        var url     = config.routes.patient.getPatientFlag;

        console.log(mrn);

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
        const isProcedureChecked = $('#procedure').is(':checked');

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
        if (isProcedureChecked && procedureRemark.trim() === '') {
            toastr.error('Please provide Procedure remark.', { timeOut: 3000 });
            return;
        }
        
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
    
});
