<?php


/**
 * Post class
 */
class Forget
{

    use Model;

    protected $table = 'forgets';

    protected $allowedColumns = [
        'token',
        'user_id'
    ];

    public function generateVerificationToken($length = 32)
    {
        return bin2hex(random_bytes($length));
    }

}