<?php global $conn1; ?>

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
if ($_SESSION['user_type'] != 3){
    header("Location: dashboard.php");
}
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
            $newpass = 1;

            $sql="INSERT INTO credentialssr.methodone (`username`,`forename`,`surname`,`email`,`password`,`user_type`,`newpassword`) VALUES (?,?,?,?,?,?,?)";
            $stmt = $conn1->prepare($sql);
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bind_param('ssssssi',$username,$forename,$surname,$email, $hashed_password,$userType,$newpass);
            if($stmt->execute()){

                echo
                '<div onclick="this.remove()" class="alert alert-success" name="salert">
            <strong>Success!</strong> Your data is inserted.</a>
            <button type="button"  class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
          </div>';
                $url = $_SERVER['REQUEST_URI'];
                header("refresh:2; URL=$url");
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
<?php

include_once ("update_config.php");


if (isset($_POST['update'])) {
    $userid = $_POST['update'];
    $username = $_POST['username'];
    $forename = $_POST['forename'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $usertype = $_POST['usertype'];
    $deleted = $_POST['deleted'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    try {
        if($password!=null){
            $stmt = $conn2->prepare('UPDATE credentialssr.methodone SET username = ?, forename = ?, surname = ?, email = ?, password = ?, user_type = ?, deleted = ? WHERE user_id = ?');
            $stmt->bind_param("sssssssi", $username, $forename, $surname, $email, $hashed_password, $usertype,$deleted, $userid);

            if ($stmt->execute()) {
                echo '<div class="alert alert-success" role="alert">' . $username . ' Updated Successfully!
                <a type="button" href="#" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close">X</a></div>';
            } else {
                echo '<div class="alert alert-warning" role="alert">Invalid Information!
                <a type="button" href="#" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close">X</a></div>';
            }
        }else{
            $stmt = $conn2->prepare('UPDATE credentialssr.methodone SET username = ?, forename = ?, surname = ?, email = ?, user_type = ?, deleted = ? WHERE user_id = ?');
            $stmt->bind_param("ssssssi", $username, $forename, $surname, $email,  $usertype,$deleted, $userid);

            if ($stmt->execute()) {
                echo '<div class="alert alert-success" role="alert">' . $username . ' Updated Successfully!
                <a type="button" href="#" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close">X</a></div>';
            } else {
                echo '<div class="alert alert-warning" role="alert">Invalid Information!
                <a type="button" href="#" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close">X</a></div>';
            }
        }

    } catch (Exception $e) {
        echo '<div class="alert alert-danger" role="alert">Database Error!
            <a type="button" href="#" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close">X</a></div>';
    }
}


$conn2->close();


?>
<?php
include_once('delete_Config.php');
if(isset($_POST['delete'])){
    $id =  $_POST['delete'];


    try {
        $stmt = $conn3->prepare('DELETE FROM credentialssr.methodone WHERE user_id = ? ');
        $stmt->bind_param("s", $id);

        if ($stmt->execute()) {
            echo '<div class="alert alert-success" role="alert">Row Deleted!
                <a type="button" href="#" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close">X</a></div>';
        }
        else{
            echo '<div class="alert alert-warning" role="alert">Something Went Wrong!
                <a type="button" href="#" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close">X</a></div>';
        }

    }catch (Exception $e){
        echo '<div class="alert alert-warning" role="alert">Sql Error!
                <a type="button" href="#" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close">X</a></div>';
    }


    $conn3->close();

}


?>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">User Mangement</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalBody">
                <div class="container p-5">
                    <!-- Display task ID and fetched data here -->




                </div>
            </div>

        </div>
    </div>
</div>



<?php include_once ('head.php'); ?>
<!-- Button trigger modal -->

<h1 class=" p-3"><i class="fa-solid fa-users"></i> User Management</h1>

<div class=" p-3"  >

    <div class="" id="tab">
        <hr>


        <table class="table table-striped" >
            <thead class="table-dark">
            <th>Username</th>
            <th>Forename</th>
            <th>Lastname</th>
            <th>Email</th>
            <th>Password</th>
            <th>Usertype</th>
            <th>Delete/Reinstate</th>
            <th></th>
            </thead>
            <tbody >
            <tr class="table-dark">
                <form action="" method="post">
                    <td><input type="text" class="form-control" id="username" name="username"  aria-label="username"  required>
                    <td> <input type="text" class="form-control" id="forename" name="forename" aria-label="forename"  required></td>
                    <td> <input type="text" class="form-control" id="surname" name="surname" aria-label="surname" required></td>
                    <td>  <input type="email" class="form-control" id="email" name="email" aria-label="email"  required></td>
                    <td>               <div class="col-auto form-floating ">
                            <input type="password" class="form-control" id="password" name="password" minlength="8" required aria-label="password" ">
                            <span class="input-group-text pb-4" id="reveal-btn"><i class="fas fa-eye"></i></span>

                        </div>
                    </td>
                    <td>  <select class=" form-select select1" id="usertype" name="usertype" required  >
                            <option disabled hidden selected value="">Choose...</option>
                            <option value="2">User</option>
                            <option value="3">Admin</option>
                        </select></td>

                    <td><select  class='form-select select1'  aria-label='' name='deleted' id='deleted' >
                            <option class='option1' value='0'>Active</option>
                            <option class='option1'  value='1'>Delete</option>

                        </select></td>
                    <td><button class="btn btn-success my-2 my-sm-0" name="submit">ADD</button></td>

                </form>


            </tr>

            <?php
            include_once ("select_Config.php");

            $stmt = $conn->prepare("SELECT * from credentialssr.methodone ");
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
                $usertype = htmlspecialchars($row['user_type']);
                $userstatus = htmlspecialchars($row['deleted']);




                    echo ' <tr>';
                    echo "<form method='post' action=''>";
                    echo '<td>'."<input type='text' class='form-control' id='uername' name='username'  value='$username'>".'</td>';
                    echo '<td>'."<input type='text' class='form-control' id='forename' name='forename'  value='$forename'>".'</td>';
                    echo '<td>'."<input type='text' class='form-control' id='surname' name='surname'  value='$lastname'>".'</td>';
                echo '<td>'."<input type='text' class='form-control' id='surname' name='email'  value='$email'>".'</td>';
                echo '<td>'.'<div class="col-auto form-floating ">
                             <input type="password" class="form-control" id="password1" name="password" minlength="8"  aria-label="password" ">
                            <span class="input-group-text pb-4 reveal-btn" id="reveal-btn" data-target="password1"><i class="fas fa-eye"></i></span>
                        </div>'.'</td>';
                    echo '<td>'. " <select onchange='low1()' class='form-select select1'  aria-label='Task Priority' name='usertype' id='usertype' >
                                <option class='option1'  value='2' ".($usertype == 2 ? "selected" : "")." >User</option>
                                <option  class='option1'  value='3' ".($usertype == 3 ? "selected" : "")." >Admin</option>
                            </select>".'</td>';
                    echo '<td>'. " <select onchange='status1()' class='form-select select1'  aria-label='Task Priority' name='deleted' id='deleted' >
                                <option class='option1' value='0'".($userstatus == 0 ? "selected" : "")." >Active</option>
                                <option class='option1'  value='1' ".($userstatus == 1 ? "selected" : "")." >Delete</option>
                               
                            </select>".'</td>';

                    echo '<td>';


                    echo "<button class='btn btn-warning my-2 my-sm-0' name='update' id='edit1' value='$userid'><i class='fa-solid fa-pen-to-square'></i></button>";
                    echo " <button class='btn btn-danger my-2 my-sm-0' name='delete' id='delete1' value='$userid'><i class='fa-solid fa-trash'></i></button>";

                    echo '</td>';
                    echo "</form>";
                    echo '</tr>';





            }

            ?>

            </tbody>
        </table>


    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                <div class="modal-body">
                    <p id="buttonValue">Value from button will be displayed here</p>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to toggle password visibility
        function togglePasswordVisibility(targetId) {
            var passwordInput = document.getElementById(targetId);
            var icon = passwordInput.nextElementSibling.querySelector('i');

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = "password";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Add event listeners to all reveal buttons
        var revealButtons = document.querySelectorAll('.reveal-btn');
        revealButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var targetId = button.getAttribute('data-target');
                togglePasswordVisibility(targetId);
            });
        });
    });
    document.addEventListener('contextmenu',
        event => event.preventDefault()
    );

    document.addEventListener('DOMContentLoaded', function () {
        var myModal = document.getElementById('exampleModal');
        myModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var value = button.getAttribute('data-value');
            var modalContent = myModal.querySelector('#buttonValue');
            modalContent.textContent = value;
        });
    });


    document.getElementById("edit1").addEventListener("click", function() {
        localStorage.setItem("runScript", "true");
        window.location.href = "page2.html"; // Redirect to the other page
    });

    document.getElementById('myForm').addEventListener('submit', function(event) {
        event.preventDefault();

        newTab.onload = () => {
            const targetButton = newTab.document.querySelector("#targetButton");
            targetButton.dispatchEvent(clickEvent);
        };
    });

    function openModal() {
        $('#exampleModal').modal('show'); // Show the modal
    }

    // Attach the function to the button click event
    $('#targetButton').click(function() {
        openModal(); // Call the function to open the modal
    });

    function modall(taskid) {
        // Set task ID in the modal body
        $('#taskID').text(taskid);
        // Make an AJAX request to fetch data based on taskid
        $.ajax({
            url: 'taskEdit.php', // Same page URL
            type: 'POST',
            data: { taskid1: taskid },
            success: function(response) {
                // Display fetched data in the modal
                $('#modalBody').html(response);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                // Handle error if any
            }
        });
    }
    document.addEventListener('DOMContentLoaded', function() {
        // Set initial background color of select elements
        updateSelectBackgroundColor('taskpriority');
        updateSelectBackgroundColor('taskstatus');

        // Attach onchange event listener to select elements
        document.getElementById('taskpriority').addEventListener('change', function() {
            updateSelectBackgroundColor('taskpriority');
        });

        document.getElementById('taskstatus').addEventListener('change', function() {
            updateSelectBackgroundColor('taskstatus');
        });
    });

    function updateSelectBackgroundColor(selectId) {
        var selectElement = document.getElementById(selectId);
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        var selectedColor = window.getComputedStyle(selectedOption).backgroundColor;
        selectElement.style.backgroundColor = selectedColor;
    }


</script>

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
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
