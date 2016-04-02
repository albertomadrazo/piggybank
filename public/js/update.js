$(function(){
    $('.meta_to_update').on('click', function(){
        // alert($(this).attr('id'));

        var meta_de_ahorro = $(this).next().attr('data-meta_de_ahorro');
        var slug = $(this).next().attr('data-slug');
        var total = $(this).next().attr('data-total');
        var fecha_inicial = $(this).next().attr('data-fecha_inicial');
        var fecha_final = $(this).next().attr('data-fecha_final');

        $('#to_update').val(slug);

        $("#meta_de_ahorro").val(meta_de_ahorro);
        $("#total").val("$"+total);
        $("#fecha_inicial").val(fecha_inicial);
        $("#fecha_final").val(fecha_final);
    });
});