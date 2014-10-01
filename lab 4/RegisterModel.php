<?php

//TODO: Är det verkligen en bra lösning i ValidateUserInput, if username & password == ""?

class RegisterModel 
{
	public function ValidateUserInput($username, $password, $passwordCheck)
	{
		if ($username == "")
		{
			if ($password == "") 
			{
				return "Användarnamnet har för få tecken, Minst 3 krävs. \n Lösenordet har för få tecken, Minst 6 krävs.";
			}
			return "Användarnamnet har för få tecken, Minst 3 krävs.";
		}

		if ($password == "")
		{
			return "Lösenordet har för få tecken, Minst 6 krävs.";
		}
		else if ($password != $passwordCheck)
		{
			return "Lösenorden matcher inte.";
		}

		if ($this->CheckIfUsernameIsTaken($username)) 
		{
			return "Användarnamnet är upptaget.";
		}

		//If any other characters than the ones below, it will return true.
		if (!preg_match('/[^A-Za-z0-9-_]/', $username))
		{
			//Filtrera bort ogiltiga tecken.

			return "Användarnamnet innehåller ogiltiga tecken."
		}

	}

	public function CheckIfUsernameIsTaken($username)
	{
		if ($this->CheckUsername($username))
			return true;

		return false;
	}

	public function CheckUsername($username)
	{
		
	}
}