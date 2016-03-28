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


var can_be_submitted = false;

function canSubmit(){
    console.log(can_be_submitted);
    return can_be_submitted;
}

$(document).ready(function(){   

    // TODO: mejorar este event handler
    $('.is-int').on('focusout', function(){
        var cifra = $(this).val();
        // cifra = parseInt(cifra);

        var is_number = /^\d+$/.test(cifra);

        if(!is_number){
            $(this).prev().html("Sólo números");
            can_be_submitted = false;
            return false;
        } else{
            $(this).prev().html("");
            can_be_submitted = true;
            return true;
        }

        // console.log(is_number);
    });

    $('#date_picker1').datepicker({dateFormat: "yy-mm-dd"});
    $('#date_picker2').datepicker({dateFormat: "yy-mm-dd"});


    // Validate fields for signup.php and signin.php
    $('#signup-form').validate({
        rules:{
            first_name: 'required',
            username:{
                required: true,
                minlength: 3
            },
            password:{
                required: true,
                minlength: 4
            },
            confirm_password:{
                required: true,
                equalTo: '#password'
            },
            email:{
                required: true,
                email: true
            }
        },
        messages:{
            first_name: "Es necesario un nombre",
            username:{
                required: "Es necesario un nombre de usuario",
                minlength: "El nombre de usuario debe ser de al menos 3 letras"
            },
            email:{
                required: "Escribe un correo v&aacute;lido",
                email: "Escribe un correo v&aacute;lido"
            },
            password:{
                required: "Es necesaria una contraseña",
                minlength: "La contraseña debe ser de al menos 4 letras"
            },
            confirm_password:{
                required: "La contraseña debe ser verificada",
                equalTo: "La contraseña no es igual a la de arriba"
            }
        }
    });

});