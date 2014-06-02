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
$arrfollower = $connection->get('followers/list');
#print_r($arrfollower); exit;
$arrfollower = $arrfollower->users;
$strHtml = '<ul class="bxslider">';
		#if(is_array($arrfollower) && count($arrfollower)> 0)
		{
			foreach($arrfollower as $intKey => $arrfollowerDtls)
			{
				#echo '<pre>';print_r($arrfollower);die;
				
				$strfollowerName = $arrfollowerDtls->screen_name;
				$strName = $arrfollowerDtls->name;
				$profile_image_url = $arrfollowerDtls->profile_image_url;
				$strHtml .='<li>
						<table border="3" bgcolor="#7FFFD4" width="500" height="75" style="margin:0 auto;">
       			<tr>			     
			     	<td rowspan="2">
							<img src="<?php echo $profile_image_url;?>" alt="" height="70" width="50">
						</td>			     	
				   <td >
		        <div class="content">
		    	    <div class="stream-item-header">         
		      		  <a  class="" href="https://twitter.com/'.$strfollowerName.'" >		    
		   					<strong class="">'.$strName.'</strong>
		    				<span>&rlm;</span><span class=""><s>@</s><b>'.$strfollowerName.'</b></span>
		      		 </a>
		       		</div>
		        </div>
		       </td>
		    </tr>		   
		</table>
	</li>';
		}//end foreach
	}//end if
	$strHtml .= '</ul>';
	
	print $strHtml;
?>