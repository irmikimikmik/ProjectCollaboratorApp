<?php

namespace App\Controllers;

class MyPosts extends BaseController
{
    public function index()
    {
        $user_id = session()->get('user_id');
        $user_name = session()->get('user_name');
        $posts = $this->get_my_posts($user_id);
        return view('my_posts', ['posts' => $posts, 'user_name' => $user_name]);
    }

    public function get_my_posts($user_id)
    {
        $db = db_connect();
        $results = $db->query("SELECT p.ProjectID, p.Title, p.Description, p.Time
                              FROM post p
                              WHERE p.UserID = $user_id");
        return $results->getResultArray();
    }

    public function delete_post()
    {
        $db = db_connect();
        $project_id = $_POST["ProjectID"];
        $db->query("DELETE FROM project WHERE ProjectID = $project_id");
        $user_id = session()->get('user_id');
        $user_name = session()->get('user_name');
        $posts = $this->get_my_posts($user_id);
        return view('my_posts', ['posts' => $posts, 'user_name' => $user_name]);
    }
}
