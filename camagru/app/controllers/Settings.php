<?php

/**
 * home class
 */
class Settings
{
    use Controller;

    public function index()
    {
        is_logged_in();
        $data = [];
        $data['username'] = $_SESSION['USER']->username;
        $data['email'] = $_SESSION['USER']->email;
        $data['mail_notification'] = $_SESSION['USER']->mail_notification;

        $this->view('settings', $data);
    }

    public function changeEmail()
    {
        is_logged_in();
        $data = [];
        $data['email'] = $_SESSION['USER']->email;
        $data['username'] = $_SESSION['USER']->username;
        $data['mail_notification'] = $_SESSION['USER']->mail_notification;

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $user = new User;

            if (isset($_POST['email'])) {
                $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

                if (empty($email)) {
                    $user->errors['email'] = "Email is required";
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $user->errors['email'] = "Email is not valid";
                } elseif ($user->isAlreadyExists('email', $email)) {
                    $user->errors['email'] = "Email already exists";
                }
            } else {
                $user->errors['email'] = "Email is required";
            }

            if (empty($user->errors)) {
                $result = $user->update($_SESSION['USER']->id, ['email' => $_POST['email']]);
                if ($result != false) {
                    $_SESSION['USER']->email = $_POST['email'];
                    header("Location: " . ROOT . "/settings");
                    exit();
                } else {
                    $user->errors['email'] = "Problem updating email";
                }
            }

            $data['errors'] = $user->errors;
        }

        $this->view('settings', $data);
    }

    public function changeUsername()
    {
        is_logged_in();
        $data = [];
        $data['email'] = $_SESSION['USER']->email;
        $data['username'] = $_SESSION['USER']->username;
        $data['mail_notification'] = $_SESSION['USER']->mail_notification;

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $user = new User;

            if (isset($_POST['username'])) {
                $username = $_POST['username'];

                if (empty($username)) {
                    $user->errors['username'] = "Username is required";
                } elseif (strlen($username) < 5 || strlen($username) > 30 || !preg_match("/^[a-zA-Z]+$/", $username)) {
                    $user->errors['username'] = "Username is not valid";
                } elseif ($user->isAlreadyExists('username', $username)) {
                    $user->errors['username'] = "Username already exists";
                }
            } else {
                $user->errors['username'] = "Username is required";
            }

            if (empty($user->errors)) {
                $result = $user->update($_SESSION['USER']->id, ['username' => $_POST['username']]);
                if ($result != false) {
                    $_SESSION['USER']->username = $_POST['username'];
                    header("Location: " . ROOT . "/settings");
                    exit();
                } else {
                    $user->errors['username'] = "Problem updating username";
                }
            }

            $data['errors'] = $user->errors;
        }

        $this->view('settings', $data);
    }

    public function changePassword()
    {
        is_logged_in();
        $data = [];
        $data['email'] = $_SESSION['USER']->email;
        $data['username'] = $_SESSION['USER']->username;
        $data['mail_notification'] = $_SESSION['USER']->mail_notification;

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $user = new User;

            if (isset($_POST['password'])) {
                $password = $_POST['password'];

                if (empty($password)) {
                    $user->errors['password'] = "Password is required";
                } elseif (strlen($password) <= '8') {
                    $user->errors['password'] = 'Your Password Must Contain At Least 8 Characters!';
                }
            } else {
                $user->errors['password'] = "Password is required";
            }

            if (empty($user->errors)) {
                $_POST['password'] = md5($_POST['password']);
                $result = $user->update($_SESSION['USER']->id, ['password' => $_POST['password']]);
                if ($result != false) {
                    $_SESSION['USER']->password = $_POST['password'];
                    header("Location: " . ROOT . "/settings");
                    exit();
                } else {
                    $user->errors['password'] = "Problem updating password";
                }
            }

            $data['errors'] = $user->errors;
        }

        $this->view('settings', $data);
    }

    public function changeEmailNotification()
    {
        is_logged_in();
        $data = [];
        $data['email'] = $_SESSION['USER']->email;
        $data['username'] = $_SESSION['USER']->username;
        $data['mail_notification'] = $_SESSION['USER']->mail_notification;

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $user = new User;

            if (empty($user->errors)) {
                // Check if the checkbox for mail notification is checked
                $mailNotification = $_SESSION['USER']->mail_notification == 1 ? 0 : 1;

                // Update the user's mail_notification status in the database
                $result = $user->update($_SESSION['USER']->id, ['mail_notification' => $mailNotification]);

                if ($result !== false) {
                    $_SESSION['USER']->mail_notification = $mailNotification;
                    header("Location: " . ROOT . "/settings");
                    exit();
                } else {
                    $user->errors['mail_notification'] = "Problem updating mail notification";
                }
            }

            $data['errors'] = $user->errors;
        }

        $this->view('settings', $data);
    }


}