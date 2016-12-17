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
		return $urlPath;
		/*$pConverted=new Convertor($urlPath, $this->ServerPath);
		$data=$pConverted->processConverting();
		return array('UrlConverted'=>$data);*/
	}
}
?>