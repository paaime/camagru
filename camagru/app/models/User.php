<?php


/**
 * User class
 */
class User
{

	use Model;

	protected $table = 'users';

	protected $allowedColumns = [
		'email',
		'username',
		'password',
		'token',
		'mail_notification'
	];

	public function generateVerificationToken($length = 32)
	{
		return bin2hex(random_bytes($length));
	}

	public function validateLogin($data)
	{
		$this->errors = [];

		if (empty($data['username'])) {
			$this->errors['username'] = "Username is required";
		}

		if (empty($data['password'])) {
			$this->errors['password'] = "Password is required";
		}

		if (empty($this->errors)) {
			return true;
		}

		return false;
	}

	public function validateRegister($data)
	{
		$this->errors = [];

		if (empty($data['email'])) {
			$this->errors['email'] = "Email is required";
		} else
			if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
				$this->errors['email'] = "Email is not valid";
			} else if ($this->isAlreadyExists('email', $data['email'])) {
				$this->errors['email'] = "Email already exists";
			}

		if (empty($data["username"])) {
			$this->errors['username'] = "Username is required";
		} else {
			if (strlen($data["username"]) < 5 || strlen($data["username"]) > 30 || !preg_match("/^[a-zA-Z]+$/", $data["username"])) {
				$this->errors['username'] = 'Invalid Username';
			}
			if ($this->isAlreadyExists('username', $data['username'])) {
				$this->errors['username'] = "Username already exists";
			}
		}

		if (empty($data['password'])) {
			$this->errors['password'] = "Password is required";
		} else {
			if (strlen($data['password']) <= '8') {
				$this->errors['password'] = 'Your Password Must Contain At Least 8 Characters!';
			}
		}

		if (empty($this->errors)) {
			// send email
			return true;
		}

		return false;
	}
}