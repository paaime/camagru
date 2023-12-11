<?php

/**
 * signup class
 */
class Register
{
	use Controller;

	public function index()
	{
		$data = [];

		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			$user = new User;
			if ($user->validateRegister($_POST)) {
				$_POST['password'] = md5($_POST['password']);
				$to = $_POST['email'];
				$token = $user->generateVerificationToken();
				$url = ROOT . "/verify?token=" . $token;
				$subject = "Camagru - Verify your account";
				$message = "
					<html>
						<head>
							<title>Camagru - Verify your account</title>
						</head>
						<body>
							<h1>Verify your account</h1>
							<p>Click the link below to verify your account</p>
							<a href='$url'>Verify</a>
						</body>
					</html>
				";

				$headers = "From: camagru@gmail.com\r\n";
				$headers .= "Reply-To: camagru@gmail.com\r\n";
				$headers .= "Content-Type: text/html\r\n";

				$mail_success = mail($to, $subject, $message, $headers);

				if ($mail_success) {
					$_POST['token'] = $token;
					$user->insert($_POST);
					redirect('login');
					return true;
				} else
					$user->errors['email'] = "Problem sending email";
			}

			$data['errors'] = $user->errors;
		}


		$this->view('register', $data);
	}

}