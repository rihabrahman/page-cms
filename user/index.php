<?php   
    session_start();
    
    //return to login if not logged in
    if (!isset($_SESSION['user']) ||(trim ($_SESSION['user']) == '')){
        header('location:../index.php');
    } 
    
    // Initialization of class object
    require 'User.php';  $editorObj = new User();  
    
    // Delete editor from user table
    if(isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $_GET['id'];
        $editorObj->destroy($id);
    }
?> 

<?php 
    require '../header.php'; 
    if($user['role'] != 'Admin'){
        $editorObj->unauthorized_user();
    }                        
?>      

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

<div class="container">
    <h3>
        All Editor Information
        <a href="add.php" class="btn btn-primary" style="float:right;">Add New Editor</a>
    </h3>
    <br>
    <table class="table table-hover table-bordered" id="data-table">
        <thead>
            <tr class="bg-dark text-light">
                <th>Sl. No.</th>
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