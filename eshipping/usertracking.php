<?php
session_start();



if ($userlogin)
{
	$userCode = $_SESSION["UserID"];
	$IP = GetUserIPAddress();
	$longIP = ip2long($IP);
	$browserRequest = checkBrowser(true);
	$browser = $browserRequest["browser"];
	$browserversion = $browserRequest["version"];
	$os = getOS();
	$uri = $_SERVER["REQUEST_URI"];
	
	$sql = "INSERT INTO useraccess 
	(userID, 
	IP, 
	IPLong, 
	browser, 
	browserVersion, 
	os, 
	uri
	)
	VALUES
	('$userCode', 
	'$IP', 
	'$longIP', 
	'$browser', 
	'$browserversion', 
	'$os', 
	'$uri'
	);";
	
	$_SESSION["trackingID"] = $db->AutoIncrementExecuteQuery($sql);
}
else
{
	$trackID = $_SESSION["trackingID"];
	$userCode = $_SESSION["UserID"];
		
	$sql = "UPDATE useraccess SET logout = NOW() WHERE accessID = $trackID";
	$db->ExecuteQuery($sql);
}


function GetUserIPAddress()
{
	$ip = "";
	 if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
	if ($_SERVER['HTTP_X_FORWARD_FOR']) 
	{
		$ip = $_SERVER['HTTP_X_FORWARD_FOR'];
	} 
	else 
	{
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}



function getOS()
{
	$uosc = "";
	$curos=strtolower($_SERVER['HTTP_USER_AGENT']);
if (strstr($curos,"iphone")) {
$uos="iPhone";
}else if (strstr($curos,"blackberry")) {
$uos="BlackBerry";
} else if (strstr($curos,"mac")) {
$uos="MacOS";
}else if (strstr($curos,"linux")) {
$uos="Linux";
} else if (strstr($curos,"win")) {
$uos="Windows";
} else if (strstr($curos,"bsd")) {
$uos="BSD";
} else if (strstr($curos,"qnx")) {
$uos="QNX";
} else if (strstr($curos,"sun")) {
$uos="SunOS";
} else if (strstr($curos,"solaris")) {
$uos="Solaris";
} else if (strstr($curos,"irix")) {
$uos="IRIX";
} else if (strstr($curos,"aix")) {
$uos="AIX";
} else if (strstr($curos,"unix")) {
$uos="Unix";
} else if (strstr($curos,"amiga")) {
$uos="Amiga";
} else if (strstr($curos,"os/2")) {
$uos="OS/2";
} else if (strstr($curos,"beos")) {
$uos="BeOS";
} else
{ $uos="Unknown OS";
}
	return $uos;
}

function checkBrowser($input) 
{

$browsers = "mozilla msie gecko firefox ";
$browsers.= "konqueror safari netscape navigator ";
$browsers.= "opera mosaic lynx amaya omniweb BlackBerry ";
//$browsers .= "Abilon Abolimba ABrowse Acoo Browser ActiveXperts Network Monitor Adobe AIR runtime Amaya Amiga Aweb Amiga Voyager Anonymouse.org AOL Explorer Apple-PubSub Arora Avant Browser AvantGo Awasu Axel Banshee Beonex BlackBerry Blackbird Blazer BlogBridge Bloglines Bolt Bookdog Boxxe Bunjalloo Camino Cheshire Chrome CometBird CorePlayer CPG Dragonfly RSS Module Crazy Browser CSE HTML Validator cURL Cynthia Deepnet Explorer Demeter DeskBrowse Dillo DocZilla Dooble Doris DownloadStudio Elinks Enigma browser Epiphany Feed::Find Feedfetcher-Google FeedParser FeedValidator Fennec Firebird  Flock Fluid FlyCast foobar2000 Funambol Mozilla Sync Client Funambol Outlook Sync Client Galeon GetRight GnomeVFS GoldenPod Google App Engine Google Listen Google Wireless Transcoder gPodder GreatNews GreenBrowser Gregarius GSiteCrawler GStreamer HotJava HTMLParser HTTP nagios plugin HTTrack Hv3 Hydra Browser IBrowse iCab ICE browser IceApe IceCat IceWeasel IE Mobile iRider Iron iSiloX Jakarta Commons-HttpClient Jasmine Java JoBo K-Meleon K-Ninja Kapiko Kazehakase KKman Klondike Konqueror LFTP LibSoup libwww-perl Liferea LinkbackPlugin for Laconica LinkChecker LinkExaminer Links Lobo Lotus Notes Lunascape LWP::Simple Lynx Madfox MagpieRSS Maxthon MicroB Microsoft WebDAV client Midori Minimo Miro Motorola Internet Browser Mozilla MPlayer Multipage Validator MultiZilla NCSA Mosaic NetBox NetCaptor NetFront NetFront Mobile Content Viewer NetNewsWire Netscape Navigator NetSurf Newsbeuter NewsBreak NewsFox NewsGatorOnline Nokia Web Browser Obigo Off By One Offline Explorer Omea Reader OmniWeb Openwave Mobile Browser Opera Opera Mini Orca Oregano P3P Validator Palm Pre web browser Paparazzi! Phaseout Phoenix (old name for Firefox) PHP PHP link checker PHP OpenID library PHPcrawl POE-Component-Client-HTTP Polaris Prism PRTG Network Monitor PycURL Python-urllib QtWeb QuickTime rekonq REL Link Checker Lite retawq RSS Menu RSS Radio RSSOwl Safari Sage SeaMonkey SEMC Browser Seznam RSS reader Seznam WAP Proxy Shiira SimplePie SiteSucker Sleipnir Snoopy Songbird Spicebird Stainless Summer Sunrise Swiftfox Tear TeaShark Teleport TheWorld Browser Thunderbird Tulip Chain Typhoeus UC Browser urlgrabber Uzbl VLC media player W3C Checklink W3C CSS Validator W3C Validator w3m WapTiger WDG CSSCheck WDG Page Valet WDG Validator WebCollage WebCopier webfs WebZIP Wget Windows Media Player WinHTTP WinPodder WinWap wKiosk WWW::Mechanize Wyzo X-Smiles Xaldon WebSpider XBMC Xenu xine XML-RPC for PHP YahooFeedSeeker";

$browsers = split(" ", $browsers);

$userAgent = strToLower( $_SERVER['HTTP_USER_AGENT']);

$l = strlen($userAgent);
for ($i=0; $i<count($browsers); $i++){
  $browser = $browsers[$i];
  
  if ($userAgent == "" || $browser == "") continue;
 	$n = stristr($userAgent, $browser);

  if(strlen($n)>0){
    $version = "";
    $navigator = $browser;
    $j=strpos($userAgent, $navigator)+$n+strlen($navigator);
    for (; $j<=$l; $j++){
      $s = substr ($userAgent, $j, 1);
      if(is_numeric($version.$s) )
      $version .= $s;
      else if ($version == "")
      continue;
      else
      break;
    }
  }
}

    if (strpos($userAgent, 'linux')) {
        $platform = 'linux';
    }
    else if (strpos($userAgent, 'macintosh') || strpos($userAgent, 'mac platform x')) {
        $platform = 'mac';
    }
    else if (strpos($userAgent, 'windows') || strpos($userAgent, 'win32')) {
        $platform = 'windows';
    }

if ($input==true) {
        return array(
        "browser"      => $navigator,
        "version"      => $version,
        "platform"     => $platform,
        "userAgent"    => $userAgent);
}else{
        return "$navigator $version";
}

}
?>