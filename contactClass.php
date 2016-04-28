<?php
require_once 'connect.php';
class contactClass{
	var $action;
	var $method;
	var $name="";
	var $id="";
	var $class="";
	var $layout=true;
	var $enctype="";
	
	function contactClass(){
		$this->action=htmlspecialchars($_SERVER["PHP_SELF"]);
		$this->method="POST";
	}
	
	
	function check_input($data, $problem='')
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		if ($problem && strlen($data) == 0)
		{
			echo $problem;
		}
		return $data;
	}
	
	
	function  CreateForm($form_item){
		echo $this->form_start();
		foreach ($form_item as $item){
			echo $item;
		}
		echo $this->form_end();
	}
	
	
	function form_start(){
		$text="<form action=\"{$this->action}\" method=\"{$this->method}\"";
		if($this->class!==""){
			$text.=" class=\"{$this->class}\"";
		}
		if ($this->enctype!=="") {
			$text.=" enctype=\"{$this->enctype}\"";
		}
		if($this->id!==""){
			$text.=" id=\"{$this->id}\"";
		}
		if($this->name!==""){
			$text.=" name=\"{$this->name}\"";
		}
		$text.=">\n";
		if($this->layout==true){
			$text.="<table>\n";
		}
		return $text;
	}
	
	function form_end(){
		if ($this->layout==true) {
			$text="\t</table>\n";
			$text.="</form>\n";
		}else {
			$text="</form>\n";
		}
		return $text;
	}
	
	//Text
	function form_text($name,$id,$label_name,$label_for,$value=""){
		$text="<input type=\"text\" name=\"{$name}\" ";
		$text.="id=\"{$id}\" ";
		if(isset($value)){
			$text.="value=\"{$value}\" ";
		}
		$text.="/>\n";
		$label=$this->form_label($label_name,$label_for);
		$form_item=$this->form_item($label,$text);
		return $form_item;
	}
	 
	
	
	//button
	function form_button($id,$name,$type,$value,$onclick=""){
		$text="<button id=\"{$id}\" name=\"{$name}\" type=\"{$type}\"";
		if($onclick!==""){
			$text.=" onclick='{$onclick}'";
		}
		$text.=">".$value;
		$text.="</button>\n";
		if($this->layout==true){
			$form_item="<tr>\n\t<th> </th><td>{$text}</td>\n</tr>\n";
		}else {
			$form_item=$text;
		}
		return $form_item;
	}
	
	//Text label
	function form_label($text,$for){
		if($for!==""){
			$label="<label for=\"{$for}\">{$text}：</label>";
		}else {
			$label=$text."：";
		}
		return $label;
	}
	
	
	function form_item($form_label,$form_text){
		switch ($this->layout){
			case true:
				$text="<tr>\n";
				$text.="\t<th class=\"label\">";
				$text.=$form_label;
				$text.="</th>\n";
				$text.="\t<td>";
				$text.=$form_text;
				$text.="</td>\n";
				$text.="</tr>\n";
				break;
			case false:
				$text=$form_label;
				$text.=$form_text;
				break;
		}
		return $text;
	}
	
  function insert($firstname, $lastname, $address,$email, $phone ){
	
		$db = new DBConnection();
		global $conn;
		$conn= $db->connect();
	
		$sql = "INSERT INTO contact (firstname, lastname, address, email, phone) VALUES ('$firstname', '$lastname', '$address', '$email', '$phone')";
	
		if ($conn->query ( $sql ) === TRUE) {
			return "You contact data has benn saved successfully";
		} else {
			return "Error: " . $sql . "<br>" . $conn->error;
		}
	
		$conn->close ();
	}
	
	
	 function check(){
		$db = new DBConnection();
		$conn = $db->connect();
		$sql = "SELECT contact_id, firstname, lastname, address, email, phone FROM contact";
		$result = $conn->query($sql);
	    return $result;
// 		if ($result->num_rows > 0) {
			
// 			// output each line
// 			while($row = $result->fetch_assoc()) {
// 				return "</br> id: ". $row["contact_id"]. " - Name: ". $row["firstname"]. " " . $row["lastname"]. " Address: ".$row["address"]. " E-mail: ".$row["email"]. " Phone: ".$row["phone"];
// 			}
// 		} else {
// 			return "0 results";
// 		}
		$conn->close();
	}
	 
  function import(){	 
		$xml = new DOMDocument();
		$xml->load('test.xml');
		$contact = $xml->getElementsByTagName('contact');
		foreach( $contact as $contact)
		{
			$firstname = $contact->getElementsByTagName( "firstname");
			foreach ( $firstname as $firstname )
			{
				$firstname = $firstname->firstChild->nodeValue;
			}
			 
			$lastname = $contact->getElementsByTagName( "lastname" );
			foreach ( $lastname as $lastname )
			{
				$lastname = $lastname->firstChild->nodeValue;
			}
			 
			$address = $contact->getElementsByTagName( "address" );
			foreach ( $address as $address )
			{
				$address = $address->firstChild->nodeValue;
			}
			 
			$email = $contact->getElementsByTagName( "email" );
			foreach ( $email as $email )
			{
				$email = $email->firstChild->nodeValue;
			}
			 
			$phone = $contact->getElementsByTagName( "phone" );
			foreach ( $phone as $phone )
			{
				$phone = $phone->firstChild->nodeValue;
			}
			 
			if (!preg_match("/^[a-zA-Z ]*$/",$firstname))
			{
				return "<script>alert('Only letters and white space allowed')</script>";
			}
			 
			if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email))
			{
				return "<script>alert('Invalid email format')</script>";
			}
			if (!preg_match("/^[a-zA-Z ]*$/",$lastname))
			{
				return "<script>alert('Only letters and white space allowed')</script>";
			}
	
			
			$db = new DBConnection();
			global $conn;
			$conn= $db->connect();
	
			$sql = "INSERT INTO contact (firstname, lastname, address, email, phone) VALUES ('$firstname', '$lastname', '$address', '$email', '$phone')";
	
			if ($conn->query ( $sql ) === TRUE) {
				return "You contact data has benn saved successfully";
			} else {
				return "Error: " . $sql . "<br>" . $conn->error;
			}
	
			$conn->close ();
		}
		 
	}
}

?>