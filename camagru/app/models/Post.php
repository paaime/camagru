<?php


/**
 * Post class
 */
class Post
{

    use Model;

    protected $table = 'posts';

    protected $allowedColumns = [
        'image_url',
        'likes',
        'user_id',
        'created_at',
    ];

    public function validate($data)
    {
        $this->errors = [];

        if (empty($data['title'])) {
            $this->errors['title'] = "Title is required";
        }

        if (empty($data['description'])) {
            $this->errors['description'] = "Description is required";
        }

        if (empty($data['date'])) {
            $this->errors['date'] = "Date is required";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }

    public function likePost($postId)
    {
        $query = "update $this->table set likes = likes + 1 where id = $postId";

        return $this->query($query);
    }

    public function unlikePost($postId)
    {
        $query = "update $this->table set likes = likes - 1 where id = $postId";

        return $this->query($query);
    }

    public function deletePostWithComments($post_id)
    {
        // Delete comments associated with the post
        $comment = new Comment;
        $comment->deleteCommentsByPostId($post_id);

        // Delete the post
        $post = new Post;
        $deleted = $post->delete($post_id);

        return $deleted;
    }

    public function addComment($postId, $commentText, $commentUsername)
    {
        $query = "INSERT INTO comments (comment_text, post_id, user_id) VALUES (:comment_text, :post_id, :user_id)";
        $data = [
            'comment_text' => $commentText,
            'post_id' => $postId,
            'user_id' => $_SESSION['USER']->id,
        ];


        // Insert the comment into the database
        $commentInsertionResult = $this->query($query, $data);

        if ($commentInsertionResult) {
            // Comment was inserted successfully
            // Now, retrieve the user's email based on post_id
            $userEmailQuery = "SELECT u.email, u.mail_notification FROM users u JOIN posts p ON u.id = p.user_id WHERE p.id = :post_id";
            $userData = [
                'post_id' => $postId,
            ];

            $result = $this->query($userEmailQuery, $userData);

            if ($result) {
                $userEmail = $result[0]->email;
                $mailNotification = $result[0]->mail_notification;

                if ($mailNotification) {
                    // Send the email only if email_notification is true
                    $to = $userEmail;
                    $subject = "Camagru - New comment on your post";
                    $message = "
                    <html>
                        <head>
                            <title>Camagru - New comment on your post</title>
                        </head>
                        <body>
                            <h1>New comment on your post !</h1>
                            <p>$commentUsername commented on your post : $commentText</p>
                        </body>
                    ";

                    $headers = "From: camagru@gmail.com\r\n";
                    $headers .= "Reply-To: camagru@gmail.com\r\n";
                    $headers .= "Content-Type: text/html\r\n";

                    $mail_success = mail($to, $subject, $message, $headers);

                    if ($mail_success) {
                        // Email sent successfully
                        return true;
                    } else {
                        // Handle email sending failure
                        return false;
                    }
                } else {
                    // Email notification is turned off, don't send the email
                    return true;
                }
            } else {
                // Handle the case where the user's email couldn't be retrieved
                return false;
            }
        } else {
            // Handle the case where comment insertion failed
            return false;
        }
    }


    public function getAllPosts()
    {
        $query = "SELECT p.id AS post_id, p.image_url, p.likes, p.user_id AS post_user_id, c.id AS comment_id, c.comment_text, c.user_id AS comment_user_id FROM posts p LEFT JOIN comments c ON p.id = c.post_id;";

        return $this->query($query);
    }

    public function getTotalPosts()
    {
        $query = "SELECT COUNT(*) as total FROM $this->table";
        $result = $this->query($query);

        if ($result) {
            return $result[0]->total;
        }

        return 0; // Return 0 if there was an error or no posts found.
    }

    public function getPostsByPage($postPerPage, $page)
    {
        $offset = ($page - 1) * $postPerPage;

        $query = "SELECT
        post_id,
        image_url,
        likes,
        created_at,
        post_user_id,
        post_username,
        comment_id,
        comment_text,
        comment_user_id,
        comment_username
    FROM (
        SELECT
            p.id AS post_id,
            p.image_url,
            p.likes,
            p.created_at,
            p.user_id AS post_user_id,
            u.username AS post_username,
            c.id AS comment_id,
            c.comment_text,
            c.user_id AS comment_user_id,
            cu.username AS comment_username
        FROM posts p
        LEFT JOIN users u ON p.user_id = u.id
        LEFT JOIN comments c ON p.id = c.post_id
        LEFT JOIN users cu ON c.user_id = cu.id
        ORDER BY p.created_at DESC
        LIMIT 5 OFFSET $offset
    ) AS subquery;";

        return $this->query($query);
    }
}