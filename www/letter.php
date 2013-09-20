<?php
	
	include("connect_function.inc");
	include("index_functions.inc");
	$conn = Connect_to_db("Variable.inc");

?>


<html>
<head>
<title><?php if($_POST["generate_sanction_order"])
			echo "Sanction Order";
		else if ($_POST["generate_covering_letter"])
			echo "Covering Letter";
		?>
</title>
</head>

<body>

<?php
	
	$heading = "<tr>
	<td width='20%' valign='top'>
      <img border='0' src='./cea-logo.gif' align='left'>
	</td>
	 <td width='60%' valign='center'>
		<br><h2><center>Government of India<br>
		Central Electricity Authority<br>
		I.T. Division<br>
		Sewa Bhawan, New Delhi - 110066<br></center></h2>
	</td>
	 <td width='20%' valign='top'>
      <img border='0' src='./iso.bmp' align='right'>
	</td>
</tr>";

	$file_font = "<font face='Arial Black' size='3'>";

	if($_POST["generate_sanction_order"])
	{
		if($_POST["sanction_order"])
		{
		$work_process=$_POST["sanction_order"];
		foreach($work_process as $temp_work)
		{
			{
				$sql = "SELECT file_id FROM bill_process WHERE process_id='$temp_work'";
				$result = mysqli_query($conn,$sql) or die("Couldn't execute query feedback_1");
				$myrow = mysqli_fetch_array($result);
				if(!isset($temp_file))
				{
					$temp_file = $myrow["file_id"];
					$use_file_id = $myrow["file_id"];
				}
				else
				{
					if($temp_file!=$myrow["file_id"])
						$error = "<h1>Selected Bill doesn't belong to the same File Number.\nSanction Order can't be generated.</h1>";
					else
						$use_file_id = $myrow["file_id"];
				}
			}
			{
				$sql = "SELECT bill.supplier_id,bill.bill_type,bill.bill_no FROM bill_process JOIN bill ON bill_process.bill_no=bill.bill_no WHERE bill_process.process_id='$temp_work'";
				$result = mysqli_query($conn,$sql) or die("Couldn't execute query feedback_2");
				$myrow = mysqli_fetch_array($result);
				if(!isset($temp_supplier) && !isset($temp_bill_type))
				{
					$temp_supplier=$myrow["supplier_id"];
					$use_supplier_id=$myrow["supplier_id"];
					$temp_bill_type=$myrow["bill_type"];
					$use_bill_no=$myrow["bill_no"];
				}
				else
				{
					if($temp_supplier!=$myrow["supplier_id"])
						$error = "<h1>Selected Bill doesn't belong to the same Supplier.\nSanction Order can't be generated.</h1>";
					else if($temp_bill_type!=$myrow["bill_type"])
						$error = "<h1>Selected Bill doesn't belong to the same Bill Type.\nSanction Order can't be generated.</h1>";
					else
					{
						$use_supplier_id = $myrow["supplier_id"];
						$use_bill_no=$myrow["bill_no"];
					}
				}
			}
		}
		}
		else
		{
			echo "<b><h1>No bills selected. Sanction Order can't be generated</h1></b>";
		}
	}
	else if ($_POST["generate_covering_letter"])
	{
		if($_POST["covering_letter"])
		{
		$work_process=$_POST["covering_letter"];
		foreach($work_process as $temp_work)
		{
			{
				$sql = "SELECT file_id FROM bill_process WHERE process_id='$temp_work'";
				$result = mysqli_query($conn,$sql) or die("Couldn't execute query feedback_1");
				$myrow = mysqli_fetch_array($result);
				if(!isset($temp_file))
				{
					$temp_file = $myrow["file_id"];
					$use_file_id = $myrow["file_id"];
				}
				else
				{
					if($temp_file!=$myrow["file_id"])
						$error = "<h1>Selected Bill doesn't belong to the same File Number.\nCovering Letter can't be generated.</h1>";
					else
						$use_file_id = $myrow["file_id"];
				}
			}
			{
				$sql = "SELECT bill.supplier_id,bill.bill_type,bill.bill_no FROM bill_process JOIN bill ON bill_process.bill_no=bill.bill_no WHERE bill_process.process_id='$temp_work'";
				$result = mysqli_query($conn,$sql) or die("Couldn't execute query feedback_2");
				$myrow = mysqli_fetch_array($result);
				if(!isset($temp_supplier) && !isset($temp_bill_type))
				{
					$temp_supplier=$myrow["supplier_id"];
					$use_supplier_id=$myrow["supplier_id"];
					$temp_bill_type=$myrow["bill_type"];
					$use_bill_no=$myrow["bill_no"];
				}
				else
				{
					if($temp_supplier!=$myrow["supplier_id"])
						$error = "<h1>Selected Bill doesn't belong to the same Supplier.\nCovering Letter can't be generated.</h1>";
					else if($temp_bill_type!=$myrow["bill_type"])
						$error = "<h1>Selected Bill doesn't belong to the same Bill Type.\nCovering Letter can't be generated.</h1>";
					else
					{
						$use_supplier_id = $myrow["supplier_id"];
						$use_bill_no=$myrow["bill_no"];
					}
				}
			}
		}
		}
		else
		{
			echo "<b><h1>No bills selected. Covering Letter can't be generated</h1></b>";
		}
	}

	if($_POST["generate_sanction_order"])
	{
		if(isset($error))
		{
			echo $error;
		}

		else if($_POST["sanction_order"])
		{
			echo "<table width='90%' align='center'>";
			
			echo $heading;

			$sql = "SELECT file_no FROM file WHERE file_id='$use_file_id'";
			$result = mysqli_query($conn,$sql) or die("Couldn't execute query feedback_3");
			$myrow_1 = mysqli_fetch_array($result);

			$sql = "SELECT name, address FROM supplier WHERE supplier_id='$use_supplier_id'";
			$result = mysqli_query($conn,$sql) or die("Couldn't execute query feedback_4");
			$myrow_2 = mysqli_fetch_array($result);

			$sql = "SELECT bill_type FROM bill WHERE bill_no='$use_bill_no'";
			$result = mysqli_query($conn,$sql) or die("Couldn't execute query feedback_4");
			$myrow_4 = mysqli_fetch_array($result);

			$sql = "SELECT budget.start_year, budget.end_year FROM budget JOIN bill ON bill.budget_id=budget.budget_id WHERE bill.bill_no='$use_bill_no'";
			$result = mysqli_query($conn,$sql) or die("Couldn't execute query feedback_4");
			$myrow_6 = mysqli_fetch_array($result);
			
			$display_amount = 0;
			foreach($work_process as $temp_work)
			{
				$sql = "SELECT bill.approved_amount FROM bill JOIN bill_process ON bill_process.bill_no=bill.bill_no WHERE bill_process.process_id='$temp_work'";
				$result = mysqli_query($conn,$sql) or die("Couldn't execute query feedback_5");
				$myrow_3 = mysqli_fetch_array($result);
				$display_amount += $myrow_3["approved_amount"];
			}

			echo "<tr>".
				 "<td colspan='2'>"."No. ".$file_font.$myrow_1["file_no"]."</font></td>
				  <td>Dated : </td>".$date_font.
				  "</tr>";
			
			echo "<tr>
				  <td colspan='3'><br><center><u><b><font face='Arial Black' size='4'>ORDER</font></b></u></center><br>
				  <br>Sanction of Competent Authority of CEA is hereby accorded for incurring of an expenditure amounting to Rs.".$display_amount
				  ." for payment to ".$myrow_2["name"].", ".$myrow_2["address"]." towards ".$myrow_4["bill_type"]." charges for ";

			foreach($work_process as $temp_work)
			{
				$sql = "SELECT item.item_name FROM item JOIN bill_item JOIN bill_process ON (bill_item.item_id=item.item_no AND ";
				$sql .= " bill_process.bill_no=bill_item.bill_no) WHERE bill_process.process_id = '$temp_work'";
				$result = mysqli_query($conn,$sql) or die ("Couldn't execute query feedback_6");
				while($myrow_5 = mysqli_fetch_array($result))
				{
					echo $myrow_5['item_name'].", ";
				}
			}
			echo "for the following bills.";
				
				echo "<br>Details of bills are as follows :<br><br></tr>
				<tr>
				<td colspan='3'>
				<table border='1' align='center' width='75%'>
				<tr>
				<td align='center'>S.No</td>
				<td align='center'>Bill Number</td>
				<td align='center'>Bill Date</td>
				<td align='center'>Amount (Rs.)</td>";
				if($myrow_4["bill_type"]!="Procurement")
					echo "<td align='center'>Bill Period</td>";
				$count=0;
				foreach($work_process as $temp_work)
				{
					$sql = "SELECT bill.bill_no, bill.approved_amount, bill.date, bill.start_date, bill.end_date FROM bill JOIN bill_process ON bill.bill_no=bill_process.bill_no WHERE bill_process.process_id='$temp_work'";
					$result = mysqli_query($conn,$sql) or die("Couldn't execute query feedback_6");
					$myrow_5 =mysqli_fetch_array($result);
					echo "<tr>
							<td align='center'>".++$count."</td>
						<td align='center'>".$myrow_5["bill_no"]."</td>
						<td align='center'>".change2dmy($myrow_5["date"])."</td>
						<td align='center'>".$myrow_5["approved_amount"]."</td>";
						if($myrow_4["bill_type"] != "Procurement")
							{
								echo "<td align='center'>".change2dmy($myrow_5["start_date"])." to ".change2dmy($myrow_5["end_date"])."</td>";
							}
				}
				echo "<tr>
				<td colspan='3' align='right'>Total
				<td>Rs.".$display_amount."</tr>
				</table>
				</tr>
				<tr>
				<td colspan='2'><br>The expenditure is debitable to the sanctioned budget under the following Head of Accounts for the financial year ".
					$myrow_6["start_year"]."-".$myrow_6["end_year"]." : 
				<br><br></tr>
				<tr><td colspan='3'>
				<table align='right' width='40%'>";
				foreach($work_process as $temp_work)
				{
					$sql = "SELECT budget.budget_head FROM budget JOIN bill JOIN bill_process ON (bill.budget_id=budget.budget_id AND bill.bill_no=bill_process.bill_no) WHERE bill_process.process_id='$temp_work'";
					$result = mysqli_query($conn,$sql) or die ("Couldn't execute query feedback_7");
					$myrow_7 = mysqli_fetch_array($result);
					echo "<tr><td align='left'>".$myrow_7["budget_head"]."</td></tr>";
				}
				echo "</table>
				</tr>
				<tr>
				<td colspan='3' align='left'><br><br>Enclosures : As above
				</tr>
				<tr>
				<td colspan='3' align='right'><br><br>Office Head
				</tr>
				<tr>
				<td align='left' colspan='3'><br><br>Copies : <br>
				1. Cash Department, C.E.A. - 2 Copies <br>
				2. Department Head, Budget, C.E.A.
				</table>";

		}
	}

	else if($_POST["generate_covering_letter"])
	{
		if(isset($error))
		{
			echo $error;
		}

		else if($_POST["covering_letter"])
		{
			echo "<table width='90%' align='center'>";
			
			echo $heading;

			$sql = "SELECT file_no FROM file WHERE file_id='$use_file_id'";
			$result = mysqli_query($conn,$sql) or die("Couldn't execute query feedback_3");
			$myrow_1 = mysqli_fetch_array($result);

			$sql = "SELECT name, address FROM supplier WHERE supplier_id='$use_supplier_id'";
			$result = mysqli_query($conn,$sql) or die("Couldn't execute query feedback_4");
			$myrow_2 = mysqli_fetch_array($result);

			$sql = "SELECT bill_type FROM bill WHERE bill_no='$use_bill_no'";
			$result = mysqli_query($conn,$sql) or die("Couldn't execute query feedback_4");
			$myrow_4 = mysqli_fetch_array($result);

			$display_amount = 0;
			foreach($work_process as $temp_work)
			{
				$sql = "SELECT approved_amount FROM bill WHERE bill_no='$use_bill_no'";
				$result = mysqli_query($conn,$sql) or die("Couldn't execute query feedback_5");
				$myrow_3 = mysqli_fetch_array($result);
				$display_amount += $myrow_3["approved_amount"];
			}

			echo "<tr>".
				 "<td colspan='3'><b><br><br>Subject : Payment of bill to ".$myrow_2["name"]."</b>
				  </tr>";
			
			echo "<tr><td colspan='3'>
				  <br>In Accordance with the above Subject, ".$myrow_2["name"].", ".$myrow_2["address"]." is to be paid towards ".
				$myrow_4['bill_type']." of ";
				  
		    foreach($work_process as $temp_work)
				{
					$sql = "SELECT item.item_name FROM item JOIN bill_item JOIN bill_process ON (bill_item.item_id=item.item_no AND ";
					$sql .= " bill_item.bill_no=bill_process.bill_no) WHERE bill_process.process_id = '$temp_work'";
					$result = mysqli_query($conn,$sql) or die ("Couldn't execute query feedback_6");
					while($myrow_5 = mysqli_fetch_array($result))
					{
						echo $myrow_5['item_name'].", ";
					}
				}
			echo " for the following bills.";

			echo " Two Copies of the Sanction Order are enclosed for your correspondence and further actions to be taken.";
				echo "<br>Details of bills are as follows :<br><br></tr>
				<tr>
				<td colspan='3'>
				<table border='1' align='center' width='75%'>
				<tr>
				<td align='center'>S.No</td>
				<td align='center'>Bill Number</td>
				<td align='center'>Bill Date</td>
				<td align='center'>Amount (Rs.)</td>";
				if($myrow_4["bill_type"]!="Procurement")
					echo "<td align='center'>Bill Period</td>";
				$count=0;
				foreach($work_process as $temp_work)
				{
					$sql = "SELECT bill.bill_no, bill.approved_amount, bill.date, bill.start_date, bill.end_date FROM bill JOIN bill_process ON bill.bill_no=bill_process.bill_no WHERE bill_process.process_id='$temp_work'";
					$result = mysqli_query($conn,$sql) or die("Couldn't execute query feedback_6");
					$myrow_5 =mysqli_fetch_array($result);
					echo "<tr>
							<td align='center'>".++$count."</td>
						<td align='center'>".$myrow_5["bill_no"]."</td>
						<td align='center'>".change2dmy($myrow_5["date"])."</td>
						<td align='center'>".$myrow_5["approved_amount"]."</td>";
						if($myrow_4["bill_type"] != "Procurement")
							{
								echo "<td align='center'>".change2dmy($myrow_5["start_date"])." to ".change2dmy($myrow_5["end_date"])."</td>";
							}
				}
				echo "<tr>
				<td colspan='3' align='right'>Total
				<td>Rs.".$display_amount."</tr>
				</table>
				</tr>";

				$sql = "SELECT first_name,last_name,designation,division FROM employee JOIN bill_process ON bill_process.user_name=employee.user_name ";
				$sql .= " WHERE bill_no = '$use_bill_no'";
				$result = mysqli_query($conn,$sql) or die ("Couldn't execute query feedback_10");
				$myrow_6 = mysqli_fetch_array($result);

				echo "<tr>
				<td colspan='3' align='right'><br><br><br><br><br>(".$myrow_6['first_name']." ".$myrow_6['last_name'].")<br>";
				
				$desigName=getDesigName();                    
				$desigCode=getDesigCode();
				$desigNo=getDesigNo();
				for ($n=1;$n<=$desigNo;$n++)                              
				{
				   $desig=$desigName[$n];                            
				   $desigcode=$desigCode[$n];
				   if ($desigcode == $myrow_6['designation']) 
					 echo $desig;
				}

				echo "(";

				$divName=getDivName();                          
				$divCode=getDivCode();
			    $divNo=getDivNo();
		        for ($n=1;$n<=$divNo;$n++)                              
				{
				   $division=$divName[$n];                            
				   $divcode=$divCode[$n];
				   if ($divcode== $myrow_6['division']) 
					  echo $division;
				}

				echo ")</tr>
				<tr>
				<td align='left' colspan='3'><br><br><br><br><br>Section Officer, Cash-2, C.E.A.
				<tr>
				<td colspan='3'><hr>
				<tr>
				<td colspan='2'>File number : ".$myrow_1["file_no"].
				"<td>Date : 
				</table>";

		}
	}
?>

</body>
</html>