<?php
    $id=$_POST['id'];
    $programtypeA=$_POST['programtypeA'];
    
    $array = array('id'=> $id,'programtypeA'=>$programtypeA);
echo json_encode($array);
?>
