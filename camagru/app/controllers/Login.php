<?php

/**
 * login class
 */
class Login
{
	use Controller;

	public function index()
	{
		$data = [];

		if ($_SERVER['REQUEST_METHOD'] == "POST") {

			$user = new User;
			if ($user->validateLogin($_POST)) {
				$arr['username'] = $_POST['username'];

				$row = $user->first($arr);

				if ($row) {
					$password = md5($_POST['password']);
					if ($row->password === $password) {
						if ($row->token) {
							$user->errors['email'] = "Please verify your email";
							$data['errors'] = $user->errors;
							$this->view('login', $data);
						} else {
							$_SESSION['USER'] = $row;
							redirect('home');
						}
					}
				}
			}

			$user->errors['email'] = "Wrong email or password";

			$data['errors'] = $user->errors;
		}

		$this->view('login', $data);
	}

}
