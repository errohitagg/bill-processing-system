<?php

	function getDesigCode()
	{
	  $desigCode = array(1=>"",
				"AD1" ,
				"AD2" ,
				"DD" ,
				"DIR" ,
				"CHIEF" ,
				"MEM" ,
				"CHR" ,
				"SO" ,
				"ASST" ,
				"US"
			   );
	  return $desigCode;
	}

	function getDesigName()
	{
	  $desigName = array(1=>"",
				"Asst. Director-I", 
				"Asst. Director-II", 
				"Deputy Director", 
				"Director", 
				"Chief Engineer", 
				"Member", 
				"Chairperson", 
				"Section Officer", 
				"Assistant", 
				"Under Secretary"
			    );
	  return $desigName;
	}

	function getDesigNo()
	{
		$desigNo=11;
		return $desigNo;
	}

	function getDivCode()
	{
	  $divCode = array(1=>  "",
				"IT" ,
				"IRP" ,
				"TPM" ,
				"TRM" ,
				"HRD" ,
				"DMLF" ,
				"GM" ,
				"CHR" ,
				"SEC" ,
				"OM"
		         );
	  return $divCode;
	}

	function getDivName()
	{
	  $divName = array(1=>  "",
				"Information Technology", 
				"Integreted Resource Plannng", 
				"Thermal Planning Monitoring", 
				"Thermal Resource Monitoring", 
				"Human Resource Development", 
				"Data Management & Load Forcasting", 
				"Grid Management", 
				"Office of Chairperson", 
				"Office of Secretary", 
				"OM Division"
			  );
	 return $divName;
	}

	function getDivNo()
	{
		$divNo=11;
		return $divNo;
	}

	function change2dmy($date)      //input format: yyyy-mm-dd
	{
		$dtmp = explode("-",$date);
		$dadate = mktime(0,0,0,$dtmp[1],$dtmp[2],$dtmp[0]);
		return date('d/m/Y',$dadate);
	}

	function change2ymd($date)     //input format: dd/mm/yy or yyyy
	{
		$dtmp = explode("/",$date);
		$dadate = mktime(0,0,0,$dtmp[1],$dtmp[0],$dtmp[2]);
		return date('Y-m-d',$dadate);
	}

	function change_ymd($date)     //input format: dd-mm-yy or yyyy
	{
		$dtmp = explode("-",$date);
		$dadate = mktime(0,0,0,$dtmp[1],$dtmp[0],$dtmp[2]);
		return date('Y-m-d',$dadate);
	}

?>