<?php

session_start();
// Check if the user is logged in


// Check if email and password are submitted via POST
if(isset($_POST['email']) && isset($_POST['password'])){
    try {
        include_once("select_Config.php"); // Include database configuration
        // Prepare SQL statement to select user by email
        $stmt = $conn->prepare("SELECT * FROM credentialssr.methodone WHERE email = ?");
        $stmt->bind_param('s', $_POST['email']); // Bind email parameter
        $stmt->execute(); // Execute SQL query
        $result = $stmt->get_result(); // Get result set

        if($result->num_rows === 1) {
            $row = $result->fetch_assoc(); // Fetch the associative array of the result
            $DB_password = htmlspecialchars($row['password']);  // Get password hash from database
            $deleted = htmlspecialchars($row['deleted']);

            if($deleted == 0){
                // Verify submitted password with the hashed password from the database
                if (password_verify($_POST['password'], $DB_password)){
                    // Set session variables for the user
                    $_SESSION['user_id'] = htmlspecialchars($row['user_id']);
                    $_SESSION['username'] = htmlspecialchars($row['username']);
                    $_SESSION['user_type'] = htmlspecialchars($row['user_type']);
                    $_SESSION['forename'] = htmlspecialchars($row['forename']);
                    $_SESSION['surname'] = htmlspecialchars($row['surname']);
                    $_SESSION['newpassword'] = htmlspecialchars($row['newpassword']);

                    // Redirect user to dashboard upon successful login
                    header("Location: dashboard.php");
                    exit;
                } else {
                    // Display error message for invalid password
                    echo '<br><div class="alert alert-danger container" name="salert">
                            <strong>Error!</strong>Invalid Password!</a>
                            <button type="button"  class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            </div>';
                }
            } else {
                // Display error message for inactive user
                echo '<br><div class="alert alert-danger container" name="salert">
                            <strong>Error!</strong> User Not Active!</a>
                            <button type="button"  class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            </div>';
            }
        } else {
            // Display error message for non-existent user
            echo '<br><div class="alert alert-danger container" name="salert">
                        <strong>Error!</strong> User Not Found!</a>
                        <button type="button"  class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        </div>';
        }
        $stmt->close(); // Close prepared statement
        $conn->close(); // Close database connection

    } catch (Exception $e){
        // Display error message for SQL error
        echo '<br><div class="alert alert-danger container" name="salert">
                        <strong>Error!</strong>SQL Error: ' . $e->getMessage() . '</a>
                        <button type="button"  class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        </div>';
    }
}
?>


<?php
include_once("head.php"); // Include header file
?>
<div class="row no-gutter border" style="max-width:100%;height:auto;">
    <div class="col-md-6 bg-light border ">
        <div class="d-inline-flex p-5">
            <div class="container">
                <div class="row">
                    <div class="col-sm-3   ">
                        <img src="/img/key-cyber.png" class="img-fluid w-100 h-100 rounded mx-auto d-block "  alt="...">
                    </div>
                    <div class="col p-3">
                        <h1 style="color: #3281a8">KeyCyber</h1>
                        <div class="p-1"> <h3 style="color: #3297a8">Project Management</h3></div>
                    </div>
                </div>
                <hr>
                <div class="d-flex flex-row">
                    <img src="https://wallpapers.com/images/hd/project-management-tools-illustration-20vwwkbworhkpzff.jpg" class="img-fluid w-100 h-100 " alt="...">
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 bg-light  ">
        <div class="d-inline-flex m-5">
            <div class="container center m-5">
                <div class="row align-items-start">
                    <div class="col p-3">
                        <div class="text-center"> <h1 style="color: #3297a8">Login</h1><br><hr></div>
                    </div>
                    <div class="col-10 m-5  ">
                        <!-- Login Form -->
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" required>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" id="exampleInputPassword1" required>
                            </div><br>
                            <!-- Login button -->
                            <div class="container text-center">
                                <div class="row">
                                    <div class="col">
                                        <input type="submit" name="submit" value="Login" class="btn bttn center w-50 " style="background-color: #3297a8;color: azure;" onmouseover="this.style.backgroundColor='#3281a8'" onmouseout="this.style.backgroundColor='#3297a8'">
                                    </div>
                                </div>
                                <br>
                                <!-- Continue as guest link -->
                                <div>
                                    <p><a class="link-opacity-100" href="./guestpage.php">Continue as Guest  <i class="fa-solid fa-arrow-right"></i></a></p>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    include_once("footer.php"); // Include footer file
    ?>
