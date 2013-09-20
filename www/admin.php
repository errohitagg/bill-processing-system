<?php
 /* File: admin.php
  * Desc: This file is used by administrator
*/
	include_once("functions_main.inc"); 
	$cxn = Connect_to_db("Vars.inc");
?>

<html>
<head><title>Admin Page </title>
<link rel="stylesheet" type="text/css" href="compstyle.css" />
<script language="Javascript" type="text/javascript">
<!--
function ValidateClick(name)
{
	if ( name.comment.value == "")
	{
		alert('Please enter complaint details.')
		return false
	}
	return true
}

function ValidateUpdate(name)
{
	if ( name.first_name.value == "" || name.last_name.value == "" || name.division.value == "" || name.designation.value == "" || name.location.value == "" || name.intercom.value == "" || name.email.value == "" || name.password.value == "")
	{
		alert('Please enter your complete profile.')
		return false
	}
	return true
}
-->
</script>
</head>

<body bgcolor="#EEEEEE">
<?php
	include("functions.inc");
	if(!session_is_registered('logname'))
		session_start();
?>
<hr>
<table width="100%" border="0" cellpadding="5" cellspacing="0">
    <td width="80%" valign="center">
      <img border="0" src="./head.gif" align="right"></td>

<td width="20%" valign="center">
      <img border="0" src="./cea-logo.gif" align="right"></td>

</table>
<hr>
	<font size= 4 color=blue><b>
	<?php
		echo "Welcome, ". $_SESSION['logname']." (Administrator)";
		$user_name=$_SESSION['logname'];
	    session_register($user_name);
 	?>
	</b></font>
<table bgcolor="#99CCFF" border="0" width="100%">
   	<td width="22%">
	<form action="admin.php?id=0" method="POST">
	<table border="0" width="100%">
		<td colspan="2" style="text-align: center" >
              <br />
            <input type="submit" name="User_Button"	value="Edit My Profile">
		</td>
		<td colspan="2" style="text-align: center" >
              <br />
            <input type="submit" name="User_Button"	value="User Details">
		</td>
		<td colspan="2" style="text-align: center" >
              <br />
            <input type="submit" name="User_Button"	value="Add Complaint">
		</td>
		<td colspan="2" style="text-align: center" >
              <br />
            <input type="submit" name="User_Button"	value="Manage Complaints">
			
		</td>
    </table>
    </form>
    </td>
    <td width="77%">
      <p align="right"><a href="index.php">Log Off</a></td>
</table>
<hr>
<table width="100%">
	<td width="40%"> 
		<?php
			$cxn = Connect_to_db("Vars.inc");
			if($user_browse)
			{
				echo "User ID is:".$user_browse;
			}
			if($user_click)
			{
				echo "User clicked is:".$user_click;
			}
			if(!isset($user_click) && !isset($user_browse))
			{
				switch(@$_POST['User_Button'])
				{
					default:
						echo "<p><u><b> View Real Time Complaint Status</b></u></p>";
						$time_a=20000;
						$time=date("h:i",time()+$time_a);
						echo "Today is : ".date("d-M-Y"); 
						echo "  " . $time;
				}
			}
		?>
	</td>
	<td bgcolor= white rowspan="4" colspan="4" ></td>
	<td width="60%">

		<?php
		switch(@$_POST['User_Button'])
		{
			case "Edit My Profile":
				$sql="SELECT * FROM employee 
					WHERE user_name='$user_name'";
				$result = mysqli_query($cxn,$sql)
					or die("Couldn't execute query feedback_4");
				$myrow = mysqli_fetch_array($result);
				echo "<table width='100%' border='1'><tr>";
				echo "<form onsubmit=\"return ValidateUpdate(this)\" action ='admin.php?id=0'			method='POST'>";
				echo "<td width='20%'><b>First Name</b></td><td width='30%'><input type='text' name='first_name' value='".$myrow["first_name"]."'";
				echo "></td>";
				echo "<td width='20%'><b>Last Name</b></td><td width='20%'><input type='text' name='last_name' value='".$myrow["last_name"]."'";
				echo "></td></tr><tr>";
				echo "<td width='20%'><b>Division</b></td><td width='30%'><select size='1' name='division'>";
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
				echo "</td><td width='20%'>";
				echo "<b>Designation</b></td><td width='30%'><select size='1' name='designation'>";
				
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
				echo "</td></tr><tr><td width='20%'>";
				echo "<b>Location</b></td><td width='30%'><input type='text' name='location' value='".
					$myrow["location"]."'";
				echo "></td><td width='20%'>";
				echo "<b>Intercom</b></td><td width='30%'><input type='text' name='intercom' value=".$myrow["intercom"];
				echo "></td></tr><tr><td width='20%'>";
				echo "<b>E-mail</b></td><td width='30%'><input type='text' name='email' value=".$myrow["email"];
				echo "></td><td width='20%'>";
				echo "<b>Phone</b></td><td width='30%'><input type='text' name='phone' value=".$myrow["phone"];
				echo "></td></tr><tr><td width='20%'>";
				echo "<b>Password</b></td><td width='30%'><input type='password' name='password' value=".$myrow["password"];
				echo "></td<td>";
				echo "<td><td><input type='submit' name='Update_profile' value='Update Now'></td></tr></form></table>";
				break;
			case "User Details":
				$sql="SELECT * FROM employee ORDER BY user_name DESC";
				$result = mysqli_query($cxn,$sql)
					or die("Couldn't execute query feedback_3");
		
				echo "<table>";
				echo "<TR><TD align=center><B><U>User ID</U></B> 
				<TD align=center><B><U>Name</U></B>
				<TD align=center><B><U>Designation</U></B>
				<TD align=center><B><U>Division</U></B>
				<TD align=center><B><U>Intercom</U></B>
				<TD align=center><B><U>Details</U></B>
				<TD align=center><B><U>Complaints</U></B></TR>";
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
					echo $tr_html.$myrow["user_name"].$td_html.$myrow["first_name"]." ".$myrow["last_name"].$td_html.$myrow["designation"].$td_html.
					$myrow["division"].$td_html.$myrow["intercom"].$td_html.
						"<a href=\"admin.php?user_click=".$myrow["user_name"]."\">Click</a>".
						$td_html."<a href=\"admin.php?user_browse=".$myrow["user_name"]."\">Browse</a>";
				}
				echo "</table>";
				break;
			default:
				$sql="SELECT * FROM complain ORDER BY complain_id DESC";
				$result = mysqli_query($cxn,$sql)
					or die("Couldn't execute query feedback_4");
		
				echo "<table style=WORD-BREAK:BREAK-ALL>";
				echo "<TR><TD width='12%' align=center><B><U>Complaint No.</U></B> <TD align=center width='36%'><B><U>Complaint Details</U></B><TD width='12%'align=center><B><U>Status
				</U></B><TD width='12%' align=center><B><U>Complaint Date</U>
				</B><TD width='16%' align=center><B><U>
				Attended on</U></B><TD width='12%' align=center><B><U>Feedback</U></B></TR>";
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
					$date_attend=change2dmy($myrow["attended_date"]);
					if($myrow["status"]=="pending")
						$date_attend="-";
					echo $tr_html.$myrow["complain_id"].$td_html.$myrow["nature_of_complaint"].
					$td_html.$myrow["status"].$td_html.$my_date.$td_html.$date_attend.$td_html.
						"<a href=\"admin.php?id=".$myrow["complain_id"]."\">Click</a> ";
				}
				echo "</table>";
			}
			?>
	</td>
 	</table>
	<hr>
	<p align = "center"><u><i>Developed by IT Division CEA</i></u></p>
</body>
</html>