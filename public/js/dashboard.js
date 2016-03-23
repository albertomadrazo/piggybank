var Tiempo = (function(){
    var intervalo;
    var intervalo_en_texto;

    dia = function(dias=1){
        return parseInt(dias) * 86400;
    };

    fecha_de_hoy = function(){
        var fecha = Math.floor(Date.now());
        return fecha.getFullYear()+"-"+(fecha.getMonth()+ 1)+"-"+fecha.getDate();

    };

    // Convierte la fecha en string al formato
    // que necesito 'YYYY-MM-DD'
    my_strtotime = function(fecha){
        var fecha = new Date(fecha);
        return fecha.getFullYear()+"-"+(fecha.getMonth()+ 1)+"-"+fecha.getDate();

    }

    convertir_intervalo_a_texto = function(intervalo){
        // var intervalo_en_texto;

        switch(intervalo){
            case 1:
                intervalo_en_texto = "diario";
                break;
            case 7:
                intervalo_en_texto = "semana";
                break;
            case 30:
                intervalo_en_texto = "mes";
                break;
            case 365:
                intervalo_en_texto = "año";
                break;
            default:
                intervalo_en_texto = "---";
        }

        return intervalo_en_texto;
    };

    calcular_periodo = function(desde, hasta){
        stamp_desde = Math.round(new Date(desde).getTime()/1000);
        stamp_hasta = Math.round(new Date(hasta).getTime()/1000);

        days = parseInt((stamp_hasta - stamp_desde) / 60 / 60 / 24);

        return days;
    };

    cantidad_de_intervalos = function(fecha_inicial, fecha_final, intervalo){
        fecha_inicial = Math.round(new Date(fecha_inicial).getTime()/1000);
        fecha_final = Math.round(new Date(fecha_final).getTime()/1000);

        return parseInt((fecha_final - fecha_inicial) / dia(intervalo));
    };

    plazo_vencido = function(fecha, intervalo){
        var plazo = [];

         switch(intervalo){
            case 'dia':
                plazo = [1, "days"];
                break;
            case 'semana':
                plazo = [1, "weeks"];
                break;
            case 'quincena':
                plazo = [15, "days"];
                break;
            case 'mes':
                plazo = [1, "months"];
                break;
            case 'año':
                plazo = [1, "years"];
                break;
            default:
                plazo = [1, "weeks"];
        }  

        plazo = parseInt(moment().subtract(plazo[0], plazo[1]).calendar());
        if(parseInt(fecha) > plazo){
            // return true;
            console.log("Ha pasado mas de "+intervalo);
        } else{
            // return false;
            console.log("No ha pasado "+intervalo+" aun.");
        } 
    }

    return {
        dia:                         dia,
        fecha_de_hoy:                fecha_de_hoy,
        convertir_intervalo_a_texto: convertir_intervalo_a_texto,
        // calcular_periodo:            calcular_periodo,
        cantidad_de_intervalos:      cantidad_de_intervalos,
        plazo_vencido:               plazo_vencido
    }
})();


