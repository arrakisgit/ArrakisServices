<?php

spl_autoload_register('apiAutoload');
function apiAutoload($classname)
{
	if (preg_match('/[a-zA-Z]+Controllers$/', $classname)) 
	{
		include __DIR__ . '/controllers/' . $classname . '.php';
		return true;
	} 
	elseif (preg_match('/[a-zA-Z]+Models$/', $classname)) 
	{
		include __DIR__ . '/models/' . $classname . '.php';
		return true;
	} 
	elseif (preg_match('/[a-zA-Z]+Views$/', $classname)) 
	{
		include __DIR__ . '/views/' . $classname . '.php';
		return true;
	}
}


//$uploaddir = realpath('./') . '/';

$request = new Request();

echo $request->result;

class Request 
{
	public $url_elements;
	public $verb;
	public $parameters;
	public $format;
	public $result;

	public function __construct() 
	{
		//return 'ici c est bon';
		$this->verb = $_SERVER['REQUEST_METHOD'];
		$this->url_elements = explode('/', $_SERVER['PATH_INFO']);
		$uploaddir = realpath('./') . '/';
		$uploadfile = $uploaddir . basename($_FILES['file_contents']['name']);
		
		$this->result = 'verb := '.$this->verb.'<br/>'.'url_elements := '.$this->url_elements.'<br/>'.'uploaddir := '.$uploaddir.'<br/>'.'uploadfile := '.$uploadfile;
		
		//if (move_uploaded_file($_FILES['file_contents']['tmp_name'], $uploadfile)) 
		//{
			// route the request to the right place
			
			/*
			$controller_name = ucfirst($this->url_elements[1]) . 'Controllers';
			if (class_exists($controller_name))
			{
				$controller = new $controller_name();
				$action_name = strtolower($this->verb) . 'Action';
				$this->result=$controller->$action_name($uploadfile);
			}
			else
			{
				$this->result ='rien'; //.$uploadfile;//$controller_name;//$_SERVER['PATH_INFO'];
			}
		} 
		else 
		{
			$this->result = "Possible file upload attack!\n";
		}
		
		*/
		//return $this->result;//'boubalou';//$this->result;//$results;//true;
	}
		
}
?>