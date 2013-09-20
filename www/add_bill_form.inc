<?php

$conn = Connect_to_db("Variable.inc");

echo"<form target='_self' action='add_bill.php' method='POST'>";
echo"     <table>
        <td width='33%'>
	     <table width='100%'>";

	 if($_POST['add_button']=='Add Supplier' || $_POST['supplier_button']=='Add Supplier')
	 {
		 if (isset($GLOBALS['message_4']))                     
			{                                                      
			  echo "<tr>
				<td colspan='2' style=\"font-weight : bold; font-style : italic; font-size: 90%; color: red\">
			        {$GLOBALS['message_4']}
				</td>
				</tr>\n";
			}
	 
		 if($_POST['supplier_button']=='Add Supplier' || isset($GLOBALS['message_4']))
		  {
		     echo "<tr>
			   <td>Supplier Name</td>
			   <td><input type='textbox' size='20' maxsize='20' name='supplier_name_' value='".@$supplier_name_."'></td>
			   </tr>
			   <tr>
			   <td>Supplier Address</td>
			   <td><textarea rows='5' cols='25' maxsize='100' name='supplier_add_'>".@$supplier_add_."</textarea></td>
			   </tr>
			   <tr><td>
			   <td align='center'><input type='submit' name='add_button' value='Add Supplier'></td></tr>";	
		  }
	  }

	else if($_POST['budget_button']=="Add Budget Head" || $_POST['add_button']=="Add Budget Head")
	  {
	     if (isset($GLOBALS['message_5']))                     
		{                                                      
		  echo "<tr>
			<td colspan='2' style=\"font-weight : bold; font-style : italic; font-size: 90%; color: red\">
	                {$GLOBALS['message_5']}
			</td>
			</tr>\n";
		}
	     if($_POST['budget_button']=='Add Budget Head' || isset($GLOBALS['message_5']))
	     {
	        echo "<tr>
		   <td>Budget Head</td>
		   <td><input type='textbox' size='20' maxsize='10' name='budget_head_' value='".@$budget_head_."'></td>
		   </tr>
		   <tr>
		   <td>Start Year</td>
		   <td><input type='textbox' size='10' maxsize='10' name='start_year_' value='".@$start_year_."'></td>
		   </tr>
		   <tr>
		   <td>End Year</td>
		   <td><input type='textbox' size='10' maxsize='10' name='end_year_' value='".@$end_year_."'></td>
		   </tr>
		   <tr>
		   <td>Amount</td>
		   <td><input type='textbox' size='15' maxsize='10' name='budget_amount_' value='".@$budget_amount_."'></td>
		   </tr>
		   <tr><td>
		   <td align='center'><input type='submit' name='add_button' value='Add Budget Head'></td></tr>";
	     }
	  }

	else if($_POST['item_button']=="Add Item" || $_POST['add_button']=="Add Item")
	  {	  
	     if (isset($GLOBALS['message_6']))                     
		{                                                      
		  echo "<tr>
			<td colspan='2' style=\"font-weight : bold; font-style : italic; font-size: 90%; color: red\">
	                {$GLOBALS['message_6']}
			</td>
			</tr>\n";
		}
	    if($_POST['item_button']=='Add Item' || isset($GLOBALS['message_6']))
	    {
	     echo "<tr>
		   <td>Item Name</td>
		   <td><input type='text' maxsize='25' name='item_name_' value='".@$item_name_."'></td>
		   </tr>
		   <tr>
		   <td>Item Details</td>
		   <td><textarea rows='5' cols='25' maxsize='100' name='item_details_'>".@$item_details_."</textarea></td>
		   </tr>
		   <tr><td>
		   <td align='center'><input type='submit' name='add_button' value='Add Item'></td></tr>";
		}
	  }

	else if($_POST['file_button']=="Add File Number" || $_POST['add_button']=="Add File Number")
	 {
	     if (isset($GLOBALS['message_7']))                     
		{                                                      
		  echo "<tr>
			<td colspan='2' style=\"font-weight : bold; font-style : italic; font-size: 90%; color: red\">
	                {$GLOBALS['message_7']}
			</td>
			</tr>\n";
		}
	    if($_POST['file_button']=='Add File Number' || isset($GLOBALS['message_7']))
	    {
	     echo "<tr>
		   <td>File Number</td>
		   <td><input type='text' maxsize='35' name='file_number_'  value='".@$file_number_."'></td>
		   </tr>
		   <tr><td>
		   <td align='center'><input type='submit' name='add_button' value='Add File Number'></td></tr>";
		}
	 }

	     echo "</table>
		   </td>

        <td style='background-color : gray'></td>

        <td width='67%'>

          <table width='100%' border='0'>";
	
	  if (isset($GLOBALS['message_3']))                     
		{                                                      
		  echo "<tr>
			<td colspan='3' style=\"font-weight : bold; font-style : italic; font-size: 90%; color: red\">
	                {$GLOBALS['message_3']}
			</td>
			</tr>\n";
		}

	  echo "<tr>
		<td style=\"text-align : right; font-weight: bold\">Bill Number</td>
		<td><input type='text' name='bill_no' value='".@$bill_no."' size='30' maxsize='30'></td>
		</tr>";
	  echo "<tr>
		<td style=\"text-align : right; font-weight: bold\">Bill Date</td>
		<td><input type='text' name='bill_date' ";
		if($_POST['bill_date'])
		{
			echo " value='".@$bill_date."' ";
		}
		else
		{	
			$today = date("Y-m-d");
			$today = change2dmy($today);
			echo " value='$today' ";
		}
		echo "' size='15' maxsize='15'></td>
		</tr>";
	  echo "<tr>
		<td style=\"text-align : right; font-weight: bold\">Date of Receipt</td>
		<td><input type='text' name='receipt_date' ";
		if($_POST['receipt_date'])
		{
			echo " value='".@$receipt_date."' ";
		}
		else
		{	
			$today = date("Y-m-d");
			$today = change2dmy($today);
			echo " value='$today' ";
		}
		echo "' size='15' maxsize='15'></td>
		</tr>";
	  echo "<tr>
		<td style=\"text-align : right; font-weight: bold\">Budget Head</td>
		<td><select name='head_select'><option value=''>"; 
		$sql = "SELECT budget_head,budget_id FROM budget";
		$result = mysqli_query($conn,$sql) or die("Couldn't execute query.");
	 	$num = mysqli_num_rows($result);
		if($num!=0)
	        {
		   while ($myrow = mysqli_fetch_array($result))                          
		   {
		    $head_budget=$myrow["budget_head"];
		    $id_budget=$myrow["budget_id"];
		    echo "<option value='$id_budget'";
		    if($head_budget == @$_POST['budget_head_'])
		 	echo " selected";
		    else if ($id_budget == @$_POST['head_select']) 
		 	echo " selected";
		    echo ">$head_budget\n";
		   }
		}
		echo"</select></td>
		<td style=\"text-align : left\">
		<input type='submit' name='budget_button' value='Add Budget Head'>
		</td>
		</tr>";
	  echo "<tr>
		<td style=\"text-align : right; font-weight: bold\">File Number</td>
		<td><select name='file_select'><option value=''>"; 
		$sql = "SELECT file_no,file_id FROM file";
		$result = mysqli_query($conn,$sql) or die("Couldn't execute query.");
	 	$num = mysqli_num_rows($result);
		if($num!=0)
		 {
		   while ($myrow = mysqli_fetch_array($result))                           
		     {
	 	      $no_file=$myrow["file_no"];
		      $id_file=$myrow["file_id"];
		      echo "<option value='$id_file'";
		      if($no_file == @$_POST['file_number_']) 
		   	echo " selected";
		      else if ($id_file == @$_POST['file_select'])
		  	echo " selected";
		      echo ">$no_file\n";
		     }
		  }
		 echo"</select></td>
		 <td style=\"text-align : left\">
		 <input type='submit' name='file_button' value='Add File Number'>
		 </td>
		 </tr>";
	  echo "<tr>
	        <td style=\"text-align : right; font-weight: bold\">Bill Type</td>
                <td><select name='bill_type_select'>"; 
		$bill_type_name=getBillTypeName();                          
		$bill_type_id=getBillTypeID();
		$bill_type_no=getBillTypeNo();
		for ($n=1;$n<=$bill_type_no;$n++)                              
		{
		   $_bill_type_name=$bill_type_name[$n];                            
		   $_bill_type_id=$bill_type_id[$n];
		   echo "<option value='$_bill_type_id'";
		   if ($_bill_type_id == @$_POST["bill_type_select"]) 
			echo " selected";
		   echo ">$_bill_type_name\n";
		}
		echo "</select>";

	  if((!($_POST['more_details'] || $_POST['submit_bill']) && !($_POST['supplier_button'] || $_POST['item_button'])
		&& ($_POST['add_button']!='Add Supplier' && $_POST['add_button']!= 'Add Item')) || ($_POST['bill_type_select']== ""))
	  {
		  echo "<tr><td><td style=\"text-align : center\"><input type='submit' value='More Details >>' name='more_details'></td><td>";
	  }

	  else if($_POST['bill_type_select']!= "" || $_POST['submit_bill'])
	  {
	        if($_POST['bill_type_select']!= 'Procurement' && $_POST['bill_type_select'] != '')
		{
			echo "<tr>
			<td style=\"text-align : right; font-weight: bold\">Bill Start Date</td>
			<td>
			<input type='text' name='bill_start_date' ";
			if($_POST['bill_start_date'])
			{
				echo " value='".@$bill_start_date."' ";	
			}
			else
			{	
				$today = date("Y-m-d");
				$today = change2dmy($today);
				echo " value='$today' ";
			}		
			echo" size='15' maxsize='15'>
			</td></tr>";
			echo "<tr>
			<td style=\"text-align : right; font-weight: bold\">Bill End Date</td>
			<td>
			<input type='text' name='bill_end_date' ";
			if($_POST['bill_end_date'])
			{
				echo " value='".@$bill_end_date."' ";	
			}
			else
			{	
				$today = date("Y-m-d");
				$today = change2dmy($today);
				echo " value='$today' ";
			}		
			echo" size='15' maxsize='15'>
			</td></tr>";
		}

		echo "<tr>
		      <td style=\"text-align : right; font-weight: bold\">Supplier</td>
		      <td><select name='supplier_select'><option value=''>"; 
		      $sql = "SELECT name,supplier_id FROM supplier"; 
		      $result = mysqli_query($conn,$sql) or die("Couldn't execute query.");
	 	      $num = mysqli_num_rows($result);
		      if($num!=0)
		      {
		       while ($myrow = mysqli_fetch_array($result))                           
			{
			   $name_supplier=$myrow["name"];
			   $id_supplier=$myrow["supplier_id"];
			   echo "<option value='$id_supplier'";
			   if($name_supplier == @$_POST['supplier_name_'])
				echo " selected";
			   else if ($id_supplier == @$_POST["supplier_select"]) 
				echo " selected";
			   echo ">$name_supplier\n";
			}
		      }
		      echo"</select></td>
		      <td style=\"text-align : left\">
		      <input type='submit' name='supplier_button' value='Add Supplier'>
		      </td>
		      </tr>";

			echo "<tr>
			 <td style=\"text-align : right; font-weight: bold\">Item</td>
			 <td><select name='item_select[]' size='4' multiple>"; 
			 $sql = "SELECT item_name,item_no FROM item"; 
			 $result = mysqli_query($conn,$sql) or die("Couldn't execute query.");
	 		 $num = mysqli_num_rows($result);
			 if($num!=0)
			  {
			     while ($myrow = mysqli_fetch_array($result))                           
				{
				   $name_item=$myrow["item_name"];
				   $id_item=$myrow["item_no"];
				   echo "<option value='$id_item'";
				   if ($id_item == @$_POST['item_select'])
					echo " selected";
				   echo ">$name_item\n";
				}
			  }
			 echo"</select></td>
			 <td style=\"text-align : left\">
			 <input type='submit' name='item_button' value='Add Item'>
			 </td>
			 </tr>";
	       echo "<tr>
		<td style=\"text-align : right; font-weight: bold\">Amount</td>
		<td><input type='text' name='amount' value='".@$amount."' size='15' maxsize='15'></td>
		</tr>";
	 
		echo "<tr><td><td style=\"text-align : center\"><input type='submit' value='Submit Bill' name='submit_bill'></td><td>";
		echo "</table>";
	 }
	 echo " </td>
	 </table>
	 </form>";

?>