<?php
    $userObj = new Auth();
    //fetch user data
    $sql = "SELECT * FROM users WHERE id = '".$_SESSION['user']."'";
    $user = $userObj->query($sql);     
?>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
<link href="style.css" type="text/css" rel="stylesheet">
<div class="container">
    <div class="row">
        <div class="col-lg-6 text-right">
            <p class="h5 mt-1"> <?php echo $user['name']; ?></p>
        </div>
        <?php 
            if($user['role'] == 'Admin'){
        ?>
        <div class="col-lg-2 text-right">
            <a href="/page-cms/user/index.php" class="btn btn-primary">View All Editor</a>
        </div>
        <?php 
            }
        ?>
        <div class="col-lg-2 text-right">
            <a href="/page-cms/page/index.php" class="btn btn-primary">View All Pages</a>
        </div>
        <div class="col-lg-2">
            <a href="/page-cms/logout.php" class="btn btn-danger"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
        </div>
    </div>
</div>