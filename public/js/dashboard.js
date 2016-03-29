// Closure para procesar las variables que me da la base de datos
// TODO: cambiarle el nombre porque no solo hay funciones relativas
// al tiempo, sino calculos matematicos
var Tiempo = (function(){

    var intervalo; // Cada cuantos dias se tiene que abonar
    var intervalo_en_texto;
    var ahorro_parcial; // Cuantos ahorros se han acumulado
    var cantidad_a_abonar;

    set_ahorro_parcial = function(cantidad){
        ahorro_parcial = cantidad;
    }

    get_ahorro_parcial = function(){
        return ahorro_parcial;
    }

    set_cantidad_a_abonar = function(cantidad){
        cantidad_a_abonar = cantidad;
    }

    get_cantidad_a_abonar = function(){
        return cantidad_a_abonar;
    }

    // convierte los dias en timestamp. Un dia tiene 86400 segundos
    dia = function(dias){
        return (parseInt(dias) * 86400);
    };

    // retorna una fecha con formato YYYY-MM-DD a partir del timestamp
    fecha_de_hoy = function(){
        var fecha = new Date();
        return fecha.getFullYear()+"-"+
                (append_0_if_needed(fecha.getMonth()+ 1))+"-"+
                (append_0_if_needed(fecha.getDate()));
    };

    // convierte un timestamp a fecha con formate YYYY-MM-DD
    timestamp_to_date = function(timestamp){
        timestamp = new Date(timestamp*1000);
        var result =timestamp.getFullYear()+"-"+
        (((timestamp.getMonth()+1) < 10) ?
                ("0"+(timestamp.getMonth()+1)): (timestamp.getMonth()+1))+
        "-"+timestamp.getDate();
        return result;
    }

    // le pone un 0 al numero si es menor de 10, para que sea una fecha valida
    append_0_if_needed = function(numero){
        var numero = parseInt(numero);
        if(numero > 0 && numero < 10){
            return "0"+numero;
        } else{
            return numero;
        }
    }

    // Convierte la fecha en string al formato
    // que necesito 'YYYY-MM-DD'
    my_strtotime = function(fecha){
        return Date.parse(fecha)/1000;
    }

    // convierte el numero de dias en texto. ejemplo: 7 => "semana"
    convertir_intervalo_a_texto = function(intervalo){

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

    // pendiente, no se para que sirva
    // eliminarla
    calcular_periodo = function(desde, hasta){
        stamp_desde = Math.round(new Date(desde).getTime()/1000);
        stamp_hasta = Math.round(new Date(hasta).getTime()/1000);

        days = parseInt((stamp_hasta - stamp_desde) / 60 / 60 / 24);

        return days;
    };

    // retorna la cantidad de intervalos entre dos fechas.
    // Ejemplo: 2016-03-20 a 2017-03-20 y el intervalo es 7, regresa 52,
    // si es 30, regresa 12
    cantidad_de_intervalos = function(fecha_inicial, fecha_final, intervalo){
        fecha_inicial = Math.round(new Date(fecha_inicial).getTime()/1000);
        fecha_final = Math.round(new Date(fecha_final).getTime()/1000);
        
        return parseInt((fecha_final - fecha_inicial) / dia(intervalo));
    };

    // si han pasado n(intervalo) dias entre dos fechas, retorna true,
    // si no, retorna false
    plazo_vencido = function(fecha_inicial, intervalo){
        var oneDay = 24*60*60*1000;
        var hoy = my_strtotime(new Date());
        var fecha_inicial = my_strtotime(fecha_inicial);
        var dias_transcurridos = Math.round((hoy - fecha_inicial)/86400);
        var b = dias_transcurridos / intervalo;
        var abonos_al_corriente = get_cantidad_a_abonar() * dias_transcurridos;
        if((b / intervalo < 1) || (get_ahorro_parcial() >= abonos_al_corriente)){
            // console.log("No ha vencido");
            return false;
        }
        else if((b / intervalo >= 1) && (get_ahorro_parcial() < abonos_al_corriente)){
            return true;
            // console.log("Ya venció");
        } else{

            console.log("Algo anda mal con esta función");
        }
    }

    return {
        set_ahorro_parcial:          set_ahorro_parcial,
        get_ahorro_parcial:          get_ahorro_parcial,    
        set_cantidad_a_abonar:       set_cantidad_a_abonar,
        get_cantidad_a_abonar:       get_cantidad_a_abonar,
        dia:                         dia,
        fecha_de_hoy:                fecha_de_hoy,
        timestamp_to_date:           timestamp_to_date,
        my_strtotime:                my_strtotime,
        convertir_intervalo_a_texto: convertir_intervalo_a_texto,
        cantidad_de_intervalos:      cantidad_de_intervalos,
        plazo_vencido:               plazo_vencido,
    }
})();

// corre cuando se cambia de meta (los tabs)
// cambia los valores de la tabla de informacion y da las cantidades a
// abonar
function getVariablesForTab(tab){

    Tiempo.set_ahorro_parcial(tab['ahorro_parcial']);
    Tiempo.set_cantidad_a_abonar(tab['cantidad_a_abonar']);
    var hoy = Tiempo.fecha_de_hoy();
    var num_de_intervalos = Tiempo.cantidad_de_intervalos(
        tab['fecha_inicial'],
        tab['fecha_final'],
        tab['intervalo']
    );
    var deuda = 0;
    var intervalo_actual = (Tiempo.cantidad_de_intervalos(
            tab['fecha_inicial'], hoy, tab['intervalo']) + 1 // TODO: checar este +1
    );
    var intervalos_faltantes = num_de_intervalos - intervalo_actual;
    var cantidad_faltante = tab['total'] - tab['ahorro_parcial'];
    // Calcula el tiempo desde el inicio hasta el ultimo intervalo
    var ultimo_intervalo = Tiempo.my_strtotime(tab['fecha_inicial']) + (Tiempo.dia(tab['intervalo']));
    var plazo_vencido = Tiempo.plazo_vencido(tab['fecha_inicial'],tab['intervalo']);
    
    if(!plazo_vencido){
        $('#al_dia').html("Estás al día.");
    } else{
        $('#al_dia').html("Es hora de ahorrar.");
    }

    var abonos_al_corriente = tab['cantidad_a_abonar'] * intervalo_actual;

    // Calcula la cantidad de deuda
    if(parseInt(tab['ahorro_parcial']) >= parseInt(abonos_al_corriente)){
        deuda = abonos_al_corriente;
        if(deuda > cantidad_faltante){
            deuda = cantidad_faltante;
        }
    } else{
        deuda = parseInt(tab['cantidad_a_abonar']) + (abonos_al_corriente - tab['ahorro_parcial']);
    }

    // Aqui es donde llena todos los campos de la tabla informativa y de la cantidad que se debe
    // en la tabla actual

    // El nombre de la tabla (no slug)
    $('#tab-meta_de_ahorro').html(tab['meta_de_ahorro']);
    // junto al checkbox de "todo lo que debo". Lado izquierdo
    // TODO: Este no esta funcionando
    $('#tab-deuda').html(deuda);
    // El indicador del intervalo "mes", "año"...
    $('#tab-intervalo_a_texto').html(Tiempo.convertir_intervalo_a_texto(parseInt(tab['intervalo'])));
    // El indicador de que intervalo va
    $('#tab-intervalo_actual').html(intervalo_actual);
    $('#tab-intervalos_faltantes').html(intervalos_faltantes);
    $('#tab-ahorro_parcial').html(tab['ahorro_parcial']);
    $('#tab-cantidad_faltante').html(cantidad_faltante);

    // Campo escondido para enviar el nombre de la meta, debe ser slug
    $('#hidden-meta_de_ahorro').val(tab['slug']);

    $('#hidden-abonar_todo').val(deuda);
    return {
        hoy                 : hoy,
        num_de_intervalos   : num_de_intervalos,
        intervalo_actual    : intervalo_actual,
        cantidad_faltante   : cantidad_faltante,
        ultimo_intervalo    : ultimo_intervalo,
        // plazo_vencido       : plazo_vencido,
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
        $('#una_parte_cantidad').val("");
        $('#una_parte_cantidad').css('visibility', 'hidden');
    });

    $('#una_parte').change(function(){
        $('#abonar_todo').attr('checked', false);
        console.log("Que pasa chingaos");

        // if($('#una_parte_cantidad').attr('name') == 'abono'){
        //     $('#una_parte_cantidad').removeAttr('name');
        // } else{
        //     $('#una_parte_cantidad').attr('name', 'abono');
        // }

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