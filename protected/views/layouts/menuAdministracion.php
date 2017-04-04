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

                <?php if (Yii::app()->user->getPermisos()->modulo_promocion) { ?>
                <li data-toggle="collapse" data-target="#menu_promocion" class="collapsed active">
                    <a href="#"> Sistema <span class="caret brandMenu" aria-hidden="true"></span></a>
                </li>
                    <ul class="sub-menu collapse" id="menu_promocion">
                        <?php if (Yii::app()->user->getPermisos()->crear_promo_bcnl) { ?>
                        <li class="subMenu"><a href="<?php echo Yii::app()->createUrl('configuracionSistemaAcciones/admin');?>"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> Configuraciones </a></li>  <?php } ?>
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
