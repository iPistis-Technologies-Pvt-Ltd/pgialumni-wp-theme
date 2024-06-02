<?php 

session_start();

if($_POST['vercode'])

{

	if($_SESSION["vercode"]==$_POST['vercode'])

	{

		echo "successfully verified";

	}

	else

	{

		echo "Invalid captcha code.";

	}

}

?>