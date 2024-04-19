<?php global $conn1; ?>

<?php
session_start();
include_once ("insert_Config.php");
if(isset($_POST['submit1'])){
    $taskname = $_POST['taskname'];
    $taskcompletiondate = $_POST['taskcompleteddate'];
    $taskdescription = $_POST['taskdescription'];
    $taskpriority = $_POST['taskpriority'];
    $taskstatus = $_POST['taskstatus'];
    $taskassigned = $_POST['taskassinged'];
    $useriid = $_SESSION['user_id'];

    $sql="INSERT INTO credentialssr.task (`taskname`,`taskcompletiondate`,`taskdescription`,`taskpriority`,`taskstatus`,`taskassigned`,`userid`) VALUES (?,?,?,?,?,?,?)";
    $stmt = $conn1->prepare($sql);

    $stmt->bind_param('sssssss',$taskname,$taskcompletiondate,$taskdescription,$taskpriority,$taskstatus,$taskassigned,$useriid);
    if($stmt->execute()){
        echo
        '<br><div class="alert alert-success container" name="salert">
                        <strong>Success!</strong>Task Created!</a>
                        <button type="button"  class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        </div>';
        $url = $_SERVER['REQUEST_URI'];
        header("refresh:2; URL=$url");

    }
}


?>
<?php
include_once ("update_config.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
include_once("update_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update'])) {
        $taskid = $_POST['update'];
        $taskname = $_POST['taskname'];
        $description = $_POST['taskdescription1'];
        $duedate = $_POST['taskcompleteddate1'];
        $taskpriority = $_POST['taskpriority1'];
        $taskstatus = $_POST['taskstatus1'];
        $taskassigned = $_POST['taskassigned1'];

        try {
            $stmt = $conn2->prepare('UPDATE credentialssr.task SET taskname = ?, taskdescription = ?, taskcompletiondate = ?, taskpriority = ?, taskstatus = ?, taskassigned = ? WHERE taskid = ?');
            $stmt->bind_param("ssssssi", $taskname, $description, $duedate, $taskpriority, $taskstatus, $taskassigned, $taskid);

            if ($stmt->execute()) {
                echo '<div class="alert alert-success" role="alert">' . $taskname . ' Updated Successfully!
                <a type="button" href="#" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close">X</a></div>';
            } else {
                echo '<div class="alert alert-warning" role="alert">Invalid Information!
                <a type="button" href="#" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close">X</a></div>';
            }
        } catch (Exception $e) {
            echo '<div class="alert alert-danger" role="alert">Database Error!
            <a type="button" href="#" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close">X</a></div>';
        }

        $conn2->close();
    }
}
}
?>
<?php
include_once('delete_Config.php');
if(isset($_POST['delete'])){
    $id =  $_POST['delete'];


    try {
        $stmt = $conn3->prepare('DELETE FROM credentialssr.task WHERE taskid = ? ');
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



<?php include_once ('head.php'); ?>
<!-- Button trigger modal -->

<h1 class=" p-3"><i class="fa-solid fa-table"></i>Task Management</h1>

<div class=" p-3"  >

    <div class="" id="tab">
        <hr>


        <table class="table table-striped" >
            <thead class="table-dark">
            <th>Task Name</th>
            <th>Task Description</th>
            <th>Task Date</th>
            <th>Task Completion Date</th>
            <th>Task Priority</th>
            <th>Task Status</th>
            <th>Task Assigned</th>
            <th></th>
            </thead>
            <tbody >
            <tr class="table-dark">
                <form action="" method="post">
                    <td><input style="width: 200px;font-family: 'Comic Sans MS'" type="text" class="form-control" id="taskname" name="taskname" required></td>
                    <td><div class="form-group">

                            <textarea  class="form-control" id="taskdescription" name="taskdescription" rows="2" required></textarea>
                        </div></td>
                    <td><input type="text" style="width: 140px;font-family: 'Comic Sans MS'"  disabled placeholder="<?php echo  $min = date("d-m-Y"); ?>"></td>
                    <td><input type="date" class="form-control date" min="<?php echo  $min = date("Y-m-d"); ?>" name="taskcompleteddate" required></td>
                    <td><div class="col-auto">
                            <select onchange="low()" class="form-select select1"  aria-label="Task Priority" name="taskpriority" id="taskpriority" >
                                <option class="option1" style="background-color: #61abff" value="0">Low</option>
                                <option class="option1" style="background-color: #4399fa" value="1">Medium</option>
                                <option class="option1" style="background-color: #1d82f5" value="2">High</option>
                                <option class="option1" style="background-color: #2b3036" value="3">Critical</option>
                            </select>
                        </div></td>
                    <td>
                        <select onchange="status()" class="form-select select2"  aria-label="Task statue" name="taskstatus" id="taskstatus" >
                            <option class="option1" style="background-color: #a8a3a3" value="0">Not Started</option>
                            <option class="option1" style="background-color: #e6b120" value="1">In Progress</option>
                            <option class="option1"  style="background-color: #0ccc6f" value="2">Done</option>
                            <option class="option1" style="background-color: #c70606"  value="3">Stuck</option>
                        </select>
                    </td>
                    <td > <select class="form-select select3"  aria-label="Task statue" name="taskassinged" id="taskassinged" >
                            <option value="0" selected>Select User</option>
                            <?php
                            include_once ("select_Config.php");

                            $stmt = $conn->prepare("SELECT * from credentialssr.methodone");
                            $stmt->execute();
                            $result = $stmt->get_result();
                            //Iterate through the results
                            while ($row = $result->fetch_assoc()) {
                                // Access the user_id, forename, and surname from the $row array
                                $userid = htmlspecialchars($row['user_id']);
                                $taskassigned = htmlspecialchars($row['username']);
                                echo '<option value='.$userid.'>'.$taskassigned.'</option>';


                            }

                            ?>

                        </select></td>
                    <td><button class="btn btn-success my-2 my-sm-0" name="submit1">ADD</button></td>

                </form>


            </tr>

               <?php
               include_once ("select_Config.php");

               $stmt = $conn->prepare("SELECT * FROM credentialssr.task LEFT JOIN credentialssr.methodone ON task.taskassigned = methodone.user_id");
               $stmt->execute();
               $result = $stmt->get_result();
               //Iterate through the results
              while ($row = $result->fetch_assoc()) {
    // Access the user_id, forename, and surname from the $row array
    $taskid1 = htmlspecialchars($row['taskid']);
    $taskname = htmlspecialchars($row['taskname']);
    $taskdate = htmlspecialchars($row['taskdate']);
    $taskcompletiondate = htmlspecialchars($row['taskcompletiondate']);
    $taskdescription = htmlspecialchars($row['taskdescription']);
    $taskpriority = htmlspecialchars($row['taskpriority']);
    $taskstatus = htmlspecialchars($row['taskstatus']);
    $useriid = htmlspecialchars($row['userid']);
    $taskassigned = htmlspecialchars($row['taskassigned']);
    $username = htmlspecialchars($row['username']);
 

    if ($_SESSION['user_id'] == $taskassigned || $_SESSION['user_type'] == 3 || $_SESSION['user_id'] == $useriid) {
        // Your code logic goes here


                   echo ' <tr>';
                   echo "<form method='post' action=''>";
                   echo '<td>'."<input type='text' class='form-control' id='taskname' name='taskname'  value='$taskname'>".'</td>';
                   echo '<td>'."<textarea  class='form-control' id='taskdescription' name='taskdescription1' rows='2'' >$taskdescription</textarea>".'</td>';
                   echo '<td>'.$taskdate.'</td>';
                   echo  '<td>' . "<input type='date' class='form-control date'  name='taskcompleteddate1' value='$taskcompletiondate' required>" . '</td>';;
                   echo '<td>'. " <select onchange='low1()' class='form-select select1'  aria-label='Task Priority' name='taskpriority1' id='taskpriority' >
                                <option class='option1' style='background-color: #61abff' value='0' ".($taskpriority == 0 ? "selected" : "")." >Low</option>
                                <option  class='option1' style='background-color: #4399fa' value='1' ".($taskpriority == 1 ? "selected" : "")." >Medium</option>
                                <option class='option1' style='background-color: #1d82f5' value='2' ".($taskpriority == 2 ? "selected" : "")." >High</option>
                                <option class='option1' style='background-color: #2b3036' value='3'".($taskpriority == 3 ? "selected" : "")." >Critical</option>
                            </select>".'</td>';
                   echo '<td>'. " <select onchange='status1()' class='form-select select1'  aria-label='Task Priority' name='taskstatus1' id='taskstatus' >
                                <option class='option1' style='background-color: #a8a3a3' value='0'".($taskstatus == 0 ? "selected" : "")." >Not Started</option>
                                <option class='option1' style='background-color: #e6b120' value='1' ".($taskstatus == 1 ? "selected" : "")." >In Progress</option>
                                <option class='option1'  style='background-color: #0ccc6f' value='2' ".($taskstatus == 2 ? "selected" : "")." >Done</option>
                                <option class='option1' style='background-color: #c70606'  value='3' ".($taskstatus == 3 ? "selected" : "")." >Stuck</option>
                            </select>".'</td>';
                   echo '<td> <select onchange="status()" class="form-select select1"  aria-label="Task Priority" name="taskassigned1" id="taskassigned" >';
                   echo '<option value="0" ' . ($taskassigned == 0 ? "selected" : "") . '>Not Assigned</option>';
                   // Now, fetch the options from the database
                   $stmt2 = $conn->prepare("SELECT * FROM credentialssr.methodone");
                   $stmt2->execute();
                   $result2 = $stmt2->get_result();
                   // Iterate through the results and create options
                   while ($row2 = $result2->fetch_assoc()) {
                       $userid = htmlspecialchars($row2['user_id']);
                       $taskassigned_option = htmlspecialchars($row2['username']);
                       if($taskassigned==0){

                       }
                       else{
                           echo '<option value="' . $userid . '" ' . ($taskassigned == $userid ? "selected" : ($taskassigned == '0' ? "selected" : "")) . '>' . $taskassigned_option . '</option>';
                       }




                   }

                   echo '</select></td>';
                   echo '<td>';


                       echo "<button class='btn btn-warning my-2 my-sm-0' name='update' id='edit1' value='$taskid1'><i class='fa-solid fa-pen-to-square'></i></button>";
                       echo " <button class='btn btn-danger my-2 my-sm-0' name='delete' id='delete1' value='$taskid1'><i class='fa-solid fa-trash'></i></button>";

                   echo '</td>';
                    echo "</form>";
                   echo '</tr>';



               }
               else{
                   echo ' <tr>';
                   echo '<td>'.$taskname.'</td>';
                   echo '<td>'.$taskdescription.'</td>';
                   echo '<td>'.$taskdate.'</td>';
                   echo '<td>'.$taskcompletiondate.'</td>';
                   if($taskpriority==0){
                       echo '<td><h5 class="text-white" style="background-color: #61abff">Low</h5></td>';
                   }elseif ($taskpriority==1){
                       echo '<td><h5 class="text-white" style="background-color: #4399fa">Medium</h5></td>';
                   }

                   elseif ($taskpriority==2){
                       echo '<td><h5 class="text-white" style="background-color: #1d82f5">High</h5></td>';
                   }
                   elseif ($taskpriority==3){
                       echo '<td><h5 class="text-white" style="background-color: #2b3036">Critical</h5></td>';
                   }

                   if($taskstatus==0){
                       echo '<td><h5 class="text-white" style="background-color: #a8a3a3">Not Started</h5></td>';
                   }elseif ($taskstatus==1){
                       echo '<td><h5 class="text-white" style="background-color: #e6b120">In Progress</h5></td>';
                   }

                   elseif ($taskstatus==2){
                       echo '<td><h5 class="text-white" style="background-color: #0ccc6f">Done</h5></td>';
                   }
                   elseif ($taskstatus==3){
                       echo '<td><h5 class="text-white" style="background-color: #c70606">Stuck</h5></td>';
                   }

                   echo '<td>'.$username.'</td>';
                   echo '</tr>';

               }
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
    function low(){
        var x = document.getElementById("taskpriority").value;

        if(x==0){
            document.getElementById("taskpriority").style.backgroundColor="#61abff";
        }

        else if(x==1){
            document.getElementById("taskpriority").style.backgroundColor="#4399fa";
        }
        else if(x==2){
            document.getElementById("taskpriority").style.backgroundColor="#1d82f5";
        }
        else if(x==3){
            document.getElementById("taskpriority").style.backgroundColor="#2b3036";
        }


    }
    function status(){
        var y = document.getElementById("taskstatus").value;

        if(y==0){
            document.getElementById("taskstatus").style.backgroundColor="#a8a3a3";
        }

        else if(y==1){
            document.getElementById("taskstatus").style.backgroundColor="#e6b120";
        }
        else if(y==2){
            document.getElementById("taskstatus").style.backgroundColor="#0ccc6f";
        }
        else if(y==3){
            document.getElementById("taskstatus").style.backgroundColor="#c70606";
        }


    }
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

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
