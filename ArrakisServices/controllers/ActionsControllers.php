<?php
class ActionsControllers //extends MyController
{
	private $ServerPath;
	
	public function __construct()
	{
		$this->ServerPath="http://192.168.0.44/ArrakisServices/ArrakisServices/";
	}
	public function getAction() 
	{
		return 'getAction';
	}

	public function postAction($param)
	{
		//return $param;
		$urlPath=$param['urlPath'];
		//return $urlPath;
		//$pConverted=new Convertor($urlPath, $this->ServerPath);
		$data=Convector($urlPath);
		return array('UrlConverted'=>$data);
	}
	
	public function Convector($PathOrigine)
	{
		$vide='';
		$SRV_CONVERT='http://192.168.0.44/ArrakisWeb/ArrakisVideos/';
		$extension=strtoupper(strrev(explode('.',strrev(strrev(explode('/',strrev($PathOrigin))[0])))[0]));
		 $NameVideos=str_replace('.'.strtolower($extension),$vide,strrev(explode('/',strrev($PathOrigin))[0]));
		 $URL_COVERT_VIDEOS=$SRV_CONVERT.$NameVideos.'.mp4';
		
		 if ($extension=='AVI')
		 {
		 $commandeShell='sudo avconv -i '.$PathOrigin.' -c:v libx264 -c:a copy '.str_replace('http://192.168.0.44','/var/www/html',$URL_COVERT_VIDEOS);
		 $result=$this->ExcuteShell($commandeShell);
		
		 }
		 elseif ($extension=="MKV")
		 {
		 $commandeShell='sudo ffmpeg -i '.$urlPath.' -vcodec copy -acodec copy '.$URL_COVERT_VIDEOS;
		 $result=$this->ExcuteShell($commandeShell);
		
		 }
		 else
		 {
		 	
		 }
		 $PathConvertedFile=$URL_COVERT_VIDEOS;
		return $PathConvertedFile;
	}
	
	public function ExcuteShell($cmd)
	{
		$output = shell_exec($cmd);
		return $output;
	
	}
	
}
?>