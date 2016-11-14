<?php
class JsonViews //extends ApiView 
{
	public function render($content) 
	{
		header('Content-Type: application/json; charset=utf8');
		echo json_encode($content);
		return json_encode($content);
	}
}
?>