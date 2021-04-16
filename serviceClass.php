<?php

class serviceClass{
	
    private $serviceID;   //Service ID
    private $serviceName; //Service Name
    private $branchID;    //Branche ID
	private $timeAvg;     //Average Time For Each Appointment
    
	
//------------- Get Data -----------------------------
    
    public function getServiceID() //Get Service ID
	{
		return $this->serviceID;
	}
    
    public function getServiceName() //Get Service Name
	{
		return $this->serviceName;
	}
    
    public function getBranchID() //Get Branch ID
	{
		return $this->branchID;
	}
    
    public function getTimeAvg() //Get Average Time
	{
		return $this->timeAvg;
	}
    
    
    
//------------- Set Data -----------------------------
    
    /*  -- Service ID Is Automatically Set -- */
    
    public function setServiceName($name){	//Set Service Name
		$this->serviceName=$name;
	}
    
    public function setBranchID($id){	//Set Branch ID
		$this->branchID=$id;
	}
    
    public function setTimeAvg($m){	 //Set Average Time
		$this->timeAvg=$m;
	}
    
    }
?>