<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("Location: index.php");
    exit;
} else {
    // Access the user_id, forename, and surname from the $row array

    $newpass =  $_SESSION['newpassword'];

         if ($newpass == 1) {
             header("Location: passwordChange.php");
             exit;
         }

}

include_once("head.php");
?>



<?php
        if(isset($_POST['taskview']) && !empty($_POST['taskview'])){
            echo $_POST['taskview'];
        }
        ?>



        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"  aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Task Edit</h5>
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

<div class=" container-fluid p-3 m-2 g-3 " >
 <div >
     <h1 class=" "><i class="fa-solid fa-list-check"></i> All Tasks</h1>

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
                $userid = htmlspecialchars($row['userid']);
                echo '<div class="col-sm-2">';

                if($_SESSION['user_id']==$taskassigned || $_SESSION['user_type']==3 || $_SESSION['user_id']==$userid ) {
                    echo "<div class='card cardd' onclick='modall($taskid)' data-bs-toggle='modal' data-bs-target='#exampleModal'>";

                }else{
                    echo "<div class='card  rounded'  >";
                }


                echo   '<img src="img/key-cyber.png" class="card-img-top" alt="...">';
                echo '   <div class="card-body">';
                echo '<h5 class="card-title">'.$taskname.'</h5>';
                echo '<p class="card-text">'.$taskcompletiondate.'</p>';
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


                if($_SESSION['user_id']==$taskassigned || $_SESSION['user_type']==3 || $_SESSION['user_id']==$userid ) {
                    echo '<form method="post"><button type="button" onclick="modall(' . $taskid . ')" class="btn btn-warning" name="taskview"  id="modalButton"  data-bs-toggle="modal" data-bs-target="#exampleModal" data-task-id=' . $taskid . '  value=' . $taskid . '>' . "<i class='fa-solid fa-pen-to-square'></i> Edit " .   '</button></form>';

                }

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
        // Get the modal element
        var myModal = document.getElementById('exampleModal');

        // Add an event listener for when the modal is hidden
        myModal.addEventListener('hidden.bs.modal', function () {
            // Refresh the homepage after a delay of 2 seconds
            setTimeout(function() {
                window.location.href = 'Home.php';
            }, 1000); // 2000 milliseconds = 2 seconds
        });



        function modalli(taskid) {
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

<script>


</script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>