$( document ).ready(function() {


    calcularNotes();
    var editbutton = "<button style='float: right' class='edit-button btn-warning'><i class='fa fa-pencil'></i></button>";
    $('.nota').append(editbutton);
    $('.noentregat').append(editbutton);

    $('.edit-button').on("click", function(){

        var valor = $(this).closest('td').text();
        $(this).closest('td').html('<input class="input-edit" type="number" min="1" max="10"  step="0.1" value='+valor+'/>');

    });


    $('td').on('blur','input', function () {
        var valorinput = $('input').val();
        $('input').closest('td').html(valorinput+editbutton);

        calcularNotes();
        assignarEvents();
    });


    function calcularNotes(){
        var ufs = $('.uf');
        ufs.each(function(){

            var notes = $(this).find('.nota');
            var suma = 0;
            var longitud = notes.length;
            var mitjana = 0;
            notes.each(function(){
                $(this).text();
                var a = parseFloat($(this).text());

                suma = suma + a;
            });

            mitjana = suma/longitud;
            $(this).find('.notafinal').html(mitjana);
        });
    }

});
