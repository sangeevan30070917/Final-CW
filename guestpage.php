<?php
include_once ('head.php');
?>
<nav class="navbar navbar-expand-lg navbar-light  nv fixed-top" >
    <img src="/img/key-cyber.png" width="45" height="45" class="d-inline-block rounded-circle " alt="">&nbsp;
    <a class="navbar-brand text-white co " href="#"><b>KeyCyber </b>Project Management</a>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
        </ul>
        <div class="form-inline my-2 my-lg-0">


               <a href="index.php"> <button class="btn btn-info my-2 my-sm-0 text-white"  type="submit" name="logout">Back to Main</button></a>
        </div>
    </div>

</nav>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa-solid fa-list-check"></i> Task Details</h5>
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

    <div class=" container-fluid p-5 mt-4 g-3 " >
        <div >
            <h1 class=" "><i class="fa-solid fa-list-check"></i> All Task</h1>
            <hr>
        </div>
        <div class=" row row-cols-1 p-3 m-2 g-3">


            <?php
            try{
                include_once ("select_Config.php");

                $stmt = $conn->prepare("SELECT * from credentialssr.task");
                $stmt->execute();
                $result = $stmt->get_result();
                //Iterate through the results
                while ($row = $result->fetch_assoc()) {
                    // Access the user_id, forename, and surname from the $row array
                    $taskid = htmlspecialchars($row['taskid']);
                    $taskname = htmlspecialchars($row['taskname']);
                    $taskcompletiondate = htmlspecialchars($row['taskcompletiondate']);
                    $taskdescription = htmlspecialchars($row['taskdescription']);
                    $taskpriority = htmlspecialchars($row['taskpriority']);
                    $taskassigned = htmlspecialchars($row['taskassigned']);
                    echo '<div class="col-sm-2">';
                    echo "<div class='card cardd' onclick='modall($taskid)' data-bs-toggle='modal' data-bs-target='#exampleModal'>";

                    echo   '<img src="img/key-cyber.png" class="card-img-top" alt="...">';
                    echo '   <div class="card-body">';
                    echo '<h5 class="card-title">'.$taskname.'</h5>';

                    if ($taskpriority==0){
                        echo '<h5 class="card-title text-white p-2 rounded" style="background-color: #61abff" >'."Low".'</h5>';
                    }
                    elseif ($taskpriority==1){
                        echo '<h5 class="card-title text-white p-2 rounded" style="background-color: #4399fa">'."medium".'</h5>';
                    }
                    elseif ($taskpriority==2){
                        echo '<h5 class="card-title text-white p-2 rounded" style="background-color: #1d82f5">'."High".'</h5>';
                    }
                    elseif ($taskpriority==3){
                        echo '<h5 class="card-title text-white p-2 rounded" style="background-color: #2b3036" >'."Critical".'</h5>';
                    }



                        echo '<form method="post"><button type="button" onclick="modall(' . $taskid . ')" class="btn btn-warning" name="taskview"  id="modalButton"  data-bs-toggle="modal" data-bs-target="#exampleModal" >' . "<i class='fa-solid fa-pen-to-square'></i> View " .   '</button></form>';



                    echo '</div>';
                    echo '</div>';

                    echo'<br>';

                    echo '</div>';

                    if (isset($_POST['taskview']) && !empty($_POST['taskview'])) {
                        $_POST['taskview'];
                    }


                }
                $conn->close();
            }
            catch (Exception $e){
                echo '<br><div class="alert alert-danger container" name="salert">
                        <strong>Error!</strong>Sql Error!</a>
                        <button type="button"  class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        </div>';
            }
            ?>


        </div>
    </div>
<?php
if (isset($_POST['update']))
    echo '<div class="alert alert-danger container" name="salert">
                        <strong>Update !</strong>update</a>
                        <button type="button"  class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        </div>';

?>





    <script>


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
                url: 'ViewTask.php', // Same page URL
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
        // Get the modal element
        var myModal = document.getElementById('exampleModal');

        // Add an event listener for when the modal is hidden
        myModal.addEventListener('hidden.bs.modal', function () {
            // Reload the page
            location.reload();
        });

    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<?php
?>

<footer class="py-1 my-0 fixed-bottom" style="background-color: #3297a8; position: fixed">

    <p class="text-center p-2" style="color: azure">© 2024 KeyCyber, Inc</p>
</footer>
<script>
    function onav() {
        document.getElementById("sidenav").style.width = "190px";
        document.getElementById("ul").style.display= "block";
        document.getElementById("close").style.display = "block";
        document.getElementById("open").style.display = "none";
        document.getElementById("iframe").style.right ="0px";

    }
    function cnav() {
        document.getElementById("sidenav").style.width = "0";
        document.getElementById("ul").style.display= "none";
        document.getElementById("close").style.display = "none";
        document.getElementById("open").style.display = "block";
        document.getElementById("iframe").style.left ="0px";


    }

