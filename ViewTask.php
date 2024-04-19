<?php
include_once ("head.php");


try{
    include_once ("select_Config.php");

    if (isset($_POST['taskid1'])){}
    $taskid =  $_POST['taskid1'];
    $stmt = $conn->prepare("SELECT * from credentialssr.task WHERE taskid = ?");
    $stmt->bind_param("i",   $taskid);
    $stmt->execute();
    $result = $stmt->get_result();
    //Iterate through the results
    while ($row = $result->fetch_assoc()) {
        // Access the user_id, forename, and surname from the $row array
        $taskname = htmlspecialchars($row['taskname']);
        $taskdate = htmlspecialchars($row['taskdate']);
        $taskcompletiondate = htmlspecialchars($row['taskcompletiondate']);
        $taskdescription = htmlspecialchars($row['taskdescription']);
        $taskpriority = htmlspecialchars($row['taskpriority']);
        $taskstatus = htmlspecialchars($row['taskstatus']);
        echo '<div class="container p-3 border">';
        echo '<h1  class="text-white p-2 nv"><b>Task Details</b></h1>';
        echo '<hr>';
        echo '<h3><b>Task Name </b> :'.$taskname.'</h3>';
        echo '<hr>';
        echo '<h3><b>Descripti </b> on: '.$taskdescription.'</h3>';
        echo '<hr>';
        echo '<h3><b>Task Date </b> :'.$taskdate.'</h3>';
        echo '<hr>';
        echo '<h3><b>Complete By </b> :'.$taskcompletiondate.'</h3>';
        echo '<hr>';
        if ($taskpriority==0){
            echo '<h5  class="card-title text-white p-2 rounded" style="background-color: #61abff" >Task Priority: <b>'."Low".'</b></h5>';
        }
        elseif ($taskpriority==1){
            echo '<h5 class="card-title text-white p-2 rounded" style="background-color: #4399fa">Task Priority: <b>'."medium".'</b></h5>';
        }
        elseif ($taskpriority==2){
            echo '<h5 class="card-title text-white p-2 rounded" style="background-color: #1d82f5">Task Priority: <b>'."High".'</b></h5>';
        }
        elseif ($taskpriority==3){
            echo '<h5 class="card-title text-white p-2 rounded" style="background-color: #2b3036" >Task Priority: <b>'."Critical".'</b></h5>';
        }
        echo '<hr>';
        if ($taskstatus==0){
            echo '<h5  class="card-title text-white p-2 rounded" style="background-color: #a8a3a3" >Task Status: <b>'."Not Started".'</b></h5>';
        }
        elseif ($taskstatus==1){
            echo '<h5 class="card-title text-white p-2 rounded" style="background-color: #e6b120">Task Status: <b>'."In Progress".'</b></h5>';
        }
        elseif ($taskstatus==2){
            echo '<h5 class="card-title text-white p-2 rounded" style="background-color: #0ccc6f">Task Status: <b>'."Done".'</b></h5>';
        }
        elseif ($taskstatus==3){
            echo '<h5 class="card-title text-white p-2 rounded" style="background-color: #c70606" >Task Status: <b>'."Stuck".'</b></h5>';
        }


        echo '</div>';



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

<div class="modal-footer">

    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa-solid fa-rectangle-xmark"></i> Close</button>

</div>