function getVariablesForTab(tab){

    var hoy = moment().format('YYYY-MM-DD');
    var num_de_intervalos = Tiempo.cantidad_de_intervalos(
        tab['fecha_inicial'],
        tab['fecha_final'],
        tab['intervalo']
    );
    var deuda = 0;
    var intervalo_actual = (Tiempo.cantidad_de_intervalos(tab['fecha_inicial'], hoy, tab['intervalo'])+1);
    var intervalos_faltantes = num_de_intervalos - intervalo_actual;
    var cantidad_faltante = tab['total'] - tab['ahorro_parcial'];
    var ultimo_intervalo = my_strtotime(tab['fecha_inicial']) + (Tiempo.dia(tab['intervalo']));
    var plazo_vencido = Tiempo.plazo_vencido(ultimo_intervalo, Tiempo.convertir_intervalo_a_texto(parseInt(tab['intervalo'])));
    
    plazo_vencido = hoy; // ????????

    // if(plazo_vencido){
    //     console.log("Es hora de ahorrar.");
    // } else{
    //     console.log("Estás al día.");
    // }
    var abonos_al_corriente = tab['cantidad_a_abonar'] * intervalo_actual;

    if(parseInt(tab['ahorro_parcial']) >= parseInt(abonos_al_corriente)){
        deuda = abonos_al_corriente;
        if(deuda > cantidad_faltante){
            deuda = cantidad_faltante;
        }
    } else{
        deuda = parseInt(tab['cantidad_a_abonar']) + (abonos_al_corriente - tab['ahorro_parcial']);
    }
    $('#tab-meta_de_ahorro').html(tab['meta_de_ahorro']);
    $('#tab-deuda').html(deuda);
    $('#tab-intervalo_a_texto').html(Tiempo.convertir_intervalo_a_texto(parseInt(tab['intervalo'])));
    $('#tab-intervalo_actual').html(intervalo_actual);
    $('#tab-intervalos_faltantes').html(intervalos_faltantes);
    $('#tab-ahorro_parcial').html(tab['ahorro_parcial']);
    $('#tab-cantidad_faltante').html(cantidad_faltante);

    $('#hidden-meta_de_ahorro').val(tab['meta_de_ahorro']);
    $('#hidden-abonar_todo').val(deuda);
    return {
        hoy                 : hoy,
        num_de_intervalos   : num_de_intervalos,
        intervalo_actual    : intervalo_actual,
        cantidad_faltante   : cantidad_faltante,
        ultimo_intervalo    : ultimo_intervalo,
        plazo_vencido       : plazo_vencido,
        intervalos_faltantes: intervalos_faltantes,
        abonos_al_corriente : abonos_al_corriente
    }
}


var valores_de_meta = {
    'user_id':'', 'meta_de_ahorro': '', 'total': '',
    'cantidad_a_abonar': '', 'periodo': '', 'intervalo': '',
    'ahorro_parcial': '', 'fecha_inicial': '',
    'fecha_final': '', 'tipo_de_ahorro': ''
};


$(function(){

    $('#abonar_todo').change(function(){
        $('#una_parte').attr('checked', false);
        $('#una_parte_cantidad').css('visibility', 'hidden');
    });

    $('#una_parte').change(function(){
        $('#abonar_todo').attr('checked', false);

        if($('#una_parte_cantidad').attr('name') == 'abono'){
            $('#una_parte_cantidad').removeAttr('name');
        } else{
            $('#una_parte_cantidad').attr('name', 'abono');
        }

        toggleVisible('#una_parte_cantidad');
    });

    // AJAX para obtener las tablas de metas de una manera mas limpia
    $.post("goal_tables.php", {user_id: $('#user-id').html()},function(data){

        var data = JSON.parse(data);

        var metas_tabs = '';
        var metas = '';

        for(var i= 0; i < data.length; i++){
            metas_tabs += '<li><a data-toggle="tab" href="#'+data[i]['meta_de_ahorro']+'">'+ data[i]['meta_de_ahorro']+'</a></li>';
            metas += '<div id="'+data[i]['meta_de_ahorro']+'" class="tab-pane fade">';

            for(var key in data[i]){
                if(i === 0){
                    valores_de_meta[key] = data[i][key];
                }
                metas += '<p><span>'+key+"</span>: <span>"+data[i][key]+'</span></p>';
            }
            metas += '</div>';
        }    

        getVariablesForTab(valores_de_meta);

        metas += '</div>';
        metas_tabs += '</ul>';

        $('#metas_tabs').append(metas_tabs);
        $('#metas').append(metas);

        // $('#metas div:first').addClass('in');
        // $('#metas div:first').addClass('active');

        $('#metas_tabs li:first').addClass('active');

        if($("#metas").has("div").length){
            $("div#metas").children("div").each(function(index){
                $(this).children("p").each(function(index){
                    valores_de_meta[$(this).html()] 
                });
            });
        } else{
            console.log("No div present in the DOM");
        }

        $("#metas_tabs > li").on('click', function(){
            var meta_values = $(this).find('a').html();

            $('#metas').children('div#'+meta_values).each(function(index){
                $(this).children('p').each(function(index2){
                    valores_de_meta[$(this).find('>:first-child').html()] = $(this).find('>:nth-child(2)').html();
                });
            });
            var aver = getVariablesForTab(valores_de_meta);
            $('#metas').removeClass('in');
            $('#metas').removeClass('active');
            $('#metas').css('display', 'none');

        });
    });
});