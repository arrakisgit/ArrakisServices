<?php

class Convertor
{
	private $PathOrigin;
	private $PathServer;
	private $PathConvertedFile;
	
	public function __construct($origin,$server)
	{
		$this->PathOrigin=$origin;
		$this->PathServer=$server;
	}
	
	public function processConverting()
	{
		$vide='';
		$SRV_CONVERT='http://127.0.0.1/ArrakisWeb/ArrakisVideos/';
		$extension=strtoupper(strrev(explode('.',strrev(strrev(explode('/',strrev($this->PathOrigin))[0])))[0]));
		$NameVideos=str_replace('.'.strtolower($extension),$vide,strrev(explode('/',strrev($this->PathOrigin))[0]));
		$URL_COVERT_VIDEOS=$SRV_CONVERT.$NameVideos.'.mp4';
		
		if ($extension=='AVI')
		{
			$commandeShell='sudo avconv -i '.$this->PathOrigin.' -c:v libx264 -c:a copy '.str_replace('http://127.0.0.1','/var/www/html',$URL_COVERT_VIDEOS);
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
		$this->PathConvertedFile=$URL_COVERT_VIDEOS;
		return $this->PathConvertedFile;
	}
	
	public function ExcuteShell($cmd)
	{
		$output = shell_exec($cmd);
		return $output;
	
	}
}
?>