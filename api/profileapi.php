<?php
    header("Content-Type: application/json");      
    header("Access-Control-Allow-Origin: *");     
    header("Access-Control-Allow-Mehtods: POST");  
    header("Access-Control-Allow-Headers:Access-Control-Allow-Mehtods,Content-Type,Access-Control-Allow-Mehtods,Authorization,X-Requested-With");

    $data=json_decode(file_get_contents("php://input"),TRUE);

    include 'include/database.php';

    $email = $_POST['email'];
    $name = $_POST['fullname'];
    $mobile = $_POST['mobile'];
    $dob = $_POST['dob'];
    $address = $_POST['useraddress'];
    $city = $_POST['city'];
    $country = $_POST['country']; 
    $targetDir = "image/";
    $time = date("d-m-Y")."-".time();
    $fileName = $_FILES['filename']['name'];
    $file_name = $time."-".$fileName ;
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
    $allowTypes = array('jpg','png','jpeg','gif','pdf');

    if(in_array($fileType, $allowTypes))
    {
        if(move_uploaded_file($_FILES["filename"]["tmp_name"], $targetFilePath))
        {
            $sql = "UPDATE user SET fullname='$name', mobile='$mobile', dob='$dob', useraddress='$address', city='$city', country='$country', filename='$fileName' WHERE email='$email'";
            $result = mysqli_query($conn, $sql);
            if($result)
            {   
                echo json_encode(array("status"=> 1, "message"=> "Profile Updated Successfully!"));
                echo json_encode(array("email"=>$email, 
                                       "fullname"=>$name,
                                       "mobile"=>$mobile,
                                       "dob"=>$dob,
                                       "useraddress"=>$address,
                                       "city"=>$city,
                                       "country"=>$country,
                                       "filename"=>$file_name)); 
            }
            else
            {
                echo json_encode(array("status"=> 0, "message"=> "Profile Not Updated, Please Try Again!"));
            }
        }
        else
        {
            echo json_encode(array("status"=> 0, "message"=> "Somethig went wrong, Please try again!"));
        }
    }
    else
    {
        echo json_encode(array("status"=> 0, "message"=> "Please Select Image"));
    }
?>  