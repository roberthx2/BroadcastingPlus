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
            <?php $this->renderPartial('busquedaPorPeriodo', array('model'=>$model, "form"=>$form, 'smsinBtl_minDate'=>$smsinBtl_minDate), true); ?>
      </div>
    </div>
  </div>
</div>
<?php $this->endWidget(); ?>

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
            <?php $this->renderPartial('busquedaPorDia', array('model'=>$model, "form"=>$form, 'smsinBtl_minDate'=>$smsinBtl_minDate), true); ?>
      </div>
    </div>
  </div>
</div>
<?php $this->endWidget(); ?>