<?php

/**
 * signup class
 */
class Verify
{
    use Controller;

    public function index()
    {
        $data = [];

        // Sanitize and validate the token
        $token = isset($_GET['token']) ? htmlspecialchars($_GET['token']) : null;

        // Verify the user
        if (!empty($token)) {
            $user = new User;
            $arr['token'] = $token;
            $row = $user->first($arr);

            if ($row) {
                $user->update($row->id, ['token' => '']);
                $data['message'] = "Your account has been verified";
                // Redirect using header
                header("Location: login");
                exit();
            } else {
                $data['message'] = "Invalid token";
            }
        } else {
            $data['message'] = "Token not provided";
        }

        // Output the data to the view
        header("Location: login");
        exit();
    }

}