<?php
class Email
{
	public $_body;
	 
	public function LoadTemplate($name)
	{
		$this->_body = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/Email/Templates/$name.html");
	}
	
	public function SetValue($name, $value)
	{
		$this->_body = str_replace("[$name]", $value, $this->_body);		
	}
	
	public function Send($to, $subject, $reply = null, $copy = true)
	{
        $base_template = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/Email/Templates/base.html");
        $this->_body = str_replace("[content]", $this->_body, $base_template);
        $this->SetValue('url', 'http://' . $_SERVER['SERVER_NAME']);

		if ($reply == null) {
			$reply = $GLOBALS['from'];
		}
		
		$this->fixBody();
		
		$subject = "=?utf-8?b?" . base64_encode($subject) . "?=";
		
		if ($_SERVER['SERVER_NAME'] == 'localhost') {
			return;
			echo $this->_body;
			exit;
		}
		/*echo "[$to],<br>[[$subject]]<br>" . $this->_body;
		exit;*/
		//echo $this->_body;
		mail($to, $subject, $this->_body, $this->_getHeaders($reply));
		if (strpos($to, $GLOBALS['admin']) === false && $copy) {
			mail($GLOBALS['admin'], "[Ушло клиенту] " . $subject, $this->_body, $this->_getHeaders($reply));
		}
	}
	
	public function SendWithAttachments($to, $subject, $files, $reply = null, $copy = true) {
		$reply = $GLOBALS['from'];
		
		$uid = md5(time());
		
		$this->fixBody();
		
		if ($_SERVER['SERVER_NAME'] == 'localhost') {
			echo $this->_body;
			exit;
		}
	    
	    $header = "From: =?utf-8?b?" . base64_encode($GLOBALS['from_name']) . "?= <" . $reply . ">\r\n";
	    $header .= "Reply-To: ".$reply."\r\n";
	    $header .= "MIME-Version: 1.0\r\n";
	    $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
	    $header .= "This is a multi-part message in MIME format.\r\n";
	    $header .= "--".$uid."\r\n";
	    $header .= "Content-type:text/html; charset=utf-8\r\n";
	    $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
	    $header .= $this->_body."\r\n\r\n";
	    $header .= "--".$uid."\r\n";
	    
	    foreach ($files as $file) {
	    	$file_size = filesize($file);
		    $handle = fopen($file, "r");
		    $content = fread($handle, $file_size);
		    fclose($handle);
		    $content = chunk_split(base64_encode($content));
		    
		    $filename = $file;
		    
		    $pos = strpos($filename, '/');
			if ($pos !== false) {
				$filename = substr($filename, $pos + 1);
			}
	    	
		    $header .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n";
		    $header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n";
		    $header .= "Content-Transfer-Encoding: base64\r\n\r\n";
		    $header .= $content."\r\n\r\n";
		    $header .= "--".$uid."\r\n";
	    }
	    
	    $subject = "=?utf-8?b?" . base64_encode($subject) . "?=";
	    
		mail($to, $subject, '', $header);
	}
	
	private function fixBody()
	{
		$this->_body = str_replace(", !", "!", $this->_body);
		$this->_body = str_replace("\\r\\n", "<br/>", $this->_body);
	}
	
	private function _getHeaders($reply)
	{
		$headers = "From: =?utf-8?b?" . base64_encode($GLOBALS['from_name']) . "?= <" . $reply . ">\r\n" .
    			   "Reply-To: $reply\r\n" .
		   		   'Content-type: text/html; charset=utf-8' . "\r\n".
    	           'X-Mailer: PHP/' . phpversion();
			
		return $headers;
	}
}