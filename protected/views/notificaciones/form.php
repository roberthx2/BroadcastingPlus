
<div id="page-content-wrapper">

    <?php
        $flashMessages = Yii::app()->user->getFlashes();
        if ($flashMessages) {
            echo '<br><div class="container-fluid">';
            foreach($flashMessages as $key => $message) {
                echo '<div class="alert alert-'.$key.'">';
                echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                echo '<span class="glyphicon glyphicon-'. (($key == "success") ? "ok":"ban-circle").'"></span> '.$message;
            }
            echo '</div></div>';
        }
    ?>

    <div class="form col-xs-12 col-sm-12 col-md-12 col-lg-12" >

    <?php 

    $form = $this->beginWidget(
        'booster.widgets.TbActiveForm',
        array(
            'id' => 'lista-form',
            'type' => 'vertical',
            'enableAjaxValidation'=>false,
            'htmlOptions' => array('class' => 'well'),
        )
    ); ?>

    <fieldset>
     
        <legend><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Crear Notificación </legend>


    <?php if (Yii::app()->user->isAdmin()){ ?>
        <div>
            <?php echo $form->dropDownListGroup(
                $model,
                'id_usuario',
                array(
                    'wrapperHtmlOptions' => array(
                        //'class' => 'col-sm-5',
                    ),
                    'widgetOptions' => array(
                        'data' => CHtml::listData(UsuarioMasivo::model()->findAll(array("order"=>"login")), 'id_usuario', 'login'),
                        'htmlOptions' => array('prompt' => 'Seleccionar...'),
                    ),
                    'prepend' => '<i class="glyphicon glyphicon-user"></i>',
                    'hint' => 'En caso de <em>NO</em> seleccionar un usuario, la notificación sera enviada a todos los usuarios.',
                )
            ); ?>
        </div>
    <?php } 
        else
        {
            echo "Al crear una notificación esta sera enviada al area encargada de <em><strong>Insignia Mobile Communications, C.A.</strong></em> <br><br>";
        }
    ?>

    <?php 

    echo $form->html5EditorGroup(
            $model,
            'mensaje',
             array(
                'widgetOptions' => array(
                    'editorOptions' => array(
                        'class' => 'span4',
                        'rows' => 5,
                        'options' => array('color' => true, 'id'=>'mensaje'),
                    ),
                    'height' => '50%',
                    'width' => '100%',
                    'htmlOptions'=>array('id'=>'mensaje'),
                ),
            )
        ); 
    ?>

    <div style="float: right; font: bold 13px Arial;"><strong>Caracteres restantes:</strong>
                <?php echo CHTML::textField('caracteres',1000,array('size'=>2 ,'style'=>'align:right; margin-left:10px; border:0;', 'readonly' => true)); ?></div>

    </fieldset>
        <br><br>
        <div>
            <div class="col-xs-offset-4 col-sm-offset-10 col-md-offset-10 col-lg-offset-10">
            <?php //echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
                <?php $this->widget(
                        'booster.widgets.TbButton',
                        array(
                            'buttonType' => 'submit',
                            'context' => 'success',
                            'label' => 'Enviar notificación',
                            'icon' => 'glyphicon glyphicon-send',
                        )
                    ); ?>
            </div>
        </div>
    </div><!-- form -->
    <?php $this->endWidget(); ?>
<div>

<script type="text/javascript">
    $(document).ready(function() 
    {
        setInterval(function() {
            contarCaracterRestantesSinLimite($("#mensaje"), 1000)
        }, 1);
    });

    function contarCaracterRestantesSinLimite(objeto, tam)
    {
        //alert(objeto);
        var caracter;

        caracter = new String(objeto.val());

        $("#caracteres").val(tam-caracter.length);
        //$("ul.wysihtml5-toolbar").find("a[title='Insert image']").hide();
        //$("ul.wysihtml5-toolbar").find("a[title='Insert image']").addClass("disabled");
    }


</script>
