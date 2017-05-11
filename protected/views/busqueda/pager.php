<div class="page-size-wrap">
    <form class="form-inline">
        <div class="form-group">
            <label for="pager">Mostrar: </label>
                <?php
                //$pageSize = Yii::app()->user->getState( 'pageSize', Yii::app()->params[ 'defaultPageSize' ] );
                $pageSize = (isset($_SESSION["pageSize"]) == true) ? $_SESSION["pageSize"] : Yii::app()->params['defaultPageSize'];

                //unset($_SESSION["pageSize"]);

                echo CHtml::dropDownList(
                    'pageSize',
                    $pageSize,
                    array( 10 => 10, 25 => 25, 50 => 50, 100 => 100 ),
                    array(
                        'class'    => 'change-pagesize form-control',                    )
                );
            ?>
        </div>
    </form>
</div>

<?php Yii::app()->clientScript->registerCss( 'initPageSizeCSS', '.page-size-wrap{text-align: right;}' ); ?>