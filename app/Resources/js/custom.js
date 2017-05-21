jQuery(document).ready(function($) {
    $(".clickableRow").click(function() { window.document.location = $(this).attr("href"); });
    $(".clickableRow").css('cursor', 'pointer');
    $('#side-menu').metisMenu();
});

$(function() {
    $(window).bind("load resize", function() {
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
//        if (width < 992) {
        if (width < 768) {
            $('div.sidebar-collapse').addClass('collapse');
            $('div.navbar-collapse').addClass('collapse');
        } else {
            $('div.sidebar-collapse').removeClass('collapse');
            $('div.navbar-collapse').removeClass('collapse');
        }
    });

    var url = window.location;
    var element = $('ul.nav a').filter(function() {
        return this.href == url || url.href.indexOf(this.href) == 0;
    }).addClass('active').parent().parent().addClass('in').parent();
    if (element.is('li')) {
        element.addClass('active');
    }
});
