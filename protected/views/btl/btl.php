<?php 
echo CHtml::dropDownList('listSC', '', 
              array_unique($sc),array('class'=>'form-control','prompt'=>'Seleccione un SC:','options'=>array('prompt'=>array('selected'=>true))));
?>

<div id="fieldProductos">
    
</div>


<script>

$("#listSC").on('change',function(){

   $.ajax({
//            beforeSend: function() {
//                $("#fieldBTL").addClass("loading");
//              },
//            complete: function() {
//                $("#fieldBTL").removeClass("loading");
//              },
            type: "POST",
            url: '<?php echo Yii::app()->createUrl('btl/getProductos'); ?>',
            data: {data:this.value}, 
            beforeSend: function(){
                $("#fieldBTL").addClass("loading");
            },
            complete: function(){
                $("#fieldBTL").removeClass("loading");
            },
            success: function(data){
                $("#fieldProductos").html(data);                   
            }
        });
});

</script>