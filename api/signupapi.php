<?php
    header("Content-Type: application/json");      
    header("Access-Control-Allow-Origin: *");     
    header("Access-Control-Allow-Mehtods: POST");  
    header("Access-Control-Allow-Headers:Access-Control-Allow-Mehtods,Content-Type,Access-Control-Allow-Mehtods,Authorization,X-Requested-With");

    $data=json_decode(file_get_contents("php://input"),TRUE); 

    include 'include/database.php';
    $name = $_POST["fullname"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $existSql = "SELECT * FROM `user` WHERE email = '$email'";
    $result = mysqli_query($conn, $existSql);
    $numExistRows = mysqli_num_rows($result);
    if($numExistRows > 0)
    {
        echo json_encode(array("message"=> "Email Already Exists","status"=> 0));
    }
    else
    {
        if(($password == TRUE))
        {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `user` (`fullname`, `email`, `password`, `create date`) 
            VALUES ('$name', '$email', '$hash', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            if ($result)
            {
                echo json_encode(array("id"=>$id, "name"=>"$name", "email"=> "$email" ));
                echo json_encode(array("message"=> "Your Account Has Been Created Successfully, Now You Can Loggedin!",
                                       "status"=> 1));
            }
        }
        else
        {
            echo json_encode(array("message"=> "Your Email And Passwoed Doesn'not Matched , Please Try Again!","status"=> 0));
        }
    }
?>