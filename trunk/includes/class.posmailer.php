<?php
require("includes/phpmailer/class.phpmailer.php");

class posmailer extends PHPMailer {
	public $site_URL;
	
	function mailinit()
	{
		include_once 'eveconfig/mailconfig.php';

		$this->site_URL=$mailconfig['site_url'];
		$this->From    =$mailconfig['site_mail'];
		$this->FromName=$mailconfig['site_mail_name'];
		$this->Host    =$mailconfig['mail_host'];
		$this->Mailer  =$mailconfig['mail_mailer'];
		$this->WordWrap= 75;
		$this->Username=$mailconfig['mail_username'];
		$this->Password=$mailconfig['mail_password'];
		$this->Port    =$mailconfig['mail_port'];
		$this->SMTPAuth=$mailconfig['smtp_auth'];
		//$this->SMTPDebug=false; //Set to True to see Debug info
	}
	
	function sendcode($email, $character, $email_code, $characterID)
	{
		//mail body
		$body  = "Hello ".$character.",<br>";
		$body .= "This is an email to validate your email address, ".$email.".<br>";
		$body .= "Please Click on the link below to comfirm your email:<br><a href=".$this->site_URL."validate.php?id=".$characterID."&code=".$email_code.">".$this->site_URL."validate.php?id=".$characterID."&code=".$email_code."</a><br>Thanks,<br>Your POS-Tracker";
		
		$this->Subject	= "POS-Tracker Email Validation";
		
		$this->Body    = $body;
		$this->IsHTML(true);
		//$mail->AltBody = $text_body;
		$this->AddAddress($email, $character);
		
		if($mailconfig['email_enabled'])
		{
			if(!$this->Send())
			{
				eve::SessionSetVar('statusmsg', 'There was an error sending your email validation code :: '.$this->ErrorInfo);
			}
		}
		
		// Clear all addresses and attachments for next loop
		$this->ClearAddresses();
		$this->ClearAttachments();
		
		return true;
	}
	
	function posalert($email, $character, $pos, $static, $diff)
	{
		//mail body
		$body  = "Hello ".$character.",<br><br>";
		$body .= "This is a fuel alert from POS-Tracker at <a href=".$this->site_URL.">".$this->site_URL."</a> The starbase assigned to you at <b>".$pos['MoonName']."</b> has only <font color=\"red\">".$pos['online']."</font> of fuel remaining.<br><hr>";
		$body .= "<table cellspacing=\"0\" border=\"1\">\n";
		$body .= "<tr bgcolor=\"#BBD9EE\"><td>Fuel</td><td>Current</td><td>Status</td><td>Required</td><td>Optimal</td><td>Difference</td></tr>\n";
		
		$body .= "<tr><td>Enriched Uranium</td><td>".$pos['uranium']."</td><td>".POSMGMT::daycalc($pos['result_uptimecalc']['uranium'])."</td><td>".$static['uranium']."</td><td>".$pos['result_optimal']['optimum_uranium']."</td><td>".$diff['uranium']."</td></tr>\n";
		$body .= "<tr><td>Oxygen</td><td>".$pos['oxygen']."</td><td>".POSMGMT::daycalc($pos['result_uptimecalc']['oxygen'])."</td><td>".$static['oxygen']."</td><td>".$pos['result_optimal']['optimum_oxygen']."</td><td>".$diff['oxygen']."</td></tr>\n";
		$body .= "<tr><td>Mechanical Parts</td><td>".$pos['mechanical_parts']."</td><td>".POSMGMT::daycalc($pos['result_uptimecalc']['mechanical_parts'])."</td><td>".$static['mechanical_parts']."</td><td>".$pos['result_optimal']['optimum_mechanical_parts']."</td><td>".$diff['mechanical_parts']."</td></tr>\n";
		$body .= "<tr><td>Coolant</td><td>".$pos['coolant']."</td><td>".POSMGMT::daycalc($pos['result_uptimecalc']['coolant'])."</td><td>".$static['coolant']."</td><td>".$pos['result_optimal']['optimum_coolant']."</td><td>".$diff['coolant']."</td></tr>\n";
		$body .= "<tr><td>Robotics</td><td>".$pos['robotics']."</td><td>".POSMGMT::daycalc($pos['result_uptimecalc']['robotics'])."</td><td>".$static['robotics']."</td><td>".$pos['result_optimal']['optimum_robotics']."</td><td>".$diff['robotics']."</td></tr>\n";
		$body .= "<tr><td>".$static['race_isotope']." Isotopes</td><td>".$pos['isotope']."</td><td>".POSMGMT::daycalc($pos['result_uptimecalc']['isotope'])."</td><td>".$static['isotopes']."</td><td>".$pos['result_optimal']['optimum_isotope']."</td><td>".$diff['isotope']."</td></tr>\n";
		$body .= "<tr><td>Liquid Ozone</td><td>".$pos['ozone']."</td><td>".POSMGMT::daycalc($pos['result_uptimecalc']['ozone'])."</td><td>".$static['ozone']."</td><td>".$pos['result_optimal']['optimum_ozone']."</td><td>".$diff['ozone']."</td></tr>\n";
		$body .= "<tr><td>Heavy Water</td><td>".$pos['heavy_water']."</td><td>".POSMGMT::daycalc($pos['result_uptimecalc']['heavy_water'])."</td><td>".$static['heavy_water']."</td><td>".$pos['result_optimal']['optimum_heavy_water']."</td><td>".$diff['heavy_water']."</td></tr>\n";
		$body .= "</table>\n";
		$body .= "<br><hr><p>This an an automated email sent from POS-Tracker. If you do not wish to receive alerts from POS-Tracker, please update your profile in the User pannel of POS-Tracker</p>";
		
		$this->Subject	= "POS-Tracker Alert: ".$static['typeName']." at ".$pos['MoonName'];
		
		$this->Body    = $body;
		$this->IsHTML(true);
		//$mail->AltBody = $text_body;
		$this->AddAddress($email, $character);
		

			if(!$this->Send())
			{
				echo "Error Sending Alert :: ".$this->ErrorInfo."<br>";

			}

		
		// Clear all addresses and attachments for next loop
		$this->ClearAddresses();
		$this->ClearAttachments();
		
		return true;
	}
	
