<?php


/**
 * Post class
 */
class UserLikes
{

    use Model;

    protected $table = 'posts';

    protected $allowedColumns = [
        'user_id',
        'post_id',
    ];
    public function addUserLike($postId, $userId)
    {
        $query = "INSERT INTO user_likes (post_id, user_id) VALUES (:post_id, :user_id)";

        $data = [
            ':post_id' => $postId,
            ':user_id' => $userId,
        ];

        return $this->query($query, $data);
    }

    public function removeUserLike($postId, $userId)
    {
        $query = "DELETE FROM user_likes WHERE post_id = :post_id AND user_id = :user_id";

        $data = [
            ':post_id' => $postId,
            ':user_id' => $userId,
        ];

        return $this->query($query, $data);
    }

    public function hasUserLikedPost($postId, $userId)
    {
        $query = "SELECT id FROM user_likes WHERE post_id = :post_id AND user_id = :user_id";

        $data = [
            ':post_id' => $postId,
            ':user_id' => $userId,
        ];

        $result = $this->query($query, $data);

        return !empty($result);
    }

}