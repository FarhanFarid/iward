const getAllInput = function (form) {
    // Find disabled inputs, and remove the "disabled" attribute
    var disabled = form.find(':input:disabled').removeAttr('disabled');
    // serialize the form
    var formData = form.serializeArray();
    // re-disabled the set of inputs that you previously enabled
    disabled.attr('disabled','disabled');

    return formData;
}

const processSerialize = function (data) {
    var fData = {};
    $.each(data, function (index, value) {
        if( fData.hasOwnProperty(value.name) ){
            let oriData = fData[value.name];
            if( $.isArray(oriData) ){
                oriData.push(value.value);
                fData[value.name] = oriData;
            }
            else {
                let oriDataN = [oriData];
                oriDataN.push(value.value);
                fData[value.name] = oriDataN;
            }
        }
        else{
            fData[value.name] = value.value;
        }
    });

    return fData;
};