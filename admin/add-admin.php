<?php include('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>

        <br><br>

        <?php 
            if(isset($_SESSION['add'])){
                echo $_SESSION['add'];   //diaplaying session message
                unset($_SESSION['add']); //removing session message
            }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full name</td>
                    <td><input type="text" name="full_name" placeholder="Enter your name"></td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td><input type="text" name="username" placeholder="Enter your username"></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="password" placeholder="Enter the password"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

    </div>
</div>

<?php include('partials/footer.php') ?>


<?php

    //process the value from form and save it in database

    //check wheather the button is clicked or not

    if(isset($_POST['submit'])){
        //button clicked
        //echo "Button clicked";
        
        //1. get the data from our form
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = md5($_POST['password']); //password encrptyed with md5

        //2. SQL query to save data in to database
        $sql = "INSERT INTO tbl_admin SET 
            full_name = '$full_name',
            username = '$username',
            password = '$password'
        ";

         
        //3. Executing query and saving data into database
        $res = mysqli_query($conn, $sql); // or die(mysqli_error());

        //4.Check wheather the data is connected to not and diaplay appropriate message
        if($res == TRUE){
            //data inserts
            //echo "data inserted";
            //create a session variable
            $_SESSION['add'] = "<div class='sucess'><strong>Admin added successfully</strong></div>";

            //rediect page to manage-admin
            header("location:".SITEURL.'admin/manage-admin.php');

        }else{
            //failed to insert data
            //echo "Fail to insert data";

            //create a session variable
            $_SESSION['add'] = "<div class='error'><strong>Failed to added admin</strong></div>";

            //rediect page to add-admin
            header("location:".SITEURL.'admin/add-admin.php');

        }

        

    }

?>