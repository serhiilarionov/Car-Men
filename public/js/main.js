$(document).ready(function () {

    var activePrimaryCat = {};

    activePrimaryCat.init = function () {
        $('div.sub-cat').on('click', function () {
            $('div.primary-cat[data = "'+$(this).attr('data')+'"] input').prop('checked', true);
        });

        $('div.primary-cat input').on('click', function (object) {
            if ($(object).is( ":checked" )){
                $(object).prop('checked', false);
            } else {
                $(object).prop('checked', true);
            }
        });
    };

    activePrimaryCat.init();
});