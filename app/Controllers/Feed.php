<?php

namespace App\Controllers;


class Feed extends BaseController
{
    public function index()
    {
        $db = db_connect();
        $allRoles = $this->get_all_roles();
        $sql = "SELECT Title, Description, Time, Name, COUNT(r.RoleName) AS OpenPositions, GROUP_CONCAT(r.RoleName) AS RolesNeeded
                FROM Post p, AppUser u, PostNeedsRole r
                WHERE p.UserID = u.UserID AND p.PostID = r.PostID
                GROUP BY p.PostID
                ORDER BY Time DESC";
        $result = $db->query($sql);
        $feed = $result->getResultArray();
        $userName = session()->get('user_name');
        return view('feed', ['feed' => $feed, 'allRoles' => $allRoles, 'selectedRoles' => [], 'userName' => $userName]);
    }

    public function filter_feed()
    {
        $db = db_connect();
        $allRoles = $this->get_all_roles();

        if ($this->request->is("post")) {
            $selectedRoles = $_POST['selectedRoles'] ?? [];
            $userName = session()->get('user_name');
            
            if (!empty($selectedRoles)) {
                $selectedRoles = array_map([$db, 'escapeString'], $selectedRoles);
                $roleConditions = "'" . implode("', '", $selectedRoles) . "'";
                // SELECTION with user input
                $sql = "SELECT Title, Description, Time, Name, COUNT(r.RoleName) AS OpenPositions, GROUP_CONCAT(r.RoleName) AS RolesNeeded
                        FROM Post p, AppUser u, PostNeedsRole r
                        WHERE p.UserID = u.UserID AND p.PostID = r.PostID AND r.RoleName IN ($roleConditions)
                        GROUP BY p.PostID
                        ORDER BY Time DESC";
                $result = $db->query($sql);
                $feed = $result->getResultArray();
                return view('feed', ['feed' => $feed, 'allRoles' => $allRoles, 'selectedRoles' => $selectedRoles, 'userName' => $userName]);
            } else {
                return view('feed', ['error' => 'missing_field', 'feed' => [], 'allRoles' => $allRoles, 'selectedRoles' => [], 'userName' => $userName]);
            }
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


}