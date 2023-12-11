<?php

/**
 * signup class
 */
class ForgetPassword
{
    use Controller;

    public function index()
    {
        $data = [];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $user = new User;
            // check if the email is valid
            if (isset($_POST['email'])) {
                $arr['email'] = $_POST['email'];

                $row = $user->first($arr);

                if ($row) {
                    $forgetPassword = new Forget;
                    $token = $forgetPassword->generateVerificationToken();

                    $toSave["user_id"] = $row->id;
                    $toSave["token"] = $token;

                    $to = $_POST['email'];
                    $url = ROOT . "/resetPassword?token=" . $token;
                    $subject = "Camagru - Reset Password";
                    $message = "
					<html>
						<head>
							<title>Camagru - Reset Password</title>
						</head>
						<body>
							<h1>Reset Password</h1>
							<p>Click the link below to reset your password</p>
							<a href='$url'>Reset Password</a>
						</body>
					</html>
				";

                    $headers = "From: camagru@gmail.com\r\n";
                    $headers .= "Reply-To: camagru@gmail.com\r\n";
                    $headers .= "Content-Type: text/html\r\n";

                    $mail_success = mail($to, $subject, $message, $headers);

                    if ($mail_success) {
                        $forgetPassword->insert($toSave);
                        $this->view('forgetPassword', $data);
                    } else
                        $user->errors['email'] = "Problem sending email";
                } else {
                    $user->errors['email'] = "Email doesn't exists";
                }
            }

            $data['errors'] = $user->errors;
        }

        // Output the data to the view
        $this->view('forgetPassword', $data);
    }

}