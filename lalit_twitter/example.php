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



$arrContent = $connection->get('statuses/user_timeline', array('count' => '10'));
//echo '<pre>';print_r($arrContent);die;
$arrfollower = $connection->get('followers/list', array('count' => '10'));
$arrfollower = $arrfollower->users;
//echo '<pre>';print_r($arrfollower);die;

?>
<!DOCTYPE html>
<html>
<head>
	<?php $arrContent = $connection->get('statuses/user_timeline');?>
	<h1>welcome <?php echo $arrContent[0]->user->name?></h1>
<style>
ul.bxslider2{
		display: block; list-style: none; width: 805px;
}
ul.bxslider2 li{
	float:left;
}
</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="api_lib/jquery.bxslider.min.js"> </script>
<script>
	
$(function() {
	$('.bxslider').bxSlider({
  mode: 'vertical',
 
  minSlides: 4,
  maxSlides: 4,
  slideWidth: 700,
  slideMargin: 10,
  easing: 'swing',
  ticker: true,
  speed: 50000,
  autoHover:true,
  pause: 25000,
  tickerHover:true
});
});

function myFunction(follower_userid){
	var parameters ="screen_name="+follower_userid; 
$.post("followerdata.php?"+parameters,function(data){   
            
            
        temp_arr=data.split("@@@");
        
        //alert(jQuery.trim(temp_arr[0])+" AND"+jQuery.trim(temp_arr[1]));
        
        if(jQuery.trim(temp_arr[0])!='success' &&  jQuery.trim(temp_arr[0])!='fail')
            {
                //alert(data);
                $('.bxslider').html(data);
                  slider();
            }
            
        if(jQuery.trim(temp_arr[0])=="success")
            {     
                                                    
                 //$.unblockUI();
                //$("#divpauseimg_"+str_news_id).html(temp_arr[1]);  
                alert(temp_arr[1]);
            }
        else 
                {
                 
                }
        });
}
function slider(){
		$('.bxslider').bxSlider({
  mode: 'vertical',
 
  minSlides: 4,
  maxSlides: 4,
  slideWidth: 700,
  slideMargin: 10,
  easing: 'swing',
  ticker: true,
  speed: 50000,
  autoHover:true,
  pause: 25000,
  tickerHover:true
});
}

$(document).ready(function(){
  $(".follower_id").click(function(){
     var follower_userid= this.id;

myFunction(follower_userid);
    
  });
    $("#button1").click(function(){
   // alert("Value: " + $("#zoom_query").val());
     //window.open("https://twitter.com/" + $("#zoom_query").val());
     myFunction($("#zoom_query").val());
   
  });
});

</script>
</head>
<body background="background1.png">
	<label><b>Followers: </b></label>
	<input type="text"id="zoom_query" name="zoom_query" list="txtFollowers"  align ="left"; style="width:100px; border:0px solid; height:30px; padding:0px 3px; position:relative;">
<input type="submit" id="button1" value="" style="border-style: none; background: url('button.png') no-repeat; width: 30px; height: 30px;">
<a href="logout.php"><button>
	logout</button>
 </a>
<div id="owner_user" style=" width:600px;margin:0 auto;">
<ul class="bxslider">
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
		
	<table border="3" bgcolor="#7FFFD4" width="500" height="75" style="margin:10 auto;">
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
</ul>
</div>
<form method="get" action="#">
<table cellpadding="0px" cellspacing="0px">
<tr>
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

</tr>
</table>
</form>

<ul class="bxslider2">
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
		    	    <!-- https://twitter.com/<?php echo $strfollowerName;?> -->         
		      		  <a  class="follower_id" id="<?php echo $strfollowerName;?>" href="#" >		    
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