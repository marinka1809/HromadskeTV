jQuery(document).ready(function ($) {
    var acs_action = 'hromadske_autocompletesearch';

    $("#s").autocomplete({
        source: function (req, response) {
            $.getJSON(MyAcSearch.url + '?callback=?&action=' + acs_action, req, response);
        },
        select: function (event, ui) {
            window.location.href = ui.item.link;
        },
        minLength: 2,
    }).data("ui-autocomplete")._renderItem = function (ul, item) {
        return $("<li></li>")
            .data("item.autocomplete", item)
            .append("<a><span class='time'>"  + item.data + "</span><h4>" + item.label + "</h4></a>")
            .appendTo(ul);
    }
});