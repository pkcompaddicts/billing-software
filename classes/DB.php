<?php

class DB 

{



	private static $_instance = null ;
	private $_pdo,
	        $_query,
			$_set,
	        $_error = false ,
	        $_results,
			$_lastinsertId,
	        $_count = 0;


    private function __construct()
    {
	
	        $db=Config::get('mysql/db');
	        $host=Config::get('mysql/host');
	        $username=Config::get('mysql/username');
	        $pass=Config::get('mysql/password');
	        $dsn = 'mysql:dbname='.$db.';host='.$host;
            $user = $username;
            $password = $pass;

            try 
			
			{
                   $this->_pdo = new PDO($dsn, $user, $password);
            } 
			catch (PDOException $e) 
			{
                    echo 'Connection failed: ' . $e->getMessage();
            }

    }


		
		
		
    public static function getInstance()
    {

            if(!isset(self::$_instance))
            {
                    self::$_instance = new DB();
            }
            else
			{
                    self::$_instance;
            }
        return self::$_instance;
    }

	   
	   
	   
    public function query($sql,$params = array())
    {

       
                 $this->_error = false;
				 
				
				 
                if($this->_query = $this->_pdo->prepare($sql))
                {
	
                                 $x = 1;

                                  if(count($params))
                                  {
								  


                                                   foreach ($params as $param)
    											   {
												 

                                                             $this->_query->bindValue($x , $param);
                                                             $x++;
                                                   }
												  
                                  }
								
                                  if($this->_query->execute())
                                  {
								    
					
						                  
                                                   $this->_results= $this->_query->fetchAll(PDO::FETCH_OBJ);
                                                   $this->_count=$this->_query->rowCount();
						   $this->_lastinsertId=$this->_pdo->lastInsertId();
    
                                  }
                                  else
                                  {
								                
                                                    $this->_error=true;
                                  }
    
                                  return $this;
                }
     
    }
        
        
		
		
     public function action($action,$tbl,$where= array())
     {

     	 
                if(count($where===3))
				{
					   $operators=array('=','>','<','>=','<=','!=');
					   
					   $column=$where[0];
					   $operator=$where[1];
					   $value=$where[2];
					   
					   
					   if(in_array($operator,$operators))
					         
					   {
							      $sql= "{$action} FROM {$tbl} WHERE {$column} {$operator} ? ";
								 
								  if(!$this->query($sql,array($value))->error())
								  {
										return $this;
										  
								  }
							 
							 
						}
				}
					   
			    return false;		   
     }
		
		
		
	public function get($tbl,$where)
    {

         return $this->action('SELECT * ',$tbl,$where);

    }
	
	public function getdistinct($tbl,$col,$where)
    {

         return $this->action("SELECT DISTINCT {$col}",$tbl,$where);

    }
	
	
	public function delete($tbl,$where)
    {

         return $this->action('DELETE',$tbl,$where);

    }


    public function ount()
	{
	   return $this->_count;
	}
	
	
	
	public function results()
	{
	 
	   return $this->_results;
	
	}
	
