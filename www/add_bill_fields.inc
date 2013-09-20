<?php

$fields_add = array("bill_no"        => "Bill Number",
		    "supplier"       => "Supplier",
		    "bill_date"      => "Bill Date",
		    "receipt_date"      => "Date of Receipt",
		    "bill_type"      => "Bill Type",
		    "bill_start_date"=> "Bill Start Date",
		    "bill_end_date"  => "Bill End Date",
		    "bill_head"      => "Budget Head",
		    "bill_amount"    => "Bill Amount",
		    "item"           => "Item",
		    "quantity"       => "Quantity",
		    "bill_file"      => "File Number"
		   );

$length_add = array("bill_no"        => "35",
		    "supplier"       => "50",
		    "bill_date"      => "20",
		    "submitted"      => "20",
		    "bill_type"      => "15",
		    "bill_start_date"=> "20",
		    "bill_end_date"  => "20",
		    "bill_head"      => "30",
		    "bill_amount"    => "15",
		    "item"           => "35",
		    "quantity"       => "10",
		    "bill_file"      => "35"
		   );

function getBillTypeID()
{
  $bill_type_id_ = array(1  =>  "",
				"Procurement" ,
				"AMC" ,
				"FSMA"
			);
  return $bill_type_id_;
}

function getBillTypeName()
{
  $bill_type_name_ = array(1 => "",
				"Procurement", 
				"AMC", 
				"FSMA",  
			  );
  return $bill_type_name_;
}

function getBillTypeNo()
{
	$bill_type_no=4;
	return $bill_type_no;
}

?>