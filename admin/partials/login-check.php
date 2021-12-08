<?php
    //Check whether the user is logged in or not
    if(!isset($_SESSION['user'])){ //if user session is not set
        //User is not logged in
        //Redirect to login page with message
        $_SESSION['no-login-message'] = "<div class='error text-center'><strong><small>please login to access Admin Panel!</small></strong></div>";
        //Redirect to Login page
        header('location:'.SITEURL.'admin/login.php');
    }
?>