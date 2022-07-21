<?php
    header("Content-Type: application/json");      
    header("Access-Control-Allow-Origin: *");     
    header("Access-Control-Allow-Mehtods: POST");  
    header("Access-Control-Allow-Headers:Access-Control-Allow-Mehtods,Content-Type,Access-Control-Allow-Mehtods,Authorization,X-Requested-With");
   
    $data=json_decode(file_get_contents("php://input"),TRUE); 

    include 'include/database.php';
    
    $email = $_POST['email'];
    $currentPassword = $_POST['oldpassword']; 
    $password = $_POST['newpassword'];  

    $sql="SELECT password from user where email='$email'";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($result);
    if(password_verify($currentPassword,$row['password']))
    {   
        $password = password_hash($password,PASSWORD_BCRYPT);

        $query = mysqli_query($conn,"UPDATE user SET password='$password' WHERE email='$email'");
        if($query)
        {   
            echo json_encode(array("status"=> 1,"message"=> "Your Password Has Been Changed Successfully!"));
            echo json_encode(array("email"=>$email));
        }
        else 
        {   
            echo json_encode(array("status"=> 0, "message"=> "Your Password Has Not Changed Successfully, Please Try Again!"));
        }
    }
    else
    {
        echo json_encode(array("status"=> 0, "message"=> "Password Doesn't Match"));
    }
?>