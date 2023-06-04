<?php
    session_start();

    //return to login if not logged in
    if (!isset($_SESSION['user']) ||(trim ($_SESSION['user']) == '')){
        header('location:index.php');
    }

    // Edit page record
    require 'Page.php';  $pageObj = new Page();  
    if(isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $_GET['id'];
        $page = $pageObj->edit($id);
    } 

    // Update Record in page table
    if(isset($_POST['update'])) {
        $pageObj->update($_POST);
    }  
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Update Page Information</title>
        <meta charset="utf-8">
    </head>
    <body>
        <div class="card text-center" style="padding:15px;">
            <div class="row">
                <div class="col-lg-3">
                    <h4>Update Page Information</h4>
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
            <form action="edit.php" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="form-group col-lg-4">
                        <label for="name">Page Name</label>
                        <input type="text" class="form-control" name="name" value="<?php echo $page['name']; ?>" required="" autofocus>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="meta_title">Meta Title</label>
                        <input type="text" class="form-control" name="meta_title" value="<?php echo $page['meta_title']; ?>" required="" autofocus>
                    </div>                
                    <div class="form-group col-lg-4">
                        <label for="meta_description">Meta Description</label>
                        <input type="text" class="form-control" name="meta_description"  value="<?php echo $page['meta_description']; ?>" required="" autofocus>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="content">Content</label>
                        <input type="text" class="form-control" name="content" value="<?php echo $page['content']; ?>" required="" autofocus>
                    </div>     
                    <div class="form-group col-lg-4">
                        <label for="thumbnail_image">Thumbnail Image</label>
                        <input type="file" class="form-control" name="thumbnail_image" accept=".jpg,.jpeg,.png" autofocus>
                    </div>     
                    <div class="form-group col-lg-4">
                        <label for="status">Status:</label>
                        <select id="" name="status" class="form-control" required>
                            <option value="<?php echo $page['status']; ?>" selected><?php echo $page['status']; ?></option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>                
                </div>
                <div class="row">
                    <div class="form-group col-lg-4">
                        <input type="hidden" name="id" value="<?php echo $page['id']; ?>">                        
                        <input type="submit" name="update" class="btn btn-primary" value="Update">
                        <a href="index.php">
                            <button type="button" class="btn btn-danger"> Back</button>
                        </a>
                    </div>
                </div>
            </form>
        </div><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</html>