	public function first()
	{
	  return $this->_results[0];
	}
     
		
	public function insert($tbl,$tmpimg= null,$path= null,$fields = array())
	{
	
	    
	   
	   
	   if(count($fields))
	   {
	      $keys=array_keys($fields);
		  $values = " " ;
		  $x=1;
		  
		  foreach($fields as $field)
		  {
		   $values .='? ';
		  
		      if($x < count($fields))
			  {
			  $values .= ', ';
			  }
		   $x++;
		  }
		  
		   if($tmpimg)
	   {
	      $this->uploadfile($path,$tmpimg);
	   }
	   
	   
		  $col=implode(',',$keys);
		  
		  $sql="INSERT INTO {$tbl} ({$col}) VALUES ({$values})";
		  
		  
		  if(!$this->query($sql, $fields)->error())
		  {
		      return true;
		  }
		  else
		  {
		 echo "Error";
		  }
		  
	   
	   }
	   
	   return false;
	
	}
	
	
	public function insertwithoutimage($tbl,$fields = array())
	{
	
	    
	   
	   
	   if(count($fields))
	   {
	      $keys=array_keys($fields);
		  $values = " " ;
		  $x=1;
		  
		  foreach($fields as $field)
		  {
		   $values .='? ';
		  
		      if($x < count($fields))
			  {
			  $values .= ', ';
			  }
		   $x++;
		  }
		  
		 
	   
	   
		  $col=implode(',',$keys);
		  
		  $sql="INSERT INTO {$tbl} ({$col}) VALUES ({$values})";
		  
		  if(!$this->query($sql, $fields)->error())
		  {
		      return true;
		  }
		  else
		  {
		 echo "Error";
		  }
		  
	   
	   }
	   
	   return false;
	
	}
	
	
	public function update($tbl,$col,$id,$tmpimg= null,$path= null,$fields = array())
	{
	   $set = "";
	   $x= 1;
	   foreach($fields as $name => $value)
	   {
	      $set .= "{$name} = ? ";
		  if($x < count($fields))
		  {
		     $set .=', ';
		  }
		  
		  $x++;
	   
	   }
	   
	   if($tmpimg)
	   {
	      $this->uploadfile($path,$tmpimg);
	   }
	   
	   $sql="UPDATE {$tbl} SET {$set} WHERE {$col}='{$id}'";
	  
	   if(!$this->query($sql,$fields)->error())
	   {
	       return true;
	   }
	  
	   return false;
	
	}
	
		public function updatewithoutimage($tbl,$col,$id,$fields = array())
	{
	   $set = "";
	   $x= 1;
	   foreach($fields as $name => $value)
	   {
	      $set .= "{$name} = ? ";
		  if($x < count($fields))
		  {
		     $set .=', ';
		  }
		  
		  $x++;
	   
	   }
	   
	   
	   $sql="UPDATE {$tbl} SET {$set} WHERE {$col}='{$id}'";
	  
	   if(!$this->query($sql,$fields)->error())
	   {
	       return true;
	   }
	  
	   return false;
	
	}
	
	public function getmultiple($tbl,$fields = array())
	{
	   $set = "";
	   $x= 1;
	   foreach($fields as $name => $value)
	   {
	      $set .= "{$name} = ? ";
		  if($x < count($fields))
		  {
		     $set .=' and ';
		  }
		  
		  $x++;
	   
	   }
	   
	   $sql="SELECT * FROM {$tbl}  WHERE {$set}";
	   
	   if(!$this->query($sql,$fields)->error())
	   {
	      
	   
		   return $this;
	   }
	  
	  
	   return false;
	
	}
	
	public function delmultiple($tbl,$fields = array())
	{
	   $set = "";
	   $x= 1;
	   foreach($fields as $name => $value)
	   {
	      $set .= "{$name} = ? ";
		  if($x < count($fields))
		  {
		     $set .=' and ';
		  }
		  
		  $x++;
	   
	   }
	   
	   
	   $sql="DELETE FROM {$tbl} WHERE {$set}";
	   if(!$this->query($sql,$fields)->error())
	   {
	       return true;
	   }
	  
	   return false;
	
	}
	
	public function getwithlimit($tbl,$fields = array(),$start,$end)
	{
	   $set = "";
	   $x= 1;
	   foreach($fields as $name => $value)
	   {
	      $set .= "{$name} = ? ";
		  if($x < count($fields))
		  {
		     $set .=' and ';
		  }
		  
		  $x++;
	   
	   }
	   
	   $sql="SELECT * FROM {$tbl}  WHERE {$set} LIMIT {$start},{$end}";
	   
	   if(!$this->query($sql,$fields)->error())
	   {
	      
	   
		   return $this;
	   }
	  
	  
	   return false;
	
	}
	
	
    public function error()
    {
            return  $this->_error;
    }
	
	 public function lastinsert()
    {
            return  $this->_lastinsertId;
    }
	
