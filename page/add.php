<?php  
    session_start();

    //return to login if not logged in
    if (!isset($_SESSION['user']) ||(trim ($_SESSION['user']) == '')){
        header('location:index.php');
    }

    // Include database file
    require 'Page.php';  $editorObj = new Page();  // Insert Record in editor table
    if(isset($_POST['submit'])) {
        $editorObj->store($_POST);
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Add New Page</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    </head>
    <body>
        <div class="card text-center" style="padding:15px;">
            <div class="row">
                <div class="col-lg-3">
                    <h4>Add New Page</h4>
                </div>
                <div class="col-lg-9">
                    <?php 
                        require '../header.php'; 
                        if($user['role'] != 'Editor'){
                            $_SESSION['message'] = 'The action is not permitted';
                            header('location:../home.php');
                            die();
                        }
                    ?>
                </div>
            </div>
        </div>
        <br> 
        <?php
            if(isset($_SESSION['failedMessage'])){
                ?>
                    <div class="alert alert-danger text-center">
                        <?php echo $_SESSION['failedMessage']; ?>
                    </div>
                <?php     
                unset($_SESSION['failedMessage']);
            }
        ?>
        <div class="container">
            <form action="add.php" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="form-group col-lg-4">
                        <label for="name">Page Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter name" required="" autofocus>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="meta_title">Meta Title</label>
                        <input type="text" class="form-control" name="meta_title" placeholder="Meta Title" required="" autofocus>
                    </div>                
                    <div class="form-group col-lg-4">
                        <label for="meta_description">Meta Description</label>
                        <input type="text" class="form-control" name="meta_description" placeholder="Meta Description" required="" autofocus>
                    </div>                
                    <div class="form-group col-lg-4">
                        <label for="content">Content</label>
                        <input type="text" class="form-control" name="content" placeholder="Content" required="" autofocus>
                    </div>                
                    <div class="form-group col-lg-4">
                        <label for="thumbnail_image">Thumbnail Image</label>
                        <input type="file" class="form-control" name="thumbnail_image" required="" autofocus accept=".jpg,.jpeg,.png">
                    </div>                
                    <div class="form-group col-lg-4">
                        <label for="status">Status</label>
                        <select id="" name="status" class="form-control" required>
                            <option value="" selected>- Select -</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-4">
                        <input type="submit" name="submit" class="btn btn-primary" value="Submit">
                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                        <a href="index.php">
                            <button type="button" class="btn btn-danger"> Back</button>
                        </a>
                    </div>
                </div>               
            </form>
        </div>
        <?php 
            require '../footer.php'; 
        ?>
    </body>
</html>