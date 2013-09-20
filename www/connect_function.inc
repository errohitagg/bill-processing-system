<?php

	/* Function:  Connect_to_db
	*  Desc	   :  Connects to a MySQL database. The name of the file containing the database variables
	*             is passed to the function.
	*/

	function Connect_to_db($filename)
	{
		include($filename);
	        $connection = mysqli_connect($host, $user,$password) or die ("Couldn't connect to the server.");
	        $db = mysqli_select_db($connection,$database) or die ("Couldn't select the database.");
	        return $connection;     
	}

?>