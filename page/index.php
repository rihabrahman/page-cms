<?php   
    session_start();
    
    //return to login if not logged in
    if (!isset($_SESSION['user']) ||(trim ($_SESSION['user']) == '')){
        header('location:../index.php');
    } 
    
    // Include database file
    require 'Page.php';  $pageObj = new Page();  // Delete record from table
    if(isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $_GET['id'];
        $pageObj->destroy($id);
    }
?> 
<!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Page Information</title>
        <meta charset="utf-8">
    </head>
    <body>
        <div class="card text-center" style="padding:15px;">
            <div class="row">
                <div class="col-lg-3">
                    <h4>Page Information</h4>
                </div>
                <div class="col-lg-9">
                    <?php 
                        require '../header.php'; 
                    ?>
                </div>
            </div>
        </div>
        <div class="container">
            <?php                
                if (isset($_GET['msg1']) == "insert") {
                echo "<div class='alert alert-success alert-dismissible'>
                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                        New page added successfully.
                        </div>";
                } 
                if (isset($_GET['msg2']) == "update") {
                echo "<div class='alert alert-success alert-dismissible'>
                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                        Page information updated successfully.
                        </div>";
                }
                if (isset($_GET['msg3']) == "delete") {
                echo "<div class='alert alert-success alert-dismissible'>
                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                        Page deleted successfully.
                        </div>";
                }
            ?>
            <br>
            <?php
                if($user['role'] == 'Editor'):
            ?>
                <h2>
                    All Page Information
                    <a href="add.php" class="btn btn-primary" style="float:right;">Create New Page</a>
                </h2>
            <?php
                endif
            ?>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>meta_title</th>
                    <th>meta_description</th>
                    <th>content</th>
                    <th>thumbnail_image</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    <?php 
                        if($user['role'] == 'Admin' ) {
                            $pages = $pageObj->index(); 
                        } else{
                            $pages = $pageObj->editorIndex($user['id']); 
                        }
                        
                        if($pages != null){
                        foreach ($pages as $key=>$page) {
                    ?>
                    <tr>
                        <td><?php echo $key+1 ?></td>
                        <td><?php echo $page['name'] ?></td>
                        <td><?php echo $page['meta_title'] ?></td>
                        <td><?php echo $page['meta_description'] ?></td>
                        <td><?php echo $page['content'] ?></td>
                        <td><?php echo $page['thumbnail_image'] ?></td>
                        <td><?php echo $page['status'] ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $page['id'] ?>">
                                <button type="button" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i> &nbsp; Edit</button>
                            </a>
                            <!-- <a href="index.php?id=<?php echo $page['id'] ?>" onclick="confirm('Are you sure want to delete this page?')">
                                <button type="button" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i> &nbsp; Delete</button>
                            </a> -->
                        </td>
                    </tr>
                    <?php 
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</html>