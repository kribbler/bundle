<?php
require "./midasorder.php";
//This is a required file for the MIDaS ordering service.
//Example How to send an order into MIDaS Using PHP
//Create an OrderHeader array with the values of the order header
$OrderHeader = array
(
//Your OrderID
"OrderID" => "12234",
//Your MIDaS Siteid
"SiteID" => "40",
//Your MIDas CusID
"CusID" => "879",
//MIDaS UserName and Password
"UserName" => "Test",
"Password" => "simon",
//Customer Details
"Title" => "Mr",
"CusFName" => "Simon",
"CusLName" => "Woodland", 
//Customer Billing Address
"BillAddr1" => "Draycott Business Park",
"BillAddr2" => "Cam",
"BillAddr3" => "Dursley",
"BillAddr4" => "Glos",
"BillPCode" => "GL11 5DQ",
"BillPhone" => "01453 891000",
"BillMobile" => "",
"BillEmail" => "",
//Delivery Customer Details 
"DelvTitle" => "",
"DelvFName" => "", 
"DelvLName" => "",
//Delivery Address
"DelvAddr1" => "",
"DelvAddr2" => "",
"DelvAddr3" => "",
"DelvAddr4" => "",
"DelvPCode" => "",
"DelvPhone" => "",
//Customer Registration Number
"RegNum" => "ABC 123X",
//Fitting Date (yyyy-mm-dd-Thh:mm:ss)
"FittingDate"=> "2005-06-04T00:00:00",
//Customer Special Instructions/Comments
"Comments" => "", 
	//Credit Card Authorisation number
	"AuthCode" => "1234", 
	//Your Invoice Number
	"InvoiceNo" => "LINUX", 
	//Fitting time slot (e.g. can be used to donate if it a morning or afternoon slot) hh:mm
	"StartTime" => "09:00", //Fitting Start time
	"EndTime" => "13:00",  // Fitting End time
	//CreditCard Transaction ID
	"CCTransID" => "123-445-sds",
	//Contact Fields
	"ContactPhoneHome" => "12345678",
	"ContactPhoneMobile" => "12345677",
	"ContactPhoneWork" => "456789",
	"ContactEmail" => "somone@someone.com"			        		
	);
//Create a new MidasOrder Object
$MidasOrder = new MidasOrder;
//Put the OrderHeader into the MidasOrder
$MidasOrder->CreateOrderHeader($OrderHeader);
//Create An Array for the order lines
$OrderLine = array
 (
	//Your StockCode
	"Code" => "2155516HAVOCR85",
	"Qty"  => 2,
	"Price" => 48.81,
);
//Add this Line to the MidasOrder
$MidasOrder->AddOrderLine($OrderLine);
//Add More Lines to the MidasOrder
$OrderLine = array
 (	
	"Code" => "2155516VBRIER30",
	"Qty"  => 2,
	"Price" => 64.64,
);
//Add 2nd Line to the MidasOrder
$MidasOrder->AddOrderLine($OrderLine);
//Finally the Send the Order to MIDAS
try
{		
		$result = $MidasOrder->SendOrder();							if($result > 0)
{
		//Update your tables with MidasOrderID here.
		//Thank the customer for the order.
		echo("MIDaS OrderRef ".$result);
	}
else
{
		echo("MIDaS OrderRef ".$result);
		//Log, Send and Email etc here, and thank the customer for the order
	}
}
catch (Exception $e)
{
//Log, Send an Email etc here, and thank the customer for the order.
echo($e->getMessage());
}
?> 
