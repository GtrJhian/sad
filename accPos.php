<?php
    require_once 'db.php';
    $query='INSERT INTO `account_pos`(position) VALUES(?)';
    $data=['position'=>$_REQUEST['position']];
    $db->prepared_query($query,$data,'s');
    header('location: contentMgmt.php');
?>