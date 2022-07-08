<?php
    include 'includes/config.php';
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    function sendMail($email, $reset_token)
    {
        require('PHPMailer/PHPMailer.php');
        require('PHPMailer/SMTP.php');
        require('PHPMailer/Exception.php');

        $mail = new PHPMailer(true);

        try {                     
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
            $mail->Subject = 'Password Reset Link From Ram Dudhaiya UBS';
            $mail->Body    = "We got a request from you to reset your password! <br>
                Click the link below: <br>
                <a href='http://localhost/student/updateforgotpassword.php?email=$email&reset_token=$reset_token'>
                Reset Password
                </a>";
        
            $mail->send();
                return true;
            } 
            catch (Exception $e) {
                return false;
            }
    }

    if(isset($_POST['send-reset-link']))
    {
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
                    echo "
                    <script>
                        alert('Password Reset Link Send To Mail');
                        window.location.href='login.php';
                    </script>
                    ";
                }
                else
                {
                    echo "
                    <script>
                        alert('Something goes wrong. Please try again');
                        window.location.href='forgotpass.php';
                    </script>
                    ";
                }
            }
            else
            {  
                echo "
                <script>
                    alert('Email Not Found');
                    window.location.href='forgotpass.php';
                </script>
                ";
            }
        }
        else
        {
            echo "
            <script>
                alert('Server Dowm! Please Try Again.');
                window.location.href='forgotpass.php';
            </script>
            ";
        }
    }
?>