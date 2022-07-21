<?php
    header("Content-Type: application/json");      
    header("Access-Control-Allow-Origin: *");     
    header("Access-Control-Allow-Mehtods: POST");  
    header("Access-Control-Allow-Headers:Access-Control-Allow-Mehtods,Content-Type,Access-Control-Allow-Mehtods,Authorization,X-Requested-With");
    
    $data=json_decode(file_get_contents("php://input"),TRUE);

    $stu_id = $_POST['id'];
    $stu_name = $_POST['sname'];
    $stu_email = $_POST['semail'];
    $stu_class = $_POST['sclass'];
    $stu_phone = $_POST['sphone'];   
    $targetDir = "image/";
    $time = date("d-m-Y")."-".time();
    $fileName = $_FILES['filename']['name'];
    $file_name = $time."-".$fileName ;
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
    $allowTypes = array('jpg','png','jpeg','gif','pdf');

    include 'include/database.php';

    if(in_array($fileType, $allowTypes))
    {
        if(move_uploaded_file($_FILES["filename"]["tmp_name"], $targetFilePath))
        {
            $sql = "UPDATE student SET sname='$stu_name', semail='$stu_email', sclass='$stu_class', sphone='$stu_phone', filename='$fileName' WHERE sid='$stu_id'";
            if(mysqli_query($conn,$sql))
            {   
                echo json_encode(array("status"=> 1, "message"=> "Student Record Updated Successfully!","id"=>$stu_id,
                                       "sname"=>$stu_name,
                                       "semail"=>$stu_email,
                                       "sclass"=>$stu_class,
                                       "sphone"=>$stu_phone,
                                       "filename"=>$file_name));
            }
            else
            {
                echo json_encode(array("status"=> 0, "message"=> "Student Record Not Updated!, Please Try Again."));
            }
        }
        else
        {
            echo json_encode(array("status"=> 0,"message"=> "Somethig went wrong, Please try again!"));
    }
    }
    
?>