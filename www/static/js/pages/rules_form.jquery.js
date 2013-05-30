jQuery(function ($) {

    $(".tagManager").each(function () {

        var $that = $(this),
            name = $that.attr("name");

        $that.tagsManager({
            prefilled: $that.val().split(","),
            preventSubmitOnEnter: false,
            typeahead: true,
            typeaheadAjaxSource: null,
            typeaheadSource: drano.m[name],
            hiddenTagListName: name + "_values"
        });
    });
});
