<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        body{
            background-color: #bfcdd2;
        }
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
    <title>Update Password</title>
</head>
<body>
<?php
    include 'includes/config.php';

    if(isset($_GET['email']) && isset($_GET['reset_token']))
    {
        date_default_timezone_set('Asia/kolkata');
        $date = date("Y-m-d");
        $sql = "SELECT * FROM user WHERE email='$_GET[email]' AND resettoken='$_GET[reset_token]' AND resettokenexpired='$date'";
        $result = mysqli_query($conn, $sql);
        if($result)
        {
            if(mysqli_num_rows($result) > 0)
            {
                echo "
                <div class='wrapper'>
                <div class='container-fluid'>
                <div class='row'>
                <div class='col-md-12'>
                <div class='container my-4'>
                <h2 class='text-center'>CREATE NEW PASSWORD</h2>
                <div class='container my-4'>
                    <form action='' method='POST'>
                    <div class='form-group'>
                        <label for='password'>New Password</label>
                        <input type='password'  class='form-control' placeholder='Password' name='password'>
                    </div>
                    <div class='form-group'>
                        <label for='password'>Confirm Password</label>
                        <input type='password'  class='form-control' placeholder='Password' name='cpassword'>
                    </div>
                        <button type='submit' class='btn btn-primary' name='updatepassword'>Update</button>
                        <a href='forgotpass.php' class='btn btn-primary'>Back</a>
                        <input type='hidden' name='email' value='$_GET[email]'>
                    </form>
                </div>
                </div>
                </div>
                </div>        
                </div>
                </div>

                ";
            }
            else
            {
                echo "
                <script>
                    alert('Invalid Or Expired Link');
                    window.location.href='forgotpass.php';
                </script>
                ";
            }
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
?>
<?php
    if(isset($_POST['updatepassword']))
    {   
        $email= $_GET["email"];
        $resrttoken= $_GET["reset_token"];
        $password = $_POST["password"];
        $cpassword = $_POST["cpassword"];

    if($password == $cpassword)
    {
        $hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $query = "UPDATE `user` SET `password`='$hash',`resettoken`=NULL,`resettokenexpired`=NULL WHERE `email`='$email' AND resettoken='$resrttoken'";
        $result1 = mysqli_query($conn, $query);
        if($result1)
        {
            echo "
            <script>
                alert('Congratulations! Your password has been updated successfully.');
                window.location.href='logout.php';
            </script>
            ";
        }
        else
        {
            echo "
            <script>
                alert('Password Dosen't Match!);
                window.location.href='forgotpass.php';
            </script>
            ";
        }
    }
}
?>
</body>
</html>