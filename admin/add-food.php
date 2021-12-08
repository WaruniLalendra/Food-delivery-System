<?php include('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
        <br><br>

        <?php
            if (isset($_SESSION['upload'])) {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Title of the food">
                    </td>
                </tr>

                <tr>
                    <td>Description</td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description of the food"></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">

                            <?php
                                //Create php code to display categories from database
                                //1.Create sql to get al active category from database
                                $sql = "SELECT * FROM tbl_category WHERE active = 'Yes'";

                                //Executing query
                                $res = mysqli_query($conn, $sql);

                                //Count rows to check whether we have categories or not
                                $count = mysqli_num_rows($res);

                                //If count is greater than 0 we have categories else we do not have categories
                                if($count > 0){
                                    //we have categories
                                    while($row = mysqli_fetch_assoc($res)){
                                        //Get the details of categories
                                        $id = $row['id'];
                                        $title = $row['title'];
                                        ?>
                                            <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                        <?php                                       
                                    }
  
                                }else{
                                    //We do not have categories
                                    ?>
                                     <option value="0">No Category Found</option>
                                    <?php
                                }

                                //2.Display on drop down
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>

        <?php

            //Check whether the button is clicked or not
            if(isset($_POST['submit'])){
                //Add the food in databse
                //1. Get the data from form
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];
                
                //Whether radio buttons are checked or not
                if(isset($_POST['featured'])){
                    //get the value from form
                    $featured = $_POST['featured'];

                }else{
                    //set the default value
                    $featured = "No";
                }

                if(isset($_POST['active'])){
                    //get the value from form
                    $active = $_POST['active'];

                }else{
                    //set the default value
                    $active = "No";
                }

                //2. Upload image if selected
                //Check whether the select image is clicked or not and upload the image only if the image is selected(button clicked or not)
                if(isset($_FILES['image']['name'])){

                    //Get the details of the selected image
                    $image_name = $_FILES['image']['name'];

                    //Upload the image only if image is selected
                    if($image_name != ""){

                        //Image is selected
                        //A. Rename the image
                        //Get the extention
                        $ext = end(explode('.',$image_name));

                        //create new name for image
                        $image_name = "Food-Name-".rand(0000, 9999).'.'.$ext; //e.g. Food-Name-678.jpg

                        //B.Upload the image
                        //Get the src path and description path

                        //Source path is current location of the image
                        $source_path = $_FILES['image']['tmp_name'];

                        //Path for the image to be uploaded
                        $destination_path = "../images/food/".$image_name;

                        //upload the image
                        $upload = move_uploaded_file($source_path,$destination_path);

                        //Check whether the image uploaded or not if the image is not uploaded then will stop the process and redirect with error message
                        if($upload==false){
                            $_SESSION['upload'] = "<div class='error'><strong>Failed to Upload Image.</strong></div>";
                            //Redirect to add category page
                            header('location:'.SITEURL.'admin/add-food.php');
                            //stop the process
                            die();
                        }
                    }

                }else{
                    $image_name = ""; //setting default value as blank

                }

                //3. Insert into datbase

                //Create a sql query to save or add food
                $sql2 = "INSERT INTO tbl_food SET
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = $category,
                    featured = '$featured',
                    active = '$active'
                ";

                //Execute the query
                $res2 = mysqli_query($conn, $sql2);
                //4. Redirecting to manage food page
                //Check whether data inserted or not
                if($res == true){
                    //Query executed and food added.
                    $_SESSION['add'] = "<div class='sucess'><strong>Food Item Added Sucessfully!</strong></div>";
                    //Redirect to manage food page
                    header('location:'.SITEURL.'admin/manage-food.php');
                }else{
                    //Failed to add food
                    $_SESSION['add'] = "<div class='error'><strong>Failed to Add Food Item!</strong></div>";
                    //Redirect to manage food page
                    header('location:'.SITEURL.'admin/manage-food.php');
                }

                

                
            }
        ?>

    </div>
</div>

<?php include('partials/footer.php') ?>