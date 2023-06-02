<?php
    session_start();

    //return to login if not logged in
    if (!isset($_SESSION['user']) ||(trim ($_SESSION['user']) == '')){
        header('location:index.php');
    }

    // Edit editor record
    require 'user.php';  $editorObj = new User();  
    if(isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $_GET['id'];
        $editor = $editorObj->edit($id);
    } 

    // Update Record in editor table
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
            if(isset($_SESSION['message'])){
                ?>
                    <div class="alert alert-danger text-center">
                        <?php echo $_SESSION['message']; ?>
                    </div>
                <?php     
                unset($_SESSION['message']);
            }
        ?>
        <div class="container">
            <form action="edit.php" method="POST">
                <div class="row">
                    <div class="form-group col-lg-4">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" name="name" value="<?php echo $editor['name']; ?>" required="" autofocus>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="email">Email address:</label>
                        <input type="email" class="form-control" name="email" value="<?php echo $editor['email']; ?>" required="" autofocus>
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