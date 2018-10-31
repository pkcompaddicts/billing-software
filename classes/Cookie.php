<?php
class Cookie
{

    public static function exists($name)
	{
	
	   return (isset($_COOKIE[$name])) ? true : false;
	
	}
	
	
	///////////////////////////   COOKIE set.
	
	
	
    public static function put($name, $value , $expiry)
	{
	   if(setcookie($name,$value,time() + $expiry, '/'))
	   {
	      return true;
	   }
	   
	   
	   return false;
	 
	}
	
	
	public static function get($name)
	{
	
	   return $_COOKIE[$name];
	
	}
	
	
	///////////////////////////   Session Unset.
	
	
	public static function delete($name)
	{
	
	   self::put($name,'',time() -1);
	
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