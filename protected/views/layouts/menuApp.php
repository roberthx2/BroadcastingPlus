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

                <?php if (Yii::app()->user->getPermisos()->modulo_promocion) { ?>
                <li data-toggle="collapse" data-target="#menu_promocion" class="collapsed active">
                    <a href="#"> Promociones <span class="caret brandMenu" aria-hidden="true"></span></a>
                </li>
                    <ul class="sub-menu collapse" id="menu_promocion">
                        <?php if (Yii::app()->user->getPermisos()->crear_promo_bcnl || Yii::app()->user->getPermisos()->crear_promo_bcp || Yii::app()->user->getPermisos()->broadcasting_cpei) { ?>
                        <li class="subMenu"><a href="<?php echo Yii::app()->createUrl('promocion/create');?>"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Crear </a></li>  <?php } ?>
                        <?php if (Yii::app()->user->getPermisos()->detalles_promo_bcnl || Yii::app()->user->getPermisos()->detalles_promo_bcp) { ?>
                        <li class="subMenu"><a href="<?php echo Yii::app()->createUrl('#');?>"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Ver detalles </a></li> <?php } ?>
                    </ul>
                 <?php } ?>
                
                <?php if (Yii::app()->user->getPermisos()->modulo_listas) { ?>
                <li data-toggle="collapse" data-target="#menu_listas" class="collapsed active">
                    <a href="#"> Listas <span class="caret brandMenu" aria-hidden="true"></span></a>
                </li>
                    <ul class="sub-menu collapse" id="menu_listas">
                        <?php if (Yii::app()->user->getPermisos()->crear_listas) { ?>
                        <li class="subMenu"><a href="<?php echo Yii::app()->createUrl('lista/create');?>"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Crear </a></li> <?php } ?>
                        <?php if (Yii::app()->user->getPermisos()->administrar_listas) { ?>
                        <li class="subMenu"><a href="<?php echo Yii::app()->createUrl('lista/admin');?>"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> Administrar </a></li> <?php } ?>
                    </ul>
                <?php } ?>    

                <?php if (Yii::app()->user->getPermisos()->modulo_cupo) { ?>
                <li data-toggle="collapse" data-target="#menu_cupo" class="collapsed active">
                    <a href="#"> Cupo <span class="caret brandMenu" aria-hidden="true"></span></a>
                </li>
                    <ul class="sub-menu collapse" id="menu_cupo">
                        <?php if (Yii::app()->user->getPermisos()->recargar_cupo_bcnl || Yii::app()->user->getPermisos()->recargar_cupo_bcp) { ?>
                        <li class="subMenu"><a href="<?php echo Yii::app()->createUrl('#');?>"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Recargar </a></li> <?php } ?>
                        <?php if (Yii::app()->user->getPermisos()->historico_cupo_bcnl || Yii::app()->user->getPermisos()->historico_cupo_bcp) { ?>
                        <li class="subMenu"><a href="<?php echo Yii::app()->createUrl('#');?>"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Histórico </a></li> <?php } ?>
                    </ul>
                <?php } ?>

                <?php if (Yii::app()->user->getPermisos()->modulo_reportes) { ?>
                <li data-toggle="collapse" data-target="#menu_reportes" class="collapsed active">
                    <a href="#"> Reportes <span class="caret brandMenu" aria-hidden="true"></span></a>
                </li>
                    <ul class="sub-menu collapse" id="menu_reportes">
                        <?php if (Yii::app()->user->getPermisos()->reporte_sms_programados_bcnl || Yii::app()->user->getPermisos()->reporte_sms_programados_bcp) { ?>
                        <li class="subMenu"><a href="<?php echo Yii::app()->createUrl('#');?>"><span class="glyphicon glyphicon-time" aria-hidden="true"></span> SMS Programados </a></li> <?php } ?>
                        <?php if (Yii::app()->user->getPermisos()->reporte_mensual_sms_bcnl || Yii::app()->user->getPermisos()->reporte_mensual_sms_bcp) { ?>
                        <li class="subMenu"><a href="<?php echo Yii::app()->createUrl('#');?>"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> Mensual de SMS </a></li> <?php } ?>
                        <?php if (Yii::app()->user->getPermisos()->reporte_mensual_sms_por_cliente_bcnl || Yii::app()->user->getPermisos()->reporte_mensual_sms_por_cliente_bcp) { ?>
                        <li class="subMenu"><a href="<?php echo Yii::app()->createUrl('#');?>"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> Mensual de SMS por Cliente </a></li> <?php } ?>
                        <?php if (Yii::app()->user->getPermisos()->reporte_mensual_sms_por_codigo_bcp) { ?>
                        <li class="subMenu"><a href="<?php echo Yii::app()->createUrl('#');?>"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> Mensual de SMS por código </a></li> <?php } ?>
                        <?php if (Yii::app()->user->getPermisos()->reporte_sms_recibidos_bcnl || Yii::app()->user->getPermisos()->reporte_sms_recibidos_bcp) { ?>
                        <li class="subMenu"><a href="<?php echo Yii::app()->createUrl('#');?>"><span class="glyphicon glyphicon-import" aria-hidden="true"></span> SMS Recibidos </a></li> <?php } ?>
                        <?php if (Yii::app()->user->getPermisos()->reporte_vigilancia_bcnl || Yii::app()->user->getPermisos()->reporte_vigilancia_bcp) { ?>
                        <li class="subMenu"><a href="<?php echo Yii::app()->createUrl('#');?>"><span class="glyphicon glyphicon-camera" aria-hidden="true"></span> Reporte de Vigilancia </a></li> <?php } ?>
                    </ul>
                <?php } ?>

                <?php if (Yii::app()->user->getPermisos()->modulo_exentos) { ?>
                <li data-toggle="collapse" data-target="#menu_exentos" class="collapsed active">
                    <a href="#"> Exentos <span class="caret brandMenu" aria-hidden="true"></span></a>
                </li>
                    <ul class="sub-menu collapse" id="menu_exentos">
                        <?php if (Yii::app()->user->getPermisos()->agregar_exentos) { ?>
                        <li class="subMenu"><a href="<?php echo Yii::app()->createUrl('#');?>"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Agregar </a></li> <?php } ?>
                        <?php if (Yii::app()->user->getPermisos()->administrar_exentos) { ?>
                        <li class="subMenu"><a href="<?php echo Yii::app()->createUrl('');?>"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> Administrar </a></li> <?php } ?>
                    </ul>
                <?php } ?>

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