<?php
    
    header("Content-Type: application/json");      
    header("Access-Control-Allow-Origin: *");     
    header("Access-Control-Allow-Mehtods: POST");  
    header("Access-Control-Allow-Headers:Access-Control-Allow-Mehtods,Content-Type,Access-Control-Allow-Mehtods,Authorization,X-Requested-With");

    $data=json_decode(file_get_contents("php://input"),TRUE);

    include 'include/database.php';
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    function sendMail($email, $reset_token)
    {
        require('PHPMailer/PHPMailer.php');
        require('PHPMailer/SMTP.php');
        require('PHPMailer/Exception.php');

        $mail = new PHPMailer(true);

        try
        {                     
            $mail->isSMTP();                                         
            $mail->Host       = 'smtp.gmail.com';                  
            $mail->SMTPAuth   = true;                                  
            $mail->Username   = 'ramdudhaiya.ubs@gmail.com ';                    
            $mail->Password   = 'vnjiaulpbynvndar';                           
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         
            $mail->Port       = 465;                                   

            $mail->setFrom('ramdudhaiya.ubs@gmail.com ', 'Ram Dudhaiya UBS');
            $mail->addAddress($email);   
    
            $mail->isHTML(true);                                  
            $mail->Subject = 'Password From Ram Dudhaiya UBS';
            $mail->Body    = "Hey $email Your Password is Ram@2576.";
        
            $mail->send();
                return true;
        } 
            catch (Exception $e) 
            {
                return false;
            }
    }

    $query = "SELECT * FROM user WHERE email = '$_POST[email]'";
    $result = mysqli_query($conn,$query);
    if($result)
    {
        if(mysqli_num_rows($result)==1)
        {
            $reset_token = bin2hex(random_bytes(16));
            date_default_timezone_set('Asia/kolkata');
            $date = date("Y-m-d");
            $query1 = "UPDATE `user` SET `resettoken`='$reset_token',`resettokenexpired`='$date' WHERE `email`='$_POST[email]'";
            if(mysqli_query($conn, $query1) && sendMail($_POST['email'], $reset_token))
            {
                echo json_encode(array("status"=> 1,"message"=> "Password send to mail" ));
            }
            else
            {
                echo json_encode(array("status"=> 0, "message"=> "Something goes wrong, please try again later!"));
            }
        }
        else
        {  
            echo json_encode(array("status"=> 0, "message"=> "Email not found, please enter valid email!"));
        }
    }
    else
    {
        echo json_encode(array("message"=> "Server down, please try again later!","status"=> 0));
    }
    
?>  