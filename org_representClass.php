<?php
class org_representClass{
	
    private $username; //Represent Username
	private $password; //Represent Password
    
    // Attribute just for the Manager Of the Organization
    private $email;
	
//------------- Get Data -----------------------------
	public function getUsername() //Get Represent Username
	{
		return $this->username;
	}
    
    public function getPassword() //Get Represent Password
	{
		return $this->password;
	}

    public function getManagerMail() //Get Manager Mail
	{
		return $this->email;
	}


//------------- Set Data -----------------------------

	public function setUsername($user){	//Set Represent Username
		$this->username=$user;
	}
    
	public function setPassword($pass){	//Set Represent Password
		$this->password=$pass;
	}
    
    public function setManagerMail($mail){ //Set Manager Mail
		$this->email=$mail;
	}
}

?>