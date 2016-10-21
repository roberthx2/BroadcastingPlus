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
    var destinatarios = $("#PromocionForm_destinatarios").val();

    if(destinatarios == "" || destinatarios.length < 10)
        return "number";

    var lastDigits = $("#PromocionForm_destinatarios").val().slice( -10 );

    //console.log("Last digits: " + lastDigits);
    //console.log("IndexOfComma: " +lastDigits.indexOf(','));

    if(lastDigits.indexOf(',') != -1)
        return "number";
    else
        return "comma";
}


function countNumber() {
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
    //countSpan.html(num);

}