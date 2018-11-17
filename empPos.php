<?php
    require_once 'db.php';
    $data=[
        'job_pos'=>$_REQUEST['job_pos'],
        'rate'=>$_REQUEST['rate']
    ];
    echo json_encode($data);
    echo $query="INSERT INTO `position`(`job_pos`,`rate`) VALUES (?,?)";
    $db->prepared_query($query,$data,'si');
    header('location: contentMgmt.php');
?>