jQuery( document ).ready(function($) {
    $('img.icon').click(function() {
        var p = $(this).next();
        var str = "<td colspan='8'>";
        str = p.html();
        str += "</td>";
        $(this).parent().parent().next().html(str);
        $(this).parent().parent().next().slideToggle(0);
    })
});
