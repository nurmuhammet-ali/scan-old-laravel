let sortedRows = Array.from(table.rows)
    .slice(1)
    .sort((rowA, rowB) => rowA.cells[0].className == 'working' ? 1 : -1);

table.tBodies[0].append(...sortedRows);

jQuery( document ).ready(function($) {
    $("<tr class='detailed'></tr>").insertAfter('tr.tr-not-working');
    $("<tr class='detailed'></tr>").insertAfter('tr.tr-working');

    // $('tr.detailed').remove();
});