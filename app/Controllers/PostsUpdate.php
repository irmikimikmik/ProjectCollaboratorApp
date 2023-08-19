<?php

namespace App\Controllers;

use CodeIgniter\Database\Query;

class PostsUpdate extends BaseController
{
    public function index()
    {

        return view('posts_update');
    }

    private function update_post_with_given_title_and_description(string $title, string $description, int $user_id, int $post_id)
    {
        $db = db_connect();
        $result = $db->query("SELECT UserID FROM Post WHERE PostID = " . $post_id);
        if ($result->getResultArray()[0]["UserID"] == $user_id) {
            $db->query("UPDATE Post SET Title = '" . $db->escapeString($title) . "' WHERE PostID = " . $post_id);
        } else {
            echo "<h1>YOU CANNOT UPDATE A POST THAT YOU DID NOT POSTED</h1>";
        }
    }

    public function update_post()
    {
        if ($this->request->is("post")) {
            $title = $_POST['Title'];
            $description = $_POST['Description'];
            $user_id = intval($_POST['UserID']);
            $post_id = intval($_POST['PostID']);
            $this->update_post_with_given_title_and_description($title, $description, $user_id, $post_id);
        }
    }
}
