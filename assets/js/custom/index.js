/* All functions/events specific to index.php */

//global variables

var page = 1;
var limit = 10;
var sort = "ASC";
var strict = 1;
var column = "name";
var criteria = [
    {
        column: "date_added",
        rule: "greater",
        value: "1899-12-31"
    }
];

$(document).ready(function () {
    //initialize the javascript

    $.fn.niftyModal('setDefaults', {
        overlaySelector: '.modal-overlay',
        contentSelector: '.modal-content',
        closeSelector: '.modal-close',
        classAddAfterOpen: 'modal-show'
    });

    App.init();

    initializeAdvSearch(
        {
            name: {
                label: "Name",
                type: "text"
            },
            date_added: {
                label: "Date Added",
                type: "date"
            },
            phone: {
                label: "Phone",
                type: "text"
            },
            type: {
                label: "Type",
                type: "dropdown"
            }
        },
        {
            text: {
                exact: "Exact",
                contains: "Contains"
            },
            dropdown: {
                exact: "Exact",
            },
            date: {
                exact: "Exact",
                less: "Before",
                greater: "After"
            }
        }
    );

    setDropdownValues("type", [
        {
            label: "SMS",
            value: "sms"
        },
        {
            label: "Voice Mail",
            value: "voice mail"
        },
        {
            label: "Both",
            value: "both"
        }
    ]);

    drawTable();

});

(function () {

    /* page event for paginator */
    $(document).on("click", '.page', function () {
        page = $(this).attr("id");
        setPageDisplay($(this));
        drawTable();
    });

    /* special paginator event for paginator */
    $(document).on("click", '.special-button', function () {
        if ($(this).hasClass("disabled") == false) {
            var special = ($(this).hasClass('previous') ? "previous" : "next");
            page = setPageSpan(special);
            setPageDisplay($('.page#' + page));
            drawTable();
        }
    });

    /* Advanced search popup event */
    $(document).on("click", '#advanced-search-popup', function () {
        createSearchPopup();
    });

    /* Quicksearch based on input */
    $(document).on("click", '#quicksearch-btn', function () {
        var quicksearch = $('#quicksearch-input').val();

        if (!isBlank(quicksearch)) {
            var quicksearch_split = quicksearch.split(" ");
            var new_criteria = [];
            for (var i = 0; i < quicksearch_split.length; i++) {
                new_criteria.push({
                    column: "name",
                    rule: "contains",
                    value: quicksearch_split[i]
                });
                new_criteria.push({
                    column: "phone",
                    rule: "contains",
                    value: quicksearch_split[i]
                });
            }

            page = 1;
            column = "name";
            sort = "ASC";
            strict = 1;
            criteria = new_criteria;

            unsetInitializedData();
            drawTable();
        }
    });

    /* enter triggers for certain events */
    $(document).on("keydown", 'body', function (e) {
        if (e.keyCode == 13) {
            if ($('#quicksearch-input').is(":focus")) {
                $('#quicksearch-btn').trigger("click");
            }
        }
    });

    /* reset table */
    $(document).on("click", '#reset-table-btn', function () {
        criteria = [
            {
                column: "date_added",
                rule: "greater",
                value: "1899-12-31"
            }
        ];

        drawTable();
    });

    /* create add phone popup */
    $(document).on("click", "#add-phone-popup", function () {
        createAddPopup();
    });

    /* delete phone number button */
    $(document).on("click", ".delete-phone-btn", function () {
        createDeletePhonePopup($(this).attr("id"));
    });

    /* edit name button */
    $(document).on("click", ".edit-phone-btn", function () {
        var id = $(this).attr("id");
        $.ajax({
            type: "GET",
            url: "/assets/php/API/phones/phone.php",
            data: {
                id: id
            },
            contentType: "application/json", // Set the data type so jQuery can parse it for you
            success: function (response) {
                response = JSON.parse(response);
                if (response["success"] == true) {
                    var body = '<div class="form-group">'
                        + '<label>Name</label>'
                        + '<input id="name-form" type="text" placeholder="Enter full name" class="form-control" value="' + response["content"]["name"] + '">'
                        + '<p class="error-message"></p>'
                        + '</div>';
                    var footer = '<button type="button" data-dismiss="modal" class="btn btn-default modal-close">Cancel</button>'
                        + '<button id="save-new-name-btn" type="button" data-dismiss="modal" class="btn btn-success">Save</button>'
                    popupModal("Edit Name", "primary", body, footer);

                    //save phone information
                    $('#save-new-name-btn').unbind("click").on("click", function () {
                        var is_ready = true;

                        var name = $('#name-form').val();


                        if (isBlank(name)) {
                            attachError($('#name-form'), "Can't be left blank");
                            is_ready = false;
                        }
                        console.log(id);
                        if (is_ready) {
                            $.ajax({
                                type: "PATCH",
                                url: "/assets/php/API/phones/phone.php",
                                data: {
                                    id: id,
                                    name: name,
                                },
                                contentType: "application/json", // Set the data type so jQuery can parse it for you
                                success: function (response) {
                                    response = JSON.parse(response);
                                    console.log(response);
                                    if (response["success"] == true) {
                                        $(".modal-close").trigger("click");
                                        popupMessage("Success", "name has been changed", "success");
                                        drawTable();
                                    }
                                    else {
                                        if (response["code"] == -501) {
                                            popupMessage("Error", "possible duplicate phone number detected", "danger");
                                        }
                                        else {
                                            popupMessage("Error", "unknown error occured", "danger");
                                        }
                                    }
                                },
                                error: function (response) {
                                    popupMessage("internal server error", "status code 500", "danger");
                                }
                            });
                        }
                    });
                }
                else {
                    popupMessage("Error", "unknown error occured", "danger");
                }
            },
            error: function (response) {
                popupMessage("internal server error", "status code 500", "danger");
            }
        });
    });
})();

