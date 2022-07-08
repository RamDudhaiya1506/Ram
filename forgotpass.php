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
    <title>Forgotpass</title>
  </head>
  <body>
    <div class="wrapper">
    <div class="container-fluid">
    <div class="row">
    <div class="col-md-12">
    <div class="container my-4">
    <h2 class="text-center">SEND EMAIL</h2>
    <form action="forgotpassword.php" method="post">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" maxlength="30" class="form-control" placeholder="Email" id="email" name="email">
        </div>    
            <button type="submit" class="btn btn-primary" name="send-reset-link">SEND LINK</button>
            <a href='logout.php' class='btn btn-primary'>Back</a>
    </form> 
    </div>
    </div>
    </div>        
    </div>
    </div>
