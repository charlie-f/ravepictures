<?php
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

	if(phpversion()<4.1){
	 $_SERVER = $HTTP_SERVER_VARS;
	 $_COOKIE = $HTTP_COOKIE_VARS;
	 $_POST = $HTTP_POST_VARS;
	 $_GET = $HTTP_GET_VARS;
	}
	if($submit){
	 $domain = eregi_replace("www.","",$_SERVER[HTTP_HOST]);
	 $domain = ".".$domain;
	 setCookie("tagsurl",$_POST[url],time()+(31*86400),"/",$domain);
	 setCookie("tagsuser",$_POST[name],time()+(31*86400),"/",$domain);
	 $tagsurl = $_POST[url];
	 $tagsuser = $_POST[name];
	}
include("config.php");
	function testConfirm($text,$fieldname,$maxlength) {
	 global $namedefault;
		if(strlen($text) > $maxlength) {
		 $toolong = strlen($text)-$maxlength;
		 echo "Your $fieldname was $toolong characters too long, please try again";
		 return TRUE;
		} elseif(strtolower(trim($text)) == "none" || strtolower(trim($text)) == strtolower(trim($namedefault)) || strtolower(trim($text)) == "message" || !$text){
		 echo "You did not enter valid information for your $fieldname";
		 return TRUE;
		}
	}

	function safeInsert($text) {
		$text = str_replace("|^|","l^l",$text);
		$text = htmlspecialchars($text);
		return $text;
	}

	function deanowrap($message,$maxwordlen) {
	 $word = explode(" ",$message);
		for ($w=0;$w<count($word);$w++) {
			if (strlen($word[$w])>$maxwordlen) {
			 $message = eregi_replace($word[$w],chunk_split($word[$w],$maxwordlen),$message);
			}
		}
	 return $message;
	}

	if($_GET[submit]){
		if(strtolower($adminusername)==strtolower($_POST[name]) && $adminpassword!=md5($_COOKIE[password])){
		 exit ("You cannot use this name, plase change it");
		}
	 $ipline = file("bannedips.php");
		for($i=0;$i<count($ipline);$i++){
			if(trim($ipline[$i])==$_SERVER[REMOTE_ADDR]){
			 exit ("You Have been banned from posting.");
			}
		}
		if(!$rfile = @fopen($data_file,"a")){
		 echo "Cannot write to '$datafile' attempting to chmod to 666...";
		 $cannotwrite = TRUE;
			if(!@chmod($data_file,0666)){
			 echo "<br>chmod unsuccessful, please manually chmod it through your ftp to 666";
			} else {
			 echo "<br>chmod successful!";
			 $cannotwrite = FALSE;
			}
		}
		if(!$cannotwrite){
		 $rfile = @fopen($data_file,"a") or die ("Cannot write to file");
		 $_POST[name] = safeInsert($_POST[name]);
		 $_POST[url] = safeInsert($_POST[url]);
		 $_POST[message] = safeInsert($_POST[message]);
			if(testConfirm($_POST[name],"name",$maxnamelength)){
			 $error = TRUE;
			} elseif(testConfirm($_POST[message],"message",$maxpostlength)){
			 $error = TRUE;
			} else {
			 $data = time()."|^|$_POST[name]|^|$_POST[url]|^|$_POST[message]|^|$_POST[id]|^|$_SERVER[REMOTE_ADDR]|^|\n";
			 @flock ($rfile,2);
			 @fputs ($rfile, $data);
			 @fclose($rfile);
			 echo "<script language=\"javascript\">window.location='$_POST[PHP_SELF]?id=$_POST[id]'</script>";
			}
		}
	}
	if(eregi("<body",$header)){
	 $header = eregi_replace("<body","<body onload=\"window.scrollTo(0,99999);\"",$header);
	} else {
	 $header .= "<body onload=\"window.scrollTo(0,99999);\">";
	}
 echo stripslashes($header);
?>
<script language="javascript">
<!--
	function submitonce() {
	 document.forms[0].elements[3].disabled=true
	 document.forms[0].elements[4].disabled=true
	}
	function doClearMessage(){
	 document.forms[0].elements[2].value = "";
	 document.forms[0].elements[2].focus();
	}
//-->
</script>
<?php
	if(!$error){
	 echo stripslashes($postheader);
	 $line = file($data_file);
		if($shouts>count($line) || $_SERVER[QUERY_STRING]=="all" || $_SERVER[QUERY_STRING]=="delete" || $_SERVER[QUERY_STRING]=="banip"){
		 $shouts = count($line);
		}
	 sort($line);
		for($i=(count($line)-$shouts);$i<count($line);$i++){
		 list($date,$name,$website,$post,$newsid,$userip,) = explode("|^|",$line[$i]);
			if($newsid==$_GET[id]){
			 $posttotal++;
				if(strtolower(trim($website)) != "none" && strtolower(trim($website)) != strtolower(trim($urldefault)) && strtolower(trim($website))){
					if(substr(strtolower($website),0,7) != "http://"){
					 $website = "http://".$website;
					}
				 $name = "<a href=\"$website\" target=\"$name\">$name</a>";
				}
			 $post = deanowrap($post,$maxwordlength);
				if(is_dir("smilies")){
				 $dir = opendir("smilies");
					while($file = readdir($dir)) {
						if($file != "." && $file != ".."){
						 $title = substr($file, 0,-4);
						 $post = eregi_replace(":$title:","<img src=\"smilies/$file\">",$post);
						}
					}
				 closedir($dir);
				}
				if(md5($_COOKIE[password])==$adminpassword){
					if($_SERVER[QUERY_STRING]=="banip"){
					 $post .= "<br><a href=\"admin.php?action=banip&ip=$userip\" style=\"color: red\">[banip]</a>";
					} elseif ($_SERVER[QUERY_STRING]=="delete"){
					 $post .= "<br><a href=\"admin.php?action=delete&id=$date\" style=\"color: red\">[delete]</a>";
					}
				}
			 $word = file("badwords.txt");
				for($w=0;$w<count($word);$w++){
				 list($curse,$replacement,) = explode("|^|",$word[$w]);
				 $post = eregi_replace($curse,$replacement,$post);
				}
			 $date = date ("dS of F, Y \@ H:i",$date);
			 $newpost = eregi_replace("<post>",$post,$postbit);
			 $newpost = eregi_replace("<name>",$name,$newpost);
			 $newpost = eregi_replace("<url>",$url,$newpost);
			 $newpost = eregi_replace("<date>",$date,$newpost);
			 echo stripslashes($newpost);
			}
		}
	 echo stripslashes($postfooter);
		if(!$posttotal){
			if($_GET[id]){
			 echo "No comments have been submitted to this article yet";
			} else {
			 echo "No comments have been submitted to Tags yet";
			}
		} elseif(md5($_COOKIE[password])==$adminpassword) {
		 echo "<a href=\"admin.php?action=delete&group=$_GET[id]\">Delete all posts in this group</a>";
		}
	}
	if(!$_COOKIE[tagsuser]){
	 $tagsuser = $namedefault;
	 $tagsurl = $urldefault;
	} else {
	 $tagsuser = $_COOKIE[tagsuser];
	 $tagsurl = $_COOKIE[tagsurl];
	}
 $formbit = eregi_replace("<nameCookie>",$tagsuser,$formbit);
 $formbit = eregi_replace("<urlCookie>",$tagsurl,$formbit);
 $formbit = eregi_replace("submit=yes","submit=yes&id=$_GET[id]",$formbit);
 echo stripslashes($formbit);
 echo stripslashes($footer);
?>