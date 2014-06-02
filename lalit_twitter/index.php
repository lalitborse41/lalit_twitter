<?php
/**
 * @file
 * User has successfully authenticated with Twitter. Access tokens saved to session and DB.
 */

/* Load required lib files. */
session_start();
require_once('twitteroauth/twitteroauth.php');
require_once('config.php');

/* If access tokens are not available redirect to connect page. */
if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
    header('Location: ./clearsessions.php');
}
/* Get user access tokens out of the session. */
$access_token = $_SESSION['access_token'];

/* Create a TwitterOauth object with consumer/user tokens. */
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

/* If method is set change API call made. Test is called by default. */
$arrContent = $connection->get('statuses/user_timeline');
$arrfollower = $connection->get('followers/list');
echo '<pre>'; print_r($arrfollower);die;
if(is_array($arrContent) && count($arrContent)> 0)
{
	foreach($arrContent as $intKey => $arrContentDtls)
	{
		$strText = $arrContentDtls->text;
		$strUserName = $arrContentDtls->user->screen_name;
		//print "<hr>$strText <br> $strUserName";
		$strLi .='<li>
		<table border="3" bgcolor=" sky blue" width="1300" height="75">
	
	<tr>
	     <td>
		<img src="lalitb.jpg" alt="" height="70" width="50">
	     </td>	
	</tr>
	<tr>
		   <td>
        <div class="content">
        <div class="stream-item-header">         
        <a  class="account-group js-account-group js-action-profile js-user-profile-link js-nav" href="/lalitborse41" data-user-id="2348447802">
    
    <strong class="fullname js-action-profile-name show-popup-with-id">Lalit Borse</strong>
    <span>&rlm;</span><span class="username js-action-profile-name"><s>@</s><b>lalitborse41</b></span>
       </a>
        </div>
        </div>
        </td>
  </tr>
  ';
	}
}

//echo '<pre>';print_r($arrContent);die;
/* Some example calls */
//$connection->get('users/show', array('screen_name' => 'abraham'));
//$connection->post('statuses/update', array('status' => date(DATE_RFC822)));
//$connection->post('statuses/destroy', array('id' => 5437877770));
//$connection->post('friendships/create', array('id' => 9436992));
//$connection->post('friendships/destroy', array('id' => 9436992));

/* Include HTML to display on the page */
include('html.inc');
