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
                if(isset($_SESSION['successMessage'])){
                    ?>
                        <div class="alert alert-success text-center">
                            <?php echo $_SESSION['successMessage']; ?>
                        </div>
                    <?php     
                    unset($_SESSION['successMessage']);
                } 

                if (isset($_SESSION['failedMessage'])){
                    ?>
                        <div class="alert alert-danger text-center">
                            <?php echo $_SESSION['failedMessage']; ?>
                        </div>
                    <?php     
                    unset($_SESSION['failedMessage']);
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
            <table class="table table-hover table-bordered" id="data-table">
                <thead>
                    <tr class="bg-dark text-light">
                        <th>Sl. No.</th>
                        <th>Name</th>
                        <th>Meta Title</th>
                        <th>Meta Description</th>
                        <th>Content</th>
                        <th>Thumbnail Image</th>
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
                        <td><img class="img-responsive" alt="" src="include/images/<?php echo $page['thumbnail_image'] ?>" /></td>
                        <td><?php echo $page['status'] ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $page['id'] ?>">
                                <button type="button" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i> &nbsp; Edit</button>
                            </a>
                            <a href="/page-cms/page/include/<?php echo $page['name'] ?>.html" target="_blank">
                                <button type="button" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i> &nbsp; View</button>
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
        <?php 
            require '../footer.php'; 
        ?>
    </body>
</html>