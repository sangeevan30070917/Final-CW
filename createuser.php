<?php
session_start();
$user = $_SESSION['username'];
$type =  $_SESSION['user_type'];

if($user==null ){
    header("Location:index.php");
}
include_once ("head.php") ?>
<h1 class="container p-3"><i class="fa-solid fa-users"> </i> Add User</h1>


<div class="container p-3 border">
<?php
require "vendor/autoload.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;


//include database config page for insert query
include_once ("insert_Config.php");
if(isset($_POST['submit'])){
$userName = $_POST['username'];
$foreName = $_POST['forename'];
$surName  = $_POST['surname'];
$email    = $_POST['email'];
$password = $_POST['password'];
$userType = $_POST['usertype'];

    include_once ("select_Config.php");

    $stmt = $conn->prepare("SELECT username from credentialssr.methodone WHERE username = ?");
    $stmt->bind_param("s", $userName);
    $stmt->execute();
    $result = $stmt->get_result();
    //Iterate through the results


    if($result->num_rows > 0){
        echo '<div onclick="this.remove()" class="alert alert-warning">
              <strong>Error!</strong> Username Already Taken Choose Different!
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            </div>';
    }else {
        // Mysql Insert Query for users
        if ($userName && $foreName && $surName && $email && $password && $userType !== null) {
            $username = $_POST['username'];
            $forename = $_POST['forename'];
            $surname = $_POST['surname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $userType = $_POST['usertype'];

            $sql="INSERT INTO credentialssr.methodone (`username`,`forename`,`surname`,`email`,`password`,`user_type`) VALUES (?,?,?,?,?,?)";
            $stmt = $conn1->prepare($sql);
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bind_param('ssssss',$username,$forename,$surname,$email, $hashed_password,$userType);
            if($stmt->execute()){



                echo
                '<div onclick="this.remove()" class="alert alert-success" name="salert">
            <strong>Success!</strong> Your data is inserted.</a>
            <button type="button"  class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
          </div>';
                //calling  function to send temporary password to mail

                $name ="No REPLY";
                $user = $_POST['forename'];
                $password = $_POST['password'];
                $email1 =$_POST['email'];
                $subject = 'KeyCyber Project Management Account';
                $message = 'Dear ' . $user . ',
                We are delighted to inform you that your Keycyber Project Management account has been successfully created!
                Please use the temporary login credentials provided below to access your account. Kindly remember to change your password once you have logged in for enhanced security.

                Temporary Login:
                Username: ' . $email . ';
                Password: ' . $password . '
                http://localhost:63342/Final%20CW/index.php?_ijt=qam9v0a8t09bqb4bbubluhil47&_ij_reload=RELOAD_ON_SAVE

                Thank you for choosing Keycyber Project Management.

                Best regards,
                Key Cyber ';



                $mail = new PHPMailer(true);

// $mail->SMTPDebug = SMTP::DEBUG_SERVER;

                $mail->isSMTP();
                $mail->SMTPAuth = true;

                $mail->Host = "smtp.gmail.com";
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->Username = "d7613758@gmail.com";
                $mail->Password = "bwet inbw zxqj pazc";

                $mail->setFrom($email, $name);
                $mail->addAddress($email1);

                $mail->Subject = $subject;
                $mail->Body = $message;

                $mail->send();


            } else {
                echo '<div onclick="this.remove()" class="alert alert-warning">
              <strong>Warning!</strong> Invalid data. Please Check Your Data !
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            </div>';
            }

        } else {
            echo '<div onclick="this.remove()" class="alert alert-warning">
              <strong>Warning!</strong> You cannot leave field empty!
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            </div>';
        }
    }

}


?>



    <form action="" method="post">
        <h6 class=" p-2 ">Insert user Details</h6>
        <hr>

        <div class="row g-3">
            <div class="col-auto form-floating mb-3">
                <label for="username" class="col-form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username"  aria-label="username" style="width: 500px" required>
            </div>

            <div class="col-auto form-floating mb-3">
                <label for="username" class="col-form-label">Forename</label>
                <input type="text" class="form-control" id="forename" name="forename" aria-label="forename" style="width: 500px" required>
            </div>

            <div class="col-auto form-floating mb-3">
                <label for="surname" class="col-form-label">Surname</label>
                <input type="text" class="form-control" id="surname" name="surname" aria-label="surname" style="width: 500px" required>
            </div>
            <div class="col-auto form-floating mb-3">
                <label for="email" class="col-form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" aria-label="email" style="width: 500px" required>
            </div>
            <div class="col-auto form-floating mb-3">
                <label for="password" class="col-form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" minlength="8" required aria-label="password" style="width: 500px">

    <span class="input-group-text" id="reveal-btn">
      <i class="fas fa-eye"></i>
    </span>

            </div>
            <div class="col-auto form-floating mb-3">
                <label for="usertype" class="col-form-label">User Type</label><br>
                <select class="form-select select4" id="usertype" name="usertype" required style="width: 500px">
                    <option disabled hidden selected value="">Choose...</option>
                    <option value="2">User</option>
                    <option value="3">Admin</option>
                </select>
            </div>

            <div class="col-auto form-floating mb-3">
                <label for="submit" class="col-form-label">.</label><br>
                <input type="submit" class="form-control btn-success " id="submit" name="submit" value="Insert" style="width: 200px">
            </div>
            <div class="col-auto form-floating mb-3">
                <label for="btn" class="col-form-label">.</label><br>
                <input type="reset" class="form-control btn-warning" id="btn1" value="Reset" style="width: 200px">
            </div>

        </div>
    </form>
</div>



<script>



    const passwordField = document.getElementById("password");

    const chars = "0123456789abcdefghijklmnopqrstuvwxyz!@#$%^&*()ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    const passwordLength = 16;
    let password = "";

    function generatePassword() {
        password = "";
        for (let i = 0; i < passwordLength; i++) {
            const randomNumber = Math.floor(Math.random() * chars.length);
            password += chars.substring(randomNumber, randomNumber + 1);
        }
        passwordField.value = password;
    }

    // Generate a password when the page loads
    window.onload = () => {
        generatePassword();
    };

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
