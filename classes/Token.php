<?php
class Token 
{


//Here we implement a token generation system to protect against Cross Site Request Forgery (CSRF).


   public static function generate()
   {
   
      return Session::put(Config::get('session/token_name'),md5(uniqid()));
	  
   }
   
   public static function check($token)
   {
      $tokenName= Config::get('session/token_name');
	  
	  if(Session::exists($tokenName) && ($token === Session::get($tokenName)))
	  {
	  
	     Session::delete($tokenName);
		 return true;
	  
	  }
	  else
	  {
	     return Session::put($token,md5(uniqid()));
	  }
	  
	  return false;
   
   }
}

?>