<?php
    require_once 'db.php';
    $query='INSERT INTO `employment_type`(emp_type) VALUES(?)';
    $data=['emp_type'=>$_REQUEST['emp_type']];
    $db->prepared_query($query,$data,'s');
    header('location: contentMgmt.php');
?>