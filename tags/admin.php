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

 include("config.php");
	if(phpversion()<4.1){
	 $_COOKIE = $HTTP_COOKIE_VARS;
	 $_POST = $HTTP_POST_VARS;
	 $_SERVER = $HTTP_SERVER_VARS;
	 $_GET = $HTTP_GET_VARS;
	}
 $action = "";
	if($_POST[action]){
	 $action = $_POST[action];
	} elseif ($_GET[action]) {
	 $action = $_GET[action];
	}

	if($action=="login"){
		if(md5($_POST[password]) != $adminpassword){
		 $loginerror = TRUE;
		} else {
		 $domain = eregi_replace("www.","",$_SERVER[HTTP_HOST]);
		 $domain = ".".$domain;
		 setCookie("password",$_POST[password],time()+(365*(3600*24)),"/",$domain);
		 $displaymenu = TRUE;
		}
	} elseif(md5($_COOKIE[password]) != $adminpassword){
	 $loginerror = TRUE;
	}

	if($loginerror){
	 echo "<b>Login</b><hr>password does not match the admin password";
	 echo "<form action=\"$PHP_SELF?$QUERY_STRING\" method=\"post\"><input type=\"text\" name=\"password\" value=\"Password\"><input type=\"hidden\" name=\"action\" value=\"login\"><input type=\"submit\" value=\"Login\"></form>";
	} else {
		if($action=="templates" && $_POST[submit] && ($adminpassword != md5($_POST[password]))){
		 $domain = eregi_replace("www.","",$HTTP_HOST);
		 $domain = ".".$domain;
		 setCookie("password",$_POST[password],time()+(365*(3600*24)),"/",$domain);
		}
	 echo stripslashes($header);
		if($action=="templates"){
		 echo "<b>Edit templates/Settings</b><hr>";
			if($_POST[submit]){
				if(!$rfile = @fopen("config.php","w")){
				 $cannotwrite = TRUE;
				 echo "Cannot write to config file, attempting to chmod...";
					if(!@chmod("config.php",0666)){
					 echo "<br>Cannot chmod, please do it manually through ftp";
					} else {
					 echo "<br>Chmod successful!!!";
					 $cannotwrite = FALSE;
					}
				}
				if($rfile = @fopen("config.php","w")){
				 $_POST[password] = md5($_POST[password]);
					if (!ereg("([0-9])", $_POST[maxnamelength])) {
					 echo "'Max name length' was not a number, it will not be edited";
					 $_POST[maxnamelength]=$maxnamelength;
					}
					if (!ereg("([0-9])", $_POST[maxpostlength])) {
					 echo "'Max post length' was not a number, it will not be edited";
					 $_POST[maxpostlength]=$maxpostlength;
					}
					if (!ereg("([0-9])", $_POST[maxwordlength])) {
					 echo "'Max word length' was not a number, it will not be edited";
					 $_POST[maxwordlength]=$maxwordlength;
					}
					if (!ereg("([0-9])", $_POST[shouts])) {
					 echo "'View amount of shouts' was not a number, it will not be edited";
					 $_POST[shouts]=$shouts;
					}
				 $data = "<?php
\$data_file = \"posts.dat\";
\$adminusername = \"$_POST[username]\";
\$adminpassword = \"$_POST[password]\";
\$maxnamelength = $_POST[maxnamelength];
\$maxpostlength = $_POST[maxpostlength];
\$maxwordlength = $_POST[maxwordlength];
\$shouts = $_POST[shouts];
\$namedefault = \"$_POST[namedefault]\";
\$urldefault = \"$_POST[urldefault]\";
\$header = <<<myscript
$_POST[header]
myscript;
\$postheader = <<<myscript
$_POST[postheader]
myscript;
\$postbit = <<<myscript
$_POST[postbit]
myscript;
\$postfooter = <<<myscript
$_POST[postfooter]
myscript;
\$formbit = <<<myscript
$_POST[formbit]
myscript;
\$footer = <<<myscript
$_POST[footer]
myscript;
?>";
				 fputs ($rfile, $data);
				 fclose($rfile);
				 echo "Config file successfully changed!";
				 $displaymenu = TRUE;
				} else {
				 echo "Could not write to <b>config.php</b> make sure it is chmodded correctly <b>(666)</b>";
				 $displaymenu = TRUE;
				}
			} else {
		 ?>
<table cellpadding="1" cellspacing="0" bgcolor="000000" align="center">
<tr>
<form action="<?php echo $_SERVER[PHP_SELF]?>?action=templates" method="post">
<td>
<table cellpading="2" width="500" cellspacing="0">
<tr>
<td bgcolor="000000" colspan="2" class="menu" align="center"><font color="#FFFFFF"><b>Fusion Tags 1.0</b></font></td>
</tr>
<tr>
<td bgcolor="666666" colspan="2" class="menu" align="center">General Settings</td>
</tr>
<tr>
<td bgcolor="c0c0c0" align="right" width="25%">Admin Username</td>
<td bgcolor="ffffff" width="75%"><font size="1">This is the same name you will use for tags (so people dont cloak your name).</font><input type="text" name="username" value="<?php echo $adminusername?>"></td>
</tr>
<tr>
<td bgcolor="c0c0c0" align="right" width="25%">Admin Password</td>
<td bgcolor="ffffff" width="75%"><input type="text" name="password"></td>
</tr>
<tr>
<td bgcolor="666666" colspan="2" class="menu" align="center">Tags Options</td>
</tr>
<tr>
<td bgcolor="c0c0c0" align="right" width="25%">Show how many shouts?</td>
<td bgcolor="ffffff" width="75%"><input type="text" name="shouts" value="<?php echo $shouts?>"></td>
</tr>
<tr>
<td bgcolor="c0c0c0" align="right" width="25%">Name Default</td>
<td bgcolor="ffffff" width="75%"><font size="1">If they haven't posted a message before, this is displayed the name field</font><br><input type="text" name="namedefault" value="<?php echo $namedefault?>"></td>
</tr>
<tr>
<td bgcolor="c0c0c0" align="right" width="25%">URL Default</td>
<td bgcolor="ffffff" width="75%"><font size="1">If they haven't posted a message before, this is displayed in the url field</font><br><input type="text" name="urldefault" value="<?php echo $urldefault?>"></td>
</tr>
<tr>
<td bgcolor="c0c0c0" align="right" width="25%">Maximum Name Length</td>
<td bgcolor="ffffff" width="75%"><input type="text" name="maxnamelength" value="<?php echo $maxnamelength?>"></td>
</tr>
<tr>
<td bgcolor="c0c0c0" align="right">Maximum Post Length</td>
<td bgcolor="ffffff"><input type="text" name="maxpostlength" value="<?php echo $maxpostlength?>"></td>
</tr>
<tr>
<td bgcolor="c0c0c0" align="right">Maximum Word Length</td>
<td bgcolor="ffffff"><input type="text" name="maxwordlength" value="<?php echo $maxwordlength?>"></td>
</tr>
<tr>
<td bgcolor="666666" colspan="2" class="menu" align="center">Templates</td>
</tr>
<tr>
<td bgcolor="c0c0c0" align="right" valign="top">Header</td>
<td bgcolor="ffffff"><font size="1">Put java and style sheets here</font><br><textarea name="header" cols="55" rows="4"><?php echo stripslashes($header)?></textarea></td>
</tr>
<tr><td colspan="2" bgcolor="000000" height="1"></tr>
<tr>
<td bgcolor="c0c0c0" align="right" valign="top">Post bit header</td>
<td bgcolor="ffffff"><font size="1">This will appear at the top of all the total messages</font><br><textarea name="postheader" cols="55" rows="4"><?php echo stripslashes($postheader)?></textarea></td>
</tr>
<tr><td colspan="2" bgcolor="000000" height="1"></tr>
<tr>
<td bgcolor="c0c0c0" align="right" valign="top">Post bit<br><font size="1">&lt;name> = posters name<br>&lt;url> = posters website<br>&lt;post> = message<br>&lt;date> = date posted</font></td>
<td bgcolor="ffffff"><font size="1">Their name is automatically converted to a link to their url if they have entered a url.<br>This is the template for each message</font><br><textarea name="postbit" cols="55" rows="4"><?php echo stripslashes($postbit)?></textarea></td>
</tr>
<tr><td colspan="2" bgcolor="000000" height="1"></tr>
<tr>
<td bgcolor="c0c0c0" align="right" valign="top">Post bit footer</td>
<td bgcolor="ffffff"><font size="1">This will appear at the bottom of all the total messages</font><br><textarea name="postfooter" cols="55" rows="4"><?php echo stripslashes($postfooter)?></textarea></td>
</tr>
<tr><td colspan="2" bgcolor="000000" height="1"></tr>
<tr>
<td bgcolor="c0c0c0" align="right" valign="top">Post Form</td>
<td bgcolor="ffffff"><font size="1"><b>Dont</b> mess about with the form please, ie field names etc other wise the script will not work.</font><br><textarea name="formbit" cols="55" rows="4"><?php echo stripslashes($formbit)?></textarea></td>
</tr>
<tr><td colspan="2" bgcolor="000000" height="1"></tr>
<tr>
<td bgcolor="c0c0c0" align="right" valign="top"> Form Footer</td>
<td bgcolor="ffffff"><textarea name="footer" cols="55" rows="4"><?php echo stripslashes($footer)?></textarea></td>
</tr>
<tr>
<td bgcolor="666666" align="center" colspan="2">
 <input type="submit" name="submit" value="Submit">
</td>
</tr>
</table>
</td>
</form>
</tr>
</table>
		 <?php
			}
		} elseif ($action=="deletebadword"){
		 echo "<b>Delete word replacement</b><hr>";
		 $line = file("badwords.txt");
		 $_GET[id] = str_replace("<sq>","'",$_GET[id]);
			for($i=0;$i<count($line);$i++){
			 list($curse,$replacement,) = explode("|^|",$line[$i]);
				if($replacement!=$_GET[id]){
				 $data .= "$curse|^|$replacement|^|\n";
				} else {
				 echo "Word replacement deleted";
				}
			}
			if(!$ofile = fopen("badwords.txt","w")){
				 echo "Cannot write to replacements file, attempting to chmod...";
					if(!@chmod("badwords.txt",0666)){
					 echo "<br>Cannot chmod, please do it manually through ftp";
					} else {
					 echo "<br>Chmod successful!!!";
					}
			}
			if($ofile = fopen("badwords.txt","w")){
			 flock($ofile,2);
			 fputs($ofile,$data);
			 fclose($ofile);
			} else {
			 echo "Could not write to <b>badwords.txt</b>, please make sure it is chmodded correctly <b>(666)</b>.";
			}
		 $displaymenu = TRUE;
		} elseif ($action=="getcode"){
		 echo "<b>Get Iframe code</b><hr>";
			 $lastslash = strrpos($_SERVER[PHP_SELF],"/");
			 $folders = substr($_SERVER[PHP_SELF], 0,$lastslash);
?>
<script language="javascript">
	function generateIframeCode(){
	 var width = document.forms[0].elements[0].value;
	 var height = document.forms[0].elements[1].value;
	 document.forms[0].elements[3].value = '<!-- Tags Markup --><iframe src="http://<?php echo $_SERVER[HTTP_HOST].$folders;?>/tags.php" name="tags" width="'+width+'" height="'+height+'" frameborder="0"></iframe><!-- End Tags Markup -->';
	}
</script>
<b>IFrame script generator</b><hr>Click generate to get the code<form>Iframe width: <input type="test" name="width" value="150"><br>Iframe height: <input type="text" name="height" value="350"> <input type="button" onClick="generateIframeCode()" value="Generate"><br>
<b>copy and paste the below to your website:</b><br>
<textarea cols="55" rows="6"></textarea></form>
<?php
		 $displaymenu = TRUE;
		} elseif ($action=="badwords"){
		 echo "<b>Word replacements</b><hr>";
			if($_POST[submit]){
$in=array('^', '$', '{', '}', '(', ')', '[', ']', '+', '\\', '*');
$out=array('\\^', '\\$', '\\{', '\\}', '\\(', '\\)', '\\[', '\\]', '\\+', '\\\\', '\\*');
					for($i=0;$i<count($in);$i++){
					 $curse = str_replace("$in[$i]","$out[$i]",$curse);
					}
				if(!$ofile = @fopen("badwords.txt","a")){
				 echo "Cannot write to replacements file, attempting to chmod...";
					if(!@chmod("badwords.txt",0666)){
					 echo "<br>Cannot chmod, please do it manually through ftp";
					} else {
					 echo "<br>Chmod successful!!!";
					}
				}
				if($ofile = @fopen("badwords.txt","a")){
				 $_POST[curse] = str_replace("(","\\(",$_POST[curse]);
				 $_POST[curse] = str_replace("{","\\{",$_POST[curse]);
				 $_POST[curse] = addslashes($_POST[curse]);
				 $data = "$_POST[curse]|^|$_POST[replacement]|^|\n";
				 flock ($ofile,2);
				 fputs ($ofile,$data);
				 fclose ($ofile);
				 echo "Word Replacement added!";
				} else {
				 echo "Could not write to <b>badwords.txt</b>, Please make sure it is chmodded correctly <b>(666)</b>.";
				}
			} else {
			 $line = file("badwords.txt");
				for($i=0;$i<count($line);$i++){
				 $split = explode("|^|",$line[$i]);
					if(!$split[0]){
					 continue;
					}
				 $split[1] = stripslashes($split[1]);
				 $split[0] = stripslashes($split[0]);
				 $id = str_replace("'","<sq>",$split[1]);
				 echo "<b>$split[0]</b> is replaced with <b>$split[1]</b> <a href='$_POST[PHP_SELF]?action=deletebadword&id=$id'>[delete]</a><br>";
				}
			 echo "<form action=\"$_POST[PHP_SELF]?action=badwords\" method=\"post\"><b>Add word</b><br><input type=\"text\" name=\"curse\"> is replaced with <input type=\"text\" name=\"replacement\"> <input type=\"submit\" name=\"submit\" value=\"Add Word\"></form>";
			}			
		 $displaymenu = TRUE;
		} elseif ($action=="cleartags") {
		 echo "<b>Delete all posts</b><hr>";
			if($_GET[confirm]=="yes"){
				if(!$ofile = @fopen($data_file,"w")){
				 echo "Cannot write to post file, attempting to chmod...";
					if(!@chmod("$data_file",0666)){
					 echo "<br>Cannot chmod, please do it manually through ftp";
					} else {
					 echo "<br>Chmod successful!!!";
					}
				}
				if($ofile = @fopen($data_file,"w")){
				 flock($ofile,2);
				 fwrite($ofile,"");
				 fclose($ofile);
				 echo "Messages deleted!";
				} else {
				 echo "Could not write to <b>$data_file</b>, please make sure it is chmodded correctly <b>(666)</b>.";
				}
			} else {
			 echo "Are you sure you want to delete all the messages on the board? <a href=\"$_SERVER[PHP_SELF]?action=cleartags&confirm=yes\">Click here to confirm</a>";
			}
		 $displaymenu = TRUE;
		} elseif ($action=="delete") {
		 echo "<b>Delete post</b><hr>";
		 $line = file($data_file);
			for($i=0;$i<count($line);$i++){
			 list($date,$name,$website,$post,$newid,$userip,) = explode("|^|",$line[$i]);
				if($_GET[id]){
					if($date!=$_GET[id]){
					 $data .= "$date|^|$name|^|$website|^|$post|^|$newid|^|$userip|^|\n";
					} else {
					 echo "Post deleleted";
					}
				} elseif ($_GET[group]) {
					if($newid!=$_GET[group]){
					 $data .= "$date|^|$name|^|$website|^|$post|^|$newid|^|$userip|^|\n";
					} else {
					 $found=TRUE;
					}
				}
			}
			if(!$found){
			 echo "No Posts could be found with that group id";
			} else {
			 echo "Post(s) deleted!";
			}
			if(!$ofile = @fopen($data_file,"w")){
			 echo "Cannot write to post file, attempting to chmod...";
				if(!@chmod("$data_file",0666)){
				 echo "<br>Cannot chmod, please do it manually through ftp";
				} else {
				 echo "<br>Chmod successful!!!";
				}
			}
			if($ofile = fopen($data_file,"w")){
			 flock($ofile,2);
			 fputs($ofile,$data);
			 fclose($ofile);
			} else {
			 echo "Could not write to <b>$data_file</b>, please make sure it is chmodded correctly <b>(666)</b>.";
			}
		 $displaymenu = TRUE;
		} elseif ($action=="banip") {
			if(!$ifile = @fopen("bannedips.php","a")){
			 echo "Cannot write to banned ip file, attempting to chmod...";
				if(!@chmod("bannedips.php",0666)){
				 echo "<br>Cannot chmod, please do it manually through ftp";
				} else {
				 echo "<br>Chmod successful!!!";
				}
			}
			if($ifile = @fopen("bannedips.php","a")){
			 flock($ifile,2);
			 fputs($ifile,"$ip\n");
			 fclose($ifile);
			 echo "Ip Banned!!!";
			} else {
			 echo "Could not write to <b>bannedips.php</b>, please make sure it is chmodded correctly <b>(666)</b>.";
			}
		 $displaymenu = TRUE;		 
		}
		if(!$action || $displaymenu){
		 echo "<hr><big><b>Menu:</b></big><br>
<li> <a href=\"$_SERVER[PHP_SELF]?action=templates\">Edit Templates/Settings</a>
<li> <a href=\"tags.php?delete\">Delete a Message</a>
<li> <a href=\"tags.php?banip\">Ban an IP</a>
<li> <a href=\"$_SERVER[PHP_SELF]?action=badwords\">Edit Word Replacements</a>
<li> <a href=\"$_SERVER[PHP_SELF]?action=getcode\">Generate Iframe Code</a>
<li> <a href=\"$_SERVER[PHP_SELF]?action=cleartags\">Delete all messages</a><br>";
		}
	}
echo stripslashes("<br>".$footer);
?>