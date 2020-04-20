<?php
//Included from the consolibyte framework
// Show errors
//error_reporting(E_ALL | E_STRICT);
//ini_set('display_errors', true);
		
// Plain text output
//header('Content-Type: text/plain');
		
// Include the QuickBooks files
require_once(dirname(dirname(dirname(__FILE__))) ."/consolibyte/QuickBooks.php");
//End inclusion from framework.


//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
// If you want to log requests/responses to a database, you can provide a 
//	database DSN-style connection string here
$dsn = null;
// $dsn = 'mysql://root:@localhost/quickbooks_merchantservice';

$path_to_private_key_and_certificate = null;							// If you're using the DESKTOP model

// This is your login ID that Intuit assignes you during the application 
//	registration process.
//$application_login = 'test.www.academickeys.com';
if(DEVELOPMENT == TRUE){$application_login = 'fatstreampayment.www.fatstream.com';} // 'test.foxycart.com';
if(DEVELOPMENT == FALSE){$application_login = 'FSPP.www.fatstream.com';}
//$application_login = 'qbms.consolibyte.com';

// This is the connection ticket assigned to you during the application 
//	registration process. To conform to Intuit security practices, you are 
//	*required* to store this key *encrypted* and not in plain-text. 
//	
//$connection_ticket = 'SDK-TGT-234-y9KWEGvtwmGndUS$D_vzBQ'; //Ticket assigned to FATSTREAM
//Get the encrpted connection ticket
if(DEVELOPMENT == TRUE){
	if(file_exists(dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/connection_crypt_test.txt")){
	//echo dirname(dirname(dirname(dirname(dirname(__FILE__)))));
		$key = 'aT48%Mya$$';
		$myfile = fopen(dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/connection_crypt_test.txt", "r") or die("Unable to open file!");
		$myfile_cont = fread($myfile,filesize(dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/connection_crypt_test.txt"));
		$connection_ticket = mysql_aes_decrypt($myfile_cont,$key);
		fclose($myfile);
	}

	else{SetError("Connection Ticket Could Not Be Found.");}
}
if(DEVELOPMENT == FALSE){
	if(file_exists(dirname(dirname(dirname(dirname(__FILE__))))."/connection_crypt_production.txt")){
	//echo dirname(dirname(dirname(dirname(dirname(__FILE__)))));
		$key = 'aT48%Mya$$';
		$myfile = fopen(dirname(dirname(dirname(dirname(__FILE__))))."/connection_crypt_production.txt", "r") or die("Unable to open file!");
		$myfile_cont = fread($myfile,filesize(dirname(dirname(dirname(dirname(__FILE__))))."/connection_crypt_production.txt"));
		$connection_ticket = mysql_aes_decrypt($myfile_cont,$key);
		fclose($myfile);
	}

	else{SetError("Connection Ticket Could Not Be Found.");}
}

//$connection_ticket = 'TGT-157-p3PyZPoH3DtieLSh4ykp6Q';

// Create an instance of the MerchantService object 
$MS = new QuickBooks_MerchantService(
	$dsn, 
	$path_to_private_key_and_certificate, 
	$application_login,
	$connection_ticket);

// If you're using a Intuit QBMS development account, you must set this to true! 
if(DEVELOPMENT == TRUE){$MS->useTestEnvironment(true);}
else{$MS->useTestEnvironment(false);}

// If you want to see the full XML input/output, you can turn on debug mode
$MS->useDebugMode(false);

/*
There are several methods available in the QuickBooks_MerchantService class. 
The most common methods are described below: 

 - authorize() 
    This authorizes a given amount against the a credit card. It is important 
    to note that this *does not* actually charge the credit card, it just 
    "reserves" the amount on the credit card and guarentees that if you do a 
    capture() on the same credit card within X days, the funds will be 
    available. 
    
    Authorizations are used in situations where you want to ensure the money 
    will be availble, but not actually charge the card yet. For instance, if 
    you have an online shopping cart, you should authorize() the credit card 
    when the customer checks out. However, because you might not have the item 
    in stock, or there might be other problems with the order, you don't want 
    to actually charge the card yet. Once the order is all ready to ship and 
    you've made sure there's no problems with it, you should issue a capture() 
   	using the returned transaction information from the authorize() to actually 
   	charge the credit card. 
    
 - capture()   
    
 - charge()
 
 - void()
 
 - refund()
 
 - voidOrRefund() 
 
 - openBatch()
 
 - closeBatch()

*/

/**
 * There are a number of test credit card numbers you can use while testing
 * 
 * Master Card 			5105105105105100
 * Master Card 			5555555555554444
 * VISA 				4222222222222
 * VISA 				4111111111111111
 * VISA 				4012888888881881
 * American Express 	378282246310005
 * American Express		371449635398431
 * Amex Corporate 		378734493671000
 * Diners Club 			38520000023237
 * Diners Club 			30569309025904
 * Discover 			6011111111111117
 * Discover 			6011000990139424
 */

// Now, let's create a credit card object, and authorize an amount agains the card
$name = $order->billing_name; //Keith Palmer';
$number = $user->form['cc_number'] ;//'5105105105105100';
$expyear = $user->form['cc_expiration_year'] ;//date('Y');
$expmonth = $user->form['cc_expiration_month'] ;//date('m');
$address = $order->billing_address ;//Cowles Road';
$postalcode = $order->billing_zip ;//'06279';
$cvv = $user->form['cc_security']; //null;


//Set amount
$c = cost_per_account 
+((cost_per_store * $store_count) - cost_per_store)
+((cost_per_employee * $user_count) - cost_per_employee);
$amount = number_format($c,2); 	

/**
 * There are also some test configurations you can use to simulate certain 
 * errors occuring. You pass these test configuration constants in as the $name 
 * parameter to the credit card to trigger various errors/warnings. 
 */
// $name = QuickBooks_MerchantService::TEST_AVSZIPCVVFAIL;		// Simulate a sucessful transaction that failed all AVS and CVV checks, but was still processed (i.e. your gateway is set up to accept everything)
// $name = QuickBooks_MerchantService::TEST_COMMUNICATIONERROR;	// Simulate a general communication error

// Create the CreditCard object
$QB_Card = new QuickBooks_MerchantService_CreditCard($name, $number, $expyear, $expmonth, $address, $postalcode, $cvv);


	if($Transaction = $MS->charge($QB_Card,$amount)){
		
		$order->SaveTransaction($connx,$Transaction->toXML(),$amount,time());
		
		if($user->GetIsAdmin()){
			header ('location: '.$_SERVER['HTTP_REFERER']);
		}
		else{
			//If the order is approved, advance it to ordered and save otherwise, don't touch the status
			if($order->status == 'Approved'){
				
				$order->status = "Ordered";
				$order->Save($connx,$user->GetID());
			}
			//Goto the confirmation page
			header ('location: ../../index.php?pg=order_view&action=viewconfirmation');
		}
		return;		
	
	}

SetError($MS->errorMessage());

/*
//Lets authorize the card for the deposit
//$deposit_amount = $amount * 8;
if ($Transaction = $MS->authorize($Card, $amount))
{
	//$order->SaveTransaction($connx,$Transaction);
	
	//capture the amount on the card
	if ($Transaction = $MS->capture($Transaction, $amount))
	//if ($Transaction = $MS->capture($Card, $amount))
	{
		//Store the transaction
		$order->SaveTransaction($connx,$Transaction);
		//Goto the confirmation page
		$order->status = "Ordered";
		$order->Save($connx,$user->GetID());
		header ('location: ../../index.php?pg=order_view&action=viewconfirmation');
		return;	
	}
	else
	{
		//An Error occured during capture
		SetError($MS->errorMessage());
	}
}
else
{
	//An error occured during authorization
	SetError($MS->errorMessage());
}
*/
unset($QB_Card);
unset($MS);	
	
	header ('location: '.$_SERVER['HTTP_REFERER']);
?>