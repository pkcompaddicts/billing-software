<?php
class User
{
  private  $_db,
           $_data,
		   $_sessionName,
		   $_cookieName,
		   $_isLoggedIn;
  
   public function __construct($user = null)
   {
     $this->_db= DB::getInstance();
	 
	 $this->_sessionName=Config::get('session/session_name');
	 $this->_cookieName=Config::get('remember/cookie_name');
	 
	 if(!$user)
	 {
	    if(Session::exists($this->_sessionName))
		{
		  $user = Session::get($this->_sessionName);
		  
		  if($this->find($user))
		  {
		     $this->_isLoggedIn=true;
		  }
		  else
		  {
		  
		  //process logout
		  
		  
		  }
		}
	 
	 }
	 else
	 {
	    $this->find($user);
	 }
   }
   
   
    public function update($fields = array(), $id = null)
   {
   
     if(!$id && $this->isLoggedIn())
	 {
	    $id= $this->data()->id;
	 }
     if(!$this->_db->update('users','id',$id ,$tmpimg=null,$path=null,$fields))
	 {
	    throw new Exception('There was a Problem creating an account');
	 }
   
   }
   
   
   public function create($fields = array())
   {
     if(!$this->_db->insert('users',$tmpimg=null,$path=null,$fields))
	 {
	    throw new Exception('There was a Problem creating an account');
	 }
	
	 
   
   }
   
   
   public function find($user = null)
   {
     if($user)
	 {
	   $field= (is_numeric($user)) ? 'id' : 'username';
	   
	   $data=$this->_db->getmultiple('users',array($field => $user,
	                                          'status' => '1'));
	   
	   if($data->ount())
	   {
	 
	   
	     $this->_data= $data->first();
		 return true;
	   
	   }
	   
	 
	 }
   
     return false;
   }
   
   
   public function login($username = null, $password = null,$remember = false)
   {
     if(!$username && !$password && $this->exists())
	 {
	 
	      Session::put($this->_sessionName,$this->data()->id);
	 
	 }
     else
	 {
		  $user = $this->find($username);
		  if($user)
		  {
		 
			if($this->data()->hash_password===Hash::make($password,$this->data()->salt))
			{
			   Session::put($this->_sessionName,$this->data()->id);
			   
			   if($remember)
			   {
				  $hash= Hash::Unique();
				  $hashCheck = $this->_db->get('users_session',array('user_id','=',$this->data()->id));
				  
				  if(!$hashCheck->ount())
				  {
					$this->_db->insert('users_session',array(
					'user_id' => $this->data()->id,
					'hash' => $hash
					));
				  }
				  else
				  {
					$hash=$hashCheck->first()->hash;
				  
				  }
				  
				  Cookie::put($this->_cookieName, $hash , Config::get('remember/cookie_expiry'));
			   
			   }
			   return true;
			}
		  }
	 } 
	  return false;
   
   }
   
   
   public function logout()
   {
     $this->_db->delete('users_session', array('user_id','=', $this->data()->id));
     Session::delete($this->_sessionName);
	 Cookie::delete($this->_cookieName);
   }
   
   
   public function exists()
   {
   
     return(!empty($this->_data)) ? true : false;
   
   }
   
   
   public function hasPermission($key)
   {
     $group=$this->_db->get('groups',array('id','=',$this->data()->group));
	 if($group->ount())
	 {
	    $permissions=$group->first()->permissions;
		if($permissions[$key] == true)
		{
		  return true;
		}
	 }
	 
	 return false;
   }
   
   public function data()
   {
     return $this->_data;
   }
   
   public function isLoggedIn()
   {
      return $this->_isLoggedIn;
   }
   
   
}

?>