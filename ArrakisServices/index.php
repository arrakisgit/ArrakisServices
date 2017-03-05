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


$uploaddir = realpath('./') . '/';

echo '<pre>';

echo 'Here is some more debugging info:';
print_r($_FILES);
echo "\n<hr />\n";
print_r($_POST);
print "</pr" . "e>\n";

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
		
		$this->verb = $_SERVER['REQUEST_METHOD'];
		$this->url_elements = explode('/', $_SERVER['PATH_INFO']);
		
		$uploadfile = $uploaddir . basename($_FILES['file_contents']['name']);
		return 'construct()';
		if (move_uploaded_file($_FILES['file_contents']['tmp_name'], $uploadfile)) 
		{
			// route the request to the right place
			$controller_name = ucfirst($this->url_elements[1]) . 'Controllers';
			if (class_exists($controller_name))
			{
				$controller = new $controller_name();
				$action_name = strtolower($this->verb) . 'Action';
				$this->result=$controller->$action_name($uploadfile);
			}
			else
			{
				$this->result ='rien //'.$uploadfile;//$controller_name;//$_SERVER['PATH_INFO'];
			}
		} 
		else 
		{
			$this->result = "Possible file upload attack!\n";
		}
		
		
		return $this->result;//'boubalou';//$this->result;//$results;//true;
	}
		
	public function parseIncomingParams() 
	{
			$parameters = array();
		
			// first of all, pull the GET vars
			if (isset($_SERVER['QUERY_STRING'])) 
			{
				parse_str($_SERVER['QUERY_STRING'], $parameters);
			}
		
			// now how about PUT/POST bodies? These override what we got from GET
			$body = file_get_contents("php://input");
			$content_type = false;
			
			if(isset($_SERVER['CONTENT_TYPE']))
			{
				$content_type = $_SERVER['CONTENT_TYPE'];
			}
			
			switch($content_type)
			{
				case "application/json":
					//$this->parameters =$body;
					$body_params = json_decode($body,true);
					//$error = json_last_error();
					
					$this->parameters =$body_params;
					/*if($body_params)
					{
						foreach($body_params as $param_name => $param_value)
						{
							$parameters[$param_name] = $param_value;
						}
					}*/
					$this->format = "json";
					break;
				case "application/x-www-form-urlencoded":
					parse_str($body, $postvars);
					foreach($postvars as $field => $value)
					{
						$parameters[$field] = $value;
		
					}
					$this->format = "html";
					break;
				default:
					// we could parse other supported formats here
					break;
			}
			//$this->parameters = $body;//$parameters;
		}
		
		public function decodeJsonError($errorCode)
		{
			$errors = array(
					JSON_ERROR_NONE => 'No error has occurred',
					JSON_ERROR_DEPTH => 'The maximum stack depth has been exceeded',
					JSON_ERROR_STATE_MISMATCH => 'Invalid or malformed JSON',
					JSON_ERROR_CTRL_CHAR => 'Control character error, possibly incorrectly encoded',
					JSON_ERROR_SYNTAX => 'Syntax error',
					JSON_ERROR_UTF8 => 'Malformed UTF-8 characters, possibly incorrectly encoded',
					JSON_ERROR_RECURSION => 'One or more recursive references in the value to be encoded',
					JSON_ERROR_INF_OR_NAN => 'One or more NAN or INF values in the value to be encoded',
					JSON_ERROR_UNSUPPORTED_TYPE => 'A value of a type that cannot be encoded was given'
			);
		
			if (isset($errors[$errorCode]))
			{
				return $errors[$errorCode];
			}
		
			return 'Unknown error';
		}
}
?>