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
echo 'result = '.$oWebPage->resultat;

class SendMediaFiles
{
	private $ch;
	private $urlArrakisServices;
	private $fileUploaded;
	public $resultat;
	public function __construct($pUrlService)
	{
		$this->urlArrakisServices=$pUrlService;
		$uploaddir = '/var/www/uploads/';
		
		if (is_uploaded_file($_FILES['userfile']['name']))
		{
			$this->fileUploaded = $uploaddir . basename($_FILES['userfile']['name']);
			$this->resultat = SendCallArrakisServices();
		}
		else 
		{
			$this->fileUploaded = 'no file';
		}
		
	}
	
	public function SendCallArrakisServices()
	{
		
		$file_name_with_full_path=$this->fileUploaded;
		
		$this->ch = curl_init($this->urlArrakisServices);
		
		if (function_exists('curl_file_create'))
		{ // php 5.6+
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			$typemim= finfo_file($finfo, $file_name_with_full_path);
			$cFile = new CURLFile($file_name_with_full_path,$typemim);
		}
		else
		{ 
			$cFile = '@' . realpath($file_name_with_full_path);
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
}
?>