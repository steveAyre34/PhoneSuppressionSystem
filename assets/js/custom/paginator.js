/* All paginator functions for tables */

//global variables
var range = 5;
var min_page = 1;
var max_page = range;
var total_page_count = 5;
var data_initialized = false;

/* setting display for page selection */
function setPageDisplay(page_element) {
    $(".page").removeClass("active");
    $(page_element).addClass("active");
}

/* setting display of table information */
function setTableInfo(page, limit, count, page_length){
    var min = (page * limit) - (limit - 1);
    var max = (min + page_length) - 1;
    $('#table-info-div').text("Showing " + min + " to " + max + " of " + count + " entries");
}

/* initialize paginator settings */
function initializePaginator(count, limit) {
    $('.special-button.disabled').addClass('disabled');
    //initialize some data
    data_initialized = true;
    min_page = 1;
    max_page = range;
    total_page_count = Math.ceil(count / limit);

    var counter = min_page;

    //initialize page display information
    $('.page').each(function () {
        if (counter <= max_page && counter <= total_page_count) {
            $(this).css("visibility", "visible");
            $(this).find('a').text(counter);
            $(this).attr("id", counter);
            if(counter == 1){
                setPageDisplay($('#1'));
            }
        }
        else {
            $(this).css("visibility", "hidden");
        }
        counter++;
    });
    if (max_page >= total_page_count) {
        $('.special-button.next').addClass('disabled');
    }
}

/* set new page span by paginator selected */
/* returns page to set tablet to */
function setPageSpan(special) {
    var set_page = 0;
    switch (special) {
        case "previous":
            $('.special-button.next').removeClass('disabled');
            min_page -= range;
            max_page -= range;

            var counter = min_page;

            if (min_page == 1) {
                $('.special-button.previous').addClass('disabled');
            }

            $('.page').each(function () {
                if (counter <= max_page && counter <= total_page_count) {
                    $(this).css("visibility", "visible");
                    $(this).find('a').text(counter);
                    $(this).attr("id", counter);
                    set_page = counter;
                }
                else {
                    $(this).css("visibility", "hidden");
                }
                counter++;
            });
            break;
        case "next":
            $('.special-button.previous').removeClass('disabled');
            min_page += range;
            max_page += range;
            
            var counter = min_page;

            if (min_page >= total_page_count) {
                $('.special-button.next').addClass('disabled');
            }

            $('.page').each(function () {
                if (counter <= max_page && counter <= total_page_count) {
                    $(this).css("visibility", "visible");
                    $(this).find('a').text(counter);
                    $(this).attr("id", counter);
                }
                else {
                    $(this).css("visibility", "hidden");
                }
                counter++;
            });
            set_page = min_page;
            break;
    }

    return set_page;
}

/* unset initialized data variable */
function unsetInitializedData() {
    data_initialized = false;
}

/* Say whether new data set is initialized */
function dataInitialized() {
    return data_initialized;
}