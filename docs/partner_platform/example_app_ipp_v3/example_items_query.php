<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>

<pre>

<?php

// Set up the IPP instance
$IPP = new QuickBooks_IPP($dsn);

// Get our OAuth credentials from the database
$creds = $IntuitAnywhere->load($the_username, $the_tenant);

// Tell the framework to load some data from the OAuth store
$IPP->authMode(
	QuickBooks_IPP::AUTHMODE_OAUTH, 
	$the_username, 
	$creds);

// Print the credentials we're using
//print_r($creds);

// This is our current realm
$realm = $creds['qb_realm'];

// Load the OAuth information from the database
if ($Context = $IPP->context())
{
	// Set the IPP version to v3 
	$IPP->version(QuickBooks_IPP_IDS::VERSION_3);
	
	$ItemService = new QuickBooks_IPP_Service_Term();
	
	$items = $ItemService->query($Context, $realm, "SELECT * FROM Item WHERE Metadata.LastUpdatedTime > '2013-01-01T14:50:22-08:00' ORDER BY Metadata.LastUpdatedTime ");
	
	foreach ($items as $Item)
	{
		//print_r($Item);

		print('Item Id=' . $Item->getId() . ' is named: ' . $Item->getName() . '<br>');
	}

	/*
	print("\n\n\n\n");
	print('Request [' . $IPP->lastRequest() . ']');
	print("\n\n\n\n");
	print('Response [' . $IPP->lastResponse() . ']');
	print("\n\n\n\n");
	*/
}
else
{
	die('Unable to load a context...?');
}

?>

</pre>

<?php

require_once dirname(__FILE__) . '/views/footer.tpl.php';

?>