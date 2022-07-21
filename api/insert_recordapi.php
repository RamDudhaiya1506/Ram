<?php
    header("Content-Type: application/json");      
    header("Access-Control-Allow-Origin: *");     
    header("Access-Control-Allow-Mehtods: POST");  
    header("Access-Control-Allow-Headers:Access-Control-Allow-Mehtods,Content-Type,Access-Control-Allow-Mehtods,Authorization,X-Requested-With");

    $data=json_decode(file_get_contents("php://input"),TRUE); 

    $stu_name = $_POST['sname'];
    $stu_email = $_POST['semail'];
    $stu_class = $_POST['sclass'];
    $stu_phone = $_POST['sphone'];
    $targetDir = "image/";
    $time = date("d-m-Y")."-".time();
    $fileName = $_FILES['filename']['name'];
    $fileName1 = $time."-".$fileName ;
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
    $allowTypes = array('jpg','png','jpeg','gif','pdf');

    include "include/database.php";

    $existSql = "SELECT * FROM `student` WHERE semail = '$stu_email'";
    $result = mysqli_query($conn, $existSql);
    $numExistRows = mysqli_num_rows($result);
    if($numExistRows > 0)
    {
        echo json_encode(array("status"=> 0, "message"=> "Record Already Exists"));
    }
    else
    {
        if(in_array($fileType, $allowTypes))
    {
        if(move_uploaded_file($_FILES["filename"]["tmp_name"], $targetFilePath))
        {
            $sql = "INSERT INTO student(sname, semail, sclass, sphone, filename, createdate)
            VALUES('{$stu_name}', '{$stu_email}', '{$stu_class}', '{$stu_phone}', '{$fileName}', current_timestamp())";
        if(mysqli_query($conn,$sql))
        {   
            echo json_encode(array("status"=> 1, "message"=> "Record Inserted"));
            echo json_encode(array("sname"=>$stu_name, 
                                   "semail"=>$stu_email, 
                                   "sclass"=>$stu_class, 
                                   "sphone"=>$stu_phone, 
                                   "filename"=>$fileName));
        }
        else
        {
	        echo json_encode(array("status"=> 0, "message"=> "Record Not Inserted"));
        }
        }
    }
    }
?>