<?php

/**
 * signup class
 */
class Posts
{
    use Controller;

    public function index()
    {
        $data = [];
        $posts = new Post;

        $posts = $posts->findAll();

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $post = new Post;
            $_POST['title'] = 'test';
            $_POST['description'] = 'test';
            $_POST['date'] = date('Y-m-d H:i:s');
            if ($post->validate($_POST)) {
                $post->insert($_POST);
                redirect('posts');
            }

            $data['errors'] = $post->errors;
        }

        $data['posts'] = $posts;

        $this->view('posts', $data);
    }

}