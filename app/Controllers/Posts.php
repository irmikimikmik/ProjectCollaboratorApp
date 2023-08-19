<?php

namespace App\Controllers;


class Posts extends BaseController
{
    public function index()
    {
        $allRoles = $this->get_all_roles();
        $userName = session()->get('user_name');
        return view('posts', ['userName' => $userName, 'allRoles' => $allRoles]);
    }

    private function create_post_needs_role(int $post_id)
    {
        $db = db_connect();
        $selectedRoles = $_POST['selectedRoles'];
        foreach ($selectedRoles as $role) {
            $db->query("INSERT INTO PostNeedsRole(PostID, RoleName) VALUES ($post_id, '$role')");
        }
    }

    private function get_all_roles()
    {
        $db = db_connect();
        $sql = "SELECT RoleName
                FROM Role r";
        $roles = $db->query($sql);
        return $roles->getResultArray();
    }

    private function create_user_with_role_project_manager(int $user_id)
    {
        $db = db_connect();
        $db->query("INSERT IGNORE INTO UserHasRole(UserID, RoleName)
                    VALUES(" . $user_id . ", 'Project Manager')
                     ");
    }


    private function create_project_and_team(array $user_inputs)
    {
        // Create Project
        $db = db_connect();
        $title = $user_inputs['Title'];
        $description = $user_inputs['Description'];
        $sql = "INSERT INTO Project (Name, Description, Status) VALUES ('$title', '$description', 'open')";
        $db->query($sql);
        //Create Team
        $project_id = $db->insertID();
        $max_capacity = count($_POST['selectedRoles']);
        $team_name = $user_inputs['TeamName'];
        $sql = "INSERT INTO Team(Name, MaxCapacity, ProjectID) VALUES ('$team_name', $max_capacity, $project_id)";
        $db->query($sql);
        //Add user to team as Project Manager
        $user_id = session()->get('user_id');
        $sql = "INSERT INTO TeamHasPeople(ProjectID, TeamName, RoleName, UserID) VALUES ($project_id, '$team_name','Project Manager', $user_id)";
        $db->query($sql);

        return $project_id;
    }

    public function create_post()
    {
        $userName = session()->get('user_name');
        $allRoles = $this->get_all_roles();

        if ($this->request->is("post")) {
            $title = $_POST['Title'];
            $description = $_POST['Description'];
            $selectedRoles = $_POST['selectedRoles'] ?? [];
            $date = date('Y/m/d');
            $user_id = session()->get('user_id');

            $db = db_connect();

            if (empty($selectedRoles) || empty($description) || empty($title)) {
                return view('posts', ['userName' => $userName, 'allRoles' => $allRoles, 'error' => 'missing_field',]);
            } else {
                $this->create_user_with_role_project_manager($user_id);
                $project_id = $this->create_project_and_team($_POST);
                $sql = "INSERT INTO Post(Title, Description, Time, UserID, ProjectID) VALUES ('$title', '$description', '$date', $user_id, $project_id)";
                $db->query($sql);
                $post_id = $db->insertID();
                $this->create_post_needs_role($post_id);
                return view('posts', ['userName' => $userName, 'allRoles' => $allRoles]);
            }
        }
        return view('posts', ['userName' => $userName, 'allRoles' => $allRoles]);
    }
}