	public function sethead($val)
	{
	             $this->_set=$this->query($val,$field= null);
         
				 
	}
	
	public function uploadfile($path,$name)
    {
	
	 move_uploaded_file($name,$path);
	
	
    }
    
      public function seourl($string) {
   // Unwanted:  {UPPERCASE} ; / ? : @ & = + $ , . ! ~ * ' ( )
    $string = strtolower($string);
    //Strip any unwanted characters
    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
    //Clean multiple dashes or whitespaces
    $string = preg_replace("/[\s-]+/", " ", $string);
    //Convert whitespaces and underscore to dash
    $string = preg_replace("/[\s_]/", "-", $string);
    return $string;
}


  public function hindiseourl($string) {
   //Unwanted:  {UPPERCASE} ; / ? : @ & = + $ , . ! ~ * ' ( )
   // $string = strtolower($string);
    //Strip any unwanted characters
   // $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
    //Clean multiple dashes or whitespaces
    $string = preg_replace("/[\s-]+/", " ", $string);
    //Convert whitespaces and underscore to dash
    $string = preg_replace("/[\s_]/", "-", $string);
    return $string;
}

public function base64_url_encode($input)
{
    return strtr(base64_encode($input), '+/=', '-_,');
}

public function base64_url_decode($input)
{
    return base64_decode(strtr($input, '-_,', '+/='));
}	
	


public function paginate($reload, $page, $tpages) {
    $adjacents = 2;
    $prevlabel = "&lsaquo; Prev";
    $nextlabel = "Next &rsaquo;";
    $out = "";
	
    // previous
	if(($page<0) || ($page==0))
	{
		$out.= "<li><span>" . $prevlabel . "</span>\n</li>";
	}
    else if ($page == 1) {
        $out.= "<li><span>" . $prevlabel . "</span>\n</li>";
    } elseif ($page == 2) {
        $out.= "<li><a style='cursor:pointer' href=\"" . $reload . "\">" . $prevlabel . "</a>\n</li>";
    } else {
        $out.= "<li><a style='cursor:pointer' href=\"" . $reload . "&amp;page=" . ($page - 1) . "\">" . $prevlabel . "</a>\n</li>";
    }
  
    $pmin = ($page > $adjacents) ? ($page - $adjacents) : 1;
    $pmax = ($page < ($tpages - $adjacents)) ? ($page + $adjacents) : $tpages;
    for ($i = $pmin; $i <= $pmax; $i++) {
        if ($i == $page) {
            $out.= "<li  class=\"active\"><a href=''>" . $i . "</a></li>\n";
        } elseif ($i == 1) {
            $out.= "<li><a style='cursor:pointer' href=\"" . $reload . "\">" . $i . "</a>\n</li>";
        } else {
            $out.= "<li><a style='cursor:pointer' href=\"" . $reload . "&amp;page=" . $i . "\">" . $i . "</a>\n</li>";
        }
    }
    
    if ($page < ($tpages - $adjacents)) {
        $out.= "<a style='font-size:11px;cursor:pointer' href=\"" . $reload . "&amp;page=" . $tpages . "\">" . $tpages . "</a>\n";
    }
    // next
    if ($page < $tpages) {
        $out.= "<li><a style='cursor:pointer' href=\"" . $reload . "&amp;page=" . ($page + 1) . "\">" . $nextlabel . "</a>\n</li>";
    } else {
        $out.= "<span style='font-size:11px;'>" . $nextlabel . "</span>\n";
    }
    $out.= "";
    return $out;
}


public function paginateAjax($reload, $page, $tpages) {
    $adjacents = 2;
    $prevlabel = "&lsaquo; Prev";
    $nextlabel = "Next &rsaquo;";
    $out = "";
	
    // previous
	if(($page<0) || ($page==0))
	{
		$out.= "<li><span>" . $prevlabel . "</span>\n</li>";
	}
    else if ($page == 1) {
        $out.= "<li><span>" . $prevlabel . "</span>\n</li>";
    } elseif ($page == 2) {
		
		$reload=$reload;
		
        $out.= "<li><a style='cursor:pointer' " . $reload . ">" . $prevlabel . "</a>\n</li>";
    } else {
		
		 $fpage=$page - 1;
		 $reload='onclick="getPagination('.$tpages.','.$fpage.')"';
         $out.= "<li><a style='cursor:pointer' " . $reload . ">" . $prevlabel . "</a>\n</li>";
    }
  
    $pmin = ($page > $adjacents) ? ($page - $adjacents) : 1;
    $pmax = ($page < ($tpages - $adjacents)) ? ($page + $adjacents) : $tpages;
    for ($i = $pmin; $i <= $pmax; $i++) {
        if ($i == $page) {
            $out.= "<li  class=\"active\"><a href=''>" . $i . "</a></li>\n";
        } elseif ($i == 1) {
			
		    $reload=$reload;
            $out.= "<li><a style='cursor:pointer' " . $reload . ">" . $i . "</a>\n</li>";
        } else {
			
			$fpage=$i;
			$reload='onclick="getPagination('.$tpages.','.$fpage.')"';
            $out.= "<li><a style='cursor:pointer' " . $reload . ">" . $i . "</a>\n</li>";
        }
    }
    
    if ($page < ($tpages - $adjacents)) {
		    $fpage=$tpages;
			$reload='onclick="getPagination('.$tpages.','.$fpage.')"';
        $out.= "<a style='font-size:11px;cursor:pointer' " . $reload . ">" . $tpages . "</a>\n";
    }
    // next
    if ($page < $tpages) {
		
		$fpage=$page + 1;
		$reload='onclick="getPagination('.$tpages.','.$fpage.')"';
        $out.= "<li><a style='cursor:pointer' " . $reload . ">" . $nextlabel . "</a>\n</li>";
    } else {
        $out.= "<span style='font-size:11px'>" . $nextlabel . "</span>\n";
    }
    $out.= "";
    return $out;
}


public function SK_createCaptcha() {
    $image = '';
    $image = @imagecreatetruecolor(80, 30);
    $background_color = @imagecolorallocate($image, 87, 143, 209);
    $text_color = @imagecolorallocate($image, 255, 255, 255);
    $pixel_color = @imagecolorallocate($image, 60, 75, 114);
    @imagefilledrectangle($image, 0, 0, 80, 30, $background_color);
    
    for ($i = 0; $i < 1000; $i++) {
        @imagesetpixel($image, rand() % 80, rand() % 30, $pixel_color);
    }
    
    $key = $this->SK_generateKey(6, 6, false, false, true);
    $_SESSION['captcha_key'] = $key;
    @imagestring($image, 7, 13, 8, $key, $text_color);
    $images = glob('photos/captcha_*.png');
    
    if (is_array($images) && count($images) > 0) {
        
        foreach ($images as $image_to_delete) {
            @unlink($image_to_delete);
        }
    }
    
    $image_url = 'photos/captcha_' . time() . '_' . mt_rand(1, 9999) . '.png';
    @imagepng($image, $image_url);
    $get = array(
        'image' => $image_url
    );
    return $get;
}

public function SK_generateKey($minlength=5, $maxlength=5, $uselower=true, $useupper=true, $usenumbers=true, $usespecial=false) {
    $charset = '';
    
    if ($uselower) {
        $charset .= "abcdefghijklmnopqrstuvwxyz";
    }
    
    if ($useupper) {
        $charset .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    }
    
    if ($usenumbers) {
        $charset .= "123456789";
    }
    
    if ($usespecial) {
        $charset .= "~@#$%^*()_+-={}|][";
    }
    
    if ($minlength > $maxlength) {
        $length = mt_rand($maxlength, $minlength);
    } else {
        $length = mt_rand($minlength, $maxlength);
    }
    
    $key = '';
    
    for ($i = 0; $i < $length; $i++) {
        $key .= $charset[(mt_rand(0, strlen($charset) - 1))];
    }
    
    return $key;
}	
}


?>