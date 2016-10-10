<?php $collapse = $this->beginWidget('booster.widgets.TbCollapse'); ?>
<div class="panel-group" id="accordion2">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
          <span class="glyphicon glyphicon-list-alt"></span> Resumen General 
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
        'title' => array(
            'text' => 'Resumen por Operadora',
        ),
        'xAxis' => array(
            'categories' => array('Apples', 'Oranges', 'Pears', 'Bananas', 'Plums'),
        ),
        'labels' => array(
            'items' => array(
                array(
                    'html' => 'Total fruit consumption',
                    'style' => array(
                        'left' => '50px',
                        'top' => '18px',
                        'color' => 'js:(Highcharts.theme && Highcharts.theme.textColor) || \'black\'',
                    ),
                ),
            ),
        ),
        'series' => array(
            array(
                'type' => 'pie',
                'name' => 'Total consumption',
                'data' => array(
                    array(
                        'name' => 'Movistar',
                        'y' => 13,
                        'color' => 'js:Highcharts.getOptions().colors[0]', // Jane's color
                    ),
                    array(
                        'name' => 'Movilnet',
                        'y' => 23,
                        'color' => 'js:Highcharts.getOptions().colors[1]', // John's color
                    ),
                    array(
                        'name' => 'Digitel',
                        'y' => 19,
                        'color' => 'js:Highcharts.getOptions().colors[2]', // Joe's color
                    ),
                    array(
                        'name' => 'Rechazados',
                        'y' => 19,
                        'color' => 'js:Highcharts.getOptions().colors[3]', // Joe's color
                    ),
                ),
                'center' => array(150, 150),
                'size' => 150,
                'showInLegend' => true,
                'dataLabels' => array(
                    'enabled' => true,
                ),
            ),
        ),
    )
));
         ?>
      </div>
    </div>
  </div>
</div>
<?php $this->endWidget(); ?>