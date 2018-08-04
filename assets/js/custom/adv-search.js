/* Basic functions for Advance Search builds */

/*
    adv_fields = {
        field_value: {
            label: ...
            type: ...
        }
    }

    adv_rules = {
        "Type Here" : {
            exact: ...
            contains: ...
        }
    }

    adv_dropdowns = {
        field_name: {
            sdfsdf234234234: Production
            ...
        }
    }

 */

var adv_fields = {};
var adv_rules = {};
var adv_dropdowns = {};

(function(){

    /* on field change change rule set */
    $(document).on("change", '.adv-field-select', function(){
        var type = adv_fields[$(this).val()]["type"];
        var rule_element = $(this).parent().parent().find('.adv-rule-select');

        $(rule_element).empty();
        $(rule_element).append(getAdvRuleasOptions(type));

        var value_element = $(this).parent().parent().find('.adv-value-select');

        switch(type){
            case "text":
                $(value_element).replaceWith('<input type="text" class="form-control adv-value-select">');
                break;
            case "date":
                $(value_element).replaceWith('<input type="date" class="form-control adv-value-select">');
                break;
            case "dropdown":
                $(value_element).replaceWith('<select class="form-control adv-value-select">'
                                                + getDropdownValuesAsOptions($(this).val())
                                                + '</select>');
                break;
        }
    });
    
})();

/* initialize adv search arrays  */
function initializeAdvSearch(fields, rules){
    adv_fields = fields;
    adv_rules = rules;
}

/* Get fields as options*/
function getAdvFieldsasOptions(){
    var options = "";
    for(key in adv_fields){
        options += '<option value="' + key + '">' + adv_fields[key]["label"] + '</option>';
    }

    return options;
}

/* Get fields as object */
function getAdvFieldsasObject(){
    return adv_fields;
}

/* get rule set based on field type as options*/
function getAdvRuleasOptions(type){
    var options = "";
    for(key in adv_rules[type]){
        options += '<option value="' + key + '">' + adv_rules[type][key] + '</option>';
    }
    return options;
}

/* Get rules set based on field type as object */
function getAdvRulesasObject(type){
    return adv_rules[type];
}

/* set dropdown values */
function setDropdownValues(field, values){
    adv_dropdowns[field] = {};

    for(var i = 0; i < values.length; i++){
        adv_dropdowns[field][values[i]["value"]] = values[i]["label"];
    }
}

/* get dropdown as Options*/
function getDropdownValuesAsOptions(field){
    var options = "";
    for(key in adv_dropdowns[field]){
        options += '<option value="' + key + '">' + adv_dropdowns[field][key] + '</option>';
    }
    return options;
}

/* get dropdown as Object*/
function getDropdownValuesAsObject(field){
    return adv_dropdowns[field];
}