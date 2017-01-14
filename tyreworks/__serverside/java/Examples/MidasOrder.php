<?php
class MidasOrder
{
	var $OrderDetails;
	var $OrderID;
	var $UserName;
	var $Password;	
function MidasOrder()
{
	//Initalise the OrderDetails object and the OrderDetails Lines
	$this->OrderDetails = new OrderHeader();
	$this->OrderDetails->Lines = array();
}
function CreateOrderHeader($OrderHdr)
{
	$this->OrderID = $OrderHdr["OrderID"];
	$this->UserName = $OrderHdr["UserName"];
	$this->Password = $OrderHdr["Password"];
	$this->OrderDetails->CusID = $OrderHdr["CusID"];
	$this->OrderDetails->SiteID = $OrderHdr["SiteID"];
	$this->OrderDetails->Title  = $OrderHdr["Title"];
	$this->OrderDetails->CusFName = $OrderHdr["CusFName"];
	$this->OrderDetails->CusLName = $OrderHdr["CusLName"];
	$this->OrderDetails->BillAddr1 = $OrderHdr["BillAddr1"];
	$this->OrderDetails->BillAddr2 = $OrderHdr["BillAddr2"];
	$this->OrderDetails->BillAddr3 = $OrderHdr["BillAddr3"];
	$this->OrderDetails->BillAddr4 = $OrderHdr["BillAddr4"];
	$this->OrderDetails->BillPCode = $OrderHdr["BillPCode"];
	$this->OrderDetails->BillPhone = $OrderHdr["BillPhone"];
	$this->OrderDetails->BillMobile = $OrderHdr["BillMobile"];
	$this->OrderDetails->BillEmail = $OrderHdr["BillEmail"];
	$this->OrderDetails->DelvTitle = $OrderHdr["DelvTitle"];
	$this->OrderDetails->DelvFName = $OrderHdr["DelvFName"];
	$this->OrderDetails->DelvLName = $OrderHdr["DelvLName"];
	$this->OrderDetails->DelvAddr1 = $OrderHdr["DelvAddr1"];
	$this->OrderDetails->DelvAddr2 = $OrderHdr["DelvAddr2"];
	$this->OrderDetails->DelvAddr3 = $OrderHdr["DelvAddr3"];
	$this->OrderDetails->DelvAddr4 = $OrderHdr["DelvAddr4"];
	$this->OrderDetails->DelvPCode = $OrderHdr["DelvPCode"];
	$this->OrderDetails->DelvPhone = $OrderHdr["DelvPhone"];
	$this->OrderDetails->RegNum = $OrderHdr["RegNum"];
	$this->OrderDetails->FittingDate = $OrderHdr["FittingDate"];
	$this->OrderDetails->Comments = $OrderHdr["Comments"];
	$this->OrderDetails->AuthCode = $OrderHdr["AuthCode"];
	$this->OrderDetails->InvoiceNo = $OrderHdr["InvoiceNo"];
	$this->OrderDetails->StartTime = $OrderHdr["StartTime"];
	$this->OrderDetails->EndTime = $OrderHdr["EndTime"];
	$this->OrderDetails->CCTransID = $OrderHdr["CCTransID"];
	$this->OrderDetails->ContactPhoneHome = $OrderHdr["ContactPhoneHome"];
	$this->OrderDetails->ContactPhoneMobile = $OrderHdr["ContactPhoneMobile"];
	$this->OrderDetails->ContactPhoneWork = $OrderHdr["ContactPhoneWork"];
	$this->OrderDetails->ContactEmail = $OrderHdr["ContactEmail"];
}
function AddOrderLine($OrderLn)
	{
		$OrderLine = new OrderLine();
		$OrderLine->InvoiceNo = $this->OrderDetails->InvoiceNo;
		$OrderLine->Code =  $OrderLn["Code"];
		$OrderLine->Qty = $OrderLn["Qty"];
		$OrderLine->Price = $OrderLn["Price"];
		//Add the order to the Array
		array_push($this->OrderDetails->Lines,$OrderLine);
	}
	//Returns Midas Orderid or - 1 if there is a problem
	function SendOrder()
	{
		try
		{
			//Url To Send the order to
			$url = "http://www.cam-systems.co.uk/websitetomidasservice/service.asmx?WSDL";
			//Your username and Password 
			$param["OrderID"] = $this->OrderID;
			$param["UserName"] = $this->UserName;
			$param["Password"] = $this->Password; 
			$param["OrderDetails"] = $this->OrderDetails;
			 //Make an instance of the soapclient
			$client = new SoapClient($url);
			$orderResult = $client->CreateMidasOrder($param);				
			return $orderResult->CreateMidasOrderResult;
		}
		catch(SoapFault $se)
		{
			throw new Exception($se->faultstring);
		}
		catch(Exception $e)
		{
			throw new Exception($e->getMessage());
		}			
	}
}
 
//Create the class that will hold the order header information
class OrderHeader
{
	var $CusID;  // Your MIDaS Customerid
	var $SiteID; // The siteid that will receive the order
	// Retail Customers Billing Contact Details
	var $Title;  // Retail Customer Title (Mr,Mrs etc)
	var $CusFName; //Retail Customers First Name
	var $CusLName; //Retail Customers Last Name
	var $BillAddr1;
	var $BillAddr2;
	var $BillAddr3;
	var $BillAddr4;
	var $BillPCode; 
	var $BillPhone;
	var $BillMobile;
	 var $BillEmail;       
	var $DelvTitle; // Retail Delivery Customer Title (Mr,Mrs etc)
	 var $DelvFName; //Retail Delivery Customers First Name
	 var $DelvLName; //Retail Delivery Customers Surname Name
	var $DelvAddr1;
	var $DelvAddr2;
	var $DelvAddr3;
	var $DelvAddr4;
	var $DelvPCode;
	var $DelvPhone;
        	var $RegNum; //Retail Customers Vehicle Registration Number
	var $Comments; //Retail Customers Special Instructions/Comments
        	var $AuthCode; //Credit Card Authorisation number
	var $InvoiceNo; //Your Invoice number
        	//Fitting time slot (e.g. can be used to donate if it a morning or afternoon slot)
	var $StartTime; //Fitting Start time
	var $EndTime; // Fitting End time
	var $CCTransID; //CreditCard Transaction ID
	var $ContactPhoneHome;
	var $ContactPhoneMobile;
	var $ContactPhoneWork;
	var $ContactEmail;
	var $Lines; //This will hold the OrderLines
}
//Create the Class that will hold the Order Line information
class OrderLine
{
	var $InvoiceNo; //Your Invoice Number
	var $Code; //StockCode to Order
	var $Qty; 
	var $Price; //Retail Price Of Item Ex Vat
}	
?> 