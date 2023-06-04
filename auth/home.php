<?php
    session_start();
    //return to login if not logged in
    if (!isset($_SESSION['user']) ||(trim ($_SESSION['user']) == '')){
        header('location:index.php');
    }

    include_once('Auth.php');
    $user = new Auth();
    
    //fetch current user data
    $sql = "SELECT * FROM users WHERE id = '".$_SESSION['user']."'";
    $row = $user->query($sql);
    
    if($row['role'] == 'Admin') 
    {
        //all editors count
        $allEditor = $user->all_editor();

        //all active editors count
        $allActiveEditor = $user->all_active_editor();

        //all inactive editors count
        $allInactiveEditor = $user->all_inactive_editor();

        //all pages count
        $allPage = $user->all_page();

        //all active pages count
        $allActivePage = $user->all_active_page();

        //all inactive pages count
        $allInactivePage = $user->all_inactive_page();
    } else {
        //all pages count
        $editorAllPage = $user->editors_all_page($_SESSION['user']);

        //all active pages count
        $editorAllActivePage = $user->editors_active_page($_SESSION['user']);

        //all inactive pages count
        $editorAllInactivePage = $user->editors_inactive_page($_SESSION['user']);
    }

?>
<?php require '../partials/header.php'; ?>

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
    <?php if($row['role'] == 'Admin') { ?>
        <div class="row">
            <div class="card col-lg-3 bg-warning p-3">
                <h5 class="mt-2">Total Editors: <?php echo $allEditor['total'] ?></h5>
            </div>        
            <div class="card col-lg-3 offset-lg-1 bg-warning p-3">
                <h5 class="mt-2">Total Active Editors: <?php echo $allActiveEditor['total'] ?></h5>
            </div>        
            <div class="card col-lg-3 offset-lg-1 bg-warning p-3">
                <h5 class="mt-2">Total Inactive Editors: <?php echo $allInactiveEditor['total'] ?></h5>
            </div>        
        </div>
        <br>
        <div class="row">
            <div class="card col-lg-3 bg-warning p-3">
                <h5 class="mt-2">Total Pages: <?php echo $allPage['total'] ?></h5>
            </div>        
            <div class="card col-lg-3 offset-lg-1 bg-warning p-3">
                <h5 class="mt-2">Total Active Pages: <?php echo $allActivePage['total'] ?></h5>
            </div>        
            <div class="card col-lg-3 offset-lg-1 bg-warning p-3">
                <h5 class="mt-2">Total Inactive Pages: <?php echo $allInactivePage['total'] ?></h5>
            </div>        
        </div>
    <?php 
        } else {    
    ?>
        <div class="row">
            <div class="card col-lg-3 bg-warning p-3">
                <h5 class="mt-2">Total Pages: <?php echo $editorAllPage['total'] ?></h5>
            </div>        
            <div class="card col-lg-3 offset-lg-1 bg-warning p-3">
                <h5 class="mt-2">Total Active Pages: <?php echo $editorAllActivePage['total'] ?></h5>
            </div>        
            <div class="card col-lg-3 offset-lg-1 bg-warning p-3">
                <h5 class="mt-2">Total Inactive Pages: <?php echo $editorAllInactivePage['total'] ?></h5>
            </div>        
        </div>
    <?php 
        }    
    ?>
</div>
<?php require '../partials/footer.php'; ?>
