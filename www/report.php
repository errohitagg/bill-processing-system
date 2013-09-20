<?php
			 /* File: Report.php
			  * Desc: This file is used to view complaint related reports
			  ALTER TABLE table_name AUTO_INCREMENT = 100000
			*/

	include("connect_function.inc");
	include("index_functions.inc");
	$conn = Connect_to_db("Variable.inc");

?>
<html>
<head><META HTTP-EQUIV="refresh" CONTENT="60"><title>View Bills </title>
	<link rel="stylesheet" type="text/css" href="comp_style.css" />
</head>

<body bgcolor="#EEEEEE">

<table border="0" cellpadding="5" cellspacing="0" align="center">
	<td width="60%" valign="center">
      	<img border="0" src="./head.gif" align="right"></td>
   	<td width="40%" valign="center">
      	<img border="0" src="./cea-logo.gif" align="right"></td>
</table>

<hr>

<table bgcolor="#99CCFF" border="0" width="100%">
<tr>
	<td width="20%" style="text-align: center" >
		<form action="index.php" method="POST"> 
            <br />
            <input type="submit" value="Home">
		</form>
      </td>
      <td width="20%" style="text-align: center" >
      	<form action=<?php echo $_SERVER['PHP_SELF']?> method="POST"> 
            <br />
            <input type="submit" value="All Bills">
            </form>
    	</td>
	<td width="20%" style="text-align: center">
		<form action="report_pending.php" method="POST"> 
         	<br />
            <input type="submit" value="Pending Bills">
            </form>
    	</td>
	<td width="20%" style="text-align: center">
		<form action="report_processing.php" method="POST"> 
            <br />
            <input type="submit" value="Processing Bills">
            </form>
    	</td>
	<td width="20%" style="text-align: center">
		<form action="report_completed.php" method="POST"> 
            <br />
            <input type="submit" value="Completed Bills">
    		</form>
    	</td>	
</tr>
</table>

<hr>

<table border="0">
<td bgcolor= "#DDDDDD" rowspan="1" colspan="1" ></td>
<td width="100%">
	
	<?php
		
		if(!isset($start))
			$start=0;
		$sql = "SELECT bill_process.process_id, bill_process.bill_no, bill_process.status, bill.date, bill.amount, supplier.name, file.file_no, ";
		$sql .= " budget.budget_head FROM bill_process JOIN bill JOIN supplier JOIN file JOIN budget ON (bill_process.bill_no=bill.bill_no AND ";
		$sql .= " bill_process.file_id=file.file_id AND bill.supplier_id=supplier.supplier_id AND bill.budget_id=budget.budget_id) ";
		$sql .= " ORDER BY bill_process.process_id DESC LIMIT $start,10";
		$result = mysqli_query($conn,$sql) or die("Couldn't execute query feedback_4");
		$rows=mysqli_num_rows($result);
		echo "<font size = 3 color = blue ><u><b>List of registered bills</u></b></font>";
		echo "<table width='90%'>";
			if($rows==0)
			{
				echo "<br><br><b>No more bills to display.<b><br><br>";
			}
			else
			{
				echo "<TR><TD align=\"center\"><B><U>Bill Number</U></B> 
					<TD align=\"center\"><B><U>Supplier Name</U></B>
					<TD align=\"center\"><B><U>File Number</U></B>
					<TD align=\"center\"><B><U>Budget Head</U></B>
					<TD align=\"center\"><B><U>Bill Date</U></B>
					<TD align=\"center\"><B><U>Bill Amount</U></B>
					<TD align=\"center\"><B><U>Status</U></B>
					<TD align=\"center\"><B><U>Details</U></B></TR>";
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

					if($myrow["status"] == "Pending")
						$str= "<font color=red>";
					if($myrow["status"] == "Completed")
						$str= "<font color=green>";
					if($myrow["status"] == "Processing")
						$str= "<font color=blue>";

					echo $tr_html.$str.$myrow["bill_no"].$td_html.$myrow["name"].$td_html.$myrow["file_no"].$td_html.$myrow["budget_head"].
						 $td_html.change2dmy($myrow["date"]).$td_html.$myrow["amount"].$td_html.$str.$myrow["status"].$td_html.
						 "<a target='_blank' href=\"bill_slip.php?id=".$myrow["process_id"]."\">View</a> ";
					echo "</u></font>";
				}
			}
			
		echo "</table>";
		echo "<table width=\"25%\">";
		echo "<td width=\"50%\">";
		if($start>=10)
			$show=$start-10;
		else
			$show=0;
		echo "<form action=\"".$_SERVER['PHP_SELF']."?start=".$show."\""."method=\"POST\">"; 
        echo "<input type=\"submit\" name=\"Page_Button\" value=\"Previous\"> </form> </td>";
		echo "<td width=\"50%\">";
		if($rows!=0)
		{
			$show=$start+10;
			echo "<form action=\"".$_SERVER['PHP_SELF']."?start=".$show."\""."method=\"POST\">"; 
           	echo "<input type=\"submit\" name=\"Page_Button\" value=\"Next\"> </form> </td>";
		}
		echo "</table>"; ?>
	</td>
</table>
<hr>
<p align = "center"><U><I>Developed by IT division CEA</I></U></p>
</body>
</html>