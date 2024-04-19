<?php
session_start();
// Check if the user is logged in
if(!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}
elseif($_SESSION['newpassword']==0) {
    header("Location: dashboard.php");
    exit;

}


if(isset($_POST['logout'])){
    session_destroy();
}

?>
<?php

include_once ("update_config.php");

if(isset($_POST['update'])) {
    $userid =  $_SESSION['user_id'];
    $pass = $_POST['password'];
    $passvalue = 0;
    if($pass!=null){
        try{
            $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
            $stmt = $conn2->prepare('UPDATE credentialssr.methodone SET password = ?, newpassword = ? WHERE user_id = ?');
            $stmt->bind_param("sii", $hashed_password,$passvalue,$userid);



            if ($stmt->execute()) {
                echo '<div class="alert alert-success" role="alert">Updated Successfully!
                    <a type="button" href="#" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close">X</a></div>';
                $_SESSION['newpassword'] = 0;
                header("Location: dashboard.php");
                exit;
            } else {
                echo '<div class="alert alert-warning" role="alert">Invalid Information!
                     <a type="button" href="#" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close">X</a></div>';
            }


        }
        catch (Exception $e){
            echo '<div class="alert alert-danger" role="alert">Database Error!
                <a type="button" href="#" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close">X</a></div>';
        }



    }else{

        echo '<div class="alert alert-danger" role="alert">You cannot leave the field empty!
            <a type="button" href="#" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close">X</a></div>';
    }
    $conn2->close();
}


include_once ("head.php");
?>

<nav class="navbar navbar-expand-lg navbar-light  nv fixed-top" >
    <img src="/img/key-cyber.png" width="45" height="45" class="d-inline-block rounded-circle " alt="">&nbsp;
    <a class="navbar-brand text-white co " href="#"><b>KeyCyber </b>Project Management</a>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
        </ul>
        <div class="form-inline my-2 my-lg-0">


            <a href="index.php"> <form action="" method="post"><button class="btn btn-info my-2 my-sm-0 text-white"  type="submit" name="logout" >Back to Main</button></form> </a>
        </div>
    </div>
</nav>
    <div class="container p-5 border">


    <form action="" method="post" class="p-5">
        <h1> Reset Your Password Before You Start!</h1>

            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">New Password</label>
                <input type="password" required class="form-control" id="exampleInputPassword1">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Confirm New Password</label>
                <input type="password" name="password" required class="form-control" id="exampleInputPassword1">
            </div>

        <button type="submit" class="btn btn-primary"  id="update" name="update"  ><i class="fa-solid fa-pen-to-square"></i> Change</button>
        </form>
</div>



</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<?php include_once ('footer.php') ?>