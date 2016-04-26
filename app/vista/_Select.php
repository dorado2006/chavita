<select name="<?php echo $name; ?>" id="<?php echo $id; ?>" <?php echo $disabled; ?> class="text ui-widget-content ui-corner-all form-control">
    <option value="">..seleccione..</option>
    <?php 
    $numarray= count($rows);
    if($numarray==1){ 
       foreach ($rows as $key => $value) { 
        ?>
         <option selected="selected" value="<?php echo $value[0]; ?>"> <?php echo $value[1]; ?> </option>
    <?php }}
    else{
    foreach ($rows as $key => $value) { ?>
        <?php if ($code != $value[0] ) { ?>
    <option value="<?php echo $value[0]; ?>"> <?php echo strtoupper($value[1]) ?> </option>
        <?php } else { ?>
            <option selected="selected" value="<?php echo $value[0]; ?>"> <?php echo $value[1]; ?> </option>
        <?php }  ?>
    <?php } } ?>
           
</select>
