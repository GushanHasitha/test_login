
$(function () {
    $.each($('.menu .list li.active'), function (i, val) {
        var $activeAnchors = $(val).find('a:eq(0)');

        $activeAnchors.addClass('toggled');
        $activeAnchors.next().show();
    });
    setTimeout(function () { $('.page-loader-wrapper').fadeOut(); }, 50);
});