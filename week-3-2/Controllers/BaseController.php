<?php

namespace Controllers;

abstract class BaseController
{
	protected function loadView($view, $data = [])
	{
		extract($data);
		require("views/" . $view . ".php");
	}
}
