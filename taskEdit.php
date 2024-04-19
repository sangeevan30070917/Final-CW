<?php
session_start();

// Check if the user is logged in
if(!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}else {
    // Access the user_id, forename, and surname from the $row array

    $newpass =  $_SESSION['newpassword'];

    if ($newpass == 1) {
        header("Location: passwordChange.php");
        exit;
    }

}

include_once ("head.php");
include_once ("update_config.php");

    if(isset($_POST['idd'])) {
        $taskid =  $_POST['idd'];
        $taskname =  $_POST['tname'];
        $description =  $_POST['description'];
        $taskdate =  $_POST['taskdate'];
        $duedate =  $_POST['duedate'];
        $taskprority =  $_POST['taskpriority'];
        $taskstatus =  $_POST['taskstatus'];
        $taskassigned =  $_POST['taskassinged'];
        try{
            $stmt = $conn2->prepare('UPDATE credentialssr.task SET taskname = ?, taskdescription = ?, taskdate = ?, taskcompletiondate = ?, taskpriority = ?, taskstatus = ?, taskassigned = ? WHERE taskid = ?');
            $stmt->bind_param("ssssssss", $taskname,  $description, $taskdate, $duedate, $taskpriority, $taskstatus, $taskassigned,$taskid);

            if ($stmt->execute()) {
                echo '<div class="alert alert-success" role="alert">'.$taskname.' Updated Successfully!
 <a type="button" href="#" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close">X</a></div>';
            } else {
                echo '<div class="alert alert-warning" role="alert">Invalid Information!
 <a type="button" href="#" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close">X</a></div>';
            }


        }
        catch (Exception $e){
            echo '<div class="alert alert-danger" role="alert">Database Error!
 <a type="button" href="#" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close">X</a></div>';
        }


    $conn2->close();
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

<div class="container p-5 border border-primary-subtle">
    <h1><i class="fa-solid fa-pen-to-square"></i> EditTask</h1>
    <?php
    try {
        include_once ("select_Config.php");
        if (isset($_POST['taskid1'])){
            $taskId = $_POST['taskid1'];
            $stmt = $conn->prepare("SELECT * FROM credentialssr.task LEFT JOIN credentialssr.methodone ON task.taskassigned = methodone.user_id WHERE task.taskid =  ?  ");
            $stmt->bind_param("s", $taskId);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $taskid = htmlspecialchars($row['taskid']);
                $taskname = htmlspecialchars($row['taskname']);
                $taskdescription = htmlspecialchars($row['taskdescription']);
                $taskdate = htmlspecialchars($row['taskdate']);
                $duedate = htmlspecialchars($row['taskcompletiondate']);
                $taskpriority = htmlspecialchars($row['taskpriority']);
                $taskstatus = htmlspecialchars($row['taskstatus']);
                $taskassigned = htmlspecialchars($row['taskassigned']);
                $username = htmlspecialchars($row['username']);



            }


        }
    }
    catch (Exception $e){
        echo '<br><div class="alert alert-danger container" name="salert">
                        <strong>Error!</strong>Sql Error!</a>
                        <button type="button"  class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        </div>';
    }

    ?>




    <hr>
    <div id="result"></div>
    <form class="row g-3" action="" id="form" method="post">
        <div class="col-md-6">
            <label for="inputEmail4" class="form-label">Task Name</label>
            <input type="text" class="form-control" id="taskname"  value="<?php
            if (isset($_POST['idd'])) {
                echo isset($taskname) ? $taskname : '';
            }else{echo isset($taskname) ? $taskname : '';}
             ?>">
        </div>
        <div class="col-md-6">
            <label for="exampleFormControlTextarea1" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"><?php
                // Check if the form is submitted and if the 'description' field is set
                if (isset($_POST['idd']) && isset($_POST['description'])) {
                    echo htmlspecialchars($_POST['description']);
                } else {

                    echo isset($taskdescription) ? htmlspecialchars($taskdescription) : '';
                }
                ?></textarea>
        </div>


        <div class="col-6">
            <label for="inputEmail4" class="form-label">Task Date</label>
            <input type="text" class="form-control" id="taskdate" required value="<?php
            if (isset($_POST['idd'])) {
                echo  isset($taskdate) ? $taskdate : '';
            }else{echo isset($taskdate) ? $taskdate : ''; }
            ?>" disabled>
        </div>
        <div class="col-6">
            <label for="duedate" class="form-label">Due date</label>
            <input type="date" class="form-control date"  name="duedate" id="duedate" required  value="<?php
            if (isset($_POST['idd'])) {
                echo  isset($duedate) ? $duedate : '';
            }
            else{
                echo isset($duedate) ? $duedate : '';
            }


            ?>">
        </div>
        <div class="col-4 p-3">
            <label for="taskpriority" class="form-label">Task Priority</label><br>
            <select style="width: 250px; background-color: <?php
            if(isset($taskpriority)) {
                switch($taskpriority) {
                    case '0':
                        echo '#61abff'; // Low
                        break;
                    case '1':
                        echo '#4399fa'; // Medium
                        break;
                    case '2':
                        echo '#1d82f5'; // High
                        break;
                    case '3':
                        echo '#2b3036'; // Critical
                        break;
                    default:
                        echo ''; // Default color if not set
                }
            } else {
                echo ''; // Default color if not set
            }
            ?>" class="form-select select1" name="taskpriority" id="taskpriority">
                <option value="0" <?php
                if (isset($_POST['idd'])) {echo 'test';}
               else{echo isset($taskpriority) && $taskpriority == '0' ? 'selected' : '';}  ?>>Low</option>
                <option value="1" <?php if (isset($_POST['idd'])) {echo 'test';}
                else {echo isset($taskpriority) && $taskpriority == '1' ? 'selected' : '';} ?>>Medium</option>
                <option value="2" <?php if (isset($_POST['idd'])) {echo 'test';}
                else {echo isset($taskpriority) && $taskpriority == '2' ? 'selected' : '';} ?>>High</option>
                <option value="3" <?php if (isset($_POST['idd'])) {echo 'selected';}
                else{ echo isset($taskpriority) && $taskpriority == '3' ? 'selected' : '';} ?>>Critical</option>
            </select>
        </div>
        <div class="col-4 p-3">
            <label for="taskstatus" class="form-label">Task Status</label><br>
            <select style="width: 250px; background-color: <?php
            if(isset($taskstatus)) {
                switch($taskstatus) {
                    case '0':
                        echo '#a8a3a3'; // Not Started
                        break;
                    case '1':
                        echo '#e6b120'; // In Progress
                        break;
                    case '2':
                        echo '#0ccc6f'; // Done
                        break;
                    case '3':
                        echo '#c70606'; // Stuck
                        break;
                    default:
                        echo ''; // Default color if not set
                }
            } else {
                echo ''; // Default color if not set
            }
            ?>" onchange="status()" class="form-select select2" aria-label="Task status" name="taskstatus" id="taskstatus">
                <option value="0" <?php echo isset($taskstatus) && $taskstatus == '0' ? 'selected' : ''; ?>>Not Started</option>
                <option value="1" <?php echo isset($taskstatus) && $taskstatus == '1' ? 'selected' : ''; ?>>In Progress</option>
                <option value="2" <?php echo isset($taskstatus) && $taskstatus == '2' ? 'selected' : ''; ?>>Done</option>
                <option value="3" <?php echo isset($taskstatus) && $taskstatus == '3' ? 'selected' : ''; ?>>Stuck</option>
            </select>

        </div>
        <div class="col-4 p-3">
            <label for="taskassinged" class="form-label">Task Assigned</label><br>
            <select style="width: 250px" class="form-select select3 border"  aria-label="Task statue" name="taskassinged" id="taskassinged" >
                <option value="0">Not Assign</option> <!-- Empty option -->
                <?php
                try {
                    include_once("select_Config.php");

                    $stmt = $conn->prepare("SELECT * FROM credentialssr.methodone");
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Iterate through the results
                    while ($row = $result->fetch_assoc()) {
                        // Access the user_id and username from the $row array
                        $userid = htmlspecialchars($row['user_id']);
                        $taskassigned = htmlspecialchars($row['username']);

                        // Check if the current user value matches the value from the database
                        $selected = isset($username) && $taskassigned == $username ? 'selected' : '';

                        echo '<option value="' . $userid . '" ' . $selected . '>' . $taskassigned . '</option>';
                    }
                } catch (Exception $e) {
                    echo "Sql Error";
                }
                ?>

            </select>
        </div>

        <div class="modal-footer">

            <button type="button" class="btn btn-warning" onclick="mod(<?php echo $taskid ?>)" id="update" name="update"   value="<?php echo $taskid ?>" data-task-id=' <?php echo $taskid ?> ' ><i class="fa-solid fa-pen-to-square"></i> Update</button>


            <button type="button" class="btn btn-danger" onclick="del(<?php echo $taskid ?>)" name="delete" value="<?php echo $taskid ?>"><i class="fa-solid fa-trash"></i> Delete</button>


                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa-solid fa-rectangle-xmark"></i> Close</button>

        </div>
    </form>
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
    function mod(buttonValue) {
        // Set task ID in the modal body
        $('#taskID').text(taskid);
        var taskid = buttonValue;
        var taskname1 = document.getElementById("taskname").value;
        var description = document.getElementById("description").value;
        var taskdate = document.getElementById("taskdate").value;
        var duedate = document.getElementById("duedate").value;
        var taskpriority = document.getElementById("taskpriority").value;
        var taskstatus = document.getElementById("taskstatus").value;
        var taskassinged = document.getElementById("taskassinged").value;
        // Make an AJAX request to fetch data based on taskid
        $.ajax({
            url: 'taskEdit.php', // Same page URL
            type: 'POST',
            data: { idd: taskid ,
                tname: taskname1,
                description:description,
                taskdate : taskdate,
                duedate : duedate,
                taskpriority : taskpriority,
                taskstatus :taskstatus,
                taskassinged :taskassinged
            },
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

    function del(buttonValue) {
        // Set task ID in the modal body
        $('#taskID').text(taskid);
        var taskid = buttonValue;
        // Make an AJAX request to fetch data based on taskid
        $.ajax({
            url: 'taskEdit.php', // Same page URL
            type: 'POST',
            data: { delete: taskid
            },
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



</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

