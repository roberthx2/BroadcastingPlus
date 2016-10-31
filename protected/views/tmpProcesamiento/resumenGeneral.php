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
        </ul>
      </div>
    </div>
  </div>
</div>
<?php $this->endWidget(); ?>