<?php
		 /* File: logged.php
		  * Desc: This file is used by normal users
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
<script language="Javascript" type="text/javascript">
<!--

function ValidateUpdate(name)
{
	if ( name.first_name.value == "" || name.last_name.value == "" || name.division.value == "" || name.designation.value == "" || name.location.value == "" || name.intercom.value == "" || name.email.value == "" || name.password.value == "")
	{
		alert('Please enter your complete profile.')
		return false
	}
	return true
}

function ValidateUpdateBill(name)
{
	if(<?php $_POST['Update_Status_Pending'] ?>)
	{
		if(name.date_verify.value=="" || name.approved_amount.value == "")
		{
			alert('Please enter the complete details of bill.')
			return false
		}
	}
	else if(<?php $_POST['Update_Status_Processing'] ?>)
	{
		if(name.date_received.value=="" || name.date_cash.value == "")
		{
			alert('Please enter the complete details of bill.')
			return false
		}
	}
	return true
}

function ValidateReport(name)
{
	if(<?php $_POST['generate_sanction_order'] ?>)
	{
		if(name.sanction_order.value=="")
		{
			alert('No bills selected, Sanction Order can\'t be generated.')
			return false
		}
	}
	else if (<?php $_POST['generate_covering_letter'] ?>)
	{
		if(name.covering_letter.value=="")
		{
			alert('No bills selected, Covering Letter can\'t be generated.')
			return false
		}
	}
	return true
}

-->
</script>
</head>

<body bgcolor="#EEEEEE">
<?php
if(!($_POST['submit_bill']))
{
echo "<hr>
<table border='0' cellpadding='5' cellspacing='0' align='center'>
    <td width='60%' valign='center'>
      <img border='0' src='./head.gif' align='right'>
	</td>
	<td width='40%' valign='center'>
      <img border='0' src='./cea-logo.gif' align='right'>
	</td>
</table>

<hr>
<font size= 4 color=blue><b>
		
		Welcome, ". $_SESSION['logname'];
		$user_name=$_SESSION['logname'];
	    session_register($user_name);

echo"
</b></font>

<table bgcolor='#99CCFF' border='0' width='100%'>
		<td width='15%'>
		<form action='logged.php?id=0' method='POST'><br>
		<input type='submit' name='view_bills' value='View My Bills'>
	    </form>
		</td>";

	echo "<td width='15%'>
		<form action='logged.php?id=0' method='POST'><br>
		<input type='submit' name='User_Button' value='Edit My Profile'>
		</form>
        </td>";

	 echo "<td width='15%'>
		<form action='add_bill.php?id=0' method='POST'><br>
	    <input type='submit' name='add_new_bill' value='Add New Bill'>	
		</form>
		</td>";

	echo "<td width='15%'>
		<form action='logged.php?id=0' method='POST'><br>
        <input type='submit' name='Edit_Button' value='Edit Previous Bill'>
		</form>
		</td>";

echo"	<td>
    <p align='right'><a href='index.php'>Log Out</a></td>
</table>
<hr>";
}
		?>
<table width="100%">
	<tr>
		<td bgcolor=white rowspan="4" colspan="4" ></td>
		<td>
			<?php
		  
					if(@$_POST['Update_Status_Pending']=='Update Status')
					{
						if (!ereg("^[0-9/-]{0,10}$",$_POST["date_verify"]) || !ereg("^.+/.+/.+$",$_POST['date_verify'])) 
						     {
						         $errors[] = $_POST["date_verify"]." is not a valid Date of Verification."; 
						     }
						if (!ereg("^[0-9.]{0,20}$",$_POST["approved_amount"])) 
						     {
						         $errors[] = $_POST["approved_amount"]." is not a valid Approved Amount."; 
						     }
						if(@is_array($errors))                            #150
						  {
						      $message_8 = "";
						      foreach($errors as $value)
							    {	
									$message_8 .= $value." Please try again<br>";
							    }
								$id=$id;
						  }
						else
						{
							$status_="Processing";
							$date_verify_=$_POST['date_verify'];
							$date_verify_=change2ymd($date_verify_); 
							$approved_amount_=$_POST['approved_amount'];
							$sql="UPDATE bill_process set status='$status_', date_of_verify = '$date_verify_' WHERE process_id = $id";
							$result=mysqli_query($conn,$sql) or die("Couldn't execute query feedback_2");
							$sql="SELECT bill_no FROM bill_process WHERE process_id='$id'";
							$result=mysqli_query($conn,$sql) or die("Couldn't execute query feedback_3");
							$myrow = mysqli_fetch_array($result);
							$sql="UPDATE bill SET approved_amount='$approved_amount_' WHERE bill_no='".$myrow["bill_no"]."'";
							$result=mysqli_query($conn,$sql) or die ("Couldn't execute query feedback_4"); 
							$id='0';
						}	
					}

					if(@$_POST['Update_Status_Processing']=='Update Status')
					{
						if (!ereg("^[0-9/-]{0,10}$",$_POST["date_received"]) || !ereg("^.+/.+/.+$",$_POST['date_received'])) 
						     {
						         $errors[] = $_POST["date_received"]." is not a valid Date of Received from H.O.O."; 
						     }
						if (!ereg("^[0-9/-]{0,20}$",$_POST["date_cash"]) || !ereg("^.+/.+/.+$",$_POST['date_cash'])) 
						     {
						         $errors[] = $_POST["date_cash"]." is not a valid Date of Cash."; 
						     }
						if(@is_array($errors))                            #150
						  {
						      $message_8 = "";
						      foreach($errors as $value)
							    {	
									$message_8 .= $value." Please try again<br>";
							    }
								$id=$id;
						  }
						else
						{
							$status_="Completed";
							$date_received_=$_POST['date_received'];
							$date_received_=change2ymd($date_received_);
							$date_cash_=$_POST['date_cash'];
							$date_cash_=change2ymd($date_cash_);
							$sql="UPDATE bill_process set status='$status_', date_received_hoo='$date_received_', ";
							$sql.=" date_of_cash='$date_cash_' WHERE process_id = '$id'";
							$result=mysqli_query($conn,$sql) or die("Couldn't execute query feedback_2");
							$id=0;
						}	
					}
	
					if(@$_POST['Update_profile']=='Update Now')
					{
						$f_name=$_POST['first_name'];
						$l_name=$_POST["last_name"];
						$div=$_POST["division"];
						$desg=$_POST["designation"];
						$loc=$_POST["location"];
						$inter=$_POST["intercom"];
						$em=$_POST["email"];
						$ph=$_POST["phone"];
						$sql="SELECT password FROM employee	WHERE user_name = '$user_name'";
						$result = mysqli_query($conn, $sql) or die("Couldn't execute query feedback_4");
						$myrow = mysqli_fetch_array($result);
						if($myrow["password"]==$_POST["password"])
							$pass_wd=$myrow["password"];
						else
							$pass_wd=md5($_POST['password']);
						$sql="UPDATE employee set first_name='$f_name', last_name='$l_name',division='$div',designation='$desg', 
						     location='$loc',intercom='$inter',email='$em',password='$pass_wd',phone='$ph' WHERE user_name = '$user_name'";
						$result = mysqli_query($conn, $sql) or die("Couldn't execute query feedback_3");
					}

					if($_POST['Edit_Button'] == "Edit Previous Bill")
					{
						$sql = "SELECT bill_process.process_id, bill_process.bill_no, bill_process.status, bill.date, bill.amount, ";
						$sql .= "supplier.name, file.file_no FROM bill_process JOIN bill JOIN supplier JOIN file ON ";
						$sql .= "(bill_process.bill_no=bill.bill_no AND bill_process.file_id=file.file_id AND bill.supplier_id=supplier.supplier_id)";
						$sql .= "WHERE bill_process.user_name='$user_name' ORDER BY bill_process.process_id DESC";
						$result = mysqli_query($conn,$sql) or die("Couldn't execute query feedback_5");
						echo "<font size = 3 color = blue ><u><b>".$user_name."'s "."previous registered bill(s)</u></b></font>";
						echo "<table style=WORD-BREAK : BREAK-ALL width='100%'> ";
						echo "<TR>
					      <TD width='18%' align=center><B><U>Bill Number</U></B> 
						  <TD align=center width='15%'><B><U>Supplier Name</U></B>
						  <TD align=center width='15%'><B><U>File Number</U></B>
						  <TD align=center width='10%'><B><U>Bill Date</U></B>
						  <TD width='10%' align=center><B><U>Amount</U></B>
						  <TD width='10%' align=center><B><U>Status</U></B>
						  <TD width='11%' align=center><B><U>Edit Bill</U></B>
						  <TD width='11%' align=center><B><U>Update Bill</U></B></TR>";
					$r_row_count=0;
					while ($myrow = mysqli_fetch_array($result))
					{
						if(++$r_row_count % 2 == 1 )
						{
							$tr_html	= "<tr><td bgcolor='#DDDDDD' align='center'>";
							$td_html	= "<td bgcolor='#DDDDDD' align='center'>";
						}
						else
						{
							$tr_html	= "<tr><td bgcolor='#EEEEEE' align='center'>";
							$td_html	= "<td bgcolor='#EEEEEE' align='center'>";
						}
						$my_date=change2dmy($myrow["date"]);
						echo $tr_html.$myrow["bill_no"].$td_html.$myrow["name"].$td_html.$myrow["file_no"].$td_html.$my_date.$td_html.
							 $myrow["amount"].$td_html.$myrow["status"].$td_html."<a href=\"edit_bill.php?id=".$myrow["process_id"].
							 "\">Edit</a>".$td_html;
						if($myrow["status"] != "Completed")
							echo "<a href=\"logged.php?id=".$myrow["process_id"]."\">Update</a>";
					}
					echo "</TABLE>";
					}

					else if(@$_POST['User_Button']=='Edit My Profile')
					{
						$sql="SELECT * FROM employee WHERE user_name='$user_name'";
						$result = mysqli_query($conn,$sql) or die("Couldn't execute query feedback_4");
						$myrow = mysqli_fetch_array($result);
						echo "<table border='1'>";
						echo "<form onsubmit=\"return ValidateUpdate(this)\" action ='logged.php?id=0' method='POST'>";
						echo "<tr>
								<td><b>First Name</b></td>
								<td><input type='text' name='first_name' value='".$myrow["first_name"]."'></td>
								<td><b>Last Name</b></td>
								<td><input type='text' name='last_name' value='".$myrow["last_name"]."'></td>
							  </tr>
							  <tr>
								<td><b>Division</b></td>
								<td><select size='1' name='division'>";
							  $divName=getDivName();
					       	  $divCode=getDivCode();
							  $divNo=getDivNo();
      						  for ($n=1;$n<=$divNo;$n++)
						      	{
						       		$division=$divName[$n];
        							$divcode=$divCode[$n];
				        			echo "<option value='$divcode'";
					       			if ($divcode== $myrow['division']) 
          								echo " selected";
					        		echo ">$division\n";
						      	}
				  		echo "</td>
						      <td><b>Designation</b></td>
							  <td><select size='1' name='designation'>";
							$desigName=getDesigName();
					  		$desigCode=getDesigCode();
							$desigNo=getDesigNo();
					      	for ($n=1;$n<=$desigNo;$n++)
      						{
					       		$desig=$desigName[$n];
					    		$desigcode=$desigCode[$n];
								echo "<option value='$desigcode'";
				       			if ($desigcode== $myrow['designation']) 
			          				echo " selected";
				        		echo ">$desig\n";
					      	}
						echo "</td>
						  </tr>
						  <tr>
							<td><b>Location</b></td>
							<td><input type='text' name='location' value='".$myrow["location"]."'></td>
							<td><b>Intercom</b></td>
							<td><input type='text' name='intercom' value=".$myrow["intercom"]."></td>
						  </tr>
						  <tr>
							<td><b>E-mail</b></td>
							<td><input type='text' name='email' value=".$myrow["email"]."></td>
							<td><b>Phone</b></td>
							<td><input type='text' name='phone' value=".$myrow["phone"]."></td>
						  </tr>
						  <tr>
							<td><b>Password</b></td>
							<td><input type='password' name='password' value=".$myrow["password"]."></td>
							<td><td><td><input type='submit' name='Update_profile' value='Update Now'></td>
						  </tr>
						  </form>
						  </table>";
					}

				else
				{
					if($id==0)
					{
						$sql = "SELECT bill_process.process_id, bill_process.bill_no, bill_process.status, bill.date, bill.amount, supplier.name, ";
						$sql .= "file.file_no FROM bill_process JOIN bill JOIN supplier JOIN file ON (bill_process.bill_no=bill.bill_no AND ";
						$sql .= "bill_process.file_id=file.file_id AND bill.supplier_id=supplier.supplier_id) WHERE ";
						$sql .= " bill_process.user_name='$user_name' ORDER BY bill_process.process_id DESC";
						$result = mysqli_query($conn,$sql) or die("Couldn't execute query feedback_4");
						echo "<font size = 3 color = blue ><u><b>".$user_name."'s "."previous registered bill(s)</u></b></font>";
						echo "<form onsubmit=\"return ValidateReport(this)\" target='_blank' action='letter.php' method='POST'>
						      <table style=WORD-BREAK : BREAK-ALL width='100%'> ";
						echo "<TR>
					      <TD width='18%' align=center><B><U>Bill Number</U></B> 
						  <TD align=center width='15%'><B><U>Supplier Name</U></B>
						  <TD align=center width='15%'><B><U>File Number</U></B>
						  <TD align=center width='10%'><B><U>Bill Date</U></B>
						  <TD width='10%' align=center><B><U>Amount</U></B>
						  <TD width='10%' align=center><B><U>Status</U></B>
						  <TD width='11%' align=center><B><U>Sanction Order</U></B>
						  <TD width='11%' align=center><B><U>Covering Letter</U></B></TR>";
					$r_row_count=0;
					while ($myrow = mysqli_fetch_array($result))
					{
						if(++$r_row_count % 2 == 1 )
						{
							$tr_html	= "<tr><td bgcolor='#DDDDDD' align='center'>";
							$td_html	= "<td bgcolor='#DDDDDD' align='center'>";
						}
						else
						{
							$tr_html	= "<tr><td bgcolor='#EEEEEE' align='center'>";
							$td_html	= "<td bgcolor='#EEEEEE' align='center'>";
						}
						$my_date=change2dmy($myrow["date"]);
						echo $tr_html.$myrow["bill_no"].$td_html.$myrow["name"].$td_html.$myrow["file_no"].$td_html.$my_date.$td_html.
							 $myrow["amount"].$td_html.$myrow["status"];
						if($myrow["status"] == "Processing" || $myrow["status"] == "Completed")
							echo $td_html."<input type='checkbox' name='sanction_order[]' value='".$myrow['process_id']."'>";
						else
							echo $td_html."<hr width='10%'>";
						if($myrow["status"] == "Completed")
							echo $td_html."<input type='checkbox' name='covering_letter[]' value='".$myrow["process_id"]."'>";
						else
							echo $td_html."<hr width='10%'>";
					}
					echo "<tr><td><td><td><td><td><td>
					      <td align='center'>
						  <br>
						  <input type='submit' name='generate_sanction_order' value='Generate'>
						  </td>
						  <td align='center'>
						  <br>
						  <input type='submit' name='generate_covering_letter' value='Generate'>
						  </td>";
					echo "</TABLE>
						  </form>";
				}


					else
					{
						$sql="SELECT status, bill_no FROM bill_process WHERE process_id='$id'";
						$result = mysqli_query($conn,$sql) or die("Couldn't execute query feedback_5");
						$myrow=mysqli_fetch_array($result);
						echo "<form onsubmit=\"return ValidateUpdateBill(this)\" action ='logged.php?id=$id' method='POST'>";
						if(isset($GLOBALS['message_8']))
							{
								echo"<br><font color='Red'><b><i>{$GLOBALS['message_8']}</font><br>";
							}
						echo "<table border='1'>";
						echo "<tr>
						      <td><b>Bill Number</b></td>
							  <td><name='bill_number' value='$id'>".$myrow['bill_no']. "</td>
							  </tr>";

						if($myrow['status'] == "Pending")
							{
							  echo" <tr>
							  <td><b>Date of Verification</b></td>
							  <td><input name='date_verify' type='text' ";
							  if($_POST['date_verify'])
								{
									echo " value='".$_POST['date_verify']."'";
								}
							  else
								{	
									$today = date("Y-m-d");
									$today = change2dmy($today);
									echo " value='$today' ";
								}
							  echo "</td></tr> 
							  <tr>
							  <td><b>Approved Amount</b></td>
							  <td><input type='text' name= 'approved_amount' value='".$_POST['approved_amount']."'></td>
							  </tr>
							  <tr>
							  <td></td>
							  <td><input type='submit' name='Update_Status_Pending' value='Update Status'>
							  </td></tr>";
							}

							else if($myrow['status'] == "Processing")
							{
							echo" <tr>
							  <td><b>Date Received from H.O.O</b></td>
							  <td><input name='date_received' type='text' ";
							  if($_POST['date_received'])
								{
									echo " value='".$_POST['date_received']."'";
								}
							  else
								{	
									$today = date("Y-m-d");
									$today = change2dmy($today);
									echo " value='$today' ";
								}
							  echo "</td></tr> 
							  <tr>
							  <td><b>Date of Cash</b></td>
							  <td><input name='date_cash' type='text' ";
							  if($_POST['date_cash'])
								{
									echo " value='".$_POST['date_cash']."'";
								}
							  else
								{	
									$today = date("Y-m-d");
									$today = change2dmy($today);
									echo " value='$today' ";
								}
							  echo "</td></tr>
							  <tr>
							  <td></td>
							  <td><input type='submit' name='Update_Status_Processing' value='Update Status'>
							  </td></tr>";
							}
							echo" </table>
							  </form>";
					}
				}
		?>
		</td>
	</tr>
</table>
<?php
if(!($_POST['submit_bill']))
{
echo "<hr>
<p align = 'center'><u><i>Developed by IT Division CEA</i></u></p>";
}
?>
</body>
</html>