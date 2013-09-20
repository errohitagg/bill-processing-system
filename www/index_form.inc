<?php
	 /* File: double_form.inc
	  * Desc: Contains the code for a Web page that displays
	  *       two HTML forms, side by side in a table.
	 */
	
	include("index_functions.inc");

?>

<html>
<head>
<title><?php echo $page['title']?></title>
</head>

<body style="margin : 0" bgcolor="#EEEEEE">

<table border="0" width="100%" bgcolor="white">
    <td width="20%" valign="middle">
    <img border="0" src="./cea-logo.gif" align="left"></td>
    <td width="60%" valign="middle">
    <h2 align="center"><u><?php echo $page['top'] ?></u></h2></td>
    <td width="20%" valign="middle">
    <img border="0" src="./iso.bmp" align="right"></td>
</table>

<table bgcolor="#D2F0FF" width="100%" border="0" cellpadding="5" cellspacing="0">
<hr>
    <td width="62%" valign="top">
    <img border="0" src="./head.gif" align="right"></td>
    <td width="48%" valign="top">
    <p align="right"><a href="report.php">View all Bills</a></td>
</table>
<hr>  

<table border="0" cellpadding="5" cellspacing="0">

<?php
   ############
   #  Form 1  #
   ############                                          
?>

    <td width="33%" valign="top">
    <p style="font-weight : bold"><?php echo $elements_1['top']?></p>
    <!-- Beginning of form 1 (left) -->
    <form action=<?php echo $_SERVER['PHP_SELF']?> method="POST"> 
    <table border="0">
    <?php                                                     
	if (isset($GLOBALS['message_1']))                     
	{                                                      
	  echo "<tr>
                <td colspan='2' style=\"font-weight : bold; font-style : italic; font-size: 90%; color: red\">
                {$GLOBALS['message_1']}
		</td>
		</tr>\n";
	}

	foreach($fields_1 as $field => $value)                
	{
	  if(ereg("pass",$field))                             
		$type = "password";
	  else
		$type = "text";
	  echo "<tr>
	        <td style=\"text-align : right; font-weight : bold\">$value</td>
                <td><input type='$type' name='$field' value='".@$$field."' size='{$length_1[$field]}' maxsize='{$length_1[$field]}'>
                </td>
		</tr>\n";
	}                                                       
      ?>
	<tr>
	<td colspan="2" style="text-align : center" ><br>
        <input type="submit" name="Button" value="<?php echo $elements_1['submit']?>">
        </td>
        </tr>
    </table>
    </form>
    </td>

    <!-- Column that separates the two forms -->
    <td style="background-color : gray"></td>


<?php                                                     
   ############
   #  Form 2  #
   ############                                           
?>

    <td width="67%">
    <p style="font-size: 110%; font-weight: bold"><?php echo $elements_2['top']?> </p>
    <!-- Beginning of Form 2 (right side) -->
    <form action=<?php echo $_SERVER['PHP_SELF']?> method="POST"> 
    <table border="0" width="100%">
    <?php                                                     
	if (isset($GLOBALS['message_2']))                     
	{
	  echo "<tr>
	        <td colspan='2' style=\"font-weight : bold; font-style : italic; font-size : 90%; color : red\">
                {$GLOBALS['message_2']}
		</td>
		</tr>\n";
	}                                                     

	foreach($fields_2 as $field => $value)                
	{
	  if($field == "designation")                         
	   {
		echo "<tr><td style=\"text-align : right; font-weight: bold\">Designation</td>
                <td><select name='designation'>"; 
		$desigName=getDesigName();                    
		$desigCode=getDesigCode();
		$desigNo=getDesigNo();
		for ($n=1;$n<=$desigNo;$n++)                              
		{
		   $desig=$desigName[$n];                            
		   $desigcode=$desigCode[$n];
		   echo "<option value='$desigcode'";
		   if ($desigcode == @$_POST['designation']) 
			echo " selected";
		   echo ">$desig\n";
		}
                echo "</select><font color=\"#FF0000\">*</font>";
	   }                                                   
	  else if($field == "division")
	   {
		echo "<tr><td style=\"text-align : right; font-weight : bold\">Division</td>
                <td><select name='division'>"; 
		$divName=getDivName();                          
		$divCode=getDivCode();
	        $divNo=getDivNo();
	        for ($n=1;$n<=$divNo;$n++)                              
		{
		   $division=$divName[$n];                            
		   $divcode=$divCode[$n];
	           echo "<option value='$divcode'";
		   if ($divcode== @$_POST['division']) 
			 echo "selected";
		   echo ">$division\n";
		}
	        echo "</select>"."<font color=\"#FF0000\">*</font>";
	   }
	  else
	   {
	      if(ereg("pass",$field))
		 $type = "password";
	      else
		 $type = "text";
	      if($field != "level")
		{
		  if($field !="phone")
		   {
			echo "<tr><td style=\"text-align : right; font-weight: bold\">$value</td>
			      <td><input type='$type' name='$field' value=\"".@$$field."\" size='{$length_2[$field]}' maxsize='{$length_2[$field]}'>
			      "."<font color=\"#FF0000\">*</font>
			      "."</td>
			      </tr>";
		   }
		  else
		   {
			echo "<tr><td style=\"text-align : right; font-weight : bold\">$value</td>
			      <td><input type='$type' name='$field' value=\"".@$$field."\" size='{$length_2[$field]}' maxsize='{$length_2[$field]}'> 
			      </td>
			      </tr>";
		   }
		}
	   }                                                  
	}                                                     
      ?>
	<tr>
	<td colspan="2" style="text-align: center">
	<p style="margin-top : .05in"><input type="submit" name="Button" value="<?php echo $elements_2['submit']?>">
	</td>
	</tr>
      </table>  
     </form>
    </td>
   </table>
<hr>
<p align="right"><font color="#FF0000">*</font> Mandatory fields</p>
<div style="text-align : center; font-size : 75%"><?php echo $page['bottom']?>
</body>

</html>