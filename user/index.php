<?php   
    session_start();
    
    //return to login if not logged in
    if (!isset($_SESSION['user']) ||(trim ($_SESSION['user']) == '')){
        header('location:../index.php');
    } 
    
    // Include database file
    require 'User.php';  $editorObj = new User();  // Delete record from table
    if(isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $_GET['id'];
        $editorObj->destroy($id);
    }
?> 
<!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Editor Information</title>
        <meta charset="utf-8">
    </head>
    <body>
        <div class="card text-center" style="padding:15px;">
            <div class="row">
                <div class="col-lg-3">
                    <h4>Editor Information</h4>
                </div>
                <div class="col-lg-9">
                    <?php 
                        require '../header.php'; 
                        if($user['role'] != 'Admin'){
                            $_SESSION['message'] = 'The action is not permitted';
                            header('location:../home.php');
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="container">
            <?php                
                if (isset($_GET['msg1']) == "insert") {
                echo "<div class='alert alert-success alert-dismissible'>
                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                        New editor added successfully.
                        </div>";
                } 
                if (isset($_GET['msg2']) == "update") {
                echo "<div class='alert alert-success alert-dismissible'>
                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                        Editor information updated successfully.
                        </div>";
                }
                if (isset($_GET['msg3']) == "delete") {
                echo "<div class='alert alert-success alert-dismissible'>
                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                        Editor deleted successfully.
                        </div>";
                }
            ?>
            <br>
            <h2>
                All Editor Information
                <a href="add.php" class="btn btn-primary" style="float:right;">Add New Editor</a>
            </h2>
            <table class="table table-hover table-bordered" id="data-table">
                <thead>
                    <tr class="bg-dark text-light">
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $editors = $editorObj->index(); 
                        foreach ($editors as $key=>$editor) {
                    ?>
                    <tr>
                        <td><?php echo $key+1 ?></td>
                        <td><?php echo $editor['name'] ?></td>
                        <td><?php echo $editor['email'] ?></td>
                        <td><?php echo $editor['status'] ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $editor['id'] ?>">
                                <button type="button" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i> &nbsp; Edit</button>
                            </a>
                            <!-- <a href="index.php?id=<?php echo $editor['id'] ?>" onclick="confirm('Are you sure want to delete this editor?')">
                                <button type="button" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i> &nbsp; Delete</button>
                            </a> -->
                        </td>
                    </tr>
                    <?php 
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <?php 
            require '../footer.php'; 
        ?>
    </body>
</html>