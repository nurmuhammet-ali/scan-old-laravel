jQuery( document ).ready(function($) {

    var obj = {
        desc: false,
        asc: true
    };

    $('img.engine-sort').click(function() {

        $('img.sort').each(function(i,val) {
            var currentPath = $(this).attr('src');
            var currentPos = currentPath.indexOf('Light.png');
            if(currentPos != -1) {
                
                $(this).attr('src',currentPath.slice(0,currentPos) + '.png');
                
            }
        });
        
        var str = $(this).attr('src');
        var pos = str.indexOf('.png');
        var path = str.slice(0,pos);
        path = path + 'Light.png';
        $(this).attr('src',path);

        $('.container th h1').css('color','#185875');
        $(this).prev().css('color','#4DC3FA');

        $('tr.detailed').remove();

        if(obj.asc) {
            let sortedRows = Array.from(table.rows)
                .slice(1)
                .sort((rowA, rowB) => rowA.cells[3].innerHTML > rowB.cells[3].innerHTML ? 1 : -1);

            table.tBodies[0].append(...sortedRows);

            obj.asc = false;
            obj.desc = true;
        } else {
            let sortedRows = Array.from(table.rows)
                .slice(1)
                .sort((rowA, rowB) => rowA.cells[3].innerHTML < rowB.cells[3].innerHTML ? 1 : -1);

            table.tBodies[0].append(...sortedRows);

            obj.asc = true;
            obj.desc = false;
        }

        

        $("<tr class='detailed'></tr>").insertAfter('tr.tr-not-working');
        $("<tr class='detailed'></tr>").insertAfter('tr.tr-working');
    });
});