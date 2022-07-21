<?php
    header("Content-Type: application/json");      
    header("Access-Control-Allow-Origin: *");     
    header("Access-Control-Allow-Mehtods: POST");  
    header("Access-Control-Allow-Headers:Access-Control-Allow-Mehtods,Content-Type,Access-Control-Allow-Mehtods,Authorization,X-Requested-With");

    $data=json_decode(file_get_contents("php://input"),TRUE); 

    include 'include/database.php';
    $email = $_POST["email"];
    $password = $_POST["password"]; 

    $sql = "SELECT * FROM user WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num == 1)
    {
    while($row=mysqli_fetch_assoc($result))
    {
        if (password_verify($password, $row['password']))
        {   
            echo json_encode(array("status"=> 1, "message"=> "Login Success!"));
            echo json_encode(array( "id"=>$row['id'],
                                    "email"=> "$email",
                                    "mobile"=>$row['mobile'], 
                                    "dob"=>$row['dob'],
                                    "useraddress"=>$row['useraddress'],
                                    "city"=>$row['city'],
                                    "country"=>$row['country'],
                                    "filename"=>$row['filename']));
        } 
        else
        {
            echo json_encode(array("message"=> "Invalid Email Or Password, Please Try Again!","status"=> 0));
        }
    }
    } 
    else
    {
        echo json_encode(array("message"=> "Please Enter Valid Email Or Password","status"=> 0));
    }
?>