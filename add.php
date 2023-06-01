<?php  
    // Include database file
    include 'users.php';  $editorObj = new Users();  // Insert Record in editor table
    if(isset($_POST['submit'])) {
        $editorObj->store($_POST);
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Add New Editor</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    </head>
    <body>
        <div class="card text-center" style="padding:15px;">
        <h4>Add New Editor</h4>
        </div><br> 
        <div class="container">
            <form action="add.php" method="POST">
                <div class="row">
                    <div class="form-group col-lg-4">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter name" required="" autofocus>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter email" required="" autofocus>
                    </div>                
                    <div class="form-group col-lg-4">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Enter password" required="" autofocus>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="role">Role</label>
                        <input type="text" class="form-control" name="role" value="Editor" required="" readonly>
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
                        <a href="index.php">
                            <button type="button" class="btn btn-danger"> Back</button>
                        </a>
                    </div>
                </div>               
            </form>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</html>