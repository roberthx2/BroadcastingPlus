<?php $collapse = $this->beginWidget('booster.widgets.TbCollapse'); ?>
<div class="panel-group" id="accordion">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
          <span class="glyphicon glyphicon-list-alt"></span> Resumen General 
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in">
      <div class="panel-body">
        <ul class="list-group">
        <?php 
        $bandera = 1;
        foreach ($objeto as $value)
        { 
            $context = "";
            if ($bandera == 1)
                $context = "background-color: white; color: black";
            if ($bandera == 2)
                $context = "background-color: #5bc0de; color: white";
            if ($bandera == 3)
            {
                if ($value["descripcion"] == "Aceptado")
                    $context = "background-color: #5cb85c; color: white";
                if ($value["descripcion"] == "Rechazado")
                    $context = "background-color: #d9534f; color: white";
            }

            if ($bandera == 4 && $value["descripcion"] == "Rechazado")
                $context = "background-color: #d9534f; color: white";
            ?>
            <li class="list-group-item">
                <?php $this->widget(
                    'booster.widgets.TbBadge',
                    array(
                        //'context' => $context,
                        // 'default', 'success', 'info', 'warning', 'danger'
                        'label' => $value["total"],
                        'htmlOptions' => array('style' => $context),
                    )
                ); ?>
                <?php echo '<strong>'.$value["descripcion"].'</strong>'; ?>
            </li>
        <?php 
        $bandera += 1; } ?>

        <?php if ($url_confirmar != null && $url_confirmar != 'CPEI')
        { ?>
            <li id="div_agregar" class="list-group-item">
                <center>
                <?php 
                    $this->widget(
                        'booster.widgets.TbButton',
                        array(
                            'id'=>'agregar',
                            //'buttonType' => 'link',
                            'context' => 'primary',
                            'label' => 'Confirmar Promoción',
                            'icon' => 'glyphicon glyphicon-ok',
                            //'url' => Yii::app()->createUrl("lista/agregarNumeros", array()),
                            'htmlOptions' => array('data-toggle' => 'modal', 'data-target' => '#modalConfirmar', 'onClick' => 'confirmar()'),
                        )
                    ); 
                ?>
                </center> 
            </li>
        <?php }
              else if ($url_confirmar == 'CPEI')
                {?>
                    <li id="div_agregar" class="list-group-item">
                        <stong><center style='color:#5cb85c; font-size: 16px;'>Confirmada</center></stong>
                    </li>
                <?php } ?>
        </ul>
      </div>
    </div>
  </div>
</div>
<?php $this->endWidget(); ?>

<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'modalConfirmar')
); ?>
 
    <div class="modal-header" style="background-color:#428bca">
        <h4 class="modal-title" style="color:#fff;"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Confirmar Promoción</h4>
    </div>
    
    <div class="modal-body" id="divModalConfirmar" >
        
    </div>

    <div id="modal_footer" class="modal-footer">
    <?php $this->widget(
        'booster.widgets.TbButton',
        array(
            'id'=>'confirmar',
            'context' => 'success',
            'label' => 'Aceptar',
            //'buttonType' =>'link',
            //'url' => '#',//Yii::app()->controller->createUrl("deleteLista", array("id" => $model->id_lista)),
            'icon' => 'glyphicon glyphicon-ok',
            'htmlOptions' => array('data-loading-text'=>'Confirmando...', 'autocomplete'=>'off'),
        )
    ); ?>
    <?php $this->widget(
        'booster.widgets.TbButton',
        array(
            'label' => 'Close',
            'url' => '#',
            'htmlOptions' => array('data-dismiss' => 'modal'),
        )
    ); ?>
</div>
 
<?php $this->endWidget(); ?>

<script type="text/javascript">
    $(document).ready(function()
    {
        $("a[data-toggle=modal]").click(function(){
            var target = $(this).attr('data-target');
            var url = $(this).attr('href');
            if(url){
                $(target).find(".modal-body").load(url);
            }
        });
    });

    function confirmar()
    {
        //var total = values.length;
        var mensaje = "<h4><center>¿Confirmar promoción?</center></h4>";
        $("#divModalConfirmar").html(mensaje);
        $("#modal_footer").show();
    }

    $('#confirmar').click(function(){
        $.ajax({
            url:"<?php echo $url_confirmar; ?>",
            type:"POST",    
            data:{},
            
            complete: function()
            {
                $("#modal_footer").hide();
            },
            success: function(data)
            {
                if (data.error == 'false')
                {
                    var mensaje = "<strong><center>Promoción confirmada correctamente</center> <br><br> <center>Redireccionando...</center></strong>";

                    $("#div_agregar").html("<stong><center style='color:#5cb85c; font-size: 16px;'>Confirmada</center></stong>");
                    $("#divModalConfirmar").html(mensaje);
 
                    setTimeout(function () {
                        var url = "<?php echo Yii::app()->createUrl('home/index'); ?>";
                        $(location).attr('href', url);
                    }, 2000);


                }
                else
                {
                    var mensaje = "<center><strong>NO se pudo confirmar la promoción</center></strong>";
                    $("#divModalConfirmar").html(mensaje);
                
                }
            },

            error: function()
            {
                $("#divModalConfirmar").html("<center><strong>Ocurrio un ERROR al confirmar la promoción</center></strong>");
                $("#modal_footer").hide();
            }
        });
    });
</script>