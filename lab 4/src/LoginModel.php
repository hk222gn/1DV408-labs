<?php
require_once("src/UserRepository.php");

class LoginModel
{
	private static $usernameSession = "loggedIn";
	private static $userAgentSession = "userAgent";
	private static $userIPSession = "userIP";
	//private $password = "Password";
	//private $username = "Admin";
	private $loginStatus = false;
	private $userRepository;

	public function __construct()
	{
		$this->userRepository = new UserRepository();
	}

	public function GetLoginStatus()
	{
		return $this->loginStatus;
	}

	public function SaveUserSpecificInformation($userAgent, $userIP)
	{
		$_SESSION[self::$userAgentSession] = $userAgent;
		$_SESSION[self::$userIPSession] = $userIP;
	}

	public function GetSavedUserAgent()
	{
		if (isset($_SESSION[self::$userAgentSession]))
		{
			return $_SESSION[self::$userAgentSession];
		}
		return false;
	}

	public function GetSavedUserIP()
	{
		if (isset($_SESSION[self::$userIPSession]))
		{
			return $_SESSION[self::$userIPSession];
		}
		return false;
	}

	public function IsLoggedIn($userAgent, $userIP)
	{
		if (isset($_SESSION[self::$usernameSession]) && $this->GetSavedUserAgent() === $userAgent && $this->GetSavedUserIP() === $userIP)
		{
			return true;
		}
		return false;
	}

	public function Logout()
	{
		$this->loginStatus = false;
		if (isset($_SESSION[self::$usernameSession])) 
		{
			unset($_SESSION[self::$usernameSession]);

			return "Du har nu loggats ut";
		}
		return "Utloggningen har misslyckats.";
	}

	public function GetUsername()
	{
		if (isset($_SESSION[self::$usernameSession])) 
		{
			return $_SESSION[self::$usernameSession];
		}
		return false;
	}

	public function Login($user, $pw, $cookie = false)
	{
		if ($user === "") 
		{
			return "Användarnamnet saknas!";
		}

		if ($pw === "") 
		{

			return "Lösenordet saknas!";
		}
		//Remove whitespace and convert to lower case, all usernames are lowercase.
		trim($user);
		//$user = strtolower($user);

		//Check the provided login information
		if($this->CheckUserLogin($user, $pw, $cookie))
		{
			//Login the user.
			$_SESSION[self::$usernameSession] = $user;
			$this->loginStatus = true;

			if($cookie)
				return "Inloggningen lyckades med cookies!";

			return "Inloggningen lyckades!";
		}
		else //We give the user a error message if the authentication failed.
		{
			if ($cookie)
			{
				return "Felaktig information i cookie";
			}
			else
				return "Fel användarnamn och/eller lösenord!";
		}
	}

	//Checks if the username and password exists and are correct.
	public function CheckUserLogin($name, $pw, $cookie)
	{
		$user = $this->userRepository->GetUserByName($name);

		if ($user == NULL)
			return false;

		if ($cookie)
		{
			//Check if the cookie has expired.
			if ($user->GetTempPWExpiration() < time()) 
				return false;

			//Compare the password in the temp password text file.
			if ($user->GetName() == $name && $user->GetTempPW() == $pw) 
				return true;
		}
		else
		{
			if ($user->GetName() == $name && $user->GetPassword() == $pw)
				return true;
		}

		return false;
	}

	public function CreateOneTimePassword($name)
	{
		$signs = "1234567890";
		$strLength = strlen($signs) - 1;
		$tempPW = "";
		
		//Create the random password based on the $signs string.
		for ($i = 0; $i < 12; $i++) 
		{
			$rand = rand(0, $strLength);
			$tempPW .= $signs[$rand];
		}

		$this->userRepository->SetTempPW($name, $tempPW);

		return $tempPW;
	}

	//public function GetOneTimePassword($user)
	//{
	//	return file_get_contents($user);
	//}

	public function StoreCookieExpirationTime($name, $cookieExpirationTime)
	{
		$this->userRepository->SetTempPWExpiration($name, $cookieExpirationTime);
		//file_put_contents("CookieExpirationTime", $cookieExpirationTime);
	}

	//public function GetCookieExpirationTime()
	//{
	//	return file_get_contents("CookieExpirationTime");
	//}
}