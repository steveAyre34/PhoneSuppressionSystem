/* Main js functions include checking inputs, error functions, etc. */

/* Check if value is blank */
function isBlank(value) {
    return value.replace(/\s/g, '').length == 0;
}

/* Check if format is incorrect based on regular expression */
function correctFormat(value, regex) {
    return regex.test(String(value));
}

/* Attach error events to detected error */
function attachError(element, message) {
    $(element).css("border", '1px solid #ea4335');
    $(element).parent().find('.error-message').text(message);
    $(element).unbind("focus").on('focus', function () {
        $(element).css("border", '');
        $(element).parent().find('.error-message').text("");
    });
}
