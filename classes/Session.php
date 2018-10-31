<?php
class Session
{

    public static function exists($name)
	{
	
	   return (isset($_SESSION[$name])) ? true : false;
	
	}
	
	
	///////////////////////////   Session set.
	
	
	
    public static function put($name, $value)
	{
	
	   return $_SESSION[$name] = $value;
	 
	}
	
	
	public static function get($name)
	{
	
	   return $_SESSION[$name];
	
	}
	
	
	///////////////////////////   Session Unset.
	
	
	public static function delete($name)
	{
	
	   if(self::exists($name))
	   {
	   
	      unset($_SESSION[$name]);
	   
	   }
	
	}
	



	
//Flashing sessions is setting a session with some text or data, redirecting and showing this data while removing it. This allows for a message like 'you have been registered' to be shown to a user once, and once only.
	
	
	
	
	public static function flash($name, $string = '')
	{
	  if(self::exists($name))
	  {
	     $session = Session::get($name);
		 self::delete($name);
		 return $session;
	  
	  }
	  
	  else
	  {
	    self::put($name,$string);
	  }
	
	
	}
}

?>