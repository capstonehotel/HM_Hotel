<?php
ob_start(); // Start output buffering
require_once("../includes/initialize.php");

// Prevent access if already logged in
if (admin_logged_in()) {
    echo '<script type="text/javascript">window.location = "index.php";</script>';
    exit();
}

// Process the form if the login button is pressed
if (isset($_POST['btnlogin'])) {
    $uname = trim($_POST['email']);
    $upass = trim($_POST['pass']);
    $h_upass = sha1($upass);

    // Validate input
    if (empty($uname) || empty($upass)) {
        echo <<<EOT
        <script type="text/javascript">
            Swal.fire({
                text: "Username or password cannot be empty.",
                icon: "error",
                confirmButtonText: 'OK'
            });
        </script>
        EOT;
    } else {
        // Use prepared statements to prevent SQL Injection
        $stmt = $connection->prepare("SELECT * FROM tbluseraccount WHERE USER_NAME = ? AND UPASS = ?");
        $stmt->bind_param("ss", $uname, $h_upass);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            // Secure session handling
            $_SESSION['ADMIN_ID'] = $row['USERID'];
            $_SESSION['ADMIN_UNAME'] = htmlspecialchars($row['UNAME'], ENT_QUOTES, 'UTF-8');
            $_SESSION['ADMIN_USERNAME'] = htmlspecialchars($row['USER_NAME'], ENT_QUOTES, 'UTF-8');
            $_SESSION['ADMIN_UPASS'] = $row['UPASS'];
            $_SESSION['ADMIN_UROLE'] = $row['ROLE'];

            // Sanitize data before embedding in JavaScript
            $uname_escaped = json_encode($row['UNAME']);

            echo <<<EOT
            <script type="text/javascript">
                Swal.fire({
                    title: "Hello, {$uname_escaped}! Welcome back!",
                    icon: "success",
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location = "index.php";
                    }
                });
            </script>
            EOT;
        } else {
            echo <<<EOT
            <script type="text/javascript">
                Swal.fire({
                    text: "Username or Password Not Registered!\\nContact your administrator.",
                    icon: "error",
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location = "login.php";
                    }
                });
            </script>
            EOT;
        }

        // Close the prepared statement
        $stmt->close();
    }
} else {
    // Initialize default values for email and password
    $email = "";
    $upass = ""; 
}

ob_end_flush(); // Flush the output buffer and send to browser
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">


    <title>HM Hotel Reservation</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../../assets/js/html5shiv.js"></script>
      <script src="../../assets/js/respond.min.js"></script>
    <![endif]-->
  </head>
<style>
   body {
    background-image: url("../images/room.jpg");
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    background-attachment: fixed;
}
.title{
    text-align: center;
    font-size: 66px;
    font-family: serif;
    color:ghostwhite;
    text-shadow: 2px 2px 2px black;

}


</style>
  <body>
       <div class="title">
    
        <p><b><span style="color:#ffd6bb;">HM Hotel </span> <span style="color:whitesmoke;">Reservation </span><span style="color:WG;">System   </span></b></p>
     </div>
       </br>
        <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4" >
                <div class="login-panel panel panel-default"style="  border-radius:8px; box-shadow: 0 2px 2px 0 rgba(2,2,2,2.1);">
                    <div class="panel-heading" style="border-top-right-radius:8px; border-top-left-radius: 8px;">
                        <h2 class="panel-title" style="font-size: 30px; font-family: Georgia;"><center>Login Credential</h2>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="POST" action="">
                            <fieldset>
                                <div class="form-group">
                                    <h5>Email</h5>
                                    <input class="form-control" required placeholder="ex.gmail.com" name="email" type="email" required  >
                                </div>
                                <div class="form-group">
                                    <h5>Password</h5>
                                    <input class="form-control" placeholder="* * * * * * * * *" name="pass" type="password" value="" minlength="6" maxlength="8">
                                    <a href="javascript:void(0)" class="text-reset text-decoration-none pass_view"> <i class="fa fa-eye-slash"></i></a>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="submit"  name="btnlogin" class="btn btn-lg btn-success btn-block">Login</button><br>
                                <div class="text-center mt-3">
                    <a href="../index.php" class="text-primary">Back to the website</a>
                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> 

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>