/* Draw phone table */
function drawTable() {
    $.ajax({
        type: "GET",
        url: "/assets/php/API/phones/phones.php",
        data: {
            page: page,
            limit: limit,
            sort: sort,
            strict: strict,
            column: column,
            criteria: criteria
        },
        contentType: "application/json", // Set the data type so jQuery can parse it for you
        success: function (response) {
            response = JSON.parse(response);
            if (response["success"] == true) {
                $('#phone-table-body').empty();
                var data = response["content"]["results"];
                for (var i = 0; i < data.length; i++) {
                    $('#phone-table-body').append('<tr>'
                        + '<td>' + data[i]["name"] + '</td>'
                        + '<td>' + data[i]["phone"] + '</td>'
                        + '<td>' + data[i]["type"] + '</td>'
                        + '<td class="center">'
                        + '<div class="btn-group btn-hspace">'
                        + '<button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Open <span class="icon-dropdown mdi mdi-chevron-down"></span></button>'
                        + '<ul role="menu" class="dropdown-menu pull-right">'
                        + '<li id="' + data[i]["id"] + '" class="edit-phone-btn"><a class="hover-link">Edit Name</a></li>'
                        + '<li id="' + data[i]["id"] + '" class="delete-phone-btn"><a class="hover-link">Delete Phone</a></li>'
                        + '</ul>'
                        + '</div>'
                        + '</td>'
                        + '</tr>');
                }

                if (!dataInitialized()) {
                    initializePaginator(response["content"]["count"], limit);
                }

                setTableInfo(page, limit, response["content"]["count"], response["content"]["results"].length);
            }
            else {
                popupMessage("Error", "unknown error occured", "danger");
            }
        },
        error: function (response) {
            popupMessage("internal server error", "status code 500", "danger");
        }
    });
}

/* create advanced search popup */
function createSearchPopup() {
    var body = '<div id="adv-search-body">'
        + '<div class="adv-search-section">'
        + '<div class="form-group col-md-4">'
        + '<label>Field</label>'
        + '<select class="form-control adv-field-select">'
        + getAdvFieldsasOptions()
        + '</select>'
        + '<p class="error-message"></p>'
        + '</div>'
        + '<div class="form-group col-md-4">'
        + '<label>Rule</label>'
        + '<select class="form-control adv-rule-select">'
        + getAdvRuleasOptions("text")
        + '</select>'
        + '<p class="error-message"></p>'
        + '</div>'
        + '<div class="form-group col-md-4">'
        + '<label>Value</label>'
        + '<input type="text" class="form-control adv-value-select">'
        + '<p class="error-message"></p>'
        + '</div>'
        + '</div>'
        + '</div>';
    var footer = '<div class="be-checkbox" style="margin-bottom: 10px">'
        + '<input id="adv-is-strict" type="checkbox">'
        + '<label for="adv-is-strict">Strict search</label>'
        + '</div>'
        + '<button type="button" data-dismiss="modal" class="btn btn-default modal-close">Cancel</button>'
        + '<button id="rm-adv-rule-btn" type="button" data-dismiss="modal" class="btn btn-default">Remove Rule</button>'
        + '<button id="add-adv-rule-btn" type="button" data-dismiss="modal" class="btn btn-default">Add Rule</button>'
        + '<button id="adv-search-btn" type="button" data-dismiss="modal" class="btn btn-primary">Search</button>'
    popupModal("Advanced Search", "primary", body, footer);

    /* Adding a rule below */
    $('#add-adv-rule-btn').unbind("click").on("click", function () {
        if ($('.adv-search-section').length < 3) {
            $('#adv-search-body').append('<div class="adv-search-section">'
                + '<div class="form-group col-md-4">'
                + '<label>Field</label>'
                + '<select class="form-control adv-field-select">'
                + getAdvFieldsasOptions()
                + '</select>'
                + '<p class="error-message"></p>'
                + '</div>'
                + '<div class="form-group col-md-4">'
                + '<label>Rule</label>'
                + '<select class="form-control adv-rule-select">'
                + getAdvRuleasOptions("text")
                + '</select>'
                + '<p class="error-message"></p>'
                + '</div>'
                + '<div class="form-group col-md-4">'
                + '<label>Value</label>'
                + '<input type="text" class="form-control adv-value-select">'
                + '<p class="error-message"></p>'
                + '</div>'
                + '</div>');
        }
        else {
            popupMessage("Maximum reached", "Only 3 parameters allowed", "warning");
        }
    });

    /* Remove Last Rule */
    $('#rm-adv-rule-btn').unbind("click").on("click", function () {
        if ($('.adv-search-section').length > 1) {
            var rule_element = $('.adv-search-section');
            $(rule_element[rule_element.length - 1]).remove();
        }
        else {
            popupMessage("Minumum reached", "Can't remove first rule", "warning");
        }
    });

    /* perform advanced search */
    $('#adv-search-btn').unbind("click").on("click", function () {
        var new_criteria = [];
        $('.adv-search-section').each(function () {
            var this_field = $(this).find('.adv-field-select').val();
            var this_rule = $(this).find('.adv-rule-select').val();
            var this_value = $(this).find('.adv-value-select').val();

            new_criteria.push({
                column: this_field,
                rule: this_rule,
                value: this_value
            });
        });

        strict = ($('#adv-is-strict').prop("checked") ? 2 : 1);
        page = 1;
        criteria = new_criteria;

        $('.modal-close').trigger("click");

        unsetInitializedData();

        drawTable();
    });
}

