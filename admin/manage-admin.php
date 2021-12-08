<?php include('partials/menu.php') ?>
    
    <!--main content starts-->
    <div class="main-content">
        <div class="wrapper">
            <h1>Manage Admin</h1>
            <br> <br> <br>

            <?php 
                if(isset($_SESSION['add'])){
                    echo $_SESSION['add'];   //diaplaying session message
                    unset($_SESSION['add']); //removing session message
                }

                if(isset($_SESSION['delete'])){
                    echo $_SESSION['delete'];
                    unset($_SESSION['delete']);
                }

                if(isset($_SESSION['update'])){
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                }

                if(isset($_SESSION['user-not-found'])){
                    echo $_SESSION['user-not-found'];
                    unset($_SESSION['user-not-found']);
                }

                if(isset($_SESSION['pwd-not-found'])){
                    echo $_SESSION['pwd-not-found'];
                    unset($_SESSION['pwd-not-found']);
                }

                if(isset($_SESSION['change-pwd'])){
                    echo $_SESSION['change-pwd'];
                    unset($_SESSION['change-pwd']);
                }
            ?>

            <br><br><br>
            <!--Button to add admin-->
            <a href="add-admin.php" class="btn-primary">Add Admin</a>
            <br> <br> <br>

            <table class="tbl-full">
                <tr>
                    <th>S.N.</th>
                    <th>Full Name</th>
                    <th>User Name</th>
                    <th>Acitions</th>
                </tr>

                <?php
                    //query to get all admins
                    $sql = "SELECT * FROM tbl_admin";

                    //Execute the query
                    $res = mysqli_query($conn, $sql);

                    //Check wheather the query is executed or not
                    if($res == TRUE){

                        //count the rows to check whetaher we have data or not
                        $count = mysqli_num_rows($res);

                        $sn = 1; //create a variable and assign the value

                        //check the number of rows
                        if($count>0){

                            //we have data
                            while($rows = mysqli_fetch_assoc($res)){

                                //using while loop to get all the data from databse
                                //this will execute as long as we have data in our database

                                //get individual data

                                $id = $rows['id'];
                                $full_name = $rows['full_name'];
                                $username = $rows['username'];

                                //dispaly the values in our table
                                ?>

                                <tr>
                                    <td><?php echo $sn++; ?> </td>
                                    <td><?php echo $full_name; ?></td>
                                    <td><?php echo $username; ?></td>
                                    <td>
                                        <a href="<?php echo SITEURL;?>admin/update-password.php?id=<?php echo $id;?>" class="btn-primary">Change Password</a>
                                        <a href="<?php echo SITEURL;?>admin/update-admin.php?id=<?php echo $id;?>" class="btn-secondary">Update Admin</a>
                                        <a href="<?php echo SITEURL;?>admin/delete-admin.php?id=<?php echo $id;?>" class="btn-danger">Delete Admin</a>
                                    </td>
                                </tr>


                                <?php
                            }

                        }else{

                            //we do not have data
                        }

                    }else{


                    }


                ?>

            </table>
        </div>
    </div>
    <!--main content ends-->

<?php include('partials/footer.php') ?>