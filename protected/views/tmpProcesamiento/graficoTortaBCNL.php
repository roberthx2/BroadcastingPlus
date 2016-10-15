<?php $collapse = $this->beginWidget('booster.widgets.TbCollapse'); ?>
<div class="panel-group" id="accordion2">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
          <span class="glyphicon glyphicon-stats"></span> Resumen Por Operadora 
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse in">
      <div class="panel-body">
        <?php

         $this->widget('highcharts.HighchartsWidget', array(
            'scripts' => array(
                'modules/exporting',
                'themes/grid-light',
            ),
            'options' => array(
                'credits' => array('enabled' => false),
                'title' => array(
                    'text' => '',
                ),
                'tooltip' => array(
                    //'pointFormat' => '<b>{series.name}:    {point.percentage:.1f}%</b>',
                    /*'formatter'=> 'js:function() { return "<b>" + this.point.name+": "+Math.round(this.point.percentage)+"</b>%"; }',*/
                    //'formatter'=> 'js:function() { return "<b>" + this.point.name+": "+this.point.y+" destinatarios</b>"; }',
                    'formatter'=> 'js:function() { return "<b>" +this.point.y+" destinatarios</b>"; }',
                ),
                'chart' => array(
                    'plotBackgroundColor' => '#ffffff',
                    'plotBorderWidth' => null,
                    'plotShadow' => false,
                    'height' => 267,
                    'style' => array(
                        'fontFamily' => 'Verdana, Arial, Helvetica, sans-serif',
                    ),
                    'weight' => 300
                ),
                'plotOptions' => array(
                    'pie' => array(
                        'allowPointSelect' => true,
                        'cursor' => 'pointer',
                        'shadow' => true,
                        'center' => array('50%', '50%'),
                        'size' => '70%',
                        'showInLegend'=>true,
                        //'colorByPoint' => true,
                        'dataLabels' => array(
                            'enabled' => true,
                            'color' => 'black',
                            'connectorColor' => 'black',
                            //'size'=> '80%',
                            'distance' => '',
                        ),
                    ),
                    'series' => array(
                        'dataLabels' => array(
                            'enabled' => true,
                            'formatter' => 'js:function()
                            {
                                //return ""+ this.point.name + ": " + Math.round(this.point.percentage) + "%";
                                return Math.round(this.point.percentage) + "%";
                            }'
                        ),
                    ),
                ),

                'series' => array(
                    array(
                        'type' => 'pie',
                        'name' => '<strong>Total</strong>',
                        'data' => $data,
                                //'color' => 'js:Highcharts.getOptions().colors[3]', // Joe's color
                        ),
                    ),
                ),
            )
        );
        ?>
      </div>
    </div>
  </div>
</div>
<?php $this->endWidget(); ?>