<?php

namespace App\Controllers;

class Signup extends BaseController
{
    public function index()
    {
        return view('signup');
    }

    public function create_user() 
    {
        if ($this->request->is("post")) 
        {
            $db = db_connect();
            $email = $_POST['Email'];
            $name = $_POST['Name'];
            $password = $_POST['Password'];
            $selectsql = "SELECT Email FROM AppUser WHERE Email = '$email'";
            $result = $db->query($selectsql);

            if(empty($email) || empty($password) || empty($name)) 
            {
                return view('signup', ['error' => 'missing_field']);
            }
            
            if ($result->getNumRows() == 0)
            {
                $insertsql = "INSERT INTO AppUser (Name, Email, Password) VALUES ('$name', '$email', '$password')";
                $db->query($insertsql);
                return view('login');
            } else {
                return view('signup', ['error' => 'email_exists']);
            } 
        }
    }


}