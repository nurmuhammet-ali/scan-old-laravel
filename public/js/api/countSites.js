jQuery( document ).ready(function($) {
    var $countAll = $('tbody tr');
    $('span.common').text('Количество сайтов: ' + $countAll.length / 2);

    var $countNotWorking = $('tr.tr-not-working');
    $('span.common.not-working').text('Не работают: ' + $countNotWorking.length);

    var $countWorking = $('tr.tr-working');
    $('span.common.working').text('Работают: ' + $countWorking.length);
});