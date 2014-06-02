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

$params= array(
	'count' => 5,
	'screen_name'=> $_GET['screen_name']
	);
	

	
$arrContent = $connection->get('statuses/user_timeline',$params);
//echo '<pre>';print_r($arrContent);die;
$arrfollower = $connection->get('followers/list', array('count' => '10'));
$arrfollower = $arrfollower->users;
//echo '<pre>';print_r($arrfollower);die;
//$arrTweet=$connection->get('statuses/retweets/:id','id_str': "471181804");
//echo'<pre>';print_r($arrTweet);die;

?>

	<?php 
		if(is_array($arrContent) && count($arrContent)> 0)
		{
			
			foreach($arrContent as $intKey => $arrContentDtls)
			{
				//echo '<pre>';print_r($arrContentDtls);die;
				$strText = $arrContentDtls->text;
				$strUserName = $arrContentDtls->user->screen_name;
				$strName = $arrContentDtls->user->name;
				$profile_image_url = $arrContentDtls->user->profile_image_url
	?>
	<li>
	<table border="3" bgcolor="#7FFFD4" width="500" height="75" style="margin:0 auto;">
	
			
				
        <tr>
			     
			     	<td rowspan="2">
							<img src="<?php echo $profile_image_url;?>" alt="" height="70" width="50">
						</td>
			     	
				   <td >
		        <div class="content">
		    	    <div class="stream-item-header">         
		      		  <a  class="" href="https://twitter.com/<?php echo $strUserName;?>" >		    
		   					<strong class=""><?php echo $strName;?></strong>
		    				<span>&rlm;</span><span class=""><s>@</s><b><?php echo $strUserName;?></b></span>
		      		 </a>
		       		</div>
		        </div>
		       </td>
		    </tr>
		   <tr>
	    	<td  bgcolor="white">
      		<p class=""><?php echo $strText;?></p>
      		<div class="">
    			</div>
       </td>
 			</tr>
		</table>
	</li>
<?php
		}//end foreach
	}//end if
	?>