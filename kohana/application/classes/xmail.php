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
	
	var $attachments;
	var $is_priority;
	
	var $charset;
	var $contentType;
	
	function __construct()
	{
		$this->charset = 'ISO-8859-1';
		$this->contentType = 'text/html';
		
		$this->is_priority = TRUE;
		$this->BCC = array();
		$this->attachments = array();
	}
	
	function __headers()
	{
		$separator = md5(time());
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
			$headers .= "BCC: " . implode(", ", $b) . "\r\n";
		}
		
		$headers .= "X-Mailer: PHP/" . phpversion() ;
		
		if($this->is_priority) {
			$headers .= "X-Priority: 1 (Highest)\r\n";
			$headers .= "X-MSMail-Priority: High\r\n";
			$headers .= "Importance: High\r\n";
		}
		
		if(!empty($this->attachments)) {
			foreach($this->attachments as $a) {
				$attachment = chunk_split(base64_encode($a['file_content']));
				
				$headers .= "--" . $separator . "\r\n";
				$headers .= "Content-Type: application/octet-stream; name=\"{$a['filename']}\"" . "\r\n";
				$headers .= "Content-Transfer-Encoding: base64" . "\r\n";
				$headers .= "Content-Disposition: attachment" . "\r\n";
				$headers .= $attachment . "\r\n\n";
				$headers .= "--" . $separator . "--";
			}
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
	
	function addAttachment($filename, $content)
	{
		$this->attachments[] = array('filename' => $filename,
																 'file_content' => $content);
		return $this->attachments;
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
