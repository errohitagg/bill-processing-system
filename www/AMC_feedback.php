<?php
 /* File: AMC_feedback.php
  * Desc: This file is used to enter AMC work
*/
	include("functions_main.inc"); 
	include("functions.inc");
	session_start();
	if($_SESSION['auth']!="yes")
		header("Location: index.php");
	if($_GET['id']==NULL)
	{
		$id=0;
	}
	$cxn = Connect_to_db("Vars.inc");
?>
<html>
<head><META HTTP-EQUIV="refresh" CONTENT="60"><title>View Complaints </title>
	<style type="text/css">
		body, p, th, td, select {
			font-family: Times New Roman, Arial, Verdana, Helvetica;
			font-size: 14px;
		}
		table {
			background-color: #FFFFFF;
		}
		input, select {
			width: 90%;
		}
		#content_div {
			width: 100%;
		}
		#content_div table {
			width: 775px;
			border: 2px solid #DDDDDD;
			margin: 2px;
		}
		#content_div table th {
			font-weight: bold;
			text-align: left;
		} 
		a {
			font-weight: bold;
			color: #000080;
			text-decoration: none;
		} 
		a:hover {
			text-decoration: underline;
		} 
		#results_cell table {
			border: 0px hidden;
			padding: 0px;
			margin: 0px;
		}
		}
	</style>
<script language="Javascript" type="text/javascript">
<!--
function ValidateWork(name)
{
	if ( name.work_detail.value == "")
	{
		alert('Please enter work details.')
		return false
	}
	return true
}
-->
</script>
</head>

<body bgcolor="#EEEEEE">

<table width=100% border="0" cellpadding="5" cellspacing="0">
	<td width="60%" valign="center">
      	<img border="0" src="./head.gif" align="right"></td>
   	<td width="40%" valign="center">
      	<img border="0" src="./cea-logo.gif" align="right"></td>
</table>

<tr><hr></tr>

<table bgcolor="#CCFFCC" border="0" width="100%">
	<td width="50%" valign="top">
	<?php echo "<h3 align=\"left\"><u>Welcome ".$logname."  (AMC Engineer)"."</u></h3></td>"; ?>
	<td width="50%" align="right"><a href="index.php">Log Off</a></td>
</table>

<td><hr></td>

