<?php
/**
 * This is a Wrapper for mailer used to fasten things up
 *
 * @author	Paul Winston Villacorta	<pwvillacorta@cebudirectories.com>
 */
 
class XMail
{
	var $headers;
	var $message;
	var $to;
	var $subject;
	var $from;

	var $replyTo;
	var $bcc;
	
	var $is_priority;
	
	var $charset;
	var $contentType;
	
	function __construct()
	{
		$this->charset = 'ISO-8859-1';
		$this->contentType = 'text/html';
		
		$this->is_priority = TRUE;
		$this->BCC = array();
	}
	
	function __headers()
	{

		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
		$headers .= "From: no-reply@tilbudibyen.com" . "\r\n".
								"Reply-To: no-reply@tilbudibyen.com" . "\r\n".
								"X-Mailer: PHP/" . phpversion();

	  
		$headers  = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type: {$this->contentType}; charset='{$this->charset}'" . "\r\n";
		
		// Set From
		if(isset($this->from)) {
			$headers .= "From: {$this->from}" . "\r\n";
		} else {
			$headers .= "From: TilbudiByen <no-reply@tilbudibyen.com>" . "\r\n";
		}
		
		// Set Reply-To
		if(isset($this->replyTo)) {
			$headers .= "Reply-To: {$this->replyTo}" . "\r\n";
		} else {
			$headers .= "Reply-To: no-reply@tilbudibyen.com" . "\r\n";
		}
		
		// Set BCC
		if(!empty($this->BCC)) {
			foreach($this->BCC as $bcc) {
				if(isset($bcc['name'])) {
					$b[] = "{$bcc['name']} <{$bcc['email']}>";
				} else {
					$b[] = $bcc['email'];
				}
			}
			$headers .= "BCC: " . implode(", ", $b) . "\n";
		}
		
		$headers .= "X-Mailer: PHP/" . phpversion() ;
		
		if($this->is_priority) {
			$headers .= "X-Priority: 1 (Highest)\n";
			$headers .= "X-MSMail-Priority: High\n";
			$headers .= "Importance: High\n";
		}
		
		$this->headers = $headers;
		return $this->headers;
	}
	
	function setFrom($name, $email)
	{
		$this->from = "$name <$email>";
	}
	
	function addBCC($name, $email)
	{
		$this->BCC[] = array('name' => $name,
												 'email' => $email);
		return $this->BCC;
	}
	
	function setHeaders($header)
	{
		$this->headers = $header;
		return $this->headers;
	}
	
	function send($to=null, $subject=null, $message=null, $header=null)
	{
		$headers = isset($header) ? $header : $this->__headers();
		$to 		 = isset($to) ? $to : $this->to;
		$subject = isset($subject) ? $subject : $this->subject;
		$message = isset($message) ? $message : $this->message;

		return mail($to, $subject, $message, $headers);
	}
}
?>
