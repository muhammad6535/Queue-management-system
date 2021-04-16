<?php
class branchClass{
	
    private $branchID;     //Branch ID
	private $branchName;   //Branch Name
    private $branchMail;   //Branch Mail
    private $branchTel;    //Branch Phone
    private $branchAddress; //Branch Addres
    
	
//------------- Get Data -----------------------------
    
    public function getBranchID()   //Get Branch ID
	{
		return $this->branchID;
	}
    
    public function getBranchName() //Get Branch Name
	{
		return $this->branchName;
	}
    
    public function getBranchMail() //Get Branch Mail
	{
		return $this->branchMail;
	}
    
    public function getBranchTel()  //Get Branch Phone
	{
		return $this->branchTel;
	}
    
    public function getBranchAddress()  //Get Branch Address
	{
		return $this->branchAddress;
	}

//------------- Set Data -----------------------------
     
    public function setBranchID($id){	//Set Branch ID
		$this->branchID=$id;
	}
    
	public function setBranchName($name){  //Set Branch Name
		$this->branchName=$name;
	}
     
    public function setBranchMail($mail){   //Set Branch Mail
		$this->branchMail=$mail;
	}
    
    public function setBranchTel($tel){	    //Set Branch Phone
		$this->branchTel=$tel;
	}
    
    public function setBranchAddress($address){ //Set Branch Address
		$this->branchAddress=$address;
	}
    
    
    
    }
?>