<table width="100%" border="0">
<td width="45%">
		<?php
		if(@$_POST['Update_stat']=='Update Status')
		{
			if($_POST["standby"]=="stand")
				$standby_val="yes";
			else
				$standby_val="no";
			if($_POST["replacement"]=="rep")
				$rep_val="yes";
			else
				$rep_val="no";
			
			$work_details=$_POST["work_detail"];
			$eqp_detail=$_POST["eqp_detail"];
			$eqp_slno=$_POST["sl_no"];
			$attend_date=change_ymd($_POST["attend"]);
			$mystatus=$_POST["status"];
			
			$sql= "SELECT * FROM work WHERE
				complaint_id='$id'";
			
			$result=mysqli_query($cxn,$sql)
                  	or die("Couldn't execute query feedback_1");
			$num = mysqli_num_rows($result);
			
			$sql="UPDATE complain set status='$mystatus', attended_date='$attend_date'
				WHERE complain_id=$id";
			$result1 = mysqli_query($cxn,$sql)
					or die("Couldn't execute query feedback_2");
			if($num==0)
			{
				$sql="INSERT INTO work (complaint_id, user_name, 
					work_detail, eqp_detail, eqp_slno, replacement, standby, attend_date) 
					VALUES ('$id', '$logname', '$work_details',
					'$eqp_detail', '$eqp_slno', '$rep_val', '$standby_val', 
					'$attend_date')";
				$result = mysqli_query($cxn,$sql)
					or die("Couldn't execute query feedback_3");
				echo "<U>Thank you for updating the status of complaint No. ". $id;
			}
			else
			{
				$sql="UPDATE work set user_name='$logname',
					work_detail='$work_details', replacement='$rep_val',
					standby='$standby_val', attend_date='$attend_date'
					WHERE complaint_id=$id";
				$result=mysqli_query($cxn,$sql);
				echo "<U>Thank you for modifying the status of complaint No. ". $id;
			}
		}
		else
		{
			if($id==0)
			{
					$time_a=20000;
					$time=date("h:i",time()+$time_a);
					echo "Today is : ".date("d-M-Y"); 
					echo "  " . $time;
			}
			else
			{
				$sql="SELECT * FROM work WHERE complaint_id='$id'";
				$result=mysqli_query($cxn,$sql);
				$num = mysqli_num_rows($result);
				$sql="SELECT user_name, status FROM complain 
					WHERE complain_id='$id'";
				$result = mysqli_query($cxn,$sql);
				$myrow=mysqli_fetch_array($result);
				$usr_name=$myrow["user_name"];
				$sql="SELECT * FROM employee WHERE user_name='$usr_name'";
				$result1 = mysqli_query($cxn,$sql);
				$myrow1=mysqli_fetch_array($result1);
				echo "<table border='1'><tr><td>";
				echo "<form onsubmit=\"return ValidateWork(this)\" action ='AMC_feedback.php?id=$id' method='POST'>";
				echo "<table border ='0'> <tr><td>";
				echo "<b>Complaint No.</b></td><td><name='comp_no' value='$id'>".$id; 
				echo "</td></tr> <tr><td>";
				echo "<b>Officer's name</b></td><td>".
					$myrow1["first_name"]." ".$myrow1["last_name"]; 
				echo "</td></tr> <tr><td>";
				echo "<b>Designation</b></td><td>".
					$myrow1["designation"]; 
				echo "</td></tr> <tr><td>";
				echo "<b>Division</b></td><td>".
					$myrow1["division"]; 
				echo "</td></tr> <tr><td>";
				echo "<b>Location</b></td><td>".
					$myrow1["location"]; 
				echo "</td></tr> <tr><td>";
				echo "<b>Intercom</b></td><td>".
					$myrow1["intercom"]; 
				echo "</td></tr> <tr><td>";
				echo "<b>Work details</b></td><td>
						<textarea rows=2 cols=30 name=\"work_detail\"></textarea><br/></td></tr>
						</td></tr><tr><td>";
				if($num==0)
				{
					
					echo "<b>Equipment details</b></td><td>
						<textarea rows=2 cols=25 name=\"eqp_detail\"></textarea><br/></td></tr>
						</td></tr><tr><td>";
					echo "<b>Equipment Sl.No.</b></td><td>
						<textarea rows=1 cols=30 name=\"sl_no\"></textarea><br/></td></tr>
						</td></tr><tr><td>";
				}
				echo "<b>Standby given</b></td><td><input type=\"checkbox\"
					name=\"standby\" value=\"stand\">"; 
				echo "</td></tr> <tr><td>";
				echo "<b>Replacement given</b></td><td><input type=\"checkbox\"
					name=\"replacement\" value=\"rep\">"; 
				echo "</td></tr> <tr><td>";

				echo "<b>Status</b></td><td><select size='1' name='status'>";
				echo "<option selected value=".$myrow["status"].">".$myrow["status"]."</option>";
				if($myrow["status"]=="pending")
					echo "<option value='attended'>attended</option>";
				else
					echo "<option value='pending'>completed</option>";
				echo "</select></td></tr> <tr><td>";
				echo "<b>Attended On (d-m-Y)</b></td><td><input type='text' name= 'attend' value=". date("d-m-Y")."></td></tr>";
				echo "<tr><td></td><td><input type='submit' name='Update_stat' value='Update Status'></td></tr>";
				echo "</form></table> </td></td> </table>";
			}
		}

		?>
</td>
<td bgcolor= white rowspan="1" colspan="1" ></td>
<td width="55%" valign="top">
	<?php
				$sql="SELECT * FROM complain ,employee WHERE 
					complain.user_name=employee.user_name AND 
					complain.status != \"completed\" ORDER BY complain_id DESC";
				$result = mysqli_query($cxn,$sql);
			
				echo "<font size = 3 color = blue ><u><b>" . 
					"List of ongoing complaints</u></b></font>";
				echo "<TABLE>";
				echo "<TR><TD align=\"center\"><B><U>Complaint No.</U></B> 
					<TD align=\"center\"><B><U>Complaint Date
					</U></B><TD align=\"center\"><B><U>Officer's Name</U></B>
					<TD align=\"center\"><B><U>Division</U></B>
					<TD align=\"center\"><B><U>Status</U></B>
					<TD align=\"center\"><B><U>Feedback</U></B></TR>";
					$r_row_count=0;
				while ($myrow = mysqli_fetch_array($result))
				{
					if(++$r_row_count % 2 == 1 )
					{
						
						$tr_html	= "<tr><td bgcolor='#DDDDDD' align=\"center\">";
						$td_html	= "<td bgcolor='#DDDDDD' align=\"center\">";
					}
					else
					{
						$tr_html	= "<tr><td bgcolor='#EEEEEE' align=\"center\">";
						$td_html	= "<td bgcolor='#EEEEEE' align=\"center\">";
					}
					if($myrow["status"] == "pending")
						$str= "<font size= 3 color=red>";
					else
						$str= "<font size= 3 color=blue>";
					echo $tr_html.$str.$myrow["complain_id"].$td_html.change2dmy($myrow["date"]).
						$td_html.$myrow["first_name"]." ".$myrow["last_name"].$td_html.
						$myrow["division"].$td_html.$myrow["status"];
					echo $td_html."<a href=\"AMC_feedback.php?id=".
					$myrow["complain_id"]."\">Click</a> ";
					echo "</u></font>";
				}
				echo "</TABLE>";
				
			?>
	
	</td>
</table>
<hr>
<p align = "center"><U><I>Developed by IT division CEA</I></U></p>
</body>
</html>