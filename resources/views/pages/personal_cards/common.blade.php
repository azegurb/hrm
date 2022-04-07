<?php
/**
 * Created by PhpStorm.
 * User: a.e.qurbanov
 * Date: 9/7/2017
 * Time: 6:23 PM
 */
?>
<script>
$(document).ready(function(){

    var bul='{{ json_encode($data->permission[0]->accesible) }}';

    if(bul=='false'){

    $('#{{ $modalid }}').find('button[type="submit"]').html('Təsdiqə göndər')

    }

})
</script>