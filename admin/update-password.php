<?php include('partials/menu.php') ?>


<div class="main-content">
    <div class="wrapper">
        <h1>Change password</h1>
        <br><br>

        <?php
            if(isset($_GET['id'])){
                $id = $_GET['id'];
            }
        ?>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Current Password: </td>
                    <td>
                        <input type="password" name="current_password" placeholder="Current Password">
                    </td>
                </tr>

                <tr>
                    <td>New Password: </td>
                    <td>
                        <input type="password" name="new_password" placeholder="New Password">
                    </td>
                </tr>

                <tr>
                    <td>Confrm Password:</td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm Password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>

    </div>
</div>

<?php

    //Check whether the submit button is clicked or not
    if(isset($_POST['submit'])){

        //1. Get data
        $id = $_POST['id'];
        $current_password = md5($_POST['current_password']);
        $new_password = md5($_POST['new_password']);
        $confirm_password = md5($_POST['confirm_password']);

        //2. Check the data with current id and password exist or not
        $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

        //Execute the query
        $res = mysqli_query($conn, $sql);

        if($res==true){
            $count = mysqli_num_rows($res);

            if($count==1){
                //echo "user found";

                //Check whether the new password and confirm password match or not
                if($new_password == $confirm_password){
                    //update new password
                    $sql2 = "UPDATE tbl_admin SET
                        password = '$new_password'
                        WHERE id = $id
                    ";

                    //execute the query
                    $res2 = mysqli_query($conn, $sql2);

                    //check the query executed or not
                    if($res==true){
                        //display sucess message
                        $_SESSION['change-pwd'] = "<div class='sucess'><strong>Password changed sucessfully!</strong></div>";
                        header('location:'.SITEURL.'admin/manage-admin.php');
                    }else{
                        //display error messge
                        $_SESSION['change-pwd'] = "<div class='error'><strong>Failed to change the Password</strong></div>";
                        header('location:'.SITEURL.'admin/manage-admin.php');
                    }


                }else{
                    //password wrong
                    $_SESSION['pwd-not-found'] = "<div class='error'><strong>Password did not match!</strong></div>";
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }

            }else{
                //user does not exist
                $_SESSION['user-not-found'] = "<div class='error'><strong>User Not Found</strong></div>";
                header('location:'.SITEURL.'admin/manage-admin.php');
            }
        }

        //3. Check whether the new password and confirm password match or not
        //4. Change password if all above is true*/
    }else{

    }
?>

<?php include('partials/footer.php') ?>