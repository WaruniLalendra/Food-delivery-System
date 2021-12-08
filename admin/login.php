<?php include('../config/constants.php');?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Food Order System</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>

    <div class="login">
        <h1 class="text-center">Login</h1>

        <br>
        <?php
            if(isset($_SESSION['login'])){
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }

            if(isset($_SESSION['no-login-message'])){
                echo $_SESSION['no-login-message'];
                unset($_SESSION['no-login-message']);
            }
        ?>
        <br><br>

        <!--Login form starts here-->
        <form action="" method="POST">
            Username: <br>
            <input type="text" name="username" placeholder="Enter username"> <br><br>
            
            Password: <br>
            <input type="text" name="password" placeholder="Enter Password"> <br><br>

            <input type="submit" name="submit" value="Login" class="btn-primary">
        </form>
        <!--login form ends here-->

        <br>
        <p class="text-center">Created By - <a href="#">Waruni Lalendra</a></p>
    </div>
    
</body>
</html>

<?php
    //Check whether the submit button is clicked or not
    if(isset($_POST['submit'])){
        //1. Get data from login form
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        //2. SQL to check wheather the user with user name and password exsit or not
        $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

        //3. Execute the query
        $res = mysqli_query($conn, $sql);

        //4. count rows to check whether the user exist or not
        $count = mysqli_num_rows($res);

        if($count==1){
            //user available login sucess
            $_SESSION['login'] = "<div class='sucess'><strong>Login sucessfull!</strong></div>";
            $_SESSION['user'] = $username;  //Check whether the user is login or not and logout will unset it
 
            //redirect to homepage/dashboard
            header("location:".SITEURL.'admin/');

        }else{ 
            //user not avilable login failed
            $_SESSION['login'] = "<div class='error text-center'><strong><small>Username or Password did not match!</small></strong></div>";

            //redirect to homepage/dashboard
            header("location:".SITEURL.'admin/login.php');
        }
    }
?>