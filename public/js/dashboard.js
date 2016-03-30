$(function(){

    $('#abonar_todo').change(function(){
        $('#una_parte').attr('checked', false);
        $('#una_parte_cantidad').val("");
        $('#una_parte_cantidad').css('visibility', 'hidden');
    });

    $('#una_parte').change(function(){
        $('#abonar_todo').attr('checked', false);
        console.log("Que pasa chingaos");

        toggleVisible('#una_parte_cantidad');
    });

    elAjax();
});