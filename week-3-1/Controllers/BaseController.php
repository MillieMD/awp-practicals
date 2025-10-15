<?php

namespace Controllers;

abstract class BaseController
{

	protected function loadView($view, $data = [])
	{
		//The extract() function creates a variable for each key in an array e.g. 
		//$arr=["msg"=>"hello","active"=>true];
		//extract($arr);
		//echo $msg; //outputs hello
		extract($data);
		require("views/" . $view . ".php");
	}
}
