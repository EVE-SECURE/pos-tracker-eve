<?php
/* $Id$ */
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
		$body .= "<tr bgcolor=\"#4F0202\"><td>><font color=\"FFFFFF\">Fuel</font></td><td><font color=\"FFFFFF\">Current</font></td><td><font color=\"FFFFFF\">Status</font></td><td><font color=\"FFFFFF\">Required</font></td><td><font color=\"FFFFFF\">Optimal</font></td><td><font color=\"FFFFFF\">Difference</font></td></tr>\n";
		
		$body .= "<tr><td><font color=\"000000\">Enriched Uranium</font></td><td><font color=\"000000\">".$pos['uranium']."</font></td><td><font color=\"000000\">".POSMGMT::daycalc($pos['result_uptimecalc']['uranium'])."</font></td><td><font color=\"000000\">".$static['uranium']."</font></td><td><font color=\"000000\">".$pos['result_optimal']['optimum_uranium']."</font></td><td><font color=\"000000\">".$diff['uranium']."</font></td></tr>\n";
		$body .= "<tr><td><font color=\"000000\">Oxygen</font></td><td><font color=\"000000\">".$pos['oxygen']."</font></td><td><font color=\"000000\">".POSMGMT::daycalc($pos['result_uptimecalc']['oxygen'])."</font></td><td><font color=\"000000\">".$static['oxygen']."</font></td><td><font color=\"000000\">".$pos['result_optimal']['optimum_oxygen']."</font></td><td><font color=\"000000\">".$diff['oxygen']."</font></td></tr>\n";
		$body .= "<tr><td><font color=\"000000\">Mechanical Parts</font></td><td><font color=\"000000\">".$pos['mechanical_parts']."</font></td><td><font color=\"000000\">".POSMGMT::daycalc($pos['result_uptimecalc']['mechanical_parts'])."</font></td><td><font color=\"000000\">".$static['mechanical_parts']."</font></td><td><font color=\"000000\">".$pos['result_optimal']['optimum_mechanical_parts']."</font></td><td><font color=\"000000\">".$diff['mechanical_parts']."</font></td></tr>\n";
		$body .= "<tr><td><font color=\"000000\">Coolant</font></td><td><font color=\"000000\">".$pos['coolant']."</font></td><td><font color=\"000000\">".POSMGMT::daycalc($pos['result_uptimecalc']['coolant'])."</font></td><td><font color=\"000000\">".$static['coolant']."</font></td><td><font color=\"000000\">".$pos['result_optimal']['optimum_coolant']."</font></td><td><font color=\"000000\">".$diff['coolant']."</font></td></tr>\n";
		$body .= "<tr><td><font color=\"000000\">Robotics</font></td><td><font color=\"000000\">".$pos['robotics']."</font></td><td><font color=\"000000\">".POSMGMT::daycalc($pos['result_uptimecalc']['robotics'])."</font></td><td><font color=\"000000\">".$static['robotics']."</font></td><td><font color=\"000000\">".$pos['result_optimal']['optimum_robotics']."</font></td><td><font color=\"000000\">".$diff['robotics']."</font></td></tr>\n";
		$body .= "<tr><td><font color=\"000000\">".$static['race_isotope']." Isotopes</font></td><td><font color=\"000000\">".$pos['isotope']."</font></td><td><font color=\"000000\">".POSMGMT::daycalc($pos['result_uptimecalc']['isotope'])."</font></td><td><font color=\"000000\">".$static['isotopes']."</font></td><td><font color=\"000000\">".$pos['result_optimal']['optimum_isotope']."</font></td><td><font color=\"000000\">".$diff['isotope']."</font></td></tr>\n";
		$body .= "<tr><td><font color=\"000000\">Liquid Ozone</font></td><td><font color=\"000000\">".$pos['ozone']."</font></td><td><font color=\"000000\">".POSMGMT::daycalc($pos['result_uptimecalc']['ozone'])."</font></td><td><font color=\"000000\">".$pos['ozone']."</font></td><td><font color=\"000000\">".$pos['result_optimal']['optimum_ozone']."</font></td><td><font color=\"000000\">".$diff['ozone']."</font></td></tr>\n";
		$body .= "<tr><td><font color=\"000000\">Heavy Water</font></td><td><font color=\"000000\">".$pos['heavy_water']."</font></td><td><font color=\"000000\">".POSMGMT::daycalc($pos['result_uptimecalc']['heavy_water'])."</font></td><td><font color=\"000000\">".$pos['heavy_water']."</font></td><td><font color=\"000000\">".$pos['result_optimal']['optimum_heavy_water']."</font></td><td><font color=\"000000\">".$diff['heavy_water']."</font></td></tr>\n";
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
		$body .= "<tr bgcolor=\"#4F0202\"><td>><font color=\"FFFFFF\">Fuel</font></td><td><font color=\"FFFFFF\">Current</font></td><td><font color=\"FFFFFF\">Status</font></td><td><font color=\"FFFFFF\">Required</font></td><td><font color=\"FFFFFF\">Optimal</font></td><td><font color=\"FFFFFF\">Difference</font></td></tr>\n";
		
		$body .= "<tr><td><font color=\"000000\">Enriched Uranium</font></td><td><font color=\"000000\">".$pos['uranium']."</font></td><td><font color=\"000000\">".POSMGMT::daycalc($pos['result_uptimecalc']['uranium'])."</font></td><td><font color=\"000000\">".$static['uranium']."</font></td><td><font color=\"000000\">".$pos['result_optimal']['optimum_uranium']."</font></td><td><font color=\"000000\">".$diff['uranium']."</font></td></tr>\n";
		$body .= "<tr><td><font color=\"000000\">Oxygen</font></td><td><font color=\"000000\">".$pos['oxygen']."</font></td><td><font color=\"000000\">".POSMGMT::daycalc($pos['result_uptimecalc']['oxygen'])."</font></td><td><font color=\"000000\">".$static['oxygen']."</font></td><td><font color=\"000000\">".$pos['result_optimal']['optimum_oxygen']."</font></td><td><font color=\"000000\">".$diff['oxygen']."</font></td></tr>\n";
		$body .= "<tr><td><font color=\"000000\">Mechanical Parts</font></td><td><font color=\"000000\">".$pos['mechanical_parts']."</font></td><td><font color=\"000000\">".POSMGMT::daycalc($pos['result_uptimecalc']['mechanical_parts'])."</font></td><td><font color=\"000000\">".$static['mechanical_parts']."</font></td><td><font color=\"000000\">".$pos['result_optimal']['optimum_mechanical_parts']."</font></td><td><font color=\"000000\">".$diff['mechanical_parts']."</font></td></tr>\n";
		$body .= "<tr><td><font color=\"000000\">Coolant</font></td><td><font color=\"000000\">".$pos['coolant']."</font></td><td><font color=\"000000\">".POSMGMT::daycalc($pos['result_uptimecalc']['coolant'])."</font></td><td><font color=\"000000\">".$static['coolant']."</font></td><td><font color=\"000000\">".$pos['result_optimal']['optimum_coolant']."</font></td><td><font color=\"000000\">".$diff['coolant']."</font></td></tr>\n";
		$body .= "<tr><td><font color=\"000000\">Robotics</font></td><td><font color=\"000000\">".$pos['robotics']."</font></td><td><font color=\"000000\">".POSMGMT::daycalc($pos['result_uptimecalc']['robotics'])."</font></td><td><font color=\"000000\">".$static['robotics']."</font></td><td><font color=\"000000\">".$pos['result_optimal']['optimum_robotics']."</font></td><td><font color=\"000000\">".$diff['robotics']."</font></td></tr>\n";
		$body .= "<tr><td><font color=\"000000\">".$static['race_isotope']." Isotopes</font></td><td><font color=\"000000\">".$pos['isotope']."</font></td><td><font color=\"000000\">".POSMGMT::daycalc($pos['result_uptimecalc']['isotope'])."</font></td><td><font color=\"000000\">".$static['isotopes']."</font></td><td><font color=\"000000\">".$pos['result_optimal']['optimum_isotope']."</font></td><td><font color=\"000000\">".$diff['isotope']."</font></td></tr>\n";
		$body .= "<tr><td><font color=\"000000\">Liquid Ozone</font></td><td><font color=\"000000\">".$pos['ozone']."</font></td><td><font color=\"000000\">".POSMGMT::daycalc($pos['result_uptimecalc']['ozone'])."</font></td><td><font color=\"000000\">".$pos['ozone']."</font></td><td><font color=\"000000\">".$pos['result_optimal']['optimum_ozone']."</font></td><td><font color=\"000000\">".$diff['ozone']."</font></td></tr>\n";
		$body .= "<tr><td><font color=\"000000\">Heavy Water</font></td><td><font color=\"000000\">".$pos['heavy_water']."</font></td><td><font color=\"000000\">".POSMGMT::daycalc($pos['result_uptimecalc']['heavy_water'])."</font></td><td><font color=\"000000\">".$pos['heavy_water']."</font></td><td><font color=\"000000\">".$pos['result_optimal']['optimum_heavy_water']."</font></td><td><font color=\"000000\">".$diff['heavy_water']."</font></td></tr>\n";
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
    
