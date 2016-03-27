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