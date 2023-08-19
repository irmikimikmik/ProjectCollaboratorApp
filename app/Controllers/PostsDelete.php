<?php

namespace App\Controllers;


class PostsDelete extends BaseController
{
    public function index()
    {

        return view('posts_delete');
    }

    public function delete_post()
    {
        if ($this->request->is("post")) {
            $user_id = intval($_POST['UserID']);
            $post_id = intval($_POST['PostID']);
            $this->delete_post_by_user_and_post_id($user_id, $post_id);
        }
    }

    private function delete_post_by_user_and_post_id(int $user_id, int $post_id)
    {
        $db = db_connect();
        $result = $db->query("SELECT UserID FROM Post WHERE PostID = " . $post_id);
        if ($result->getResultArray()[0]["UserID"] == $user_id) {
            $db->query("DELETE FROM Post WHERE PostID = " . $post_id);
        } else {
            echo "<h1>YOU CANNOT DELETE A POST THAT YOU DID NOT POSTED</h1>";
        }
    }
}
