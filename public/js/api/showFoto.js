jQuery( document ).ready(function($) {
    $('div.photo-btn').click(function() {
        $(this).parent().next().slideToggle();
    });
});