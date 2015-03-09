<?php
if ( !defined( "MEDIAWIKI" ) ) {
exit;
}

$wgSitename = "Datum Club";
$wgMetaNamespace = "DatumClub";
$wgScriptPath = "";
$wgScriptExtension = ".php";
$wgDisableCounters = true;

$wgServer = "//datum.club";
$wgCanonicalServer = "http://datum.club";
$wgStylePath = "$wgScriptPath/skins";
$wgLogo = "$wgScriptPath/resources/assets/datumclub-logo-150.png";

$wgEnableEmail = true;
$wgEnableUserEmail = true;
$wgSMTP = array(
        'host' => 'ssl://smtp.zoho.com',
        'IDHost' => 'datum.club',
        'port' => 465,
        'username' => 'admin@datum.club',
        'password' => 'horsesdonkeyswolves',
        'auth' => true
     );

$wgEmergencyContact = "daniel.w.page@gmail.com";
$wgPasswordSender = "admin@datum.club";
$wgEnotifUserTalk = false;
$wgEnotifWatchlist = false;
$wgEmailAuthentication = true;
$wgDBtype = "mysql";
$wgDBserver = "localhost";
$wgDBname = "wiki";
$wgDBuser = "mediawiki";
$wgDBpassword = "XVK0EofMPH";
$wgDBprefix = "";
$wgDBTableOptions = "ENGINE=InnoDB, DEFAULT CHARSET=binary";
$wgDBmysql5 = true;
$wgMainCacheType = CACHE_NONE;
$wgMemCachedServers = array();
$wgEnableUploads = true;
$wgUseInstantCommons = false;
$wgShellLocale = "en_US.utf8";
$wgLanguageCode = "en";
$wgSecretKey = "YTdlOGNkODk5NWVkM2VhZWI4NmY4ZTY5";
$wgUpgradeKey = "YTdlOGNkODk5NWVk";
$wgRightsPage = "";
$wgRightsUrl = "";
$wgRightsText = "";
$wgRightsIcon = "";
$wgDiff3 = "/usr/bin/diff3";
$wgDefaultSkin = "vector";
$wgRestrictDisplayTitle = false;
require_once "$IP/skins/CologneBlue/CologneBlue.php";
require_once "$IP/skins/Modern/Modern.php";
require_once "$IP/skins/MonoBook/MonoBook.php";
require_once "$IP/skins/Vector/Vector.php";


// Extensions

// Base Extension
require_once "$IP/extensions/Mantle/Mantle.php";

// User Merge. Used primarily to delete, but could merge users.
require_once "$IP/extensions/UserMerge/UserMerge.php";
// By default nobody can use this function, enable for bureaucrat?
$wgGroupPermissions['bureaucrat']['usermerge'] = true; 
// optional: default is array( 'sysop' )
$wgUserMergeProtectedGroups = array( 'groupname' );

// Create a Mobile view
require_once "$IP/extensions/MobileFrontend/MobileFrontend.php";
$wgMFAutodetectMobileView = true;

// Google Analytics
require_once "$IP/extensions/googleAnalytics/googleAnalytics.php";
// Replace xxxxxxx-x with YOUR GoogleAnalytics UA number
$wgGoogleAnalyticsAccount = 'UA-59786273-1'; 
// Add HTML code for any additional web analytics (can be used alone or with $wgGoogleAnalyticsAccount)
// $wgGoogleAnalyticsOtherCode = '<script type="text/javascript" src="https://analytics.example.com/tracking.js"></script>';
 
// Optional configuration (for defaults see googleAnalytics.php)
// Array with NUMERIC namespace IDs where web analytics code should NOT be included.
// $wgGoogleAnalyticsIgnoreNsIDs = array(500);
// Array with page names (see magic word Extension:Google Analytics Integration) where web analytics code should NOT be included.
// $wgGoogleAnalyticsIgnorePages = array('ArticleX', 'Foo:Bar');
// Array with special pages where web analytics code should NOT be included.
// $wgGoogleAnalyticsIgnoreSpecials = array( 'Userlogin', 'Userlogout', 'Preferences', 'ChangePassword', 'OATH');
// Use 'noanalytics' permission to exclude specific user groups from web analytics, e.g.
$wgGroupPermissions['sysop']['noanalytics'] = true;
$wgGroupPermissions['bot']['noanalytics'] = true;
// To exclude all logged in users give 'noanalytics' permission to 'user' group, i.e.
// $wgGroupPermissions['user']['noanalytics'] = true;
