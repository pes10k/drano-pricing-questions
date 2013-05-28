jQuery(function ($) {

    var $extra_fields = $("#email-plus-fields").hide(),
        $severity_field = $("#severity"),
        update_extra_fields = function (speed) {

            if (speed === undefined) {
                speed = 500;
            }

            if ($severity_field.val() === 'Email plus') {
                $extra_fields.slideDown(speed);
            } else {
                $extra_fields.slideUp(speed);
            }
        };

    update_extra_fields(0);
    $severity_field.change(function () {
        update_extra_fields();
    });

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
