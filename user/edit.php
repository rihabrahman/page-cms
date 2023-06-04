<?php
    session_start();

    //return to login if not logged in
    if (!isset($_SESSION['user']) ||(trim ($_SESSION['user']) == '')){
        header('location:index.php');
    }

    // Initialization of class object
    require 'User.php';  $editorObj = new User();  

    // Edit editor record
    if(isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $_GET['id'];
        $editor = $editorObj->edit($id);
    } 

    // Update record in editor table
    if(isset($_POST['update'])) {
        $editorObj->update($_POST);
    }  
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Update Editor Information</title>
        <meta charset="utf-8">
    </head>
    <body>
        <div class="card text-center" style="padding:15px;">
            <div class="row">
                <div class="col-lg-3">
                    <h4>Update Editor Information</h4>
                </div>
                <div class="col-lg-9">
                    <?php 
                        require '../header.php'; 
                        if($user['role'] != 'Admin'){
                            $editorObj->unauthorized_user();
                        }                        
                    ?>
                </div>
            </div>
        </div>
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
        <br>
        <div class="container">
            <form action="edit.php" method="POST">
                <div class="row">
                    <div class="form-group col-lg-4">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" name="name" value="<?php echo $editor['name']; ?>" placeholder="Must be 2 to 100 letters" pattern="[a-z0-9 &A-Z.-]{2,100}" required="" autofocus>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="email">Email address:</label>
                        <input type="email" class="form-control" name="email" value="<?php echo $editor['email']; ?>" placeholder="Must be 2 to 100 letters" pattern="[a-z0-9@A-Z._-]{2,100}" required="" autofocus>
                    </div>                
                    <div class="form-group col-lg-4">
                        <label for="role">Role:</label>
                        <input type="text" class="form-control" value="<?php echo $editor['role']; ?>" readonly>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="status">Status:</label>
                        <select id="" name="status" class="form-control" required>
                            <option value="<?php echo $editor['status']; ?>" selected><?php echo $editor['status']; ?></option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>                
                </div>
                <div class="row">
                    <div class="form-group col-lg-4">
                        <input type="hidden" name="id" value="<?php echo $editor['id']; ?>">
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