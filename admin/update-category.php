<?php include('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>
        <br><br>

        <?php
            //Check whether the id is set or not
            if(isset($_GET['id'])){
                //Get the id and all the other details
                $id = $_GET['id'];

                //Create sql query to get other data
                $sql = "SELECT * FROM tbl_category WHERE id =$id ";

                //Execute the query
                $res = mysqli_query($conn, $sql);

                //Count the rows ro check whether the id is valid or not
                $count = mysqli_num_rows($res);

                if($count == 1){
                    //Get all the data
                    $row = mysqli_fetch_assoc($res);

                    $title = $row['title'];
                    $current_image = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];

                }else{
                    //Redirect to manage category page
                    $_SESSION['no-category-found'] = "<div class= 'error'>Category Not Found! </div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }

            }else{
                //Rediect to manage-category page
                header('location:'.SITEURL.'admin/manage-category.php');
            }
        
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title ; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php
                        if($current_image != ""){
                            //Display the image
                            ?>
                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image;?>" width="100px">
                            <?php

                        }else{
                            //Display message
                            echo "<div class = 'error'>Image Not Added!</div>";
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>New Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Featured:</td>
                    <td>
                        <input <?php if($featured=="Yes"){echo "Checked";} ?> type="radio" name="featured" value="Yes"> Yes
                        <input <?php if($featured=="No"){echo "Checked";} ?> type="radio" name="featured" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                        <input <?php if($featured=="Yes"){echo "Checked";} ?> type="radio" name="active" value="Yes"> Yes
                        <input <?php if($featured=="No"){echo "Checked";} ?> type="radio" name="active" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
            if(isset($_POST['submit'])){
                //1. Get all the values form our form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $current_image = $_POST['current_image'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                //2. Updating new image if selected
                //Check whether the image is selected or not(button is clicked or not)
                if(isset($_FILES['image']['name'])){
                    //Get image details
                    $image_name = $_FILES['image']['name'];

                    //Check whether the image is available or not
                    if($image_name != ""){
                        //Image available
                        //Upload the new image 

                        //Auto rename our image
                        //Get the extention of our image(.jpg .png) e.g. food1.jpg
                        $ext = end(explode('.',$image_name));

                        //Rename the image
                        $image_name = "Food_Category_".rand(000, 999).'.'.$ext; //e.g. Food_Category_678.jpg


                        $source_path = $_FILES['image']['tmp_name'];
                        $destination_path = "../images/category/".$image_name;

                        //upload the image
                        $upload = move_uploaded_file($source_path,$destination_path);

                        //Check whether the image is uploaded or not 
                        //And if the image is not uploaded then will stop the process and redirect with error message
                        if($upload==false){
                            $_SESSION['upload'] = "<div class='error'><strong>Failed to Upload Image.</strong></div>";
                            //Redirect to add category page
                            header('location:'.SITEURL.'admin/manage-category.php');
                            //stop the process
                            die();
                        }
                        
                        //Remove the current image if available
                        if($current_image != ""){
                            
                            $remove_path = "../images/category/".$current_image;
                            $remove = unlink($remove_path);

                            //Check whether the image is removed or not

                            //If failed to remove display a message and stop the process
                            if($remove == false){
                                //Falied to remove
                                $_SESSION['Failed-remove'] = "<div class='error'>Failed to remove current image!</div>";
                                header('location:'.SITEURL.'admin/manage-category.php');
                                die();
                            }

                        }
                        


                    }else{
                        $image_name = $current_image;

                    }

                }else{
                    $image_name = $current_image;

                }

                //3. Update the datbase
                $sql2 = "UPDATE tbl_category SET
                    title = '$title',
                    image_name = '$image_name',
                    featured = '$featured',
                    active = '$active'
                    WHERE id = $id
                ";

                //Execute the query
                $res2 = mysqli_query($conn, $sql2);

                //Check whether the query executed or not
                if($res2==true){
                    //Update category
                    $_SESSION['update'] = "<div class='sucess'>Category Updated Sucessfully!</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }else{
                    $_SESSION['update'] = "<div class='error'>Failed to Update the Category!</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');

                }

                //4. Redirect the manage category with message
            }
        ?>

    </div>
</div>


<?php include('partials/footer.php'); ?>