<?php
		/* Program: Login.php
		 * Desc:    Main application script for the User Login
		 *          application. It provides two options: (1) login
		 *          using an existing User Name and (2) register
		 *          a new user name. User Names and passwords are
		 *          stored in a MySQL database. 
		*/

  session_start();                                       
  include_once("connect_function.inc");                    
  $table_name = "employee";                              
  $next_program = "logged.php";
  $conn = Connect_to_db("variable.inc");
  $id=0;

  switch (@$_POST['Button'])                             
  {
    case "Login":                                        
				  $sql = "SELECT user_name FROM $table_name WHERE user_name='$_POST[fusername]'";      
				  $result = mysqli_query($conn,$sql) or die("Couldn't execute query 1.");     
			      $num = mysqli_num_rows($result);
				  if($num == 1)                                      
					{
				     $sql = "SELECT user_name FROM $table_name WHERE user_name='$_POST[fusername]' AND password=md5('$_POST[fpassword]')";
					 $result2 = mysqli_query($conn,$sql) or die("Couldn't execute query 2.");  
				     $row = mysqli_fetch_assoc($result2);            
					 if($row)                                        
						{
							$_SESSION['auth']="yes";                 
							$_SESSION['logname'] = $_POST['fusername'];   
							include("$next_program");
						}
					 else                                            
						{
						    $message_1="The Login Name, '$_POST[fusername]' exists, but you have not entered the correct password! Please try again.<br>";
						    include("index_fields.inc");
						    include("index_form.inc");
						}                                            
					}                                                  
			      else if ($num == 0)         
					{
						$message_1 = "The User Name you entered does not exist! Please try again.<br>";
				        include("index_fields.inc");
						include("index_form.inc");
					}
				  break;              

    case "Register":                  
				     /* Check for blanks */
				     if($_POST['user_name'] == "")                                              
						 $blanks[] = "User Name";
					if($_POST['password'] == "")                                              
						 $blanks[] = "Password";
					if($_POST['email'] == "")                                              
						 $blanks[] = "E-Mail ID";
					if($_POST['first_name'] == "")                                              
						 $blanks[] = "First Name";
					if($_POST['last_name'] == "")                                              
						 $blanks[] = "Last Name";
					if($_POST['designation'] == "")                                              
						 $blanks[] = "Designation";
					if($_POST['division'] == "")                                              
						 $blanks[] = "Division";
					if($_POST['location'] == "")                                              
						 $blanks[] = "Location";
					if($_POST['intercom'] == "")                                              
						 $blanks[] = "Intercom";
					if(isset($blanks))                                 
				       {
				          $message_2 = "The following fields are blank. Please enter the required information :  ";
				          foreach($blanks as $value)
							{
					            $message_2 .="$value, ";
					        }
				          include("index_fields.inc");
				          include("index_form.inc");
						  break;
					   }                                                  

					/* validate data */
					if (!ereg("^[A-Za-z'. ]{1,50}$", $_POST['first_name'])) 
					     {
					         $errors[] = "$value is not a valid First Name."; 
					     }
					if (!ereg("^[A-Za-z'. ]{1,50}$", $_POST['last_name'])) 
					     {
					         $errors[] = "$value is not a valid Last Name."; 
					     }
					if (!ereg("^[A-Za-z0-9'., -]{1,50}$", $_POST['location'])) 
						 {
					         $errors[] = "$value is not a valid Location."; 
					     }
					if(!ereg("^.+@.+\\..+$",$_POST['email']))
					     {
					         $errors[] = "$value is not a valid E-Mail Address.";
					     }
		            if(!ereg("^[0-9()]{4}$",$_POST['intercom']))
					     {
					         $errors[] = "$value is not a valid Intercomm Number. ";
					     }
					if($_POST['phone']!="")
						{	
				            if(!ereg("^[0-9]{8,11}$",$_POST['phone']))
					             {
						                $errors[] = "$value is not a valid Phone Number. ";
							     }
					    }

				    if(@is_array($errors))                            #150
				      {
				        $message_2 = "";
				        foreach($errors as $value)
					        {
					           $message_2 .= $value." Please try again<br />";
							}
						include("index_fields.inc");
				        include("index_form.inc");
						break;
					  } 

			      $user_name = $_POST['user_name'];                                                #139
			      /* check to see if user name already exists */
			      $sql = "SELECT user_name FROM $table_name WHERE user_name='$user_name'"; #158
			      $result = mysqli_query($conn,$sql) or die("Couldn't execute query.");
			      $num = mysqli_num_rows($result);                  #169
			      if ($num > 0)                                     #170
			      {
			        $message_2 = "$user_name already used. Select another User Name.";
			        include("index_fields.inc");
			        include("index_form.inc");
			        break;
			      }
			      else                                              #178
			      { 
					$store_user_name=$_POST['user_name'];
					$store_password=$_POST['password'];
					$store_email=$_POST['email'];
					$store_first_name=$_POST['first_name'];
					$store_last_name=$_POST['last_name'];
					$store_designation=$_POST['designation'];
					$store_division=$_POST['division'];
					$store_location=$_POST['location'];
					$store_intercom=$_POST['intercom'];
					if($_POST['phone']!="")
					  {
						$store_phone=$_POST['phone'];
					  }
			        $store_today = date("Y-m-d");                         #180
					$store_user_name = strip_tags(trim($store_user_name));
			        $values[] = addslashes($store_user_name);
					$store_email = strip_tags(trim($store_email));
			        $values[] = addslashes($store_email);
					$store_first_name = strip_tags(trim($store_first_name));
			        $values[] = addslashes($store_first_name);
					$store_last_name = strip_tags(trim($store_last_name));
			        $values[] = addslashes($store_last_name);
					$store_designation = strip_tags(trim($store_designation));
			        $values[] = addslashes($store_designation);
					$store_division = strip_tags(trim($store_division));
			        $values[] = addslashes($store_division);
					$store_location = strip_tags(trim($store_location));
			        $values[] = addslashes($store_location);
					$store_intercom = strip_tags(trim($store_intercom));
			        $values[] = addslashes($store_intercom);
					$store_today = strip_tags(trim($store_today));
			        $values[] = addslashes($store_today);
					if($_POST['phone']!="")
					  {
						$store_phone = strip_tags(trim($store_phone));
			            $values[] = addslashes($store_phone);
						}
					$values_str = implode('","',$values);
			        $values_str .= '"'.","."md5"."('".$store_password."')";
			        $sql = "INSERT INTO $table_name (user_name,email,first_name,last_name,designation,division,location,intercom,create_date,";
					if($_POST['phone']!="")
						$sql.="phone,";
					$sql.="password) VALUES (".'"'.$values_str.")";
			        mysqli_query($conn,$sql) or die(mysqli_error($conn));                 

			        $_SESSION['auth']="yes";                        
			        $_SESSION['logname'] = $store_user_name;              
			
					/* send email to new Customer 
			        $emess = "You have successfully registered. ";
			        $emess .= "Your new user name and password are: ";
			        $emess .= "\n\n\t$user_name\n\t";
			        $emess .= "$store_password\n\n";
			        $emess .= "We appreciate your interest. \n\n";
			        $emess .= "If you have any questions or problems,";
			        $emess .= " email service@ourstore.com";        
			        $subj = "Your new customer registration";       
			        #$mailsend=mail("$email","$subj","$emess");     
					#header("Location: $next_program?$user_name");*/

					include($next_program);
			      }
			    break;                                              

    default:
			$_SESSION['auth']="no";                     
			$_SESSION['logname'] ="";
			include("index_fields.inc");
			include("index_form.inc");
  }

?>