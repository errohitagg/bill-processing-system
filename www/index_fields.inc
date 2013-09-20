<?php

	/* File: fields_login.inc
	 * Desc: Contains arrays with the field names and form
	 *       elements for the login Web page.
	*/


$page = array( "title"  => "Bill Processing System",
               "top"    => "CENTRAL ELECTRICITY AUTHORITY",
               "bottom" => "Developed by IT Division CEA",
             );

$elements_1 = array( "top"    => "Log in for Bill Processing : <span style=\"font-size : 80%; font-weight : 100%\">
                                  <i>Login here</i></span>",
                     "bottom" => "",
                     "submit" => "Login"
                   );

$elements_2 = array("top"    => "Register for new login : <span style=\"font-size : 80%; font-weight : 100%\">
                                 <i>Register here</i></span>",
                    "bottom" => "",
                    "submit" => "Register"
                   );

$fields_1 =   array("fusername" => "User Name",
                    "fpassword" => "Password"
                   );

$length_1 =   array("fusername" => "20",
                    "fpassword" => "15"
                   );

$fields_2 =   array("user_name"      => "User Name",
                    "password"       => "Password",
                    "email"          => "Email Address",
                    "first_name"     => "First Name",
                    "last_name"      => "Last Name",
		    "designation"    => "Designation",
                    "division"       => "Division",
                    "location" 	     => "Location",
                    "intercom"       => "Intercomm No.",
                    "phone"          => "Phone (if any)"
                   );

$length_2 =   array("user_name"      => "20",
                    "password"       => "15",
                    "email"          => "40",
                    "first_name"     => "30",
                    "last_name"      => "30",
		    "designation"    => "40",
                    "division"       => "40",
                    "location"       => "25",
                    "intercom"       => "7",
                    "phone"          => "15"
                   ); 

?>