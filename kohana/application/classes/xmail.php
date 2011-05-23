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
		$headers  = "MIME-Version: 1.0\n";
		$headers .= "Content-type: {$this->contentType}; charset=\"{$this->charset}\"\n";
		
		// Set From
		if(isset($this->from)) {
			$headers .= "From: {$this->from}\n";
		} else {
			$headers .= "From: TilbudiByen <no-reply@tilbudibyen.com>\n";
		}
		
		// Set Reply-To
		if(isset($this->replyTo)) {
			$headers .= "Reply-To: {$this->replyTo}\n";
		} else {
			$headers .= "Reply-To: no-reply@tilbudibyen.com\n";
		}
		
		// Set BCC
		if(!empty($this->BCC)) {
			foreach($this->BCC as $bcc) {
				$b[] = "{$bcc['name']} <{$bcc['email']}>";
			}
			$headers .= "BCC: " . implode(", ", $b) . "\n";
		}
		
		$headers .= "X-Mailer: PHP/" . phpversion() . "\n";
		
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
