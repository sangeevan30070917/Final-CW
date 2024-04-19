<?php

session_start();

// Check if the user is logged in
if(!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}
else {
    // Access the user_id, forename, and surname from the $row array

    $newpass =  $_SESSION['newpassword'];

    if ($newpass == 1) {
        header("Location: passwordChange.php");
        exit;
    }

}

include_once("head.php");

?>
<div class="container border p-5">
<?php
include_once ("select_Config.php");
$id =  $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * from credentialssr.methodone WHERE user_id = ?");
$stmt->bind_param("i",   $id);
$stmt->execute();
$result = $stmt->get_result();
//Iterate through the results
while ($row = $result->fetch_assoc()) {
    // Access the user_id, forename, and surname from the $row array
    $userid = htmlspecialchars($row['user_id']);
    $username = htmlspecialchars($row['username']);
    $forename = htmlspecialchars($row['forename']);
    $lastname = htmlspecialchars($row['surname']);
    $email = htmlspecialchars($row['email']);

    }

    ?>



   <h1 style="font-family: 'Comic Sans MS'"><i class="fa-solid fa-user-pen"></i> My Account</h1>

    <hr>
    <?php
    include_once ('update_config.php');
    if (isset($_POST['update'])) {
        $userid = $_SESSION['user_id'];
        $forename = $_POST['forename'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $password = $_POST['password'];


        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        try {
            $stmt = $conn2->prepare('UPDATE credentialssr.methodone SET  forename = ?, surname = ?, email = ?, password = ? WHERE user_id = ?');
            $stmt->bind_param("ssssi",  $forename, $surname, $email, $hashed_password, $userid);

            if ($stmt->execute()) {
                echo '<div class="alert alert-success" role="alert"> Updated Successfully!
                <a type="button" href="#" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close">X</a></div>';
            } else {
                echo '<div class="alert alert-warning" role="alert">Invalid Information!
                <a type="button" href="#" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close">X</a></div>';
            }

        } catch (Exception $e) {
            echo '<div class="alert alert-danger" role="alert">Database Error!
            <a type="button" href="#" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close">X</a></div>';
        }
    }


    $conn2->close();


    ?>
    <div  class="text-center"><img style="width: 200px" src="img/user.png"></i><br><h1><?php echo $_SESSION['username']; ?></h1></div>

    <hr>
    <form action="" method="post">
    <div class="row g-3">
        <div class="col-6">
            <label for="Forename:" class="col-form-label">Forename</label>
            <input type="text" class="form-control" placeholder="Forename" name="forename" aria-label="First name" value="<?php echo $forename ?>">
        </div>
        <div class="col-6">
            <label for="Surname:" class="col-form-label">Surname</label>
            <input type="text" class="form-control" placeholder="Surname" name="surname" aria-label="Last name" value="<?php echo $lastname ?>">
        </div>
        <div class="col-6">
            <label for="email:" class="col-form-label">email</label>
            <input type="email" class="form-control" placeholder="email" name="email" aria-label="Last name" value="<?php echo $email ?>">
        </div>
        <div class="col-6">
            <label for="password:" class="col-form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" minlength="8"  aria-label="password" style="width: 500px">
            <span class="input-group-text" id="reveal-btn">
      <i class="fas fa-eye"></i>
    </span>
        </div>
        <div class="col-12 p-3 flaot-end">
           <button type="submit" name="update" value="<?php echo $userid ?>" class="btn btn-warning">Update</button>
        </div>
    </div>
    </form>
</div>



<script>
    const showPasswordBtn = document.querySelector('#reveal-btn');
    const passwordInput = document.querySelector('#password');

    showPasswordBtn.addEventListener('click', () => {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            showPasswordBtn.querySelector('i').classList.remove('fa-eye');
            showPasswordBtn.querySelector('i').classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            showPasswordBtn.querySelector('i').classList.remove('fa-eye-slash');
            showPasswordBtn.querySelector('i').classList.add('fa-eye');
        }
    });

</script>