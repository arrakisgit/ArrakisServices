<?php
/*Auteur      : Amine El Ouazzani
 *Projet      : Arrakis
 *Date        : 08/07/2017 
 *Licence     : GNU GPL v3
 *Description : Controller send media file to webservice
 *git         : https://github.com/arrakisgit/ArrakisServices.git
 */


echo 'initialisation<br/>';
$oWebPage = new SendMediaFiles('http://192.168.0.23/ArrakisServices/ArrakisServices/index.php/Actions');

if ($oWebPage->resultat!='no file')
{
	echo 'result = '.$oWebPage->SendCallArrakisServices();
}
else
{
	echo 'result = '.$oWebPage->resultat;
}

class SendMediaFiles
{
	private $ch;
	private $urlArrakisServices;
	private $fileUploaded;
	public $resultat;
	public function __construct($pUrlService)
	{
		$this->urlArrakisServices=$pUrlService;
		$uploaddir = '/var/www/html/ArrakisServices/uploads/';
		
		if (is_uploaded_file($_FILES['userfile']['tmp_name']))
		{
			$this->fileUploaded = $uploaddir . basename($_FILES['userfile']['tmp_name']);
		}
		else 
		{
			$this->resultat ='no file';
		}
		
	}
	
	public function SendCallArrakisServices()
	{
		
		if (move_uploaded_file($_FILES['userfile']['tmp_name'], $this->fileUploaded))
		{
		
			$this->ch = curl_init($this->urlArrakisServices);
			
			if (function_exists('curl_file_create'))
			{ // php 5.6+
				$finfo = finfo_open(FILEINFO_MIME_TYPE);
				$typemim= finfo_file($finfo, $this->fileUploaded);
				$cFile = new CURLFile($this->fileUploaded,$typemim);
			}
			else
			{
				$cFile = '@' . realpath($this->fileUploaded);
			}
			
			$post = array('extra_info' => 'videos file','file_contents'=> $cFile);
			curl_setopt_array($this->ch, array(
					CURLOPT_POST => TRUE,
					CURLOPT_RETURNTRANSFER => TRUE,
					CURLOPT_POSTFIELDS => $post
			));
			
			// Send the request
			$response = curl_exec($this->ch);
			
			return $response;
		}
		else 
		{
			return 'no file moved';
		}
		
	}
}
?>