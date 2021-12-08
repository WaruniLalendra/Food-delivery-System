<?php

    //include constant.php file
    include('../config/constants.php');

    //1. Get the id of admin to delete
    $id = $_GET['id'];

    //2. Create sql query to delete the admin
    $sql = "DELETE FROM tbl_admin WHERE id = $id";

    //Execute the query
    $res = mysqli_query($conn, $sql);

    //check whether the query executed sucessfully or not
    if($res==TRUE){
        //echo "Admin Deleted";
        //create session varibale to dispaly message
        $_SESSION['delete'] = "<div class='sucess'><strong>Admin deleted sucessfully</strong></div>";

        //Redirect to manage admin page
        header('location:'.SITEURL.'admin/manage-admin.php');

    }else{
        //echo "Failed to delete admin";
        //create session varibale to dispaly message
        $_SESSION['delete'] = "<div class='error'>Failed to delete admin</div>";

        //Redirect to manage admin page
        header('location:'.SITEURL.'admin/manage-admin.php');
    }

    //3. Redirect to manage admin page

?>