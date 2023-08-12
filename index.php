<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include_once("config.php");

if(isset($_POST['submit']))
{
 $name = $_POST['name'];
 $phone = $_POST['phone'];
 $email = $_POST['email'];
 $subject = $_POST['subject'];
 $message = $_POST['message'];
 $ip_address = $_SERVER['REMOTE_ADDR'];
 
 if(empty($name)){ $err = "Name is required."; }
 elseif(empty($phone)){ $err = "Phone is required."; }
 elseif(!empty($phone) && !filter_var($phone, FILTER_SANITIZE_NUMBER_INT)){ $err = "Enter valid phone number."; }
 elseif(empty($email)){ $err = "Email is required."; }
 elseif(!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)){ $err = "Enter valid email."; }
 elseif(empty($subject)){ $err = "Subject is required."; }
 elseif(empty($message)){ $err = "Message is required."; }
 else
 {
  $addCF = mysqli_query($conn,"insert into contact_form (name, phone, email, subject, message, ip_address) values ('".$name."', '".$phone."', '".$email."', '".$subject."', '".$message."', '".$ip_address."')") or die(mysqli_error());
  
  $body="<table width=100% border=0 cellspacing=0 cellpadding=0>
		 <tr>
		   <td><strong>Dear Sir</strong>,</td>
		 </tr>
		 <tr>
		   <td>&nbsp;</td>
		 </tr>
		 <tr>
		   <td>You have 1 enquiry from Contact Form</td>
		 </tr>
		 <tr>
		   <td>&nbsp;</td>
		 </tr>
		 <tr>
		   <td><strong>Name</strong> : ".$name."</td>
		 </tr>
		 <tr>
		   <td><strong>Phone</strong> : ".$phone."</td>
		 </tr>
		 <tr>
		   <td><strong>Email</strong> : ".$email."</td>
		 </tr>
		 <tr>
		   <td><strong>Subject</strong> : ".$subject."</td>
		 </tr>
		 <tr>
		   <td><strong>Message</strong> : ".$message."</td>
		 </tr>
		 <tr>
		   <td>&nbsp;</td>
		 </tr>
		 <tr>
		   <td><strong>Thanks &amp; Regards</strong></td>
		 </tr>
		 <tr>
		   <td>&nbsp;</td>
		 </tr>
		 <tr>
		   <td>Team</td>
		 </tr>
		</table>";
  
  $headers  = "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/HTML; charset=\"iso-8859-1\"\n";
  $headers .= "From: ".$email." \r\n";
  
  $to = "test@techsolvitservice.com";
  $subject = "Contact Us Enquiry";
  $sendmail = mail($to, $subject, $body, $headers);
  $msg = "Success! Thanks for contacting us, we will get back to you shortly.";
  header("location:index.php?msg=$msg");
 }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Contact Form</title>
</head>

<body>
<form action="" method="post">
<fieldset>
<legend>Contact Form</legend>
<div>
  <label>Name</label><br />
  <input name="name" placeholder="Name" type="text" size="50" value="<?php echo $_POST['name']; ?>">
</div>
<br />
<div>
  <label>Phone</label><br />
  <input name="phone" placeholder="Phone" type="text" size="50" value="<?php echo $_POST['phone']; ?>">
</div>
<br />
<div>
  <label>Email</label><br />
  <input name="email" placeholder="Email" type="text" size="50" value="<?php echo $_POST['email']; ?>">
</div>
<br />
<div>
  <label>Subject</label><br />
  <input name="subject" placeholder="Subject" type="text" size="50" value="<?php echo $_POST['subject']; ?>">
</div>
<br />
<div>
  <label>Message</label><br />
  <textarea name="message" cols="50" rows="3" placeholder="Message"><?php echo $_POST['message']; ?></textarea>
</div>
<?php if(isset($err)){ ?><br /><div style="color:#FF0000;">Error: <?php echo $err; ?></div><?php } ?>
<?php if(isset($_GET['msg'])){ ?><br /><div style="color:#00CC00;"><?php echo $_GET['msg']; ?></div><?php } ?>
<br />
<div>
  <button type="submit" name="submit">Submit</button>
</div>
</fieldset>
</form>
</body>
</html>