/* add phone popup */
function createAddPopup() {
    var body = '<div class="form-group">'
        + '<label>Name</label>'
        + '<input id="name-form" type="text" placeholder="Enter full name" class="form-control">'
        + '<p class="error-message"></p>'
        + '</div>'
        + '<div class="form-group">'
        + '<label>Phone #</label>'
        + '<input id="phone-form" type="number" placeholder="7 digits or 10 digits" class="form-control">'
        + '<p class="error-message"></p>'
        + '</div>'
        + '<div class="form-group">'
        + '<label>Type</label>'
        + '<select id="type-form" class="form-control">'
        + '<option value="sms">SMS</option>'
        + '<option value="voice mail">Voice Mail</option>'
        + '<option value="both">Both</option>'
        + '</select>'
        + '<p class="error-message"></p>'
        + '</div>';
    var footer = '<button type="button" data-dismiss="modal" class="btn btn-default modal-close">Cancel</button>'
        + '<button id="save-new-phone-btn" type="button" data-dismiss="modal" class="btn btn-success">Save</button>'
    popupModal("Add Phone Number", "primary", body, footer);

    //save phone information
    $('#save-new-phone-btn').unbind("click").on("click", function () {
        var is_ready = true;

        var name = $('#name-form').val();
        var phone = $('#phone-form').val();
        var type = $('#type-form').val();


        if (isBlank(name)) {
            attachError($('#name-form'), "Can't be left blank");
            is_ready = false;
        }
        if (!correctFormat(phone, /^\d{7}$/) && !correctFormat(phone, /^\d{10}$/)) {
            attachError($('#phone-form'), "Phone must contain 7 or 10 digits");
            is_ready = false;
        }

        if (is_ready) {
            $.ajax({
                type: "POST",
                url: "/assets/php/API/phones/phone.php",
                data: {
                    name: name,
                    phone: phone,
                    type: type
                },
                contentType: "application/json", // Set the data type so jQuery can parse it for you
                success: function (response) {
                    response = JSON.parse(response);
                    console.log(response);
                    if (response["success"] == true) {
                        $(".modal-close").trigger("click");
                        popupMessage("Success", "phone added to system", "success");
                        drawTable();
                    }
                    else {
                        if (response["code"] == -501) {
                            popupMessage("Error", "possible duplicate phone number detected", "danger");
                        }
                        else {
                            popupMessage("Error", "unknown error occured", "danger");
                        }
                    }
                },
                error: function (response) {
                    popupMessage("internal server error", "status code 500", "danger");
                }
            });
        }
    });
}

/* delete phone popup */
function createDeletePhonePopup(id) {
    var body = '<div class="form-group">'
        + '<p>You are deleting this phone number from the list. Would you like to continue? </p>'
        + '</div>';
    var footer = '<button type="button" data-dismiss="modal" class="btn btn-default modal-close">Cancel</button>'
        + '<button id="delete-phone-save-btn" type="button" data-dismiss="modal" class="btn btn-danger">Delete</button>'
    popupModal("Deleting Phone", "warning", body, footer);

    //change username on save
    $('#delete-phone-save-btn').unbind("click").on("click", function () {
        $.ajax({
            type: "DELETE",
            url: "/assets/php/API/phones/phone.php",
            data: {
                id: id
            },
            contentType: "application/json", // Set the data type so jQuery can parse it for you
            success: function (response) {
                response = JSON.parse(response);
                if (response["success"] == true) {
                    $(".modal-close").trigger("click");
                    popupMessage("Success", "phone number deleted", "success");
                    drawTable();
                }
                else {
                    popupMessage("Error", "unknown error occured", "danger");
                }
            },
            error: function (response) {
                popupMessage("internal server error", "status code 500", "danger");
            }
        });

    });
}