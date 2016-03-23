function toggleVisible(element){

    if($(element).css('visibility') == 'visible'){
        $(element).css('visibility', 'hidden');
        return;
    }
    else if($(element).css('visibility') == 'hidden'){
        $(element).css('visibility', 'visible');

        return;
    }
}





$(document).ready(function(){

    // var fecha = moment(moment().subtract(3, 'months'), "YYYY-MM-DD");
    // fecha = new Date(fecha);
    // fecha = fecha.getFullYear()+"-"+(fecha.getMonth()+ 1)+"-"+fecha.getDate(); 

    // // Tiempo.plazo_vencido(fecha, "mes");
    // // console.log(Tiempo.convertir_intervalo_a_texto(365));

    // // console.log(Tiempo.cantidad_de_intervalos('2016-05-03', '2017-05-03', 7));

    $('#date_picker1').datepicker({dateFormat: "yy-mm-dd"});
    $('#date_picker2').datepicker({dateFormat: "yy-mm-dd"});


});