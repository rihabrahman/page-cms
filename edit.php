<?php

    // Include database file
    include 'users.php';  $editorObj = new Users();  // Edit editor record
    if(isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $_GET['id'];
        $editor = $editorObj->edit($id);
    }  // Update Record in editor table
    if(isset($_POST['update'])) {
        $editorObj->update($_POST);
    }  
    
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Update Editor Information</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    </head>
    <body>
        <div class="card text-center" style="padding:15px;">
            <h4>Update Editor Information</h4>
        </div>
        <br> 
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
                    <input type="text" class="form-control" name="role" value="<?php echo $editor['role']; ?>" readonly>
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