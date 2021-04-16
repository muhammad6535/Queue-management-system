<?php
class appointmentClass{
	
    private $appointmentID; //Appointment ID
	private $customerName;  //Appointment Name
    private $customerID;    //Customer ID    
    private $customerMail;  //Customer Mail
    private $branchName;    //Branch Mail
    private $appointmentService;    //Appointment Service
    private $appointment_date;      //Appointment Date
    private $appointment_time;      //Appointment Time
    
	
//------------- Get Data -----------------------------
	public function getAppointmentID() //Get Appointment ID
	{
		return $this->appointmentID;
	}
    
    public function getCustomerName()  //Get Customer Name
	{
		return $this->customerName;
	}
    
    public function getCustomerID()    //Get Customer ID
	{
		return $this->customerID;
	}
    
    public function getCustomerMail()  //Get Customer Mail
	{
		return $this->customerMail;
	}
	
    public function getBranchName()    //Get Branch Name
	{
		return $this->branchName;
	}

    public function getApointmentService()  //Get Appointment Service
	{
		return $this->appointmentService;
	}

    public function getAppointment_date()   //Get Appointment Date
	{
		return $this->appointment_date;
	}
    
    public function getAppointment_time()   //Get Appointment Time
	{
		return $this->appointment_time;
	}


//------------- Set Data -----------------------------

	public function setAppointmentID($id){	//Set Appointment ID
		$this->appointmentID=$id;
	}
    
	public function setCustomerName($name){	//Set Customer Name
		$this->customerName=$name;
	}
    
	public function setCustomerID($id){	   //Set Customer ID
		$this->customerID=$id;
	}

	public function setCustomerMail($mail){	//Set Customer Mail
		$this->customerMail=$mail;
	}

	public function setBranchName($BrName){	//Set Branch Name
		$this->branchName=$BrName;
	}

	public function setAppointmentService($AppService){	//Set Appointment Service
		$this->appointmentService=$AppService;
	}
    
    public function setAppointment_date($AppDate){	    //Set Appointment Date
		$this->appointment_date=$AppDate;
	}
    
    public function setAppointment_time($AppTime){	    //Set Appointment Time
		$this->appointment_time=$AppTime;
	}
	  
}

?>
