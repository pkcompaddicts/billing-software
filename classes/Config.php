<?php

class Config
{


	public static function get($path = null)
	{

		if($path)
		{

			$config = $GLOBALS['config'];
			$path = explode('/', $path);
			foreach ($path as $bit ) {
				if(isset($config[$bit]))
				{
//echo 'SET';
					 $config = $config[$bit];
					// echo $config;
				//exit;
				}
		}
		return $config;
	}
	return false; //if we dont having anything in the parameter.
}

}

?>