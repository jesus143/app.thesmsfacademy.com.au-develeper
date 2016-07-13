<?php /* Template Name: BGL360 Import */ get_header();

	/**
	 * Curl query to the bgl360 application
	 * https://api-staging.bgl360.com.au/oauth/token
	 * ?grant_type=authorization_code
	 * &code=%3CAuth-Code%3E
	 * &scope=%3CScope%3E
	 * &client_id=%3CAPI-Client-ID%3E
	 * &client_secret=%3CAPI-Client-Secret
	 * REQUIREMENT:
	 * grant type = authorization_code
	 * code = qQiNrL
	 * scope = developer
	 * client id = 5dbf9b2c-981f-44e4-8212-d3b5c74795a1
	 * client secret = 7005380b-fc86-40df-8457-d4f42f539d2c
	 */


	$clientId = 'f937a03e-db37-4213-9d37-9484e7eab33d';
	$clientSecret = '9a88e4bc-ab1c-41b3-a8b3-a5f7b32502de';
	$basicAuthorizationHeader = 'ZjkzN2EwM2UtZGIzNy00MjEzLTlkMzctOTQ4NGU3ZWFiMzNkOjlhODhlNGJjLWFiMWMtNDFiMy1hOGIzLWE1ZjdiMzI1MDJkZQ==';


	$postManToken = '93e27fae-9973-848a-d983-6cc07657c14d';
	$grant_type = 'authorization_code';
	$code = (!empty($_GET['code'])) ? $_GET['code'] : 'Y3K3mI';
	$scope = 'investment';
	$clientId = 'f937a03e-db37-4213-9d37-9484e7eab33d';
	$clientSecret = '9a88e4bc-ab1c-41b3-a8b3-a5f7b32502de';
	$redirectUril = 'https://app.thesmsfacademy.com.au/wp-content/bgl360/index.php';
	$getAccessToken = "https://api-staging.bgl360.com.au/oauth/token?grant_type=$grant_type&code=$code&scope=$scope&client_id=$clientId&client_secret=$clientSecret&redirect_uri=$redirectUril";

	$curlPostUri    = "https://api-staging.bgl360.com.au/oauth/token?grant_type=$grant_type&code=$code&scope=$scope&client_id=$clientId&client_secret=$clientSecret&redirect_uri=$redirectUril";
	$curlPostFields = "grant_type=$grant_type&code=iq04CF&scope=$scope&client_id=$clientId&client_secret=$clientSecret&redirect_uri=$redirectUril";
	$curlPostUriBase = "https://api-staging.bgl360.com.au/oauth/token";




	/**
	 * Get wp user
	 */
	$current_user = wp_get_current_user();

	//If not logged in then page should redirect to main website login page
	if($current_user->ID < 1) { header("location: https://app.thesmsfacademy.com.au/wp-login.php"); }

	/**
	 * Include relevant files
	 */
	require ("bgl360/app/Http/ServiceBgl360.php");
	require ("bgl360/app/Http/AuthenticationBgl360.php");
	require ("bgl360/app/Http/ResourceRequestBgl360.php");
	require ("bgl360/app/Http/Time.php");

	require ("bgl360/app/Http/FundDetails.php");
	require ("bgl360/app/Http/Trustees.php");
	require ("bgl360/app/Http/Member.php");
	require ("bgl360/app/Http/Document.php");


	/**
	 * Call namespaces
	 */
	use App\ServiceBgl360;
	use App\AuthenticationBgl360;
	use App\ResourceRequestBgl360;
	use App\Time;

	/**
	 * Declare local and global variables
	 */
	global $wpdb;

	/**
	 * Instantiate classes
	 */
	$service_bgl360          = new ServiceBgl360($wpdb, $current_user->ID);
	$resource_request_bgl360 = new ResourceRequestBgl360();
	$document = new \App\Document();
	//echo "<pre>";

	$current_user = wp_get_current_user();



	
	// get access status if access token is exist
	$isExistAccessToken = $service_bgl360->isExistAccessToken(); 

	//check access token status from bgl360
	// if access token is expired then





 
	/**
	 * Get the users token information from smsf database
	 */
	$currentUser['bgl360_token'] = $service_bgl360->getCurrentAccessTokenByUser();
	$queryData['access_token']   = $currentUser['bgl360_token'][0]['access_token'];
	$queryData['token_type']     = $currentUser['bgl360_token'][0]['token_type'];
	$queryData['refresh_token']  = $currentUser['bgl360_token'][0]['refresh_token'];
	$queryData['expires_in']     = $currentUser['bgl360_token'][0]['expires_in'];
	$queryData['scope']          = $currentUser['bgl360_token'][0]['scope'];


	/**
	 * Querry data to bgl360 application with current users logged in access token
	 */
	$currentUser['bgl360_query_data'] = $resource_request_bgl360->getData($queryData['access_token'], '/fund/list');
	//$currentUser['bgl360_query_data'] = $resource_request_bgl360->getData($queryData['access_token'], '/fund/detal?fundId=8a009fab528515320152ae5f949d003a');
	//$currentUser['bgl360_query_data'] = $resource_request_bgl360->getData($queryData['access_token'], '/fund/trustees ');
	//echo print_r($currentUser['bgl360_query_data']);
	$funds = $currentUser['bgl360_query_data']['funds'];



	//echo 'fund list = ' . $_POST['fundList'] .' access token = '  . $queryData['access_token'] . '<br>';


	/**
	 * Tim's code
	 */
    if($_POST)
	{
		// echo "<pre>";
		$fundDetails = $resource_request_bgl360->getFundDetail($_POST['fundList'], $queryData['access_token']);
		// echo "<h1>Fund details</h1>";
		// print_r($fundDetails);
		$fundDetailsData = $fundDetails;

		$members = $resource_request_bgl360->getFundMembers($_POST['fundList'], $queryData['access_token']);
		// echo "<h1>Members</h1>";
		// print_r($members);
		$membersData = $members;

		$trustees = $resource_request_bgl360->getTrusteesList($_POST['fundList'], $queryData['access_token']);
		// echo "<h1>Trustees</h1>";
		// print_r($trustees);
		$trusteesData = $trustees;



				// Set fund details
		//		$resource_request_bgl360->setFundDetail($fundDetails);
		//		$resource_request_bgl360->setTrustees($trustees, 0);
		//		$resource_request_bgl360->setFundMembers($members, 0);


		//		$fundDetails = new \App\FundDetails($fundDetails);
		//		echo "Fund details = " . $fundDetails->fundName . '<br>';
		//		echo "Fund postal address = " . $fundDetails->fundPostalAddress . '<br>';
		//
		//
		//		$trustees  = new \App\Trustees($trustees, 0);
		//
		//		echo "trustees type " . $trustees->trusteesType . '<br>';
		//
		//		echo "trustees name " . $trustees->trusteesName . '<br>';
		//		$trustees->setTrusteesContacts($trustees->trusteesContacts, 0);
		//		echo "trustees contacts full name " . $trustees->trusteesContactsFullName . '<br>';
		//		echo "trustees contact full name " . $trustees->trusteesContactFullName . '<br>';
		//
		//
		//		$member = new \App\Member($members, 0);
		//		echo "member full name = 0 " . $member->fundMemberFullName . '<br>';
		//		echo "member address =  0 " . $member->fundMemberAddress . '<br>';
		//
		//		$member = new \App\Member($members, 1);
		//		echo "member full name  = 1 " . $member->fundMemberFullName . '<br>';
		//		echo "member address =  1 " . $member->fundMemberAddress . '<br>';


		//		echo "Trustess name " . $resource_request_bgl360->trusteesName . '<br>';
		//		echo "This is members first name = " . $resource_request_bgl360->fundMemberFullName .'<br>';
		//		echo "This is the fund postal address = " . $resource_request_bgl360->fundPostalAddress . '<br>';
		//		echo "This is full name " . $resource_request_bgl360->trusteesContactFullName . '<br>';
		//	 	$resource_request_bgl360->setTrusteesContacts($resource_request_bgl360->trusteesContacts, 0);
		//		echo "contacts full name 0 = " . $resource_request_bgl360->trusteesContactsFullName . '<br>';
		//		$resource_request_bgl360->setTrusteesContacts($resource_request_bgl360->trusteesContacts, 1);
		//		echo "contacts full name 1 = " . $resource_request_bgl360->trusteesContactsFullName . '<br>';
		//
		//
		//		echo " address of trustees " . $resource_request_bgl360->trusteesAddress . '<br>';
		//


		//		$resource_request_bgl360->setTrustees($trustees, 1);
		//		echo "This is full name " . $resource_request_bgl360->trusteesContactFullName . '<br>';
		//		echo "Total contacts " . $resource_request_bgl360->trusteesTotalContacts . '<br>';
		//
		//		$resource_request_bgl360->setTrusteesContacts($resource_request_bgl360->trusteesContacts, 0);
		//		echo "contacts full name 0 = " . $resource_request_bgl360->trusteesContactsFullName . '<br>';
		//		$resource_request_bgl360->setTrusteesContacts($resource_request_bgl360->trusteesContacts, 1);
		//		echo "contacts full name 1 = " . $resource_request_bgl360->trusteesContactsFullName . '<br>';

		//trustees
		$numMembers 		  = count($members);
		//echo 'Members: '.print_r($response,true);
		$fundState   	 	  = $fundDetails['postalAddress']['state'];
		$fundName 	  		  = $fundDetails['name'];
		$fundAbn              = $fundDetails['abn'];
		$postalAddress 		  = $fundDetails['postalAddress']['streetLine1'].' '.$fundDetails['postalAddress']['streetLine2'];
		$estDate	  		  = date("d/m/Y", strtotime($fundDetails['estDate']));
		$formId		  		  = (int)$_POST['documentList'];
		$form 		  		  = GFAPI::get_form( $formId );
		$title 		  		  = $form['title'];
		$current_user   	  = wp_get_current_user();
    	$user_id 	          = $current_user->ID;
		$entry                = array();
		$entry['form_id']     = $formId;
		$entry['created_by']  = $user_id;
		$entry['orderStatus'] = 'incomplete';



		switch($formId)
		{
			// New SMSF
			case 6:  

				$fundDetails  = new \App\FundDetails($fundDetailsData);
				$trustees     = new \App\Trustees($trusteesData, 0);
				$entry['2']	  = $fundDetails->fundName;
				//State Law to govern the Fund
				$entry['9']   = $fundDetails->fundAddressState;
				$entry['137'] = 'BGL360 Import '.date('d-m-Y');
				$entry['139'] = $fundDetails->fundPostalAddress;
				$entry['416'] = $fundDetails->fundPostalAddress;
				if($trustees->trusteesType == 'Corporate')
				{
					$entry['111'] = 'Company - Already Registered';
				}
				else
				{
					$entry['111'] = 'Individuals';
				}
				//we have 4 member
				$fundDetails = new \App\FundDetails($fundDetailsData);
//				$trustees1   = new \App\Trustees($trusteesData, 0);
//				$trustees2   = new \App\Trustees($trusteesData, 1);
//				$trustees3   = new \App\Trustees($trusteesData, 2);
//				$trustees4   = new \App\Trustees($trusteesData, 3);
				$member1 = new \App\Member($members, 0);
				$member2 = new \App\Member($members, 1);
				$member3 = new \App\Member($members, 2);
				$member4 = new \App\Member($members, 3);
				// Add meeting address for trustees
				$entry['337']  = 'Other Address';
				$entry['330']  = $member1->fundMemberAddress; //$trustees1->trusteesAddress;
				// Open for trustee members directors
				 
				$entry['12']        =  $member1->totalMembers; // $trustees->trusteesContactTotal;
 
				//trustee member1
				$entry['71']         = $member1->fundMemberTitle;// title//$trustees1->trusteesContactTitle; // title
				$entry['14']         = $member1->fundMemberLastName;// given first name//$trustees1->trusteesContactFirstName; // given first name
				$entry['72']         = $member1->fundMemberFirstName;// given last name//$trustees1->trusteesContactLastName; // given last name
				$entry['417']        = $member1->fundMemberGender;//$trustees1->trusteesContactGender;
				$entry['17']         = 'Other Address';
				$entry['246']        = $member1->fundMemberAddress;
				//trustee member 2
				$entry['73']         = $member2->fundMemberTitle;// title//$trustees2->trusteesContactTitle;// title
				$entry['25']         = $member2->fundMemberLastName;// given first name//$trustees2->trusteesContactFirstName;// given first name
				$entry['74']         = $member2->fundMemberFirstName;// given last name//$trustees2->trusteesContactLastName;// given last name
				$entry['418']        = $member2->fundMemberGender;//$trustees2->trusteesContactGender;
				$entry['169']        = 'Other Address';
				$entry['247']        = $member2->fundMemberAddress;
				//trustee member 3
				$entry['75']         = $member3->fundMemberTitle;// title//$trustees3->trusteesContactTitle;// title
				$entry['33']         = $member3->fundMemberLastName;// given first name//$trustees3->trusteesContactFirstName;// given first name
				$entry['76']         = $member3->fundMemberFirstName;// given last name//$trustees3->trusteesContactLastName;// given last name
				$entry['419']        = $member3->fundMemberGender;//
				//trustee member 4
				$entry['77']         = $member4->fundMemberTitle;// title
				$entry['42']         = $member4->fundMemberLastName;// given first name
				$entry['78']         = $member4->fundMemberFirstName;// given last name
				$entry['420']        = $member4->fundMemberGender;
    
			break;

			// Borrowing
			case 56:

				$fundDetails = new \App\FundDetails($fundDetails);
				$trustees  = new \App\Trustees($trusteesData, 0);
				$entry['11']    = $fundDetails->fundName;
				$entry['12']    = $fundDetails->fundPostalAddress;

				if ($trustees->trusteesType == 'Corporate')
				{
					$entry['93'] = 'Corporate Trustee';
					$entry['22'] = ''; //fund corporate trustees
					$entry['24'] = $trustees->trusteesAddress;
					$entry['77'] = $trustees->trusteesACN;

					// Set directors full name
					$trustees->setTrusteesContacts($trustees->trusteesContacts, 0);
					$entry['27'] = $trustees->trusteesContactsFullName;

					$trustees->setTrusteesContacts($trustees->trusteesContacts, 1);
					$entry['28'] = $trustees->trusteesContactsFullName;

					$trustees->setTrusteesContacts($trustees->trusteesContacts, 2);
					$entry['29'] = $trustees->trusteesContactsFullName;

					$trustees->setTrusteesContacts($trustees->trusteesContacts, 3);
					$entry['30'] = $trustees->trusteesContactsFullName;

					// Set members under directors
					$member1 = new \App\Member($members, 0);
					$member2 = new \App\Member($members, 1);
					$member3 = new \App\Member($members, 2);
					$member4 = new \App\Member($members, 3);

					$entry['32'] = $member1->fundMemberFullName;
					$entry['34'] = $member2->fundMemberFullName;
					$entry['35'] = $member3->fundMemberFullName;
					$entry['36'] = $member4->fundMemberFullName;

					// Open document field for directors
				    $entry = $document->smsfBorrowingOpenDocumentFieldsDirectors($trustees->trusteesTotalContacts, $entry);

				 	// Open document field for members
				    $entry = $document->smsfBorrowingOpenDocumentFieldsMembers($member1->totalMembers, $entry);

				} else {

 					$fundDetails = new \App\FundDetails($fundDetailsData);
					$trustees1   = new \App\Trustees($trusteesData, 0);
					$trustees2   = new \App\Trustees($trusteesData, 1);
					$trustees3   = new \App\Trustees($trusteesData, 2);
					$trustees4   = new \App\Trustees($trusteesData, 3);

					// Set trustees member
					$entry['93'] = 'Individual Trustee';
					$entry['15'] = $trustees1->trusteesContactFullName;
					$entry['16'] = $trustees2->trusteesContactFullName;
					$entry['21'] = $trustees3->trusteesContactFullName;
					$entry['20'] = $trustees4->trusteesContactFullName;
					$entry['95'] = $trustees1->trusteesAddress;

					// Open document field for trustees
					$entry = $document->smsfBorrowingOpenDocumentFieldsTrustees($trustees1->trusteesContactTotal, $entry);
				}


				// print_r($entry);
				// $importResult = $formId.GFAPI::add_entry($entry);
				// echo "End of borrowing case <br>";
				// exit;
			break;

			// SMSF Pension
			case 15:

				$fundDetails = new \App\FundDetails($fundDetailsData);
				$trustees    = new \App\Trustees($trusteesData, 0);


				$entry['289']	      = 'BGL360 Import '.date('d-m-Y'); // references
				$entry['1']	          =	$fundDetails->fundName; // fund name
				$entry['213']	 	  = $postalAddress; // address
				$entry['103']	      = $fundDetails->fundAbn; //abn
				$entry['213']         = $fundDetails->fundPostalAddress;

				if($trustees->trusteesType == 'Corporate')
				{
					$entry['138']         = 'Company'; // company or individual option

					$entry['31']          =  $trustees->trusteesName; // company name
					$entry['32']          =   $trustees->trusteesACN; // ACN
					$entry['220']         =  $trustees->trusteesAddress; // Trustee meeting address


					// Open slot for directors
					$entry['153']        = $trustees->trusteesTotalContacts;


					// Director 1
					$trustees->setTrusteesContacts($trustees->trusteesContacts, 0);
					$entry['190']         = $trustees->trusteesContactsTitle; //  Title
					$entry['154']         = $trustees->trusteesContactsFirstName;  // Given name
					$entry['189']         = $trustees->trusteesContactsLastName; // Family name


					// Director 2
					$trustees->setTrusteesContacts($trustees->trusteesContacts, 1);
					$entry['199']         = $trustees->trusteesContactsTitle; //  Title
					$entry['200']         = $trustees->trusteesContactsFirstName;  // Given name
					$entry['201']         = $trustees->trusteesContactsLastName; //  Family name

					// Director 3
					$trustees->setTrusteesContacts($trustees->trusteesContacts, 2);
					$entry['202']         = $trustees->trusteesContactsTitle; // Title
					$entry['203']         = $trustees->trusteesContactsFirstName;  //Given name
					$entry['204']         = $trustees->trusteesContactsLastName; // Family name

					// Director 4
					$trustees->setTrusteesContacts($trustees->trusteesContacts, 3);
					$entry['205']         = $trustees->trusteesContactsTitle; // Title
					$entry['206']         = $trustees->trusteesContactsFirstName;  // Given name
					$entry['207']         = $trustees->trusteesContactsLastName; //  Family name

				}
				else
				{

					$fundDetails = new \App\FundDetails($fundDetailsData);
					$trustees1   = new \App\Trustees($trusteesData, 0);
					$trustees2   = new \App\Trustees($trusteesData, 1);
					$trustees3   = new \App\Trustees($trusteesData, 2);
					$trustees4   = new \App\Trustees($trusteesData, 3);

					// Add meeting address for trustees
					$entry['559']  = 'Other Address';
					$entry['220']  = $trustees1->trusteesAddress;

					// Open for trustee members directors
					$entry['150']        =  $fundDetails->totalTrustees;
					$entry['138']         = 'Individuals'; // company or individual option
					$entry['150']         = $trustees1->trusteesContactTotal;  // total trustee
					$entry['220']         = $trustees1->trusteesAddress; // trustee meeting address

					//trustee member1
					$entry['190']         = $trustees1->trusteesContactTitle; // title
					$entry['154']         = $trustees1->trusteesContactFirstName; // given first name
					$entry['189']         = $trustees1->trusteesContactLastName; // given last name

					//trustee member 2
					$entry['199']         = $trustees2->trusteesContactTitle;// title
					$entry['200']         = $trustees2->trusteesContactFirstName;// given first name
					$entry['201']         = $trustees2->trusteesContactLastName;// given last name

					//trustee member 3
					$entry['202']         = $trustees3->trusteesContactTitle;// title
					$entry['203']         = $trustees3->trusteesContactFirstName;// given first name
					$entry['204']         = $trustees3->trusteesContactLastName;// given last name

					//trustee member 4
					$entry['205']         = $trustees4->trusteesContactTitle;// title
					$entry['206']         = $trustees4->trusteesContactFirstName;// given first name
					$entry['207']         = $trustees4->trusteesContactLastName;// given last name

				}







				/********************************************
				 * // Map member who will receive the pension
				 * // This will map both company and individual
				 ********************************************/
				$memberSelectedIndex = 0;
				$isMapForPensionReceiver = false;
				for($i=0; $i<count($membersData); $i++)
				{
					$member = new \App\Member($membersData, $i);
					if( $_POST['pensionMemberRefKey'] == $member->fundMemberMemberRefKey)
					{
						$memberSelectedIndex = $i;
						$isMapForPensionReceiver = true;
					}
					else
					{
						// Do nothing
					}
				}


				// Start mapping to pension document
				if($isMapForPensionReceiver == true)
				{
					$member = new \App\Member($membersData, $memberSelectedIndex);
					$entry['296'] = $member->fundMemberFullName; // Chairman -> Tim Foster
					$entry['585'] = $member->fundMemberFullName; //'Member will receive the pension -> Tim Foster';
					$entry['70']  = $member->fundMemberDobAuFormat ; // '01/02/2016';
					$entry['105'] = $member->fundMemberGender; //'Male';
					$entry['258'] = 'Other address';
					$entry['231'] = $member->fundMemberAddress; //'iligan city, philippines, 9200';
				}


//				echo "<pre>";
//				 print_r($entry);
//				 $importResult = $formId.GFAPI::add_entry($entry);
//				 exit;

				break;

			// Deed Upgrade
			case 53:
				$entry['9']  = $fundName;
				$entry['59'] = $estDate;
				if($trusteeType == 'Corporate Trustee')
				{
					$entry['14'] = $trusteeName;
					$entry['12'] = 'The trustee is a Company already incorporated';
					$entry['79'] = $trusteeDetail['ACN'];
					$entry['18'] = $trusteeAddress;
				}
				else
				{
					$entry['12'] = 'The Trustees are individuals';
					$entry['80'] = $trustees[0]['detail']['address']['streetLine1'].' '.$trustees[0]['detail']['address']['streetLine2'].' '.$trustees[0]['detail']['address']['city'].' '.$trustees[0]['detail']['address']['state'].' '.$trustees[0]['detail']['address']['postCode'];
					$entry['33'] = $trustees[0]['detail']['address']['streetLine1'].' '.$trustees[0]['detail']['address']['streetLine2'].' '.$trustees[0]['detail']['address']['city'].' '.$trustees[0]['detail']['address']['state'].' '.$trustees[0]['detail']['address']['postCode'];
				}
				//$entry['15'] = '';
				$entry['20'] = $contacts[0]['firstName'].' '.$contacts[0]['lastName'];
				$entry['21'] = '';
				$entry['22'] = $contacts[1]['firstName'].' '.$contacts[1]['lastName'];
				$entry['24'] = $contacts[2]['firstName'].' '.$contacts[2]['lastName'];
				$entry['23'] = $contacts[3]['firstName'].' '.$contacts[3]['lastName'];
				$entry['27'] = $trustees[0]['detail']['contact']['firstName'].' '.$trustees[0]['detail']['contact']['lastName'];
				$entry['29'] = $trustees[1]['detail']['contact']['firstName'].' '.$trustees[1]['detail']['contact']['lastName'];
				$entry['31'] = $trustees[2]['detail']['contact']['firstName'].' '.$trustees[2]['detail']['contact']['lastName'];
				$entry['30'] = $trustees[3]['detail']['contact']['firstName'].' '.$trustees[3]['detail']['contact']['lastName'];
				$entry['28'] = '';
				if(($numMembers) > 3)
				{ //4 members
					$entry['42.1'] = 'Member 2';
					$entry['42.2'] = 'Member 3';
					$entry['42.3'] = 'Member 4';
					$entry['37'] = $members[0]['firstName'].' '.$members[0]['lastName'];
					$entry['41'] = $members[0]['address']['streetLine1'].' '.$members[0]['address']['streetLine2'].' '.$members[0]['address']['city'].' '.$members[0]['address']['state'].' '.$members[0]['address']['postCode'];
					$entry['43'] = $members[1]['firstName'].' '.$members[1]['lastName'];
					$entry['47'] = $members[1]['address']['streetLine1'].' '.$members[1]['address']['streetLine2'].' '.$members[1]['address']['city'].' '.$members[1]['address']['state'].' '.$members[1]['address']['postCode'];
					$entry['48'] = $members[2]['firstName'].' '.$members[2]['lastName'];
					$entry['52'] = $members[2]['address']['streetLine1'].' '.$members[2]['address']['streetLine2'].' '.$members[2]['address']['city'].' '.$members[2]['address']['state'].' '.$members[2]['address']['postCode'];
					$entry['53'] = $members[3]['firstName'].' '.$members[3]['lastName'];
					$entry['57'] = $members[3]['address']['streetLine1'].' '.$members[3]['address']['streetLine2'].' '.$members[3]['address']['city'].' '.$members[3]['address']['state'].' '.$members[3]['address']['postCode'];
				}
				elseif(($numMembers) > 2)
				{  // 3 members
					$entry['42.1'] = 'Member 2';
					$entry['42.2'] = 'Member 3';
					$entry['37'] = $members[0]['firstName'].' '.$members[0]['lastName'];
					$entry['41'] = $members[0]['address']['streetLine1'].' '.$members[0]['address']['streetLine2'].' '.$members[0]['address']['city'].' '.$members[0]['address']['state'].' '.$members[0]['address']['postCode'];
					$entry['43'] = $members[1]['firstName'].' '.$members[1]['lastName'];
					$entry['47'] = $members[1]['address']['streetLine1'].' '.$members[1]['address']['streetLine2'].' '.$members[1]['address']['city'].' '.$members[1]['address']['state'].' '.$members[1]['address']['postCode'];
					$entry['48'] = $members[2]['firstName'].' '.$members[2]['lastName'];
					$entry['52'] = $members[2]['address']['streetLine1'].' '.$members[2]['address']['streetLine2'].' '.$members[2]['address']['city'].' '.$members[2]['address']['state'].' '.$members[2]['address']['postCode'];
				}
				elseif(($numMembers) > 1)
				{ //2 members
					$entry['42.1'] = 'Member 2';
					$entry['37'] = $members[0]['firstName'].' '.$members[0]['lastName'];
					$entry['41'] = $members[0]['address']['streetLine1'].' '.$members[0]['address']['streetLine2'].' '.$members[0]['address']['city'].' '.$members[0]['address']['state'].' '.$members[0]['address']['postCode'];
					$entry['43'] = $members[1]['firstName'].' '.$members[1]['lastName'];
					$entry['47'] = $members[1]['address']['streetLine1'].' '.$members[1]['address']['streetLine2'].' '.$members[1]['address']['city'].' '.$members[1]['address']['state'].' '.$members[1]['address']['postCode'];
				}
				else
				{
					//has 1 member
					$entry['37'] = $members[0]['firstName'].' '.$members[0]['lastName'];
					$entry['41'] = $members[0]['address']['streetLine1'].' '.$members[0]['address']['streetLine2'].' '.$members[0]['address']['city'].' '.$members[0]['address']['state'].' '.$members[0]['address']['postCode'];
				}
			break;

			// Change of Trustee
			case 65:


				//echo " <br>started the doc case ";
				//echo "<pre>";




					$fundDetails = new \App\FundDetails($fundDetailsData);
					$trustees    = new \App\Trustees($trusteesData, 0);


					$entry['9']  = $fundDetails->fundName;
					$entry['59'] = $fundDetails->fundCreateTimeAuFormat;  //Name of Fund
					$entry['60'] = ''; //Deed 2
					$entry['62'] = ''; //Deed 3
					$entry['61'] = ''; //Deed 4
					$entry['105'] = ''; //Rule number to change the Fund Trustee


					if($trustees->trusteesType == 'Corporate')
					{


						// Set option
						$entry['12'] = 'The trustee is a Company';


						$entry['14']  = $trustees->trusteesName; //company name;
						$entry['101'] = $trustees->trusteesACN; //

						// Open document fields for directors
						$entry = $document->smsfChangeOfTrusteeOpenDocumentFieldsDirectors($trustees->trusteesTotalContacts, $entry);

						// Set directors first name and last name
						$trustees->setTrusteesContacts($trustees->trusteesContacts, 0);
						$entry['20']  = $trustees->trusteesContactsFirstName;
						$entry['117'] = $trustees->trusteesContactsLastName;

					    $trustees->setTrusteesContacts($trustees->trusteesContacts, 1);
						$entry['22']  = $trustees->trusteesContactsFirstName;
						$entry['118'] = $trustees->trusteesContactsLastName;

						$trustees->setTrusteesContacts($trustees->trusteesContacts, 2);
						$entry['24']  = $trustees->trusteesContactsFirstName;
						$entry['119'] = $trustees->trusteesContactsLastName;

						$trustees->setTrusteesContacts($trustees->trusteesContacts, 3);
						$entry['23']  = $trustees->trusteesContactsFirstName;
						$entry['120'] = $trustees->trusteesContactsLastName;

						$entry['18'] = $fundDetails->fundPostalAddress;


					}
					else
					{
						$entry['12'] = 'The Trustees are individuals';


						$fundDetails = new \App\FundDetails($fundDetailsData);
						$trustees1   = new \App\Trustees($trusteesData, 0);
						$trustees2   = new \App\Trustees($trusteesData, 1);
						$trustees3   = new \App\Trustees($trusteesData, 2);
						$trustees4   = new \App\Trustees($trusteesData, 3);


						$entry = $document->smsfChangeOfTrusteeOpenDocumentFieldsTrustee($trustees->trusteesContactTotal, $entry);


						// Set trustees first name and last name

					    $entry['27']  = $trustees1->trusteesContactFirstName;
						$entry['121'] = $trustees1->trusteesContactLastName;

						$entry['29']  =  $trustees2->trusteesContactFirstName;
						$entry['122'] = $trustees2->trusteesContactLastName;

						$entry['31']  = $trustees3->trusteesContactFirstName;
						$entry['123'] = $trustees3->trusteesContactLastName;

						$entry['30']  = $trustees4->trusteesContactFirstName;
						$entry['124'] = $trustees4->trusteesContactLastName;

						$entry['103'] = $trustees1->trusteesAddress;
					}

						//print_r($entry);
						//$importResult = $formId.GFAPI::add_entry($entry);
						 //exit;

			break;
			//case XXXXXXXXX: //Investment Strategy
			//	$entry['1'] = $fundName;
			//break;
		} // End switch case



//		echo "<pre>";

//			print_r($entry);

//		echo "</pre>";
		// Add entry to database
		$importResult = $formId.GFAPI::add_entry($entry);

    } // End post
 	?>

	<!--TEMPLATE DISPLAY-->
	<!-- BEGIN CONTAINER -->
	<div class="page-container">
		<?php get_sidebar(); ?>
		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
				<h1><?php the_title(); ?></h1>
				<h2> <?php // echo "ID = " . $current_user->ID . "<br>"; ?> </h2> 

				<!-- BEGIN PAGE HEADER-->
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="/">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<?php
							if(empty($post->post_parent))
							{
								$link = '<a href="'.$post->post_name.'">'.get_the_title( $post->ID ).'</a>';
							}
							else
							{
								$ancestors = get_post_ancestors( $post );
								$links = '';
								foreach($ancestors as $ancestor)
								{
									$links = '<a href="'.get_page_template_slug( $ancestor ).'">'.get_the_title($ancestor).'</a><i class="fa fa-angle-right"></i> '.$links;
								}
								$link = $links.'<a href="'.$post->post_name.'">'.get_the_title( $post->ID ).'</a>';
							}
							echo $link;
							?>
						</li>
					</ul>
				</div>
				<!-- END PAGE HEADER-->
				<!-- section -->
				<section>
					<?php if($isExistAccessToken == true): ?>
						<?php if (have_posts()): while (have_posts()) : the_post(); ?>
							<!-- article -->
							<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
								<form action="" method="POST">
									<table border="0" cellpadding="0"cellspacing="0" >
										<td>
											<label for="fundList">Choose Fund: </label>
										</td>
										<td style="padding-left: 20px;" >
											<?php
											$importForm = '<select name="fundList" id="fundList" onchange="loadMember()" ><option value="">- Select One - </option>';
											foreach($funds as $fund)
											{
												$value = $fund['fundID'];
												$importForm .= '<option value="' . $value . '">'.$fund['fundName'].'</option>';
											}
											$importForm .= '</select>';
											echo $importForm;
											?>
										</td>

										<td style="padding-left: 20px;" >
											<label for="fundList">Choose Document: </label>
										</td>
										<td style="padding-left: 20px;" >
											<select name="documentList" id="documentList" onchange="loadMember()" >
												<option value="">- Select One -</option>
												<option value="6">SMSF Establishment</option>
												<option value="15">SMSF Pension</option>
												<option value="56">SMSF Borrowing</option>
												<option value="53">SMSF Deed Upgrade</option>
												<option value="65">SMSF Change of Trustee</option>
											</select>

										</td>

										<td style="padding-left: 20px;" >
											<input type="submit" name="submit" value="Import" style="border: none;background-color: #0071B2;color: white;padding: 6px 19px 6px 18px;">
										 </td>

										<td>
											<div id="data-loader" style="display:none">&nbsp;&nbsp; loading...</div>
										</td>
										<tr>
											<td id="fund-name-members-td-1"  >

	<!--											<label for="fundList">Choose Fund Member: </label>-->
											</td>
											<td id="fund-name-members-td-2" style="padding-left: 20px;" >
	<!--											<select name="documentList" id="select-fund-member">-->
	<!--												<option value="">- Select One -</option>-->
	<!--												<option value="6">Michael</option>-->
	<!--												<option value="15">Japz</option>-->
	<!--												<option value="56">Tim</option>-->
	<!--												<option value="53">Floyd</option>-->
	<!--											</select>-->
											</td>
									</table>
								</form>
							   <?php
								   if($_POST['fundList'])
								   {
										echo '<h4>Import Successful. Order No: '.$importResult.'. Redirecting now...</h4>';
										foreach($trustees as $trustee){
												//echo print_r($trustee['detail'],true).'<br/>';
												$trusteeDetail 		= $trustee['detail'];
												$trusteeName 		= $trusteeDetail['name'];
												$trusteeType 		= $trusteeDetail['type'];
												$trusteeAddress 	= $trusteeDetail['address'];
												$contacts			= $trusteeDetail['contacts'];
												$contact			= $trusteeDetail['contact'];
												//echo 'Contacts: '.print_r($contact,true).'<br/>';
												if($numTrustees < 2){
													foreach($contacts as $contact){
														$corpTee .= $contact['position'].'<br/>'.$contact['firstName'].' '.$contact['lastName'].'<br/>';

													}
												}
												else {
													$indivTees .= $contact['title'].' '.$contact['firstName'].' '.$contact['lastName'].' '.$contact['address'].'<br/>';

												}
											}

											//echo "<h3> ".$fundName." </h3>";
											//echo "<p>Establishment Date: ".$estDate."</p>";
											//echo print_r($response['detail'], true);
											//echo '<h4>Trustees:</h4>';
											//echo $indivTees;
											//echo $corpTee;
											//echo '<h4>Members:</h4>';
											//foreach($members as $member){
											//	echo $member['firstName'].' '.$member['lastName'].'<br/>';
											//	echo $member['address']['streetLine1'].' '.$member['address']['streetLine2'].' '.$member['address']['city'].' '.$member['address']['state'].'<br/>';
											//}
											//echo 'Num: '.$numTrustees.'<br/>';
										 header('Refresh: 3; URL=https://app.thesmsfacademy.com.au/saved/documents/');
								   }
							   ?>
								<div id="demo">
								</div>
								<br class="clear">
							</article>
							<!-- /article -->
						<?php endwhile; ?>
						<?php else: ?>
							<!-- article -->
							<article>
								<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>
							</article>
							<!-- /article -->
						<?php endif; ?>


					<?php else: ?>
						 <form action="https://app.thesmsfacademy.com.au/wp-bgl360-authenticate.php" method="POST">
							<input type="submit" value="Get access to bgl360" style="background-color: #0071B2;color: white;padding: 10px 40px 10px 40px;font-size: 17px;"/>
						 </form>
					<?php endif; ?>
				</section>
				<!-- /section -->
			</div>
		</div>
		<!-- END CONTENT -->
	</div>
	<!-- END CONTAINER -->
	<?php get_footer(); ?>

	<script>
		function loadMember()
		{
			var docId = document.getElementById("documentList").value;
			if(docId == 15)
			{
				var fundList =  document.getElementById("fundList").value;
				if(fundList != "")
				{
					document.getElementById("fund-name-members-td-1").innerHTML = '';
					document.getElementById("fund-name-members-td-2").innerHTML = '';
					//document.getElementById("fund-name-members-td-1").style.display = "";
					//document.getElementById("fund-name-members-td-2").style.display = "";

					document.getElementById("data-loader").style.display = "block";
					var xhttp = new XMLHttpRequest();
					xhttp.onreadystatechange = function() {
						if (xhttp.readyState == 4 && xhttp.status == 200)
						{
							document.getElementById("data-loader").style.display = "none";
							document.getElementById("demo").innerHTML = xhttp.responseText;
							var label     = xhttp.responseText.split('<content-label>');
							var dropDown  = xhttp.responseText.split('<content-dropdown>');
							document.getElementById("fund-name-members-td-1").innerHTML = label[1];
							document.getElementById("fund-name-members-td-2").innerHTML = dropDown[1];
						}
					};
					xhttp.open("POST", "https://app.thesmsfacademy.com.au/wp-content/themes/TPO10/template-bgl360import-getmembers.php", true);
					xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xhttp.send("fundList="+fundList);
					// alert("done..");
				}
				else
				{
					//alert("please select a fund");
					document.getElementById("demo").innerHTML = '';
					document.getElementById("fund-name-members-td-1").innerHTML = '';
					document.getElementById("fund-name-members-td-2").innerHTML = '';
					//document.getElementById("fund-name-members-td-1").style.display = "none";
					//document.getElementById("fund-name-members-td-2").style.display = "none";
				}
			}
			else
			{
				document.getElementById("demo").innerHTML = '';
				document.getElementById("fund-name-members-td-1").innerHTML = '';
				document.getElementById("fund-name-members-td-2").innerHTML = '';
				//document.getElementById("fund-name-members-td-1").style.display = "none";
				//document.getElementById("fund-name-members-td-2").style.display = "none";
			}
		}
	</script>
