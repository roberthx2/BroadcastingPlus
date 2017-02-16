function contarCaracterPromocion()
{
    var caracter;

    caracter = new String($("#PromocionForm_mensaje").val());

    if(caracter.length>158)
    {
        $("#PromocionForm_mensaje").val(caracter.substring(0, 158));
    } else
	    {
	    	$("#caracteres").val(158-caracter.length);
	    }
}

/*function contarNumerosTextArea()
{
    var destinatarios = $("#PromocionForm_destinatarios");
    var countSpan = $("#total");

    var text = destinatarios.val();
    var num = 0;

    if (text != '')
    {
        var nats = text.split(',');
        var num = nats.length;
    }
    $("#total").val(num);
}*/

function disabledPuertos()
{
	$("#PromocionForm_puertos").prop('disabled', function(i, v) { return !v; });
}

function processKeydown(e)
{
    tecla = (document.all) ? e.keyCode : e.which;
    //console.log("CanPress" + canPress());
    countNumber();
    // Allow: backspace delete
    if ($.inArray(tecla, [46, 8]) !== -1 ||

         // Allow: Ctrl+V
        (tecla == 86 && e.ctrlKey === true) || 
         // Allow: Ctrl+A
        (tecla == 65 && e.ctrlKey === true) || 
        // Allow: Ctrl+C
        (tecla == 67 && e.ctrlKey === true) || 
        // Allow: Ctrl+X
        (tecla == 88 && e.ctrlKey === true) ||
         // Allow: home, end, left, right
        (tecla >= 35 && tecla <= 39)) 
    {
         return;
    }
    
    //Si se puede presionar una coma, y se presiona, dejar
    if(tecla == 44 && canPress() == "comma")
        return;

    // Si lo presionado no es un numero, stop
    if ((e.shiftKey || (tecla < 48 || tecla > 57)) && (tecla < 96 || tecla > 105)) {
        e.preventDefault();
    }
    //si se presiono un numero, y no se puede presionar un numero, stop
    else if(!(canPress() == "number"))
    {
        e.preventDefault();
    }
}

function canPress()
{
    var destinatarios = $(".numerosTextarea").val();

    if(destinatarios == "" || destinatarios.length < 10)
        return "number";

    var lastDigits = $(".numerosTextarea").val().slice( -10 );

    //console.log("Last digits: " + lastDigits);
    //console.log("IndexOfComma: " +lastDigits.indexOf(','));

    if(lastDigits.indexOf(',') != -1)
        return "number";
    else
        return "comma";
}


function countNumber() {
    var destinatarios = $(".numerosTextarea");
    var countSpan = $("#total");

    var text = destinatarios.val();
    var num = 0;

    if (text != '')
    {
        var nats = text.split(',');
        var num = nats.length;
    }
    $("#total").val(num);
    //countSpan.html(num);

}

function enableFormPromocion(tipo)
{
    //BCNL
    if (tipo == 1)
    {
        $("#PromocionForm_fecha").prop('disabled', false);
        $("input[name='PromocionForm[hora_inicio]']" ).prop('disabled', false);
        $("input[name='PromocionForm[hora_fin]']" ).prop('disabled', false);
        $("#PromocionForm_duracion").prop('disabled', true);
        $("#PromocionForm_puertos").prop('disabled', false); 
        $("#all_puertos").prop('disabled', false);      
    }
    //CPEI
    else if (tipo == 2)
    {
        $("#PromocionForm_fecha").prop('disabled', true);
        $("input[name='PromocionForm[hora_inicio]']" ).prop('disabled', true);
        $("input[name='PromocionForm[hora_fin]']" ).prop('disabled', true);
        $("#PromocionForm_duracion").prop('disabled', false);
        $("#PromocionForm_puertos").prop('disabled', false);
        $("#all_puertos").prop('disabled', false);            
    }   
    //BCP
    else if (tipo == 3)
    {
        $("#PromocionForm_fecha").prop('disabled', false);
        $("input[name='PromocionForm[hora_inicio]']" ).prop('disabled', false);
        $("input[name='PromocionForm[hora_fin]']" ).prop('disabled', false);
        $("#PromocionForm_duracion").prop('disabled', true);
        $("#PromocionForm_puertos").prop('disabled', true);
        $("#all_puertos").prop('disabled', true);       
    }
    //Desconocida
    else
    {
        $("#PromocionForm_fecha").prop('disabled', true);
        $("input[name='PromocionForm[hora_inicio]']" ).prop('disabled', true);
        $("input[name='PromocionForm[hora_fin]']" ).prop('disabled', true);
        $("#PromocionForm_duracion").prop('disabled', true);
        $("#PromocionForm_puertos").prop('disabled', true);
        $("#all_puertos").prop('disabled', true);
    }      
}

function hideShowFormPromocion(tipo)
{
    //BCL
    if (tipo == 1)
    {       
        $("#div_id_cliente").show();
        $("#div_nombre").show();
        $("#div_prefijo").show();
        $("#div_mensaje").show();
        $("#div_fecha").show();
        $("#div_hora_inicio").show();
        $("#div_hora_fin").show();
        $("#div_duracion").hide();
        $("#div_puertos").show();
        $("#div_destinatarios").show();
        $("#div_listas").show();
        $("#div_btl").show();
        $("#div_botones").show();
    }
    //CPEI
    else if (tipo == 2)
    {       
        $("#div_id_cliente").show();
        $("#div_nombre").show();
        $("#div_prefijo").show();
        $("#div_mensaje").show();
        $("#div_fecha").hide();
        $("#div_hora_inicio").hide();
        $("#div_hora_fin").hide();
        $("#div_duracion").show();
        $("#div_puertos").show();
        $("#PromocionForm_all_puertos").prop("checked", true);
        $("#PromocionForm_puertos").prop('disabled', true);
        $("#div_destinatarios").show();
        $("#div_listas").show();
        $("#div_btl").show();
        $("#div_botones").show();
    }
    //BCP
    else if (tipo == 3)
    {       
        $("#div_id_cliente").show();
        $("#div_nombre").show();
        $("#div_prefijo").show();
        $("#div_mensaje").show();
        $("#div_fecha").show();
        $("#div_hora_inicio").show();
        $("#div_hora_fin").show();
        $("#div_duracion").hide();
        $("#div_puertos").hide();
        $("#div_destinatarios").show();
        $("#div_listas").show();
        $("#div_btl").show();
        $("#div_botones").show();
    }
    //Desconocido
    else
    {       
        $("#div_id_cliente").hide();
        $("#div_nombre").hide();
        $("#div_prefijo").hide();
        $("#div_mensaje").hide();
        $("#div_fecha").hide();
        $("#div_hora_inicio").hide();
        $("#div_hora_fin").hide();
        $("#div_duracion").hide();
        $("#div_puertos").hide();
        $("#div_destinatarios").hide();
        $("#div_listas").hide();
        $("#div_btl").hide();
        $("#div_botones").hide();
    }
}

function insertarPrefijo()
{
    if ($("#PromocionForm_prefijo").val() != "")
    {
        var mensaje = "("+$("#PromocionForm_prefijo").val()+") "+$("#PromocionForm_mensaje").val();
        $("#PromocionForm_mensaje").val(mensaje);
    }
}

function defaultOperadoraBTL()
{
    $("#Btl_all_operadoras").prop('checked', true);
    $("#Btl_all_operadoras").prop('disabled', false);
    $("#Btl_operadoras").prop('disabled', true);
}

function checkedOperadoraBTL()
{
    $("#Btl_operadoras").prop('disabled', function(i, v) { return !v; });
}