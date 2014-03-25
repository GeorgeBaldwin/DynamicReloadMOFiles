<?php 
// Since we are running on a shared server I am unable to clear the cache when I update language files... therefore lets start off by forcing a refresh and renaming the file everytime.
function initialize_i18n($language) {
	$locales_root = "./Locale";
    putenv("LANG=" . $language); 
	putenv("LC_ALL=en_us"); 
	setlocale(LC_ALL, $language);
    $domains = glob($locales_root.'/'.$language.'/LC_MESSAGES/messages-*.mo');	
	$newTimeStamp = time();
    $current = basename($domains[0],'.mo');
    $timestamp = preg_replace('{messages-}i','',$current);
	$oldFileName = $domains[0];
	$newFileName = $locales_root."/".$language."/LC_MESSAGES/messages-".$newTimeStamp.".mo";
	$newFile = "messages-".$newTimeStamp;
	rename($oldFileName, $newFileName);
    bindtextdomain($newFile,$locales_root);
	bind_textdomain_codeset($newFile, 'UTF-8');
    textdomain($newFile);
} 
// get language preference
if (isset($_GET["lang"])) {
    $language = $_GET["lang"];
}
else if (isset($_SESSION["lang"])) {
    $language  = $_SESSION["lang"];
}
else {
    $language = "en_US"; //substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

}

$_SESSION["Language"]  = $language;
 
// save language preference for future page requests
$_SESSION["Language"]  = $language;

switch ($language){
    case "fr":
    case "it":
    case "en":
	case "ru":
		initialize_i18n($language);
	break;
    default:
        //echo "Will show default of english if we do not recognize";
        initialize_i18n("en_US");
        break;
}
?>