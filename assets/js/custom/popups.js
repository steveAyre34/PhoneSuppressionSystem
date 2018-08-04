/* Handles all popup messages in javascript using Beagle Template */

/* Create popup message on the side */
function popupMessage(title, text, type){
    $.gritter.add({
        title: title,
        text: text,
        class_name: "color " + type
    });
}

/* Create modal with info */
function popupModal(title, id, modal_body_string, modal_footer_string) {
	//Remove current Modal Properties
	var current_id = $('.modal-container').attr("id");
	$('.modal-container').removeClass('colored-header-' + current_id);

	//Add new modal properties
	$('.modal-container').attr("id", id);
	$('.modal-container').addClass('colored-header-' + id);

	//setup text values
	$('.modal-title').text(title);
	$('.modal-body').html(modal_body_string);
	$('.modal-footer').html(modal_footer_string);

	$("#" + id).niftyModal();
}