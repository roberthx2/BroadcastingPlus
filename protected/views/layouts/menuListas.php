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
