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
$arrfollower = $arrfollower->users;
//echo '<pre>'; print_r($arrfollower);die;
?>

<!DOCTYPE html>
<html>
<head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<style>
ul.bxslider{
		display: block; list-style: none; width: 805px;
}
ul.bxslider li{
	float:left;
}
</style>
</head>
<body background="background1.png">
 
<form method="get" action="http://www.twitter.com">
<table cellpadding="0px" cellspacing="0px">
<tr>
<td style="border-style:solid;border-color:#CCCCCC;border-width:1px;">
<input type="text" name="zoom_query" list="txtFollowers"  style="width:100px; border:0px solid; height:30px; padding:0px 3px; position:relative;">
<datalist id="txtFollowers">
<?php if(is_array($arrfollower) && count($arrfollower)> 0)
		{
			foreach($arrfollower as $intKey => $arrfollowerDtls)
			{ ?>
				<option  value="<?php echo $arrfollowerDtls->screen_name;?>" >
			<?php }
		}
?>
</datalist>
</td>
<td style="border-style:solid;border-color:#CCCCCC;border-width:0px;">
<input type="submit" value="" style="border-style: none; background: url('button.png') no-repeat; width: 30px; height: 30px;">

</td>
</tr>
</table>
</form>

<ul class="bxslider">
	<?php 
		if(is_array($arrfollower) && count($arrfollower)> 0)
		{
			foreach($arrfollower as $intKey => $arrfollowerDtls)
			{
				//echo '<pre>';print_r($arrfollower);die;
				
				$strfollowerName = $arrfollowerDtls->screen_name;
				$strName = $arrfollowerDtls->name;				
				$profile_image_url = $arrfollowerDtls->profile_image_url;
	?>
	<li width="400">
	<table border="3" bgcolor="#7FFFD4" width="300" height="75" style="margin:0 auto;">
	
			
				
        <tr>
			     
			     	<td rowspan="2">
							<img src="<?php echo $profile_image_url;?>" alt="" height="70" width="50">
						</td>
			     	
				   <td >
		        <div class="content">
		    	    <div class="stream-item-header">         
		      		  <a  class="" href="https://twitter.com/<?php echo $strfollowerName;?>" >		    
		   					<strong class=""><?php echo $strName;?></strong>
		    				<span>&rlm;</span><span class=""><s>@</s><b><?php echo $strfollowerName;?></b></span>
		      		 </a>
		       		</div>
		        </div>
		       </td>
		    </tr>
		   
		</table>
	</li>
<?php
		}//end foreach
	}//end if
?>
</ul>
</body>
</html>
