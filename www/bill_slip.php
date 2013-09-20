<html>
<head>
<?php
	include("connect_function.inc");
	include ("index_functions.inc");
	$conn = Connect_to_db("Variable.inc");
?>
<title>Bill Slip</title>
</head>

<body>

<?php

	$sql = "SELECT bill_no,file_id,user_name,date_of_receipt,status FROM bill_process WHERE process_id='$id'";
	$result = mysqli_query($conn,$sql) or die("Couldn't execute query feedback_1");
	$myrow_1 = mysqli_fetch_array($result);
	$sql = "SELECT * FROM employee WHERE user_name='".$myrow_1['user_name']."'";
	$result = mysqli_query($conn,$sql) or die("Couldn't execute query feedback_2");
	$myrow_2 = mysqli_fetch_array($result);
	$sql = "SELECT file_no FROM file WHERE file_id='".$myrow_1['file_id']."'";
	$result = mysqli_query($conn,$sql) or die("Couldn't execute query feedback_3");
	$myrow_3 = mysqli_fetch_array($result);
	$sql = "SELECT supplier_id,date,amount,budget_id,bill_type FROM bill WHERE bill_no='".$myrow_1['bill_no']."'";
	$result = mysqli_query($conn,$sql) or die("Couldn't execute query feedback_4");
	$myrow_4 = mysqli_fetch_array($result);
	$sql = "SELECT name,address FROM supplier WHERE supplier_id='".$myrow_4['supplier_id']."'";
	$result = mysqli_query($conn,$sql) or die("Couldn't execute query feedback_5");
	$myrow_5 = mysqli_fetch_array($result);
	$sql = "SELECT budget_head FROM budget WHERE budget_id='".$myrow_4['budget_id']."'";
	$result = mysqli_query($conn,$sql) or die("Couldn't execute query feedback_6");
	$myrow_6 = mysqli_fetch_array($result);

	
echo "<table width='95%' border='0' cellpadding='0' cellspacing='0'>
  <tr>
    <td width='20%'><img border='0' src='cea-logo.gif' width='76' height='75'></td>
    <td width='60%'><p align='center'><u><b><font size='4'>BILL FORM</font></b></u></td>
    <td width='20%'><img border='0' src='iso.bmp' align='right' width='92' height='75'></td>
  </tr>
</table>

<hr>

<table width='95%' border='1' style='WORD-BREAK:BREAK-ALL'>
  <tr>
    <td width='10%'><B>Bill Number</B></td>
    <td width='30%'><B>".$myrow_1["bill_no"];
	

	?></B></td>
    <td width="20%"><B>Bill Date</B></td>
    <td width="20%"><?php echo "<b>".change2dmy($myrow_4["date"])."</b>"; ?></td>	
  </tr>

  <tr>
    <td width="10%"><B>User Name</B></td>
    <td width="30%"><?php echo $myrow_2["first_name"] ." ".$myrow_2["last_name"]; ?></td>
  </tr>

  <tr>
    <td width="20%"><B>Division</B></td>
    <td width="20%"><?php echo $myrow_2["division"]; ?></td>
	<td width="20%"><B>Designation</B></td>
    <td width="20%"><?php echo $myrow_2["designation"]; ?></td>
  </tr>

  <tr>
    <td width="10%"><B>Location</B></td>
    <td width="20%"><?php echo $myrow_2["location"]; ?></td>
    <td width="10%"><B>Contact No.</B></td>
    <td width="20%"><?php echo $myrow_2["intercom"]; ?></td>
  </tr>
  
</table>

<hr>

  <tr>
    <td width="22%"><B>Bill Details</B></td>
    <td width="78%">&nbsp;</td>
  </tr>

