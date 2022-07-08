<?php
      session_start();

      if(isset($_SESSION["email"]))
      {
          header("Location: index.php");
      }
?>
<?php
$login = false;
$showError = false;
if($_SERVER["REQUEST_METHOD"] == "POST")
{   
    include 'includes/config.php';
    $email = $_POST["email"];
    $password = $_POST["password"]; 
    
    $sql = "SELECT * FROM user WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num == 1){
        while($row=mysqli_fetch_assoc($result))
        {
            if (password_verify($password, $row['password']))
            { 
                $login = true;
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['email'] = $email;
                header("location: index.php");
            } 
            else
            {
                $showError = "Invalid Email Or Password";
            }
        }
        
    } 
    else
    {
        $showError = "Invalid Email Or Password";
    }
}
    
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
    <title>Login Page</title>
  </head>
  <body>
    <?php
    if($login)
    {
    echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> You are logged in!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> ';
    }
    if($showError)
    {
    echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>'. $showError.'</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> ';
    }
    ?>
    <div class="wrapper">
    <div class="container-fluid">
    <div class="row">
    <div class="col-md-12">
    <div class="container my-5">
     <h2 class="text-center">LOGIN</h2>
     <form action="login.php" method="post">
        <div class="form-group my-4">
            <label for="email">Email</label>
            <input type="email" maxlength="30" class="form-control" placeholder="Email" id="email" name="email" aria-describedby="emailHelp">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" maxlength="255" class="form-control" placeholder="Password" id="password" name="password" required>
        </div>
       
        <button type="submit" class="btn btn-primary">Login</button>
        <input type="reset" class="btn btn-primary"><br><br>
        <div class="text-center">Don't have an account? <a href="signup.php">SignUp Here</a></div>
        <div class="text-center">Forgot Password? <a href="forgotpass.php">Click Here</a></div>
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