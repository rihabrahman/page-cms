<?php  
    session_start();

    //return to login if not logged in
    if (!isset($_SESSION['user']) ||(trim ($_SESSION['user']) == '')){
        header('location:index.php');
    }

   // Initialization of class object
    require 'Page.php';  $pageObj = new Page();  
    
    // Insert Record in editor table
    if(isset($_POST['submit'])) {
        $pageObj->store($_POST);
    }
?>

<?php 
    require '../partials/header.php'; 
    if($user['role'] != 'Editor') {
        $pageObj->unauthorized_user();
    }
?>

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
    <h3>Add New Page</h3>
    <form action="add.php" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="form-group col-lg-4">
                <label for="name">Page Name</label>
                <input type="text" class="form-control" name="name" placeholder="Must be 2 to 200 letters" pattern="[a-z0-9A-Z-_.]{2,200}" required="" autofocus>
            </div>
            <div class="form-group col-lg-4">
                <label for="meta_title">Meta Title</label>
                <input type="text" class="form-control" name="meta_title" placeholder="Must be 2 to 250 letters" pattern="[a-z0-9 A-Z!?$%@#=+._-]{2,250}" required="" autofocus>
            </div>                
            <div class="form-group col-lg-4">
                <label for="meta_description">Meta Description</label>
                <input type="text" class="form-control" name="meta_description" placeholder="Must be 2 to 250 letters" pattern="[a-z0-9 A-Z!?$%@#=+._-]{2,250}" required="" autofocus>
            </div>
            <div class="form-group col-lg-4">
                <label for="thumbnail_image">Thumbnail Image (jpg, jpeg, png only)</label>
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
            <div class="form-group col-lg-12">
                <label for="content">Page Content</label>
                <textarea class="form-control" name="content" required autofocus></textarea>
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
    require '../partials/footer.php'; 
?>