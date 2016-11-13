<?php
class ActionsControllers //extends MyController
{
	public function getAction($request) 
	{
		
	}

	public function postAction($request)
	{
			$data = $request->parameters;
			$data['message'] = "This data was submitted";
			return $data;
	}
}
?>