<?php

namespace App\Controllers;


class FindUsers extends BaseController
{
    public function index()
    {

        return view('find_users');
    }


    private function find_users_by_specific_role($role)
    {
        ## DIVISION
        $db = db_connect();
        $result = $db->query("SELECT Name, Email, Bio
                              FROM appuser a1
                              WHERE NOT EXISTS((SELECT R.RoleName
                                                FROM Role R
                                                WHERE R.RoleName = '$role')
                                                EXCEPT  (SELECT uhs.RoleName
                                                         FROM userhasrole uhs
                                                         WHERE a1.UserID = uhs.UserID))");
        $result_array = $result->getResultArray();
        return $result_array;
    }

    public function find_users()
    {
        if ($this->request->is("post")) {
            $role = $this->request->getVar("Role");;
            $users_with_role = $this->find_users_by_specific_role($role);

            if (empty($role)) {
                return view('find_users', ['error' => 'no_role_specified', 'users_with_role' => []]);
            } else {
                return view('find_users', ['users_with_role' => $users_with_role]);
            }
            
        }
    }
}
