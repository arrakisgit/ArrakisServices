<?php
class ActionsControllers //extends MyController
{
	private $ServerPath;
	
	public function __construct()
	{
		$this->ServerPath="http://127.0.0.1";
	}
	public function getAction($request) 
	{
		
	}

	public function postAction($request)
	{
		$urlPath=$request->parameters['urlPath'];
		$pConverted=new Convertor($urlPath, $this->ServerPath);
		$data=$pConverted->processConverting();
		return array('UrlConverted'=>$data);
	}
}
?>