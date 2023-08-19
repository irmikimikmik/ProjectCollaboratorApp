<?php

namespace App\Controllers;

class MyProfile extends BaseController
{
    public function index()
    {
        $userId = session()->get('user_id');
        $currentUser = $this->get_user_info($userId);
        return view('profile', ['user' => $currentUser]);
    }

    private function get_user_info(string $userId) 
    {
        $db = db_connect();
        $selectsql = "SELECT * FROM AppUser WHERE UserID = $userId";
        $result = $db->query($selectsql);
        $user = $result->getResultArray();
        return $user;
    }

    public function update_profile() 
    {
        if ($this->request->is("post")) {
            $db = db_connect();
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $bio = $_POST['bio'];
            $userId = session()->get('user_id');
            $updateSQL = "UPDATE AppUser SET Name = '$name', Email = '$email', Password = '$password', Bio = '$bio' WHERE UserID = $userId";
            $db->query($updateSQL);
        }
        session()->set('user_name', $name);
        $currentUser = $this->get_user_info($userId);
        return view('profile', ['success' => 'profile_updated', 'user' => $currentUser]); 
    }

    public function delete_profile() 
    {
        if ($this->request->is("post")) {
            $db = db_connect();
            $userId = session()->get('user_id');
            $deleteuser = "DELETE FROM AppUser WHERE UserID = $userId";
            $db->query($deleteuser);
        }
        return view('signup'); 
    }

}