<table width="95%" border="1" style="WORD-BREAK:BREAK-ALL">
  <tr>
    <td width="20%"><B>Date of Receipt</B></td>
    <td width="30%"><?php echo change2dmy($myrow_1["date_of_receipt"]); ?></td>
  
	<?php
  if($myrow_1["status"] != "Pending")
  {
	  $sql = "SELECT date_of_verify FROM bill_process WHERE process_id='$id'";
	  $result = mysqli_query($conn,$sql);
	  $myrow_ = mysqli_fetch_array($result);
	  echo "
	<td width='20%'><B>Date of Verify</B></td>
    <td width='30%'>".change2dmy($myrow_["date_of_verify"]).
	"</td>
  </tr>";
	if($myrow_1["status"] == "Completed")
	  {
		$sql = "SELECT date_received_hoo,date_of_cash FROM bill_process WHERE process_id='$id'";
	  $result = mysqli_query($conn,$sql);
	  $myrow_ = mysqli_fetch_array($result);
	echo "<tr>
	<td width='20%'><B>Date of Received from H.O.O</B></td>
    <td width='30%'>".change2dmy($myrow_["date_received_hoo"]).
	"</td>
	<td width='20%'><B>Date of Cash</B></td>
    <td width='30%'>".change2dmy($myrow_["date_of_cash"]).
	"</td>
  </tr>";
  }
}
?>
  <?php
	if($myrow_4["bill_type"] != "Procurement")
	{
		$sql = "SELECT start_date,end_date FROM bill WHERE bill_no='".$myrow_1["bill_no"]."'";
	  $result = mysqli_query($conn,$sql);
	  $myrow_ = mysqli_fetch_array($result);
		echo "<tr>
			 <td width='20%'><B>Bill Start Date</B></td>
			 <td width='30%'>".change2dmy($myrow_['start_date'])."</td>
			 <td width='20%'><B>Bill End Date</B></td>
		     <td width='30%'>".change2dmy($myrow_['end_date'])."</td>
			 </tr>";		
	}
  
	echo "<tr>
	<td width='20%'><B>Bill Amount</B></td>
    <td width='30%'>".$myrow_4["amount"]."</td>";
	if($myrow_1["status"]!="Pending")
	{
		$sql = "SELECT approved_amount FROM bill WHERE bill_no='".$myrow_1["bill_no"]."'";
	  $result = mysqli_query($conn,$sql);
	  $myrow_ = mysqli_fetch_array($result);
	echo "<td width='20%'><B>Approved Amount</B></td>
    <td width='30%'>".$myrow_["approved_amount"]."</td>";
	}
  echo "</tr>";
  ?>

  <tr>
	<td width="20%"><B>Budget Head</B></td>
    <td width="30%"><?php echo $myrow_6["budget_head"]; ?></td>
	<td width="20%"><B>File Number</B></td>
    <td width="30%"><?php echo $myrow_3["file_no"]; ?></td>
  </tr>

</table>

<hr>
  <tr>
    <td width="22%"><B>Supplier Details</B></td>
    <td width="78%">&nbsp;</td>
  </tr>

<table width="95%" border="1" style="WORD-BREAK:BREAK-ALL">
  <tr>
	<td width="20%"><B>Supplier Name</B></td>
    <td width="30%"><?php echo $myrow_5["name"]; ?></td>
	<td width="20%"><B>Supplier Address</B></td>
    <td width="30%"><?php echo $myrow_5["address"]; ?></td>
  </tr>
</table>

<?php

	echo "<hr>
		  <tr>
			<td width='22%'><B>Item Details</B></td>
			<td width='78%'>&nbsp;</td>
		  </tr>";

		  $sql = "SELECT item_id FROM bill_item WHERE bill_no='".$myrow_1['bill_no']."'";
		  $result = mysqli_query($conn,$sql) or die("Couldn't execute query feedback_7");
		  
	echo "<table width='95%' border='1' style='WORD-BREAK:BREAK-ALL'>
		  <tr>
		  <td width='20%'><B>Item Name</B></td>
		  <td width='60%'><B>Item Details</B></td>
		  </tr>";

	while($myrow_7 = mysqli_fetch_array($result))
	{
		$sql = "SELECT item_name,item_details from item WHERE item_no='".$myrow_7["item_id"]."'";
		$result_2 = mysqli_query($conn,$sql) or die ("Couldn't execute query feedback_8");
		$myrow_8 = mysqli_fetch_array($result_2);
		echo "<tr>
			  <td width='20%'>".$myrow_8["item_name"]."</td>
			  <td width='60%'>".$myrow_8["item_details"]."</td>
			  </tr>";
	}
	echo "</table>";

?>

<hr>
</body>
</html>