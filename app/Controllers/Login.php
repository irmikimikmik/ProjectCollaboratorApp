<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function index()
    {
        return view('login');
    }

    public function login() 
    {
        $email = $_POST['Email'];
        $password = $_POST['Password'];

        if ($this->request->is("post")) 
        {
            $db = db_connect();
            
            $sql = "SELECT * FROM AppUser WHERE Email = '$email' AND Password = '$password'";
            $result = $db->query($sql);
            $currentUser = $result->getResultArray();

            if ($result && $result->getNumRows() > 0)
            {    
                session()->set('user_id', $currentUser[0]['UserID']);
                session()->set('user_name', $currentUser[0]['Name']);
                //redirect user to feed
                $feedController = new \App\Controllers\Feed();
                return $feedController->index();
            } else {
                return view('login', ['error' => 'invalid']);
            }
        }
    }

}