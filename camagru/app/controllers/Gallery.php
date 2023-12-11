<?php

/**
 * signup class
 */
class Gallery
{
    use Controller;

    public function index()
    {
        $data = [];
        $posts = new Post;
        $userLikes = new UserLikes;

        $page = isset($_GET['page']) ? filter_var($_GET['page'], FILTER_VALIDATE_INT) : 1;

        if ($page === false || $page <= 0) {
            // Invalid page number, handle the error (e.g., set it to 1, display an error message, or redirect).
            $data["currentPage"] = 0;
            $data["totalPages"] = 0;
            $data['posts'] = [];
            $this->view('gallery', $data);
            return;
        }

        $postsPerPage = 5;
        $offset = ($page - 1) * $postsPerPage;

        $totalPosts = $posts->getTotalPosts();

        $posts = $posts->getPostsByPage($postsPerPage, $page);

        if (empty($posts)) {
            $data["currentPage"] = 0;
            $data["totalPages"] = 0;
            $data['posts'] = [];
            $this->view('gallery', $data);
            return;
        }

        // Calculate the total number of pages
        $totalPages = ceil($totalPosts / $postsPerPage);
        $data["currentPage"] = $page;
        $data["totalPages"] = $totalPages;

        foreach ($posts as $row) {
            $postId = $row->post_id;
            $hasUserLiked = isset($_SESSION['USER']) ? $userLikes->hasUserLikedPost($postId, $_SESSION['USER']->id) : false;

            // Initialize the post if it's not added to the array yet
            if (!isset($postsWithComments[$postId])) {
                $postsWithComments[$postId] = [
                    'post_id' => $postId,
                    'username' => $row->post_username,
                    'image_url' => $row->image_url,
                    'likes' => $row->likes,
                    'user_id' => $row->post_user_id,
                    'created_at' => $row->created_at,
                    'user_has_liked' => $hasUserLiked,
                    'comments' => [],
                ];
            }

            // Add the comment if available
            if ($row->comment_id) {
                $postsWithComments[$postId]['comments'][] = [
                    'comment_id' => $row->comment_id,
                    'comment_text' => $row->comment_text,
                    'user_id' => $row->comment_user_id,
                    'comment_username' => $row->comment_username,
                ];
            }
        }

        if (!$postsWithComments) {
            $data['errors'][] = "No posts found";
            $data['posts'] = [];
        } else {
            $data['posts'] = $postsWithComments;
        }



        $this->view('gallery', $data);
    }

    public function likePost()
    {
        if (!is_logged_in_request()) {
            http_response_code(400);
            echo "You must be logged in to like a post";
            return;
        }
        $postId = $_POST['post_id'];

        $post = new Post;
        $userLikes = new UserLikes;

        $userId = $_SESSION['USER']->id;

        if ($userLikes->hasUserLikedPost($postId, $userId)) {
            $success = $post->unlikePost($postId);
            if ($success != false) {
                $success = $userLikes->removeUserLike($postId, $userId);
                if ($success != false) {
                    echo json_encode(['success' => 'remove_like']);
                    return http_response_code(200);
                } else {
                    return http_response_code(400);
                }
            } else
                return http_response_code(400);
        }

        $success = $post->likePost($postId);

        if ($success != false) {
            $success = $userLikes->addUserLike($postId, $userId);
            if ($success != false) {
                echo json_encode(['success' => 'add_like']);
                return http_response_code(200);
            } else {
                return http_response_code(400);
            }
        } else {
            http_response_code(400);
            return;
        }
    }

    public function addComment()
    {
        if (!is_logged_in_request()) {
            http_response_code(400);
            echo "You must be logged in to comment a post";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postId = $_POST['post_id'];
            $commentText = $_POST['comment'];

            // Validate the comment
            if (empty($commentText)) {
                http_response_code(400);
                echo "Comment cannot be empty";
                return;
            }
            // Check for XSS or SQL injection
            if (preg_match('/[\'^£$%&*()}{@#~><>,|=_+¬-]/', $commentText)) {
                http_response_code(400);
                echo "Comment cannot contain special characters";
                return;
            }
            // Check if the comment is too long
            if (strlen($commentText) > 255) {
                http_response_code(400);
                echo "Comment cannot be longer than 255 characters";
                return;
            }


            $post = new Post();
            $commentUsername = $_SESSION['USER']->username;
            $success = $post->addComment($postId, $commentText, $commentUsername);

            if ($success) {

                http_response_code(200);
                echo json_encode(['username' => $commentUsername, 'comment' => $commentText]);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to add comment']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Bad request']);
        }
    }

}