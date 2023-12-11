<?php


/**
 * Post class
 */
class Comment
{

    use Model;

    protected $table = 'comments';

    protected $allowedColumns = [
        'post_id',
        'comment_text',
        "user_id",
        "created_at"
    ];

    public function deleteCommentsByPostId($post_id)
    {
        $data['post_id'] = $post_id;
        $query = "DELETE FROM $this->table WHERE post_id = :post_id";
        return $this->query($query, $data);
    }

}