<div id="fieldBTL" >
    <?php
    // VARIABLES DE SESIÓN QUE SE DEBEN TENER PARA QUE EL MÓDULO FUNCIONE CORRECTAMENTE    
    Yii::app()->user->setState('scSeleccionado', null);
    Yii::app()->user->setState('cadena_serv', null);
    Yii::app()->user->setState('cadena_sc', null);
    Yii::app()->user->setState('accesoBTL', null);
    if(ControlFe::model()->getAccesoBTL(Yii::app()->user->id)){
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'Numeros BTL',
            'id' => 'botonBTL',
        ));
    }

    ?>
</div>
<?php
$this->beginWidget(
        'booster.widgets.TbModal', array('id' => 'myModalBtl')
);
?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">*</a>
    <h3>Clave de transacciones</h3>
</div>

<div class="modal-body" id="bodyModalBtl">
    <p>

    </p>
</div>

<div class="modal-footer">
    <?php
    $this->widget(
            'booster.widgets.TbButton', array(
        'id' => 'confirmarForm',
        'label' => 'Confirmar',
        'context' => 'primary',
        'htmlOptions' => array('data-dismiss' => 'modal'),
            )
    );
    ?>

    <?php
    $this->widget(
            'booster.widgets.TbButton', array(
        'id' => 'cerrar_nuevo',
        'label' => 'Cancelar',
        'htmlOptions' => array('data-dismiss' => 'modal'),
            )
    );
    ?>
</div>

<?php $this->endWidget(); ?>

<script>
$(document).ready(function(){
    $("#Usuario_masivo_pwd").val("");
    
        $.ajax({
            url: '<?php echo Yii::app()->createUrl('btl/claveTransacciones'); ?>',
            type: "POST",
            dataType: "html",
            success: function(data) {
                $("#bodyModalBtl").html(data);
            }

        });
  });
  
   $('#myModalBtl').keypress(function(event) {
       
        if (event.keyCode == 13) {
            event.preventDefault();

            $('#confirmarForm').click();
        }
   
    });

    function openModal(id, header, body) {
        var closeButton = '<a class="close" data-dismiss="modal">X</a>';

        $("#" + id + " .modal-header").html(closeButton + '<h3>' + header + '</h3>');
        $("#" + id + " .modal-body").html(body);
        $("#" + id).modal("show");
    }
    $('#confirmarForm').on('click', function() {

        $.ajax({
            beforeSend: function() {
                $("#fieldBTL").addClass("loading");
            },
            complete: function() {
                $("#fieldBTL").removeClass("loading");
            },
            type: "POST",
            url: '<?php echo Yii::app()->createUrl('btl/claveTransacciones'); ?>',
            data: $("#claveTransaccionesForm").serialize(), 
            success: function(data)
            {
                if (data == "1") {
                    bootbox.alert("Clave de transacciones invalida");
                } else {
                    $("#fieldBTL").html(data);

                }

            }
        });
    });

    $('#botonBTL').on('click', function() {
        $("#myModalBtl").modal('show');
    });

</script>