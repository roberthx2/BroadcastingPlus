<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#" style="padding-top:10px;">
                        Listas de Destinatarios
                    </a>
                </li>
                <li>
                    <a href="<?php echo Yii::app()->createUrl('lista/create');?>"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Crear</a>
                </li>
                <li>
                    <a href="<?php echo Yii::app()->createUrl('lista/admin');?>"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> Administrar</a>
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <?php /*$this->widget(
                            'booster.widgets.TbButton',
                            array(
                                'url' => '#menu-toggle',
                                'icon'=>'share-alt',
                                'htmlOptions' => array('class'=>'boton_menu visible-xs'),
                            )
                        ); ?>
                        <?php $this->widget(
                            'booster.widgets.TbButton',
                            array(
                                'url' => '#menu-toggle',
                                'icon'=>'arrow-left star-empty',
                                'htmlOptions' => array('class'=>'boton_menu visible-md visible-lg'),
                            )
                        ); */?>
                        <?php echo $content; ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Menu Toggle Script -->
    <script>

    $(".boton_menu").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
        $(this).find(".glyphicon").toggleClass('glyphicon-arrow-left glyphicon-share-alt');
        //$(".glyphicon").toggleClass('glyphicon-arrow-left glyphicon-share-alt');
    });
    </script>

<?php $this->endContent(); ?>

<style type="text/css">
	@media (max-width: 768px) { 
		.contenedor_principal {
			margin-top: 11%; 
			margin-bottom:25%;
		}
	}

	/* Medium devices (desktops, 992px and up) */
	@media (min-width: 768px) {
		.contenedor_principal {
			margin-top: 3%; 
			margin-bottom:5%;
		}
	}
</style>