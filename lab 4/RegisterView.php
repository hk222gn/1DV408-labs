<?php

class RegisterView
{
	private $registerModel;

	public function __construct(RegisterModel $registerModel) 
	{
		$this->registerModel = $registerModel;
	}

	public function GenerateRegisterHTML()
	{
		$usernameInput = $this->GetUsernameInput();

		$HTML = "<h1>Laborationskod hk222gn</h1>
				<form name='f1' method='post' action='?register'>
					<h3>Användarnamn</h3>
					<input type='text' name='username' value='$usernameInput'>
					<h3>Lösenord</h3>
					<input type='password' name='password'>
					<h3>Repetera Lösenord</h3>
					<input type='password' name='passwordCheck'>
					<h3>Skicka:</h3>
					<input type='submit' value='Registera' name='doRegister'>
				</form>;
				"

		return $HTML;
	}

	public function GetUsernameInput()
	{
		if (isset($_POST['username'])) 
		{ 
			return $_POST['username'];
		}
		return false;
	}

	public function GetUsernameInput()
	{
		if (isset($_POST['password'])) 
		{ 
			return $_POST['password'];
		}
		return false;
	}
}