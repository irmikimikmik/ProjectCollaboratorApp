<?php

namespace App\Controllers;

class Tasks extends BaseController
{    
    public $displayable = true;

    public function index()
    {
        return view('tasks');
    }

    public function get_tasks()
	{
        if ($this->request->is("get")) { 

            // JOIN
            $user_id = session()->get('user_id');
            $role = $this->request->getVar("Role");
            $task_type = $this->request->getVar("TaskType");
            $this->get_tasks_with_input($user_id, $task_type, $role);

            if ($this->displayable){
                // AGGREGATION with GROUP BY
                $show_distribution = $this->request->getVar("showDistribution");
                if ($show_distribution == "showDistribution") {
                    $this->show_distribution($user_id, $task_type, $role);
                }

                // AGGREGATION with HAVING
                $show_progress = $this->request->getVar("showProgress");
                if ($show_progress == "showProgress") {
                    $this->show_progress($user_id, $task_type, $role);
                }

                // NESTED QUERY with AGGREGATION
                $show_task_types = $this->request->getVar("showTaskTypes");
                if ($show_task_types == "showTaskTypes") {
                    $this->show_task_types($user_id, $role);
                }
            }
        }
	}

    public function get_tasks_with_input(int $user_id, string $task_type, string $role)
    {

        if ($role != "All") {
            if ($task_type == 'All') {
                $result = $this->query_all_tasks_for_user_and_role($user_id, $role);
            } else {
                $result = $this->query_one_task_for_user_and_role($user_id, $role, $task_type);
            }
        } else {
            if ($task_type == 'All') {
                $result = $this->query_all_tasks_for_user($user_id);
            } else {
                $result = $this->query_one_task_for_user($user_id, $task_type);
            }
        }

        $this->display_tasks($result->getResultArray());
        // $this->display_back_button();
    }

