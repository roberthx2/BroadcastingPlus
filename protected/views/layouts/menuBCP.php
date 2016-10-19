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
            <?php echo $content; ?>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Menu Toggle Script -->
    <script>

    $(".boton_menu").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>

<?php $this->endContent(); ?>
