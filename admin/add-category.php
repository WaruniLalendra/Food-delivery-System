<?php include('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        <br><br>

        <?php
            if(isset($_SESSION['add'])){
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            if(isset($_SESSION['upload'])){
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <br><br>

        <!--Add category form starts-->
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Category title">
                    </td>
                </tr>

                <tr>
                    <td>Image:</td>
                    <td>
                        <input type="file" name="image" >
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
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        <!--Add category form ends-->

        <?php
            //Check wheather the submit button is clicked or not
            if(isset($_POST['submit'])){
                
                //1. Get the value from form
                $title = $_POST['title'];
                
                //For radio input type we need to check whether the button is clicked or not
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

                //Check whether the image is selected or not and set the value for image name accordingly
                //print_r($_FILES['image']);

                //die();//Break the code here

                if(isset($_FILES['image']['name'])){
                    //Upload the image
                    //To upload image we need image name and,source path and destination path

                    $image_name = $_FILES['image']['name'];

                    //Upload the image only if image is selected
                    if($image_name != ""){
                        
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
                            header('location:'.SITEURL.'admin/add-category.php');
                            //stop the process
                            die();
                        }

                    }


                }else{
                    //DOn't upload image and set the image name value as blank
                    $image_name = "";
                }

                //2. Create sql query to insert category
                $sql = "INSERT INTO tbl_category SET
                    title = '$title',
                    image_name = '$image_name',
                    featured = '$featured',
                    active = '$active'
                ";



                //3. Execute the query
                $res = mysqli_query($conn, $sql);

                //4. Check whether the query is executed or not and added or not
                if($res == true){
                    //Query executed and category added.
                    $_SESSION['add'] = "<div class='sucess'><strong>Category Added Sucessfully!</strong></div>";
                    //Redirect to manage category page
                    header('location:'.SITEURL.'admin/manage-category.php');
                }else{
                    //Failed to add category
                    $_SESSION['add'] = "<div class='error'><strong>Failed to add category!</strong></div>";
                    //Redirect to manage category page
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
            }
        ?>
    
    </div>
</div>


<?php include('partials/footer.php') ?>