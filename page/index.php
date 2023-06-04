<?php   
    session_start();
    
    //return to login if not logged in
    if (!isset($_SESSION['user']) ||(trim ($_SESSION['user']) == '')){
        header('location:../index.php');
    } 
    
    // Include database file
    require 'Page.php';  $pageObj = new Page();  
    
    // Delete page from table
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
        <div class="container">
            <?php
                if($user['role'] == 'Editor'){
            ?>
                <h2>
                    All Page Information
                    <a href="add.php" class="btn btn-primary" style="float:right;">Create New Page</a>
                </h2>
            <?php
                }
            ?>
            <table class="table table-hover table-bordered" id="data-table">
                <thead>
                    <tr class="bg-dark text-light">
                        <th>Sl. No.</th>
                        <?php if($user['role'] == 'Admin') { ?>
                            <th>Editor Name</th>
                        <?php } ?>                       
                        <th>Page Name</th>
                        <th>Meta Title</th>
                        <th>Meta Description</th>
                        <th>Thumbnail Image</th>
                        <th>Status</th>
                        <th>Created On</th>
                        <th>Updated On</th>
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
                        
                        if($pages != null) {
                            foreach ($pages as $key=>$page) {
                    ?>
                    <tr>
                        <td><?php echo $key+1 ?></td>
                        <?php if(isset($page['editorName'])) { ?>
                            <td><?php echo $page['editorName'] ?></td>
                        <?php } ?>
                        <td><?php echo $page['pageName'] ?></td>
                        <td><?php echo $page['meta_title'] ?></td>
                        <td><?php echo $page['meta_description'] ?></td>
                        <td><img class="img-responsive" alt="" src="include/images/<?php echo $page['thumbnail_image'] ?>" width="150"/></td>
                        <td><?php echo $page['status'] ?></td>
                        <td><?php echo date("d-m-Y, g:i A", strtotime($page['created_at'])) ?></td>
                        <td>
                            <?php 
                                if($page['updated_at'] != null)
                                {
                                    echo date("d-m-Y, g:i A", strtotime($page['updated_at']));
                                } else {
                                    echo 'Not updated yet.';
                                }
                            ?>
                        </td>
                        <td>
                            <?php if($user['role'] == 'Editor') { ?>
                                <a href="edit.php?id=<?php echo $page['id'] ?>">
                                    <button type="button" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i> &nbsp; Edit</button>
                                </a>
                                <a href="index.php?id=<?php echo $page['id'] ?>" onclick="confirm('Are you sure want to delete this page?')">
                                    <button type="button" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i> &nbsp; Delete</button>
                                </a>
                            <?php } ?>  
                            <?php if($page['status'] == 'Active') { ?>
                                <a href="include/<?php echo $page['pageName'] ?>.html" target="_blank">
                                    <button type="button" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i> &nbsp; View</button>
                                </a>
                            <?php } ?>                             
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