    public function query_all_tasks_for_user_and_role(int $user_id, string $role){
        $db = db_connect();
        return $db->query("SELECT DISTINCT TaskID, Title, B.Status AS Status,
                                F.Status AS FeatureStatus, S.Status AS SecurityStatus, M.Status AS TestingStatus
                            FROM Task T, Bug B, Feature F, Security S, Testing X, TestingCoverageStatusMap M
                            WHERE (B.UserID=$user_id AND B.RoleName='$role' AND B.BugID = T.TaskID AND B.Status = F.Status AND B.Status = S.Status AND B.Status = M.Status) OR
                                (F.UserID=$user_id AND F.RoleName='$role' AND F.FeatureID = T.TaskID AND F.Status = B.Status AND F.Status = S.Status AND F.Status = M.Status) OR
                                (S.UserID=$user_id AND S.RoleName='$role' AND S.SecurityID = T.TaskID AND S.Status = F.Status AND S.Status = B.Status AND S.Status = M.Status) OR
                                (X.UserID=$user_id AND X.RoleName='$role' AND X.TestingID = T.TaskID AND X.Coverage = M.Coverage AND M.Status = F.Status AND M.Status = S.Status AND M.Status = B.Status)");
    }

    public function query_all_tasks_for_user(int $user_id){
        $db = db_connect();
        return $db->query("SELECT DISTINCT TaskID, Title, B.Status AS Status,
                                F.Status AS FeatureStatus, S.Status AS SecurityStatus, M.Status AS TestingStatus
                            FROM Task T, Bug B, Feature F, Security S, Testing X, TestingCoverageStatusMap M
                            WHERE (B.UserID=$user_id AND B.BugID = T.TaskID AND B.Status = F.Status AND B.Status = S.Status AND B.Status = M.Status) OR
                                (F.UserID=$user_id AND F.FeatureID = T.TaskID AND F.Status = B.Status AND F.Status = S.Status AND F.Status = M.Status) OR
                                (S.UserID=$user_id AND S.SecurityID = T.TaskID AND S.Status = F.Status AND S.Status = B.Status AND S.Status = M.Status) OR
                                (X.UserID=$user_id AND X.TestingID = T.TaskID AND X.Coverage = M.Coverage AND M.Status = F.Status AND M.Status = S.Status AND M.Status = B.Status)");
    }

    public function query_one_task_for_user_and_role(int $user_id, string $role, string $table){
        $db = db_connect();
        if ($table == 'Testing') {
            return $db->query("SELECT TaskID, Title, Status
                FROM Task T, Testing X, TestingCoverageStatusMap M
                WHERE X.UserID=$user_id AND X.RoleName='$role' AND X.TestingID = T.TaskID AND X.Coverage = M.Coverage");
        } else {
            return $db->query("SELECT TaskID, Title, Status
                FROM Task T, {$table} X
                WHERE X.UserID=$user_id AND X.RoleName='$role' AND X.{$table}ID = T.TaskID");
        }
    }

    public function query_one_task_for_user(int $user_id, string $table){
        $db = db_connect();
        if ($table == 'Testing') {
            return $db->query("SELECT TaskID, Title, Status
                FROM Task T, Testing X, TestingCoverageStatusMap M
                WHERE X.UserID=$user_id AND X.TestingID = T.TaskID AND X.Coverage = M.Coverage");
        } else {
            return $db->query("SELECT TaskID, Title, Status
                FROM Task T, $table X
                WHERE X.UserID=$user_id AND X.{$table}ID = T.TaskID");
        }
    }

    public function display_tasks(array $result_as_array){

        if (sizeof($result_as_array) == 0){
            echo "<br><br><h3> <center>
                    There are no tasks to display. Please go back and change the filter.
                </h3>";
            $this->displayable = false;
            return;
        }

        echo "<h2>Tasks:</h2>";
        echo "
        <table border='1'>
        <tr>
        <th>TaskID</th>
        <th>Title</th>
        <th>Status</th>
        </tr>";

        foreach ($result_as_array as $row) {
            echo "<tr>";
            echo "<td>" . $row["TaskID"] . "</td>";
            echo "<td>" . $row['Title'] . "</td>";
            echo "<td>" . $row['Status'] . "</td>";
            echo "</tr>";
        }

    }

    public function show_distribution(int $user_id, string $task_type, string $role) {

        $result = NULL;
        $result_as_array = NULL;

        if ($task_type == 'All') {
            $result_as_array = $this->show_distribution_for_all_tasks($user_id, $role);
        } else {
            if ($role != "All") {
                $result = $this->show_distribution_for_one_task_of_user_and_role($user_id, $role, $task_type);
            } else {
                $result = $this->show_distribution_for_one_task_of_user($user_id, $task_type);
            }
        }

        if ($result) {
            $this->display_distribution($result->getResultArray());
        } else if ($result_as_array) {
            $this->display_distribution($result_as_array);
        }
    }

    public function show_distribution_for_one_task_of_user_and_role(int $user_id, string $role, string $task_type){
        $db = db_connect();
        return $db->query("SELECT COUNT(*) AS TotalTasks, ProjectID
                            FROM {$task_type} X
                            WHERE X.UserID=$user_id AND X.RoleName='$role'
                            GROUP BY X.ProjectID");
    }

    public function show_distribution_for_all_tasks(int $user_id, string $role){
        
        $db = db_connect();

        if ($role != "All"){
            $bug_result = $this->show_distribution_for_one_task_of_user_and_role($user_id, $role, "Bug");
            $feature_result = $this->show_distribution_for_one_task_of_user_and_role($user_id, $role, "Feature");
            $security_result = $this->show_distribution_for_one_task_of_user_and_role($user_id, $role, "Security");
            $testing_result = $this->show_distribution_for_one_task_of_user_and_role($user_id, $role, "Testing");    
        } else {
            $bug_result = $this->show_distribution_for_one_task_of_user($user_id, "Bug");
            $feature_result = $this->show_distribution_for_one_task_of_user($user_id, "Feature");
            $security_result = $this->show_distribution_for_one_task_of_user($user_id, "Security");
            $testing_result = $this->show_distribution_for_one_task_of_user($user_id, "Testing");
        }

        $merged_result = array_merge($bug_result->getResultArray(), $feature_result->getResultArray(), $security_result->getResultArray(), $testing_result->getResultArray());

        for ($row_i = 0; $row_i < sizeof($merged_result); $row_i++) {
            for ($row_j = 0; $row_j < sizeof($merged_result); $row_j++) {
                if ($merged_result[$row_j]['ProjectID'] == $merged_result[$row_i]['ProjectID'] && $row_j != $row_i) {
                    $merged_result[$row_i]['TotalTasks']++;
                    unset($merged_result[$row_j]);
                }
            }
        }

        return $merged_result;
    }

    public function show_distribution_for_one_task_of_user(int $user_id, string $task_type){
        $db = db_connect();
        return $db->query("SELECT COUNT(*) AS TotalTasks, ProjectID
                            FROM {$task_type} X
                            WHERE X.UserID=$user_id
                            GROUP BY X.ProjectID");
    }

    public function display_distribution(array $result_as_array){
        
        echo "
        <table border='1'>
        <tr>
        <th>Project ID</th>
        <th>Number of Tasks</th>
        </tr>";

        echo "<br>
        <h3>Distribution of above tasks per project:</h3>
        <br>";

        foreach ($result_as_array as $row) {
            echo "<tr>";
            echo "<td>" . $row['ProjectID'] . "</td>";
            echo "<td>" . $row['TotalTasks'] . "</td>";
            echo "</tr>";
        }
    }

    public function show_progress(int $user_id, string $task_type, string $role) {

        $complete_tasks_count = NULL;
        $all_tasks_count = NULL;

        if ($task_type == 'All') {
            $complete_tasks_count = $this->show_progress_for_all_tasks($user_id, $role);
            $all_tasks_count = $this->show_distribution_for_all_tasks($user_id, $role);
        } else {
            if ($role != "All") {
                $complete_tasks_count = $this->show_progress_for_one_task_of_user_and_role($user_id, $role, $task_type);
                $all_tasks_count = $this->show_distribution_for_one_task_of_user_and_role($user_id, $role, $task_type);
            } else {
                $complete_tasks_count = $this->show_progress_for_one_task_of_user($user_id, $task_type);
                $all_tasks_count = $this->show_distribution_for_one_task_of_user($user_id, $task_type);
            }
        }

        if (!is_array($complete_tasks_count)){
            $complete_tasks_count = $complete_tasks_count->getResultArray();
        }
        if (!is_array($all_tasks_count)){
            $all_tasks_count = $all_tasks_count->getResultArray();
        }

        $result_as_percentage_array = $this->convert_query_result_to_percentage_array($complete_tasks_count, $all_tasks_count);

        $this->display_progress($result_as_percentage_array);
    }

    public function add_task_counts($task_count_array1, $task_count_array2) {

        if ($task_count_array1 == NULL && $task_count_array2 == NULL){
            return [];
        } else if ($task_count_array1 == NULL){
            return $task_count_array2;
        } else if ($task_count_array2 == NULL){
            return $task_count_array1;
        }

        foreach($task_count_array1 as $array1_row){
            $project_entry_exists = false;
            foreach($task_count_array2 as $array2_row){
                if ($array1_row['ProjectID'] == $array2_row['ProjectID']) {
                    $project_entry_exists = true;
                    $array2_row['TotalCompletedTasks'] = $array2_row['TotalCompletedTasks'] + $array1_row['TotalCompletedTasks'];
                }
            }
            if (!$project_entry_exists){
                $new_entry = array();
                $new_entry['ProjectID'] = $array1_row['ProjectID'];
                $new_entry['TotalCompletedTasks'] = $array1_row['TotalCompletedTasks'];
                array_push($task_count_array2, $new_entry);
            }
        }

        return $task_count_array2;
    }

    public function show_progress_for_all_tasks(int $user_id, string $role){

        if ($role != "All") {
            $complete_bug_tasks_count = $this->show_progress_for_one_task_of_user_and_role($user_id, $role, "Bug");
            $complete_feature_tasks_count = $this->show_progress_for_one_task_of_user_and_role($user_id, $role, "Feature");
            $complete_security_tasks_count = $this->show_progress_for_one_task_of_user_and_role($user_id, $role, "Security");
            $complete_testing_tasks_count = $this->show_progress_for_one_task_of_user_and_role($user_id, $role, "Testing");
        } else {
            $complete_bug_tasks_count = $this->show_progress_for_one_task_of_user($user_id, "Bug");
            $complete_feature_tasks_count = $this->show_progress_for_one_task_of_user($user_id, "Feature");
            $complete_security_tasks_count = $this->show_progress_for_one_task_of_user($user_id, "Security");
            $complete_testing_tasks_count = $this->show_progress_for_one_task_of_user($user_id, "Testing");
        }

        $complete_bug_tasks_count_as_array = $complete_bug_tasks_count->getResultArray();
        $complete_feature_tasks_count_as_array = $complete_feature_tasks_count->getResultArray();
        $complete_security_tasks_count_as_array = $complete_security_tasks_count->getResultArray();
        $complete_testing_tasks_count_as_array = $complete_testing_tasks_count->getResultArray();

        $complete_tasks_count = []; 
        $complete_tasks_count = $this->add_task_counts($complete_bug_tasks_count_as_array, $complete_tasks_count);
        $complete_tasks_count = $this->add_task_counts($complete_feature_tasks_count_as_array, $complete_tasks_count);
        $complete_tasks_count = $this->add_task_counts($complete_security_tasks_count_as_array, $complete_tasks_count);
        $complete_tasks_count = $this->add_task_counts($complete_testing_tasks_count_as_array, $complete_tasks_count);
        
        return $complete_tasks_count;
    }

    public function show_progress_for_one_task_of_user_and_role(int $user_id, string $role, string $task_type){
        $db = db_connect();

        if ($task_type == 'Testing'){
            return $db->query("SELECT COUNT(*) AS TotalCompletedTasks, ProjectID
                FROM Testing T, TestingCoverageStatusMap M
                WHERE T.UserID=$user_id AND T.Coverage = M.Coverage AND T.RoleName='$role'
                GROUP BY T.ProjectID, M.Status
                HAVING M.Status='closed'");
        } else {
            return $db->query("SELECT COUNT(*) AS TotalCompletedTasks, ProjectID
                FROM {$task_type} X
                WHERE X.UserID=$user_id AND X.RoleName='$role'
                GROUP BY X.ProjectID, X.Status
                HAVING X.Status='closed'");
        }
    }

    public function show_progress_for_one_task_of_user(int $user_id, string $task_type){
        $db = db_connect();

        if ($task_type == 'Testing'){
            return $db->query("SELECT COUNT(*) AS TotalCompletedTasks, ProjectID
                FROM Testing T, TestingCoverageStatusMap M
                WHERE T.UserID=$user_id AND T.Coverage = M.Coverage
                GROUP BY T.ProjectID, M.Status
                HAVING M.Status='closed'");
        } else {
            return $db->query("SELECT COUNT(X.Status) AS TotalCompletedTasks, ProjectID
                FROM {$task_type} X
                WHERE X.UserID=$user_id
                GROUP BY X.ProjectID, X.Status
                HAVING X.Status='closed'");
        }
    }

    public function convert_query_result_to_percentage_array(array $complete_tasks_count_array, array $all_tasks_count_array){

        $index = 0;
        $result_array = array();
        $projectID_array = array();

        foreach ($all_tasks_count_array as $row_all) {

            $found_matching_entry_for_project_ID = false;

            foreach ($complete_tasks_count_array as $row_complete) {
                if($row_complete['ProjectID'] == $row_all['ProjectID']){
                    $found_matching_entry_for_project_ID = true;
                    $projectID_array;
                    $percentage_complete = $row_complete['TotalCompletedTasks'] * 100 / $row_all['TotalTasks'];
                    $result_array[$index] = array();
                    $result_array[$index]['ProjectID'] = $row_complete['ProjectID'];
                    $result_array[$index]['Percentage'] = $percentage_complete;
                    $index++;
                }
            }

            if (!$found_matching_entry_for_project_ID){
                $result_array[$index] = array();
                $result_array[$index]['ProjectID'] = $row_all['ProjectID'];
                $result_array[$index]['Percentage'] = 0;
                $index++;
            }
        }

        return $result_array;
    }

    public function display_progress(array $result_as_percentage_array){

        echo "
        <table border='1'>
        <tr>
        <th>Project ID</th>
        <th>Progress</th>
        </tr>";

        echo "<br>
        <h3>Progress of above tasks per project:</h3>
        <br>";

        foreach ($result_as_percentage_array as $row) {
            echo "<tr>";
            echo "<td>" . $row['ProjectID'] . "</td>";
            echo "<td>" . $row['Percentage'] . "%</td>";
            echo "</tr>";
        }
    }

    public function show_task_types(int $user_id, string $role){
        $db = db_connect();
        $result = NULL; 

        if ($role == "All") {
            $result = $db->query("SELECT TaskType, COUNT(*) AS task_count
                                FROM (SELECT 'Bug' AS TaskType, BugID, UserID FROM Bug
                                        UNION ALL
                                        SELECT 'Testing' AS TaskType, TestingID, UserID FROM Testing
                                        UNION ALL
                                        SELECT 'Feature' AS TaskType, FeatureID, UserID FROM Feature
                                        UNION ALL
                                        SELECT 'Security' AS TaskType, SecurityID, UserID FROM Security) AS combined_tasks
                                WHERE combined_tasks.UserID IN (SELECT UserID FROM Bug WHERE UserID = $user_id
                                                                UNION ALL
                                                                SELECT UserID FROM Testing WHERE UserID = $user_id
                                                                UNION ALL
                                                                SELECT UserID FROM Feature WHERE UserID = $user_id
                                                                UNION ALL
                                                                SELECT UserID FROM Security WHERE UserID = $user_id)
                                GROUP BY TaskType;");
        } else {
            $result = $db->query("SELECT TaskType, COUNT(*) AS task_count
                                FROM (SELECT 'Bug' AS TaskType, BugID, UserID, RoleName FROM Bug
                                        UNION ALL
                                        SELECT 'Testing' AS TaskType, TestingID, UserID, RoleName FROM Testing
                                        UNION ALL
                                        SELECT 'Feature' AS TaskType, FeatureID, UserID, RoleName FROM Feature
                                        UNION ALL
                                        SELECT 'Security' AS TaskType, SecurityID, UserID, RoleName FROM Security) AS combined_tasks
                                WHERE combined_tasks.UserID IN (SELECT UserID FROM Bug WHERE UserID = $user_id 
                                                                UNION ALL
                                                                SELECT UserID FROM Testing WHERE UserID = $user_id
                                                                UNION ALL
                                                                SELECT UserID FROM Feature WHERE UserID = $user_id
                                                                UNION ALL
                                                                SELECT UserID FROM Security WHERE UserID = $user_id) AND
                                    combined_tasks.RoleName IN (SELECT RoleName FROM Bug WHERE RoleName = '$role'
                                                                UNION ALL
                                                                SELECT RoleName FROM Testing WHERE RoleName = '$role'
                                                                UNION ALL
                                                                SELECT RoleName FROM Feature WHERE RoleName = '$role'
                                                                UNION ALL
                                                                SELECT RoleName FROM Security WHERE RoleName = '$role')
                                GROUP BY TaskType;");
        }

        $this->display_task_types($result->getResultArray());
    }

    public function display_task_types(array $result_array){

        echo "
        <table border='1'>
        <tr>
        <th>Task Type</th>
        <th>Task Count</th>
        </tr>";

        echo "<br>
        <h2>Distribution of all my tasks based on task type:</h2>
        <br>";

        foreach ($result_array as $row) {
            echo "<tr>";
            echo "<td>" . $row['TaskType'] . "</td>";
            echo "<td>" . $row['task_count'] . "</td>";
            echo "</tr>";
        }
    }

}
