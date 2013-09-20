<?php
		 /* File: edit_bill.php
		  * Desc: This file is used by normal users to edit previously entered bills
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
function ValidateUpdateEdit(name)
{
	if (name.bill_date.value == "" || name.receipte_date.value == "" || name.budget_head_select.value == "" || name.file_no_select.value == "" 
		|| name.supplier_select.value == "")
	{
		alert('Please enter the complete details of the bill.')
		return false
	}
	if(name.bill_type.value == "Procurement")
	{
		if(name.item_select.value == "")
		{
			alert('Please enter the complete details of the bill.')
			return false
		}
	}
	else
	{
		if(name.bill_start_date.value == "" || name.bill_end_date.value == "")
		{
			alert('Please enter the complete details of the bill.')
			return false
		}
	}
	if(name.status.value != "Pending")
	{
		if(name.approved_amount.value == "" || name.date_verify.value == "")
		{
			alert('Please enter the complete details of the bill.')
			return false
		}
		if(name.status.value == "Completed")
		{
			if(name.date_received_hoo.value == "" || name.date_cash.value == "")
			{
				alert('Please enter the complete details of the bill.')
				return false
			}
		}
	}
	return false
}
-->
</script>

</head>

<body bgcolor="#EEEEEE">

<hr>
<table border="0" cellpadding="5" cellspacing="0" align="center">
    <td width="80%" valign="center">
      <img border="0" src="./head.gif" align="right">
	</td>
	<td width="20%" valign="center">
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
    <p align="right"><a href="index.php">Log Out</a></td>
</table>
<hr>

<?php

	if($_POST['submit_bill'] == "Update Now")
	{
		$store_user_name = $user_name;
		$store_bill_number = $_POST["bill_no"];
		$store_supplier = $_POST["supplier_select"];
		$store_bill_date = $_POST["bill_date"];
		$store_bill_date = change2ymd($store_bill_date);
		$store_receipt_date = $_POST['receipt_date'];
		$store_receipt_date = change2ymd($store_receipt_date);
		$store_bill_amount = $_POST["amount"];
		$store_budget_head = $_POST["budget_head_select"];
		$store_file = $_POST["file_no_select"];
		if($_POST['bill_type'] != 'Procurement')
		  {
			$store_bill_start = $_POST['bill_start_date'];
			$store_bill_start = change2ymd($store_bill_start);
			$store_bill_end = $_POST['bill_end_date'];
			$store_bill_end = change2ymd($store_bill_end);
		  }
		$store_item = $_POST['item_select'];
		
		$sql = "UPDATE bill_process SET file_id='$store_file',date_of_receipt='$store_receipt_date' WHERE bill_no='$store_bill_number'";
		mysqli_query($conn,$sql) or die(mysqli_error($conn));

		if($_POST['bill_type'] != 'Procurement')
		  {
			$sql = "UPDATE bill SET supplier_id='$store_supplier',date='$store_bill_date',amount=";
			$sql .= "'$store_bill_amount',budget_id='$store_budget_head',start_date='$store_bill_start',end_date='$bill_end_date' WHERE"; 
			$sql .= " bill_no='$store_bill_number'";
			mysqli_query($conn,$sql) or die(mysqli_error($conn)); 
		  }
		else
		  {
			$sql = "UPDATE bill SET supplier_id='$store_supplier',date='$store_bill_date',";
			$sql .= "amount='$store_bill_amount',budget_id='$store_budget_head' WHERE bill_no='$store_bill_number'";
			mysqli_query($conn,$sql) or die(mysqli_error($conn)); 
		  }

		if($store_item != "")
			  {
				$sql = "DELETE FROM bill_item WHERE bill_no='$store_bill_number'";
				mysqli_query($conn,$sql) or die (mysqli_error($conn));
	
				foreach($store_item as $store_item_)
				  {
					$sql = "INSERT INTO bill_item VALUES (".'"'.$store_bill_number.'","'.$store_item_.'"'.")";
					mysqli_query($conn,$sql) or die (mysqli_error($conn));
				}
			  }

		$store_status = $_POST["status"];
		if($store_status != "Pending")
		{
			$store_verify_date = $_POST["date_verify"];
			$store_verify_date = change2ymd($store_verify_date);
			$store_approved_amount = $_POST["approved_amount"];
			$sql = "UPDATE bill SET approved_amount='$store_approved_amount' WHERE bill_no='$store_bill_number'";
			mysqli_query($conn,$sql) or die (mysqli_error($conn));
			$sql = "UPDATE bill_process SET date_of_verify='$store_verify_date' WHERE bill_no='$store_bill_number'";
			mysqli_query($conn,$sql) or die (mysqli_error($conn));
			
			if($store_status == "Completed")
			{
				$store_cash_date = $_POST["date_cash"];
				$store_cash_date = change2ymd($store_cash_date);
				$store_date_hoo = $_POST["date_received_hoo"];
				$store_date_hoo = change2ymd($store_date_hoo);
				$sql = "UPDATE bill_process SET date_of_cash='$store_cash_date',date_received_hoo='$store_date_hoo' ";
				$sql .= " WHERE bill_no='$store_bill_number'";
				mysqli_query($conn,$sql) or die (mysqli_error($conn));
			}
		}
		
		include("logged.php");
	}

	else
	{
		$sql="SELECT bill_process.bill_no, bill_process.status, bill_process.date_of_verify, bill_process.date_of_cash, bill_process.date_of_receipt,";
		$sql.=" bill_process.date_received_hoo, bill.date, bill.amount, bill.approved_amount, bill.bill_type, bill.start_date, ";
		$sql.="bill.end_date, budget.budget_head, budget.budget_id, file.file_no, file.file_id, supplier.name, supplier.supplier_id FROM bill_process ";
		$sql.=" JOIN bill JOIN budget JOIN file JOIN supplier ON (bill_process.bill_no=bill.bill_no AND bill_process.file_id=file.file_id AND ";
		$sql.="bill.budget_id=budget.budget_id AND bill.supplier_id=supplier.supplier_id) WHERE bill_process.process_id='$id'";
		$result = mysqli_query($conn,$sql) or die("Couldn't execute query feedback_4");
		$myrow = mysqli_fetch_array($result);
		echo "<table border='1'>";
		echo "<form onsubmit=\"return ValidateUpdateEdit(this)\" action ='edit_bill.php?id='".$id."' method='POST'>";
		echo "<tr>
			<td><b>Bill Number</b></td>
			<td><input readonly name='bill_no' value='".$myrow["bill_no"]."'></td>
			</tr>
			<tr>
			<td><b>Bill Date</b></td>
			<td><input type='text' name='bill_date' value='".change2dmy($myrow["date"])."'></td>
			<td><b>Date of Receipt</b></td>
			<td><input type='text' name='receipt_date' value='".change2dmy($myrow["date_of_receipt"])."'></td>
			</tr>";

		$sql = "SELECT budget_id,budget_head FROM budget";
		$result = mysqli_query($conn,$sql) or die ("Couldn't execute query feedback_5");
		$num_2 = mysqli_num_rows($result);
		echo "<tr>
			<td><b>Budget Head</b></td>
			<td><select name='budget_head_select'><option value=''>"; 
			if($num_2!=0)
			    {
				   while ($myrow_2 = mysqli_fetch_array($result))                          
				   {
				    $head_budget=$myrow_2["budget_head"];
				    $id_budget=$myrow_2["budget_id"];
				    echo "<option value='$id_budget'";
					if($id_budget == $myrow['budget_id'])
				 		echo " selected";
				    else if ($id_budget == @$_POST['budget_head_select']) 
			 			echo " selected";
				    echo ">$head_budget\n";
				   }
				}
			echo"</select></td>";
	
		$sql = "SELECT file_id,file_no FROM file";
		$result = mysqli_query($conn,$sql) or die ("Couldn't execute query feedback_6");
		$num_3 = mysqli_num_rows($result);
		echo "<td><b>File Number</b></td>
			<td><select name='file_no_select'><option value=''>"; 
			if($num_3!=0)
		        {
				   while ($myrow_3 = mysqli_fetch_array($result))                          
				   {
					$no_file=$myrow_3["file_no"];
				    $id_file=$myrow_3["file_id"];
				    echo "<option value='$id_file'";
				    if($id_file == $myrow['file_id'])
					 	echo " selected";
					else if ($id_file == @$_POST['file_no_select']) 
		 				echo " selected";
				    echo ">$no_file\n";
				   }
				}
			echo"</select></td>";
		echo "<tr>";
	
		$sql = "SELECT supplier_id,name FROM supplier";
		$result = mysqli_query($conn,$sql) or die ("Couldn't execute query feedback_7");
		$num_4 = mysqli_num_rows($result);
		echo "<tr>
			<td><b>Supplier</b></td>
			<td><select name='supplier_select'><option value=''>"; 
			if($num_4!=0)
		        {
				   while ($myrow_4 = mysqli_fetch_array($result))                          
				   {
					$name_supplier=$myrow_4["name"];
				    $id_supplier=$myrow_4["supplier_id"];
				    echo "<option value='$id_supplier'";
				    if($id_supplier == $myrow['supplier_id'])
					 	echo " selected";
					else if ($id_supplier == @$_POST['supplier_select']) 
		 				echo " selected";
				    echo ">$name_supplier\n";
				   }
				}
		echo"</select></td>
			 <td><b>Bill Type</b></td>
			 <td><input readonly name='bill_type' value='";
		echo $myrow['bill_type']."'</td>";
		echo "</tr>";

		$sql = "SELECT item_no,item_name FROM item";
		$result = mysqli_query($conn,$sql) or die ("Couldn't execute query feedback_9");
		$num_6 = mysqli_num_rows($result);
		echo "<tr>
			<td><b>Item</b></td>
			<td><select name='item_select[]' size='4' multiple>";
			if($num_6!=0)
			{
				while($myrow_6 = mysqli_fetch_array($result))
				{
					$name_item=$myrow_6["item_name"];
					$id_item=$myrow_6["item_no"];
					echo"<option value='$id_item'";
					if ($id_item == @$_POST['item_select[]']) 
							echo " selected";
					echo ">$name_item\n";
				}
			}
	}
		else if($myrow['bill_type'] != "Procurement")
		{
			echo "<tr>
				<td><b>Bill Start Date</b></td>
				<td><input type='text' name='bill_start_date' value='".change2dmy($myrow["start_date"])."'></td>
				<td><b>Bill End Date</b></td>
				<td><input type='text' name='bill_end_date' value='".change2dmy($myrow["end_date"])."'></td>
				</tr>";
		}
	
		echo "<tr>
			<td><b>Amount</b></td>
			<td><input type='text' name='amount' value='".$myrow["amount"]."'></td>
			</tr>
			<tr>
			<td><b>Status</b></td>
			<td><input readonly name='status' value='".$myrow["status"]."'></td>
			</tr>";

		if($myrow['status'] != "Pending")
		{
			echo "<tr>
				<td><b>Approved Amount</b></td>
				<td><input type='text' name='approved_amount' value=".$myrow["approved_amount"]."></td>
				<td><b>Date of Verification</b></td>
				<td><input type='text' name='date_verify' value='".change2dmy($myrow["date_of_verify"])."'></td>
				</tr>";
		}

		if($myrow['status'] == "Completed")
		{
			echo "<tr>
				<td><b>Date of Received from H.O.O</b></td>
				<td><input type='text' name='date_received_hoo' value=".change2dmy($myrow["date_received_hoo"])."></td>
				<td><b>Date of Cash</b></td>
				<td><input type='text' name='date_cash' value='".change2dmy($myrow["date_of_cash"])."'></td>
				</tr>";
		}
	
		echo "<tr>
			<td><td><td><td><td><td><td><input type='submit' name='submit_bill' value='Update Now'></td>
			</tr>
			</form>
			</table>";
	}
?>

<hr>
<p align = "center"><u><i>Developed by IT Division CEA</i></u></p>
</body>
</html>