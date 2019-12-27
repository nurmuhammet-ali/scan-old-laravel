jQuery( document ).ready(function($) {
    $('div.user,div.menu').click(function() {
        $(this).children().last().slideToggle('fast');
    });
});