	function criticalpossalert($email, $character, $owner, $pos, $static, $diff)
	{
		//mail body
		$body  = "Hello ".$character.",<br><br>";
		$body .= "This is a fuel alert from POS-Tracker at <a href=".$this->site_URL.">".$this->site_URL."</a> The starbase assigned to ".$owner." at <b>".$pos['MoonName']."</b> has only <font color=\"red\">".$pos['online']."</font> of fuel remaining.<br><hr>";
		$body .= "<table cellspacing=\"0\" border=\"1\">\n";
		$body .= "<tr bgcolor=\"#BBD9EE\"><td>Fuel</td><td>Current</td><td>Status</td><td>Required</td><td>Optimal</td><td>Difference</td></tr>\n";
		
		$body .= "<tr><td>Enriched Uranium</td><td>".$pos['uranium']."</td><td>".POSMGMT::daycalc($pos['result_uptimecalc']['uranium'])."</td><td>".$static['uranium']."</td><td>".$pos['result_optimal']['optimum_uranium']."</td><td>".$diff['uranium']."</td></tr>\n";
		$body .= "<tr><td>Oxygen</td><td>".$pos['oxygen']."</td><td>".POSMGMT::daycalc($pos['result_uptimecalc']['oxygen'])."</td><td>".$static['oxygen']."</td><td>".$pos['result_optimal']['optimum_oxygen']."</td><td>".$diff['oxygen']."</td></tr>\n";
		$body .= "<tr><td>Mechanical Parts</td><td>".$pos['mechanical_parts']."</td><td>".POSMGMT::daycalc($pos['result_uptimecalc']['mechanical_parts'])."</td><td>".$static['mechanical_parts']."</td><td>".$pos['result_optimal']['optimum_mechanical_parts']."</td><td>".$diff['mechanical_parts']."</td></tr>\n";
		$body .= "<tr><td>Coolant</td><td>".$pos['coolant']."</td><td>".POSMGMT::daycalc($pos['result_uptimecalc']['coolant'])."</td><td>".$static['coolant']."</td><td>".$pos['result_optimal']['optimum_coolant']."</td><td>".$diff['coolant']."</td></tr>\n";
		$body .= "<tr><td>Robotics</td><td>".$pos['robotics']."</td><td>".POSMGMT::daycalc($pos['result_uptimecalc']['robotics'])."</td><td>".$static['robotics']."</td><td>".$pos['result_optimal']['optimum_robotics']."</td><td>".$diff['robotics']."</td></tr>\n";
		$body .= "<tr><td>".$static['race_isotope']." Isotopes</td><td>".$pos['isotope']."</td><td>".POSMGMT::daycalc($pos['result_uptimecalc']['isotope'])."</td><td>".$static['isotopes']."</td><td>".$pos['result_optimal']['optimum_isotope']."</td><td>".$diff['isotope']."</td></tr>\n";
		$body .= "<tr><td>Liquid Ozone</td><td>".$pos['ozone']."</td><td>".POSMGMT::daycalc($pos['result_uptimecalc']['ozone'])."</td><td>".$static['ozone']."</td><td>".$pos['result_optimal']['optimum_ozone']."</td><td>".$diff['ozone']."</td></tr>\n";
		$body .= "<tr><td>Heavy Water</td><td>".$pos['heavy_water']."</td><td>".POSMGMT::daycalc($pos['result_uptimecalc']['heavy_water'])."</td><td>".$static['heavy_water']."</td><td>".$pos['result_optimal']['optimum_heavy_water']."</td><td>".$diff['heavy_water']."</td></tr>\n";
		$body .= "</table>\n";
		$body .= "<br><hr><p>This an an automated email sent from POS-Tracker. If you do not wish to receive alerts from POS-Tracker, please update your profile in the User pannel of POS-Tracker</p>";
		
		$this->Subject	= "POS-Tracker Critical Alert: ".$static['typeName']." at ".$pos['MoonName'];
		
		$this->Body    = $body;
		$this->IsHTML(true);
		//$mail->AltBody = $text_body;
		$this->AddAddress($email, $character);

			if(!$this->Send())
			{
				echo "Error Sending Alert :: ".$this->ErrorInfo."<br>";
			}
		// Clear all addresses and attachments for next loop
		$this->ClearAddresses();
		$this->ClearAttachments();
		
		return true;
	}

}
    
