<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<?php $permisos = Yii::app()->user->getPermisos(); ?>

    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#" style="padding-top:10px;">
                         
                    </a> 
                </li>

                <?php if ($permisos->modulo_promocion) { ?>
                <li data-toggle="collapse" data-target="#menu_promocion" class="collapsed menu active">
                    <a href="#"> Promociones <span class="caret brandMenu" aria-hidden="true"></span></a>
                </li>
                    <ul class="sub-menu collapse menu" id="menu_promocion">
                        <?php if ($permisos->crear_promo_bcnl || $permisos->crear_promo_bcp || $permisos->broadcasting_cpei) { ?>
                        <li class="subMenu"><a class="opcion_menu" href="<?php echo Yii::app()->createUrl('promocion/create');?>"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Crear </a></li> <?php } ?>
                        <?php if ($permisos->crear_promo_personalizada_bcnl || $permisos->crear_promo_personalizada_bcp) { ?>
                        <li class="subMenu"><a class="opcion_menu" href="<?php echo Yii::app()->createUrl('promocion/createPersonalizada');?>"><span class="glyphicon glyphicon-plus-sign " aria-hidden="true"></span> Crear Personalizada </a></li>  <?php } ?>
                        <?php if ($permisos->detalles_promo_bcnl || $permisos->detalles_promo_bcp) { ?>
                        <li class="subMenu"><a class="opcion_menu" href="<?php echo Yii::app()->createUrl('promocion/verDetalles');?>"><span class="glyphicon glyphicon-eye-open " aria-hidden="true"></span> Ver detalles </a></li> <?php } ?>
                    </ul>
                 <?php } ?>
                
                <?php if ($permisos->modulo_listas) { ?>
                <li data-toggle="collapse" data-target="#menu_listas" class="collapsed menu active">
                    <a href="#"> Listas <span class="caret brandMenu" aria-hidden="true"></span></a>
                </li>
                    <ul class="sub-menu collapse menu" id="menu_listas">
                        <?php if ($permisos->crear_listas) { ?>
                        <li class="subMenu"><a class="opcion_menu" href="<?php echo Yii::app()->createUrl('lista/create');?>"><span class="glyphicon glyphicon-plus-sign " aria-hidden="true"></span> Crear </a></li> <?php } ?>
                        <?php if ($permisos->administrar_listas) { ?>
                        <li class="subMenu"><a class="opcion_menu" href="<?php echo Yii::app()->createUrl('lista/admin');?>"><span class="glyphicon glyphicon-wrench " aria-hidden="true"></span> Administrar </a></li> <?php } ?>
                    </ul>
                <?php } ?>    

                <?php if ($permisos->modulo_cupo) { ?>
                <li data-toggle="collapse" data-target="#menu_cupo" class="collapsed menu active">
                    <a href="#"> Cupo <span class="caret brandMenu" aria-hidden="true"></span></a>
                </li>
                    <ul class="sub-menu collapse menu" id="menu_cupo">
                        <?php if ($permisos->recargar_cupo_bcnl || $permisos->recargar_cupo_bcp) { ?>
                        <li class="subMenu"><a class="opcion_menu" href="<?php echo Yii::app()->createUrl('cupo/recarga');?>"><span class="glyphicon glyphicon-shopping-cart " aria-hidden="true"></span> Recargar </a></li> <?php } ?>
                        <?php if ($permisos->historico_cupo_bcnl || $permisos->historico_cupo_bcp) { ?>
                        <li class="subMenu"><a class="opcion_menu" href="<?php echo Yii::app()->createUrl('cupo/historico');?>"><span class="glyphicon glyphicon-list-alt " aria-hidden="true"></span> Histórico </a></li> <?php } ?>
                        <?php if ($permisos->administrar_cupo_bcp) { ?>
                        <li class="subMenu"><a class="opcion_menu" href="<?php echo Yii::app()->createUrl('cupo/admin');?>"><span class="glyphicon glyphicon glyphicon-wrench " aria-hidden="true"></span> Administrar Cupo </a></li> <?php } ?>
                    </ul>
                <?php } ?>

                <?php /*if ($permisos->modulo_reportes) { ?>
                <li data-toggle="collapse" data-target="#menu_reportes" class="collapsed menu active">
                    <a href="#"> Reportes <span class="caret brandMenu" aria-hidden="true"></span></a>
                </li>
                    <ul class="sub-menu collapse menu" id="menu_reportes">
                        <?php if ($permisos->reporte_mensual_sms_bcnl || $permisos->reporte_mensual_sms_bcp) { ?>
                        <li class="subMenu"><a href="<?php echo Yii::app()->createUrl('reportes/mensualSms');?>"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> Mensual de SMS </a></li> <?php } ?>
                        <?php if ($permisos->reporte_mensual_sms_por_cliente_bcnl || $permisos->reporte_mensual_sms_por_cliente_bcp) { ?>
                        <li class="subMenu"><a href="<?php echo Yii::app()->createUrl('reportes/mensualSmsPorCliente');?>"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> Mensual de SMS por Cliente </a></li> <?php } ?>
                        <?php if ($permisos->reporte_mensual_sms_por_codigo_bcp) { ?>
                        <li class="subMenu"><a href="<?php echo Yii::app()->createUrl('reportes/mensualSmsPorCodigo');?>"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> Mensual de SMS por código </a></li> <?php } ?>
                        <?php if ($permisos->reporte_sms_recibidos_bcnl || $permisos->reporte_sms_recibidos_bcp) { ?>
                        <li class="subMenu"><a href="<?php echo Yii::app()->createUrl('reportes/smsRecibidos');?>"><span class="glyphicon glyphicon-import" aria-hidden="true"></span> SMS Recibidos </a></li> <?php } ?>
                    </ul>
                <?php } */?>

                <?php if ($permisos->modulo_reportes) { ?>
                <li data-toggle="collapse" data-target="#menu_reportes" class="collapsed menu active">
                    <a href="#"> Reportes <span class="caret brandMenu" aria-hidden="true"></span></a>
                </li>
                    <ul class="sub-menu collapse menu" id="menu_reportes">
                        <?php if ($permisos->reporte_sms_enviados_bcp) { ?>
                        <li class="subMenu"><a class="opcion_menu" href="<?php echo Yii::app()->createUrl('reportes/smsEnviadosBcp');?>"><span class="glyphicon glyphicon-calendar " aria-hidden="true"></span> SMS Enviados</a></li> <?php } ?>
                        <?php if ($permisos->reporte_sms_por_cliente_bcp) { ?>
                        <li class="subMenu"><a class="opcion_menu" href="<?php echo Yii::app()->createUrl('reportes/smsPorClienteBcp');?>"><span class="glyphicon glyphicon-calendar " aria-hidden="true"></span> SMS por Cliente </a></li> <?php } ?>
                        <?php if ($permisos->reporte_sms_por_codigo_bcp) { ?>
                        <li class="subMenu"><a class="opcion_menu" href="<?php echo Yii::app()->createUrl('reportes/smsPorCodigo');?>"><span class="glyphicon glyphicon-calendar " aria-hidden="true"></span> SMS por código </a></li> <?php } ?>
                        <?php if ($permisos->reporte_sms_por_codigo_cliente_bcp) { ?>
                        <li class="subMenu"><a class="opcion_menu" href="<?php echo Yii::app()->createUrl('reportes/smsPorCodigoCliente');?>"><span class="glyphicon glyphicon-calendar " aria-hidden="true"></span> SMS por código/cliente </a></li> <?php } ?>
                        <?php /* if ($permisos->reporte_generar_mt_mo) { ?>
                        <li class="subMenu"><a class="opcion_menu" href="<?php echo Yii::app()->createUrl('reportes/reporteMTMO');?>"><span class="glyphicon glyphicon-calendar " aria-hidden="true"></span> Reporte MT/MO </a></li> <?php } */ ?>
                        <?php /*if ($permisos->reporte_sms_recibidos_bcnl || $permisos->reporte_sms_recibidos_bcp) { ?>
                        <li class="subMenu"><a href="<?php echo Yii::app()->createUrl('reportes/smsRecibidos');?>"><span class="glyphicon glyphicon-import" aria-hidden="true"></span> SMS Recibidos </a></li> <?php } */?>
                    </ul>
                <?php } ?>

                <?php if ($permisos->modulo_herramientas) { ?>
                <li data-toggle="collapse" data-target="#menu_herramientas" class="collapsed menu active">
                    <a href="#"> Herramientas <span class="caret brandMenu" aria-hidden="true"></span></a>
                </li>
                    <ul class="sub-menu collapse menu" id="menu_herramientas">
                        <?php if ($permisos->administrar_prefijo) { ?>
                        <li class="subMenu"><a class="opcion_menu" href="<?php echo Yii::app()->createUrl('prefijoPromocion/admin');?>"><span class="glyphicon glyphicon-tags " aria-hidden="true"></span> Prefijos </a></li> <?php } ?>
                        <?php if ($permisos->modulo_exentos) { ?>
                        <li class="subMenu"><a class="opcion_menu" href="<?php echo Yii::app()->createUrl('listaExentos/index');?>"><span class="glyphicon glyphicon-ban-circle " aria-hidden="true"></span> Exentos </a></li><?php } ?>
                    </ul>
                <?php } ?>

                <?php /*if ($permisos->modulo_exentos) { ?>
                <li data-toggle="collapse" data-target="#menu_exentos" class="collapsed menu active">
                    <a href="#"> Exentos <span class="caret brandMenu" aria-hidden="true"></span></a>
                </li>
                    <ul class="sub-menu collapse menu" id="menu_exentos">
                        <?php if ($permisos->agregar_exentos) { ?>
                        <li class="subMenu"><a href="<?php echo Yii::app()->createUrl('#');?>"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Agregar </a></li> <?php } ?>
                        <?php if ($permisos->administrar_exentos) { ?>
                        <li class="subMenu"><a href="<?php echo Yii::app()->createUrl('');?>"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> Administrar </a></li> <?php } ?>
                    </ul>
                <?php }*/ ?>

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

        $(".opcion_menu").click(function(){
            $(".loader_superior").css("display", "block");
        });

        /*$(".collapsed").click(function()
        {
            var principal = $(this);

            $(".collapse").each(function ()
            {
                if (principal != $(this))
                    $(this).collapse("hide");
            });
        });*/

        $(".collapsed.menu").click(function()
        {
            $(this).addClass("in");

            var principal = $(this);

            $(".collapse.menu").each(function ()
            {
                if (principal != $(this)) {
                    $(this).removeClass("in");
                }
            });
        });

    </script>

<?php $this->endContent(); ?>
