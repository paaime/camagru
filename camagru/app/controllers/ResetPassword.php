<?php

/**
 * signup class
 */
class ResetPassword
{
    use Controller;

    public function index()
    {
        $data = [];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $user = new User;
            $forget = new Forget;

            if (isset($_POST['password'])) {
                $password = $_POST['password'];

                if (empty($password)) {
                    $data['errors']['password'] = "Password is required";
                } elseif (strlen($password) <= '8') {
                    $data['errors']['password'] = 'Your Password Must Contain At Least 8 Characters!';
                }
            } else {
                $data['errors']['password'] = "Password is required";
            }

            // if there is errors return
            if (!empty($data)) {
                $this->view('resetPassword', $data);
                exit();
            }

            $token = isset($_GET['token']) ? htmlspecialchars($_GET['token']) : null;

            if (!empty($token)) {
                $arr['token'] = $token;
                $forget_row = $forget->first($arr);

                if ($forget_row) {
                    $user_row = $user->first(['id' => $forget_row->user_id]);
                    if ($user_row) {
                        // update the password
                        $user->update($user_row->id, ['password' => md5($password)]);
                        $forget->delete($forget_row->id);
                        redirect('login');
                        exit();
                    } else {
                        $data['errors']['token'] = 'Invalid token';
                    }
                } else {
                    $data['errors']['token'] = 'Invalid token';
                }
            } else {
                $data['errors']['token'] = 'Invalid token';
            }
        }
        $this->view('resetPassword', $data);
    }

}