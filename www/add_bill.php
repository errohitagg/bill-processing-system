<?php
	/* File: add_bill.php
	 * Desc: This file is used by normal users to add new bills
	*/

	include_once("connect_function.inc"); 
	include_once("index_functions.inc");
	$conn = Connect_to_db("Variable.inc");
	if(!session_is_registered('logname'))
		session_start();
	if($_SESSION['auth']!="yes")
		header("Location:index.php");
?>

<html>
<head>
<title>Bill Page </title>
<link rel="stylesheet" type="text/css" href="comp_style.css" />
</head>

<body bgcolor="#EEEEEE">

<hr>
<table border="0" cellpadding="5" cellspacing="0" align="center">
	<td width="60%" valign="center">
	<img border="0" src="./head.gif" align="right">
	</td>
	<td width="40%" valign="center">
      	<img border="0" src="./cea-logo.gif" align="right">
	</td>
</table>

<hr>
<font size= 4 color=blue><b>
<?php
	echo "Welcome, ". $_SESSION['logname'];
	$user_name=$_SESSION['logname'];
	session_register($user_name);
?>
</b></font>

<table bgcolor="#99CCFF" border="0" width="100%">	
	<td width='15%'>
		<form action='logged.php?id=0' method="POST"><br>
		<input type='submit' name='view_bills' value='View My Bills'>
		</form>
    	</td>

	<td width="15%">
		<form action="logged.php?id=0" method="POST"><br>
		<input type="submit" name="User_Button" value='Edit My Profile'>
		</form>
    	</td>

	<td width='15%'>
 	    	<form action='add_bill.php' method='POST'><br>
		<input type='submit' name='add_new_bill'  value='Add New Bill'>
		</form>
    	</td>

	<td width="15%">
		<form action="logged.php?id=0" method="POST"><br>
        	<input type="submit" name="Edit_Button" value='Edit Previous Bill'>
        	</form>
   	</td>

	<td>
    		<p align="right"><a href="index.php">Log Out</a>
	</td>
</table>

<hr>

