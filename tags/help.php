<?
############################################################
#                     Fusion Tags v.1.0                    #
#----------------------------------------------------------#
#          Author:    J.C.				                   #
#          E-mail:    webmaster@fusionphp.org              #
#          Website:   http://www.fusionphp.org/            #
#----------------------------------------------------------#                                                
############################################################
######################  Copyrights  ########################
############################################################
#                     Fusion Scripts                       #
#----------------------------------------------------------#
#                This Script is NOT Freeware.              #
#      Please read the license.txt file for more info.     #
############################################################

include("config.php");
echo stripSlashes($header);
?>
<script language="javascript">
	function insertSmiley(smiley){
	    var currentMessage = window.opener.document.forms[0].elements[2].value;
	    newMessage = currentMessage+" "+smiley+" ";
	    window.opener.document.forms[0].elements[2].value=newMessage;
	    window.opener.document.forms[0].elements[2].focus();
	}
</script>
<b>Posting a message:</b><br>
Where it says "<?php echo $namedefault?>" enter your name.<br>
If you have a website, enter the url of your website where it says "<?php echo $urldefault?>".<br>
When you have filled in a message, just click 'Post'!
<br><br>
<b>Viewing date/time of post:</b><br>
Hover over a message and you'll see the date and time of the post (if the template hasn't been to modified)<br><br>
<b>About the script:</b><br>
This uses php and text files to bring interaction to your site for your fans, they are allowed to leave messages!<br><br>
<?php
	if(is_dir("smilies")){
?>
<b>Smilies:</b><br>
Click one and it will be inserted in your post.<Br>
<?php
	 $dir = opendir("smilies");
		while($file = readdir($dir)) {
			if($file != "." && $file != ".."){
			 $title = substr($file, 0,(strlen($file)-4));
			 echo "<a href=\"javascript: insertSmiley(':$title:')\"><img src=\"smilies/$file\" border=\"0\"></a>\n";
			}
		}
	 closedir($dir);
	 echo "<br><br>";
	}
?>
<b>Where can i download tags?</b><br>
Go <a href="http://www.fusionphp.org/" target="_blank">Here</a> to get it!