<?php
    include 'includes/session.php';
    include 'includes/config.php';
    $email=$_SESSION["email"];
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
    <title>Change Password</title>
  </head>
<body>
<?php
    if(isset($_POST['submit']))
    {
        $currentPassword=$_POST['opwd']; 
        $password=$_POST['npwd'];  
        $passwordConfirm=$_POST['cpwd']; 
    
        $sql="SELECT password from user where email='$email'";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_assoc($result);
        if(password_verify($currentPassword,$row['password']))
        {
            if($passwordConfirm =='')
            {
                $error[] = 'Please confirm the password.';
            }
                if($password != $passwordConfirm)
                {
                    $error[] = 'Passwords do not match.';
                }
    if(!isset($error))
        {
            $password = password_hash($password,PASSWORD_BCRYPT);

            $query = mysqli_query($conn,"UPDATE user SET password='$password' WHERE email='$email'");
            if($query)
            {
                header("location:logout.php");
            }
            else 
            {
                $error[]='Something went wrong';
            }
        }

        } 
        else 
        {
            $error[]='Current password does not match.'; 
        }   
    }
        if(isset($error)){ 

        foreach($error as $error){ 
        echo  '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>'. $error.'</strong> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> ';
}
}
        ?> 
<div class="wrapper">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
<div class="container my-4">
    <h2 class="text-center">CHANGE PASSWORD</h2>
    <form method="post" action="" onSubmit="return valid();">
        <div class="form-group my-4">
            <label for="opwd">Old Password</label>
            <input type="password" maxlength="255" class="form-control" placeholder="Password" id="opwd" name="opwd" required>
        </div>

        <div class="form-group">
            <label for="npwd">New Password</label>
            <input type="password" maxlength="255" class="form-control" placeholder="Password" id="npwd" name="npwd" required>
        </div>

        <div class="form-group">
            <label for="cpwd">Confirm Password</label>
            <input type="password" maxlength="255" class="form-control" placeholder="Password" id="cpwd" name="cpwd" required>
        </div>
        <input type="submit" name="submit" class="btn btn-primary" value="ChangePassword">
        <a href='index.php' class='btn btn-primary'>Back</a>
    </form>
</div>
</div>
</div>        
</div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>