<table width="100%">
	<tr>
	<td bgcolor=white rowspan="4" colspan="4" ></td>
	<td>
	<?php
	
		if($_POST['supplier_button']=='Add Supplier' || $_POST['budget_button']=="Add Budget Head" || $_POST['item_button']=="Add Item"||
		   $_POST['file_button']=="Add File Number" || $_POST['add_new_bill']=='Add New Bill' || $_POST['add_button'] || $_POST['more_details'])
		{
		  	switch($_POST['add_button'])
			{
				case "Add Supplier":

					/* Check for blanks */                          
					{
						if($_POST["supplier_name_"] == "")
							$blanks[]="Supplier Name";
						if($_POST["supplier_add_"] == "")
							$blanks[]="Supplier Address";
						if(isset($blanks))                                 
						{
							$message_4 = "The following fields are blank. Please enter the required information :  ";
							foreach($blanks as $value)
							{
								$message_4 .="$value, ";
						        }
							break;
					   	}
					}

					/* validate data */
					if(!(isset($blanks)))                              
				  	{
						if (!ereg("^[A-Za-z.&/ -]{1,50}$",$_POST["supplier_name_"])) 
						{
							$errors[] = $_POST["supplier_name_"]." is not a valid Supplier Name."; 
						}
						if(!ereg("^[A-Za-z0-9.,/' -]{1,50}$",$_POST["supplier_add_"]))
						{
							$errors[] = $_POST["supplier_add_"]." is not a valid Supplier Address.";
					        }
					}

					if(@is_array($errors))                           
					{
						$message_4 = "";
						foreach($errors as $value)
						{	
							$message_4 .= $value." Please try again<br>";
					    	}
					}
					else
					{
						$store_supplier_name = $_POST["supplier_name_"];
						$store_supplier_add = $_POST["supplier_add_"];
						$store_supplier_name = strip_tags(trim($store_supplier_name));
			              		$values[] = addslashes($store_supplier_name);
						$store_supplier_add = strip_tags(trim($store_supplier_add));
			              		$values[] = addslashes($store_supplier_add);
						$values_str = implode('","',$values);
						$sql = "INSERT INTO supplier (Name,Address)";
						$sql .= " VALUES ";
						$sql .= "(".'"'.$values_str.'"'.")";
						mysqli_query($conn,$sql) or die(mysqli_error($conn)); 
					}
					break;

				case "Add Budget Head":
					
					/* Check for blanks */
					{
						if($_POST["budget_head_"] == "")
							$blanks[]="Budget Head";
						if($_POST["start_year_"] == "")
							$blanks[]="Start Year";
						if($_POST["end_year_"] == "")
							$blanks[]="End Year";
						if($_POST["budget_amount_"] == "")
							$blanks[]="Budget Amount";
						if(isset($blanks))                                
					       	{
							$message_5 = "The following fields are blank. Please enter the required information :  ";
							foreach($blanks as $value)
							{
								$message_5 .="$value, ";
							}
							break;
						}	
					}
					
					/* validate data */
					if(!(isset($blanks)))                              
				  	{
						if (!ereg("^[A-Za-z0-9.&/ -]{1,50}$",$_POST["budget_head_"])) 
							{
								$errors[] = $_POST["start_year_"]." is not a valid Start Year."; 
						      	}
					      	if (!ereg("^[0-9]{4}$",$_POST["start_year_"])) 
						      	{
							        $errors[] = $_POST["start_year_"]." is not a valid Start Year."; 
							}
						if (!ereg("^[0-9]{4}$",$_POST["end_year_"])) 
						      	{
							        $errors[] = $_POST["end_year_"]." is not a valid End Year."; 
							}
						if(!ereg("^[0-9.]{1,50}$",$_POST["budget_amount_"]))
						        {
						              	$errors[] = $_POST["budget_amount"]." is not a valid Budget Amount.";
							}
				  	}

					if(@is_array($errors))                           
				  	{
						$message_5 = "";
						foreach($errors as $value)
						{	
							$message_5 .= $value." Please try again<br />";
					    	}
					}

					else
				  	{
						$store_budget_head = $_POST["budget_head_"];
						$store_start_year = $_POST["start_year_"];
						$store_end_year = $_POST["end_year_"];
						$store_budget_amount = $_POST["budget_amount_"];
						$store_budget_head = strip_tags(trim($store_budget_head));
			              		$values[] = addslashes($store_budget_head);
						$store_start_year = strip_tags(trim($store_start_year));
			              		$values[] = addslashes($store_start_year);
						$store_end_year = strip_tags(trim($store_end_year));
			              		$values[] = addslashes($store_end_year);
						$store_budget_amount = strip_tags(trim($store_budget_amount));
			              		$values[] = addslashes($store_budget_amount);
						$values_str = implode('","',$values);
						$sql = "INSERT INTO budget (budget_head,start_year,end_year,amount)";
						$sql .= " VALUES ";
						$sql .= "(".'"'.$values_str.'"'.")";
						mysqli_query($conn,$sql) or die(mysqli_error($conn)); 
					}
					break;
					
				case "Add Item":

					/* Check for blanks */
					{
						if($_POST["item_name_"] == "")
							$blanks[]="Item Name";
						if($_POST["item_details_"] == "")
							$blanks[]="Item Details";
						if(isset($blanks))                                
						{
					  		$message_6 = "The following fields are blank. Please enter the required information :  ";
							foreach($blanks as $value)
							{
								$message_6 .="$value, ";
						        }
						        break;
						}
					}
												
					$store_item_name = $_POST["item_name_"];
					$store_item_details = $_POST["item_details_"];
					$store_item_name = strip_tags(trim($store_item_name));
			              	$values[] = addslashes($store_item_name);
					$store_item_details = strip_tags(trim($store_item_details));
			              	$values[] = addslashes($store_item_details);
					$values_str = implode('","',$values);
					$sql = "INSERT INTO item (item_name,item_details)";
					$sql .= " VALUES ";
					$sql .= "(".'"'.$values_str.'"'.")";
					mysqli_query($conn,$sql) or die(mysqli_error($conn)); 
					break;
					
				case "Add File Number":

					/* Check for blanks */
					{
						if($_POST["file_number_"] == "")
							$blanks[]="File Number";
						if(isset($blanks))                                 
					      	{
							$message_7 = "The following fields are blank. Please enter the required information :  ";
							foreach($blanks as $value)
							{
								$message_7 .="$value, ";
						        }
						        break;
					   	}
					}

					/* validate data */
					if(!(isset($blanks)))                             
				  	{
						if (!ereg("^[A-Za-z0-9.&/ -]{1,50}$",$_POST["file_number_"])) 
							{
								$errors[] = $_POST["start_year_"]." is not a valid Start Year."; 
							}
					}

				    	if(@is_array($errors))                           
				  	{
						$message_5 = "";
						foreach($errors as $value)
						{	
							$message_5 .= $value." Please try again<br />";
					    	}
					}
					else
					{
					   	$store_file_number = $_POST["file_number_"];
						$store_file_number = strip_tags(trim($store_file_number));
			              		$values[] = addslashes($store_file_number);
						$values_str = implode('","',$values);
						$sql = "INSERT INTO file (file_no)";
					    	$sql .= " VALUES ";
						$sql .= "(".'"'.$values_str.'"'.")";
						mysqli_query($conn,$sql) or die(mysqli_error($conn)); 
					}
					break;
			}
			include("add_bill_fields.inc");
			include("add_bill_form.inc");
		}

		else if($_POST['submit_bill']=='Submit Bill')
		{

	 		/* Check for blanks */
			{
				if($_POST["bill_no"] == "")
					$blanks[]="Bill Number";
				if($_POST["bill_date"] == "")
					$blanks[]="Bill Date";
				if($_POST["receipt_date"] == "")
					$blanks[]="Date of Receipt";
				if($_POST["head_select"] == "")
					$blanks[]="Budget Head";
				if($_POST["file_select"] == "")
					$blanks[]="File Number";
				if($_POST["bill_type_select"] == "")
					$blanks[]="Bill Type";
				if($_POST["bill_type_select"] != "Procurement")
				{
					if($_POST["bill_start_date"] == "")
						$blanks[]="Bill Start Date";
					if($_POST["bill_end_date"] == "")
						$blanks[]="Bill End Date";
				}
				if($_POST["item_select"] == "")
					$blanks[]="Item";
				if($_POST["supplier_select"] == "")
					$blanks[]="Supplier";
				if($_POST["amount"] == "")
					$blanks[]="Amount";
				if(isset($blanks))                                
				{
					$message_3 = "The following fields are blank. Please enter the required information :  ";
				  	foreach($blanks as $value)
					{
						$message_3 .="$value, ";
				       	}
					include("add_bill_fields.inc");
					include("add_bill_form.inc");
				}
			}

			/* validate data */
			if(!(isset($blanks)))                              
			{
		      		if (!ereg("^[0-9.]{0,20}$",$_POST["bill_amount"])) 
				{
					$errors[] = $_POST["bill_amount"]." is not a valid Bill Amount."; 
			     	}
				if (!ereg("^[0-9/]{0,10}$",$_POST["bill_date"]) || !ereg("^.+/.+/.+$",$_POST['bill_date'])) 
				{
				        $errors[] = $_POST["bill_date"]." is not a valid Bill Date."; 
				}
				if (!ereg("^[0-9/]{0,10}$",$_POST["receipt_date"]) || !ereg("^.+/.+/.+$",$_POST['receipt_date'])) 
				{
				        $errors[] = $_POST["bill_date"]." is not a valid Date of Receipt."; 
				}
				if($_POST["bill_type_select"] != "Procurement")
				{
					if (!ereg("^[0-9/]{0,10}$",$_POST["bill_start_date"]) || !ereg("^.+/.+/.+$",$_POST['bill_start_date'])) 
				    	{
				   	     	$errors[] = $_POST["bill_date"]." is not a valid Bill Start Date."; 
					}
					if (!ereg("^[0-9/]{0,10}$",$_POST["bill_end_date"]) || !ereg("^.+/.+/.+$",$_POST['bill_end_date'])) 
					{
						$errors[] = $_POST["submitted"]." is not a valid Bill End Date."; 
					}
				}
						
				if(@is_array($errors))                          
				{
					$message_3 = "";
					foreach($errors as $value)
					{	
						$message_3 .= $value." Please try again<br />";
					}
					include("add_bill_fields.inc");
					include("add_bill_form.inc");
				}
				else
				{
					$store_user_name = $user_name;
					$store_bill_number = $_POST["bill_no"];
					$store_supplier = $_POST["supplier_select"];
					$store_bill_date = $_POST["bill_date"];
					$store_bill_date = change2ymd($store_bill_date);
					$store_receipt_date = $_POST['receipt_date'];
					$store_receipt_date = change2ymd($receipt_date);
					$store_bill_amount = $_POST["amount"];
					$store_bill_type = $_POST['bill_type_select'];
					$store_budget_head = $_POST["head_select"];
					$store_file = $_POST["file_select"];
					if($_POST['bill_type_select']!= 'Procurement')
					{
						$store_bill_start = $_POST['bill_start_date'];
						$store_bill_start = change2ymd($store_bill_start);
						$store_bill_end = $_POST['bill_end_date'];
						$store_bill_end = change2ymd($store_bill_end);
				 	}
					$store_item = $_POST['item_select'];

					$store_bill_number = strip_tags(trim($store_bill_number));
			    	$values[] = addslashes($store_bill_number);
					$store_supplier = strip_tags(trim($store_supplier));
			            	$values[] = addslashes($store_supplier);
					$store_bill_date = strip_tags(trim($store_bill_date));
			            	$values[] = addslashes($store_bill_date);
					$store_bill_amount = strip_tags(trim($store_bill_amount));
			      		$values[] = addslashes($store_bill_amount);
					$store_budget_head = strip_tags(trim($store_budget_head));
			            	$values[] = addslashes($store_budget_head);
					$store_bill_type = strip_tags(trim($store_bill_type));
					$values[] = addslashes($store_bill_type);
					if($_POST['bill_type_select'] != 'Procurement')
					{
						$store_bill_start = strip_tags(trim($store_bill_start));
						$values[] = addslashes($store_bill_start);
						$store_bill_end = strip_tags(trim($store_bill_end));
						$values[] = addslashes($store_bill_end);
					}
						
					$values_str = implode('","',$values);
					$sql = "INSERT INTO bill (bill_no,supplier_id,date,amount,budget_id,bill_type";
					if($_POST['bill_type_select'] != 'Procurement')
					{
						$sql.=",start_date,end_date";
					}
					$sql .= ") VALUES ";
					$sql .= "(".'"'.$values_str.'"'.")";
					mysqli_query($conn,$sql) or die(mysqli_error($conn)); 

					$store_bill_number = strip_tags(trim($store_bill_number));
				  	$values_2[] = addslashes($store_bill_number);
					$store_file = strip_tags(trim($store_file));
			           	$values_2[] = addslashes($store_file);
					$store_receipt_date = strip_tags(trim($store_receipt_date));
			            	$values_2[] = addslashes($store_receipt_date);
					$store_user_name = strip_tags(trim($store_user_name));
					$values_2[] = addslashes($store_user_name);
					$status = "Pending";
					$values_2[] = addslashes($status);
					$values_str_2 = implode('","',$values_2);
					$sql = "INSERT INTO bill_process (bill_no,file_id,date_of_receipt,user_name,status)";
					$sql .= " VALUES ";
					$sql .= "(".'"'.$values_str_2.'"'.")";
					mysqli_query($conn,$sql) or die(mysqli_error($conn));
					
					foreach($store_item as $item_store_)
					{
						$store_bill_number = strip_tags(trim($store_bill_number));
						$store_bill_number = addslashes($store_bill_number);
						$item_store_ = strip_tags(trim($item_store_));
						$item_store_ = addslashes($item_store_);
						$sql = "INSERT INTO bill_item VALUES (".'"'.$store_bill_number.'","'.$item_store_.'"'.")";
						mysqli_query($conn,$sql) or die(mysqli_error($conn));
					}
				}

					include("logged.php");
				}
		}
		
	?>
	</td>
	</tr>
</table>

<hr>
<p align = "center"><u><i>Developed by IT Division CEA</i></u></p>
</body>

</html>