<?php

namespace App\Controllers;


class MyProjects extends BaseController
{
    public function index()
    {
        $user_id = session()->get('user_id');
        $projects = $this->get_my_projects($user_id);
        return view('my_projects', ['projects' => $projects]);
    }

    public function get_my_projects($user_id)
    {
        $db = db_connect();
        $result = $db->query("SELECT p.Name, p.Description, p.Status, t.TeamName
                               FROM Project p, teamhaspeople t
                               WHERE t.UserID = $user_id AND p.ProjectID = t.ProjectID
                                ");
        $result_array = $result->getResultArray();
        return $result_array;
    }

    public function get_filtered_projects()
    {
        $db = db_connect();
        $user_id = session()->get('user_id');
        $array = array();
        if (isset($_POST['open'])) {
            $array[] = 'open';
        }
        if (isset($_POST['in_progress'])) {
            $array[] = 'in progress';
        }
        if (isset($_POST['completed'])) {
            $array[] = 'completed';
        }
        $selectedStatus = array_map([$db, 'escapeString'], $array);
        $statuses = "'" . implode("', '", $selectedStatus) . "'";
        # Selection: Selecting projects with the chosen roles for the user
        $result = $db->query("SELECT p.Name, p.Description, p.Status, t.TeamName
                               FROM Project p, teamhaspeople t
                               WHERE t.UserID = $user_id AND p.ProjectID = t.ProjectID AND p.status IN ($statuses)
                                ");
        $result_array = $result->getResultArray();
        return view('my_projects', ['projects' => $result_array]);
    }
}
