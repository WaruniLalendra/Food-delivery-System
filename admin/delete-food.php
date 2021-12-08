<?php 

    include('../config/constants.php');

    //Check wheather the id and image_name is set or not
    if(isset($_GET['id']) && isset($_GET['image_name'])){
        //Get the value and delete
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //Remove the physical image file is available
        if($image_name != ""){

            //Image is available and remove it.
            $path = "../images/food/".$image_name;

            //Remove the image
            $remove = unlink($path);

            //If failed to remove image then add an error message and stop process
            if($remove == false){
                //Set the session message and redirect to manage-category page and stop the process
                $_SESSION['remove'] = "<div class= 'error'> Failed to remove Food Image!</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
                die();

            }
        } 

        //Delete data from database
        $sql = "DELETE FROM tbl_food WHERE id = $id";

        //Execute the query 
        $res = mysqli_query($conn, $sql);

        //check the data deleted or not
        if($res == true){
            //Set sucess message and redirect
            $_SESSION['delete'] = "<div class= 'sucess'>Food Item Deleted Sucessfully! </div>";
            header('location:'.SITEURL.'admin/manage-food.php');

        }else{
            //Set failed message and redirect
            $_SESSION['delete'] = "<div class= 'error'>Failed to Delete the Food Item </div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }

       

    }else{
        //Redirect to manage category page
        header('location:'.SITEURL.'admin/manage-food.php');

    }

?>