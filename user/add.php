<?php  
    session_start();

    //return to login if not logged in
    if (!isset($_SESSION['user']) ||(trim ($_SESSION['user']) == '')){
        header('location:index.php');
    }

    // Initialization of class object
    require 'User.php';  $editorObj = new User();  
    
    // Insert record in editor table
    if(isset($_POST['submit'])) {
        $editorObj->store($_POST);
    }
?>

<?php 
    require '../partials/header.php'; 
    if($user['role'] != 'Admin'){
        $editorObj->unauthorized_user();
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
    <h3>Add New Editor</h3>
    <form action="add.php" method="POST">
        <div class="row">
            <div class="form-group col-lg-4">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" placeholder="Must be 2 to 100 letters" pattern="[a-z0-9 &A-Z.-]{2,100}" required="" autofocus>
            </div>
            <div class="form-group col-lg-4">
                <label for="email">Email address</label>
                <input type="email" class="form-control" name="email" placeholder="Must be 2 to 100 letters" pattern="[a-z0-9@A-Z._-]{2,100}" required="" autofocus>
            </div>                
            <div class="form-group col-lg-4">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Must be 6 to 100 letters" pattern="[a-z0-9A-Z!?$%@#=+._-]{6,100}" required="" autofocus>
            </div>
            <div class="form-group col-lg-4">
                <label for="role">Role</label>
                <input type="text" class="form-control" value="Editor" readonly>
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
<?php 
    require '../partials/footer.php'; 
?>