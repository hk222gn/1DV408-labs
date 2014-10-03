<?php

class HTMLRenderer
{
	public function RenderHTML($body = "", $head = "")
	{
		if ($body === NULL) 
		{
			$body = "NULL";
		}

		$day = utf8_encode(strftime("%A"));

		echo 	"
				<!DOCTYPE html>
				<html lang=\"sv\">
				<head>
					<title>Lab2</title>
					<meta charset=\"utf-8\">
					$head
				</head>
				<body>
					$body"
					. "<br/><br/>" 
					. strftime("$day, den %d %B år %Y. Klockan är [%X].") //gmdate("[H:i:s].", time() + 2 * 60 * 60)
				. "</body>
				</html>";
	}
}