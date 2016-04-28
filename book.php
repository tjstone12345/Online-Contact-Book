<!DOCTYPE HTML> 
<html>

<head>
    <title>Web based contact book</title>
</head>
<body>
<h2>Web Based Contact Book</h2>

<?php
require_once 'contactClass.php';

$form = new contactClass();
                
$firstnamef=$form->form_text("fname","fname","Firstname*","fname");
$lastnamef=$form->form_text("lname","lname","Lastname*","lname"); 
$addressf=$form->form_text("address", "address", "Address", "address");
$emailf=$form->form_text("email","email","E-mail*","email");
$phonef=$form->form_text("phone","phone","Phone Number","phone");
$submit=$form->form_button("","submit","submit","Submit");
$submiti=$form->form_button("","import","import","Import from XML");
$check=$form->form_button("","check","check","Check records");
$form_item=array($firstnamef, $lastnamef, $addressf, $emailf, $phonef,$submit, $check, $submiti);
$form->CreateForm($form_item);
?>
  


<?php 
// to deal with data submit
  if (isset($_POST['submit'])){
	
	$firstname = $lastname = $address = $email = $phone = "";
	$firstnameErr = $lastnameErr = $addressErr = $emailErr = $phoneErr = "";
	
	if (empty($_POST['fname']))
	{$firstnameErr = "Firstname is required";}
	else
	{
		$firstname = $form-> check_input($_POST['fname']);
		if (!preg_match("/^[a-zA-Z ]*$/",$firstname))
		{
			$firstnameErr = "Only letters and white space allowed";
		}
	}
	
	if (empty($_POST['lname']))
	{$lastnameErr = "Lastname is required";}
	else
	{
		$lastname = $form-> check_input($_POST['lname']);
		// check if name only contains letters and whitespace
		if (!preg_match("/^[a-zA-Z ]*$/",$lastname))
		{
			$lastnameErr = "Only letters and white space allowed";
		}
	}
	
	if (empty($_POST['address']))
	{$address = "";}
	else
	{
		$address =$form-> check_input($_POST['address']);
	}
	
	if (empty($_POST['email']))
	{$emailErr = "Email is required";}
	else
	{
		$email = $form-> check_input($_POST['email']);
		// check if e-mail address syntax is valid
		if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email))
		{
			$emailErr = "Invalid email format";
		}
	}
	
	if (empty($_POST['phone']))
	{$phone = "";}
	else
	{$phone =$form-> check_input($_POST['phone']);}
	
	// Save data to database 
	if (!empty($firstname) && !empty($lastname) && !empty($email) && empty($emailErr) && empty($firstnameErr) && empty($lastnameErr)) {
		$firstname = $_POST['fname'];
		$lastname = $_POST['lname'];
		$address = $_POST['address'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		
		$news= $form->insert($firstname, $lastname, $address, $email, $phone);
		echo "<script>alert('$news')</script>";
		
	   } else 
	   	
	   	if (!empty($emailErr) || !empty($firstnameErr) || empty($lastnameErr)){
				echo "<script>alert('$emailErr! $firstnameErr!  $lastnameErr!')</script>";
		   }else{
					echo "<script>alert('You have to put all necessary information!')</script>";
	 			}
	 
  }

?>
<?php    
 // to deal with import xml
  if (isset($_POST['import'])){
  	$news = $form->import();
  	echo "<script>alert('$news')</script>";
  }
  
?>  




<?php
// to deal with data check
  if (isset($_POST['check'])){
  	
  	$result= $form->check();
  	
  	
  	echo "<table border='1'>
	<tr>
    <th>ID</th>
	<th>Firstname</th>
	<th>Lastname</th>
	<th>Address</th>
	<th>E-mail</th>
	<th>Phone</th>
	</tr>";
  	if ($result->num_rows > 0) {
  	while($row = $result->fetch_assoc()) 
  	{
  		echo "<tr>";
  		echo "<td>" . $row['contact_id'] . "</td>";
  		echo "<td>" . $row['firstname'] . "</td>";
  		echo "<td>" . $row['lastname'] . "</td>";
  		echo "<td>" . $row['address'] . "</td>";
  		echo "<td>" . $row['email'] . "</td>";
  		echo "<td>" . $row['phone'] . "</td>";
  		echo "</tr>";
  	}
  	echo "</table>";
  	} else {
  		echo "0 results";
  	}  	
  	
  }
  
?>


</body>
</html>   



 


