<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#" style="padding-top:10px;">
                         
                    </a>
                </li>

                <li data-toggle="collapse" data-target="#menu_configuracion" class="collapsed menu active">
                    <a href="#"> Configuraciones <span class="caret brandMenu" aria-hidden="true"></span></a>
                </li>
                    <ul class="sub-menu collapse menu" id="menu_configuracion">
                        <?php if (Yii::app()->user->getPermisos()->configurar_sistema) { ?>
                        <li class="subMenu"><a class="opcion_menu" href="<?php echo Yii::app()->createUrl('configuracionSistemaAcciones/admin');?>"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> Sistema </a></li>  <?php } ?>
                        <?php if (Yii::app()->user->getPermisos()->configurar_sms_por_dia) { ?>
                        <li class="subMenu"><a class="opcion_menu" href="<?php echo Yii::app()->createUrl('configuracionSmsPorDia/admin');?>"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> SMS por dias </a></li>  <?php } ?>
                        <?php if (Yii::app()->user->getPermisos()->configurar_reservacion_por_dia) { ?>
                        <li class="subMenu"><a class="opcion_menu" href="<?php echo Yii::app()->createUrl('configuracionReservacionPorDia/admin');?>"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> Reservación por dias </a></li>  <?php } ?>
                        <?php if (Yii::app()->user->getPermisos()->configurar_reservacion_por_operadora) { ?>
                        <li class="subMenu"><a class="opcion_menu" href="<?php echo Yii::app()->createUrl('configuracionOperadoraReservacion/admin');?>"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> Reservación por operadora </a></li>  <?php } ?>
                        <?php /* if (Yii::app()->user->getPermisos()->configurar_recarga_cupo_bcp_por_dia) { ?>
                        <li class="subMenu"><a class="opcion_menu" href="<?php echo Yii::app()->createUrl('configuracionRecargaCupoPorDia/admin');?>"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> Recarga de cupo por dia </a></li>  <?php } */ ?>
                    </ul>
                <li data-toggle="collapse" data-target="#menu_accesos" class="collapsed menu active">
                    <a href="#"> Administrar <span class="caret brandMenu" aria-hidden="true"></span></a>
                </li>
                    <ul class="sub-menu collapse menu" id="menu_accesos">
                        <?php if (Yii::app()->user->getPermisos()->administrar_clientes) { ?>
                        <li class="subMenu"><a class="opcion_menu" href="<?php echo Yii::app()->createUrl('clientesBcp/admin');?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Clientes </a></li>  <?php } ?>
                        <?php if (Yii::app()->user->getPermisos()->administrar_usuarios) { ?>
                        <li class="subMenu"><a class="opcion_menu" href="<?php echo Yii::app()->createUrl('usuarioSms/admin');?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Usuarios </a></li>  <?php } ?>
                        <?php /*if (Yii::app()->user->getPermisos()->crear_promo_bcnl) { ?>
                        <li class="subMenu"><a href="<?php echo Yii::app()->createUrl('usuarioMasivo/accesoBcplus');?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Acceso de Usuarios </a></li>  <?php } */ ?>
                    </ul>
                <li data-toggle="collapse" data-target="#menu_herramientas" class="collapsed menu active">
                    <a href="#"> Herramientas <span class="caret brandMenu" aria-hidden="true"></span></a>
                </li>
                    <ul class="sub-menu collapse menu" id="menu_herramientas">
                        <?php if (Yii::app()->user->getPermisos()->supervisar_log) { ?>
                        <li class="subMenu"><a class="opcion_menu" href="<?php echo Yii::app()->createUrl('log/admin');?>"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Supervisar log </a></li>  <?php } ?>
                        <li class="subMenu"><a class="opcion_menu" href="<?php echo Yii::app()->createUrl('contactosAdministrativos/admin');?>"><span class="glyphicon glyphicon-earphone" aria-hidden="true"></span> Contactos Administrativos </a></li>
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

    $(".opcion_menu").click(function(){
        $(".loader_superior").css("display", "block");
    });

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
