<?php
    $userObj = new Auth();
    //fetch user data
    $sql = "SELECT * FROM users WHERE id = '".$_SESSION['user']."'";
    $user = $userObj->query($sql);     
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Page CMS</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
        <link href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.dataTables.min.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css" rel="stylesheet" />
    </head>
    <body>
        <div class="text-center p-3">
            <div class="row">
                <div class="col-lg-3">
                    <h4>Page CMS</h4>
                </div>                
                <div class="col-lg-2 text-right">
                    <p class="h5 mt-1"> <?php echo $user['name']; ?></p>
                </div>
                <div class="col-lg-1 text-right p-0">
                    <a href="../auth/home.php" class="btn btn-primary"><i class="fa fa-home" aria-hidden="true"></i></a>
                </div>
                <?php 
                    if($user['role'] == 'Admin'){
                ?>                
                    <div class="col-lg-2 text-right">
                        <a href="../user/index.php" class="btn btn-primary">View All Editor</a>
                    </div>
                <?php 
                    }
                ?>               
                <div class="col-lg-2 text-right">
                    <a href="../page/index.php" class="btn btn-primary">View All Pages</a>
                </div>
                <div class="col-lg-2">
                    <a href="../auth/logout.php" class="btn btn-danger"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
                </div>
            </div>
            <hr class="border border-dark">
        </div>