<?php
	$flashMessages = Yii::app()->user->getFlashes();
	if ($flashMessages) {
	    echo '<br><div class="container-fluid">';
	    foreach($flashMessages as $key => $message) {
	        echo '<div class="alert alert-'.$key.'">';
	        echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
	        echo '<span class="glyphicon glyphicon-'. (($key == "success") ? "ok":"ban-circle").'"></span> '.$message;
	    }
	    echo '</div></div>';
	}
?>