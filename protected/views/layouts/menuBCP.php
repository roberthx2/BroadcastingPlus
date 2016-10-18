<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#" style="padding-top:10px;">
                        Envios Premium
                    </a>
                </li>

                <li data-toggle="collapse" data-target="#promociones_mt" class="collapsed active">
                    <a href="#"> Promociones Premium <span class="caret brandMenu" aria-hidden="true"></span></a>
                </li>
                    <ul class="sub-menu collapse" id="promociones_mt">
                        <li class="subMenu"><a href="<?php echo Yii::app()->createUrl('#');?>"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Crear</a></li>
                        <li class="subMenu"><a href="<?php echo Yii::app()->createUrl('#');?>"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Ver detalles</a></li>
                    </ul>
                <li data-toggle="collapse" data-target="#cupo_mt" class="collapsed active">
                    <a href="#"> Cupo <span class="caret brandMenu" aria-hidden="true"></span></a>
                </li>
                    <ul class="sub-menu collapse" id="cupo_mt">
                        <li class="subMenu"><a href="<?php echo Yii::app()->createUrl('#');?>"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Recargar</a></li>
                        <li class="subMenu"><a href="<?php echo Yii::app()->createUrl('#');?>"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Histórico</a></li>
                    </ul>
                <li data-toggle="collapse" data-target="#reportes_mt" class="collapsed active">
                    <a href="#"> Reportes <span class="caret brandMenu" aria-hidden="true"></span></a>
                </li>
                    <ul class="sub-menu collapse" id="reportes_mt">
                        <li class="subMenu"><a href="<?php echo Yii::app()->createUrl('#');?>"><span class="glyphicon glyphicon-time" aria-hidden="true"></span> SMS Programados</a></li>
                        <li class="subMenu"><a href="<?php echo Yii::app()->createUrl('#');?>"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> Mensual de SMS</a></li>
                        <li class="subMenu"><a href="<?php echo Yii::app()->createUrl('#');?>"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> Mensual de SMS por Cliente</a></li>
                        <li class="subMenu"><a href="<?php echo Yii::app()->createUrl('#');?>"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> Mensual de SMS por código</a></li>
                        <li class="subMenu"><a href="<?php echo Yii::app()->createUrl('#');?>"><span class="glyphicon glyphicon-import" aria-hidden="true"></span> SMS Recibidos</a></li>
                        <li class="subMenu"><a href="<?php echo Yii::app()->createUrl('#');?>"><span class="glyphicon glyphicon-camera" aria-hidden="true"></span> Reporte de Vigilancia</a></li>
                    </ul>
                <li data-toggle="collapse" data-target="#administracion_mt" class="collapsed active">
                    <a href="#"> Administración <span class="caret brandMenu" aria-hidden="true"></span></a>
                </li>
                    <ul class="sub-menu collapse" id="administracion_mt">
                        <li class="subMenu"><a href="<?php echo Yii::app()->createUrl('#');?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Clientes</a></li>
                        <li class="subMenu"><a href="<?php echo Yii::app()->createUrl('#');?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Usuarios</a></li>
                    </ul>
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
                        );?>
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
        //$(this).find(".glyphicon").toggleClass('glyphicon-arrow-left glyphicon-share-alt');
        //$(".glyphicon").toggleClass('glyphicon-arrow-left glyphicon-share-alt');
    });
    </script>

<?php $this->endContent(); ?>

<style type="text/css">

    .sidebar-nav .brandMenua {
        content: "\f078";
        display: inline-block;
        padding-left: 10px;
        padding-right: 10px;
        vertical-align: middle;
        float: right;
    }

    .sidebar-nav .subMenu{
        list-style-type: none;
        list-style-position:outside;
        padding-left: 0px;
    }

    .sub-menu {
        -webkit-padding-start: 0px;
    }

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