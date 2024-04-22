<?php
// Start a session to manage user authentication data
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    // Redirect unauthenticated users to the index page
    header("Location: index.php");
    exit;
} else {
    // Access the user's password change status from the session data
    $newpass = $_SESSION['newpassword'];

    // If the user needs to change their password, redirect them to the password change page
    if ($newpass == 1) {
        header("Location: passwordChange.php");
        exit;
    }
}

// Handle logout
if (isset($_POST['logout'])) {
    // Clear all session variables
    $_SESSION = array();

    // Destroy the session cookie for enhanced security
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Destroy the session to log out the user
    session_destroy();

    // Redirect the user to the login page
    header("Location: index.php");
    exit;
}

// Include the header file for the page
include_once("head.php");
?>

<!-- HTML for the navigation bar -->
<nav class="navbar navbar-expand-lg navbar-light shadow nv">
    <img src="/img/key-cyber.png" width="45" height="45" class="d-inline-block rounded-circle" alt="">&nbsp;
    <a class="navbar-brand text-white co" href="#"><b>KeyCyber</b> Project Management</a>

    <!-- Navbar collapse for navigation links and logout button -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <!-- Empty for now, can add more navigation items here -->
        </ul>
        <div class="form-inline my-2 my-lg-0">
            <a class="text-white">
                <i class="fa-regular fa-user"></i>&nbsp;<b><?php echo $_SESSION['username'] ?></b>
            </a>&nbsp;
            <!-- Logout form -->
            <form action="" method="post">
                <button class="btn btn-info my-2 my-sm-0 text-white" type="submit" name="logout">Logout</button>
            </form>
        </div>
    </div>
</nav>

<!-- Main content container -->
<div class="">
    <div class="row">
        <div class="col-1">
            <!-- Sidebar navigation and controls -->
            <div class="row">
                <div>
                    <a id="open" onclick="onav()" class="btn btn-primary m-2 close" style="display: none">></a>
                </div>

                <!-- Sidebar navigation with collapsible controls -->
                <div id="sidenav" class="d-flex flex-column flex-shrink-0 text-white bg-dark responsive sidebar shadow" style="height: 100%; position: fixed">
                    <a id="close" onclick="cnav()" class="btn btn-primary position-absolute close">X</a>
                    <hr>
                    <!-- Navigation links in the sidebar -->
                    <ul id="ul" class="nav nav-pills flex-column mb-auto m-3">
                        <li class="nav-item">
                            <a href="" style="color: azure" class="nav-link active actbtn" aria-current="page">
                                <i class="fa-solid fa-house"></i> Home
                            </a>
                        </li>
                        <li>
                            <a href="javascript:project();" id="project" class="nav-link text-white actbtn">
                                <i class="fa-solid fa-list-check"></i> Projects
                            </a>
                        </li>
                        <?php
                        // Display the Users link only for admin users (user_type = 3)
                        if ($_SESSION['user_type'] == 3) {
                            echo '<li>
                                    <a href="javascript:usr();" id="usr" class="nav-link text-white actbtn">
                                        <i class="fa-solid fa-users"></i> Users
                                    </a>
                                  </li>';
                        }
                        ?>
                        <li>
                            <a href="javascript:profile();" class="nav-link text-white actbtn fw-b">
                                <i class="fa-solid fa-user"></i> My Account
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Content area where the iframe will load different pages -->
        <div class="col-11">
            <iframe id="iframe" src="Home.php"></iframe>
        </div>
    </div>
</div>

<script>
    // JavaScript code for handling active state of navigation links
    var hd = document.getElementById("ul");
    var bt = hd.getElementsByClassName("nav-link");
    for (var i = 0; i < bt.length; i++) {
        bt[i].addEventListener("click", function() {
            var cur = document.getElementsByClassName("active");
            cur[0].className = cur[0].className.replace(" active", "");
            this.className += " active";
        });
    }

    // Functions for navigating to different pages through the iframe
    function usr() {
        document.getElementById("iframe").src = "users.php";
    }

    function cusr() {
        document.getElementById("iframe").src = "createuser.php";
    }

    function project() {
        document.getElementById("iframe").src = "taskmenu.php";
    }

    function profile() {
        document.getElementById("iframe").src = "myaccount.php";
    }
</script>

<?php
// Include the footer file for the page
include_once("footer.php");
?>
