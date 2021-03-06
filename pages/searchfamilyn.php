<?php

require_once("../Personal/config.php");
require_once("../Lib/autoload.php");
require_once 'function.menuSmarty.php';        //plugin per menù Smarty
include ("orizontalmenu.php");         //contiene la funzione che genera il menù

$session = new session();

if (!accesslimited::isInAutorizedGroups(user::getUserName($session->getUserId()), array("admins", "users"))) {
    header("Location:index?logout=1");
    exit(0);
}


$title = PAGETITLE . " - Ricerca schede";
$shortcuticon = SHORTCUTICON;


//configurazioni per l' inclusione dei link nella pagina
$arr_style_config = array();
$arr_js_config = array();

$arr_style_config[] = UI_STYLE;
$arr_style_config[] = "../styles/page/page.css";
//$arr_style_config[] = "../styles/page/TableTools_JUI.css";
$arr_style_config[] = "../styles/orizontalmenu/orizontalmenu.css";
$arr_style_config[] = "../styles/searchfamily/searchfamilyn.css";

$arr_js_config[] = JQUERY;
$arr_js_config[] = JQUERY_UI;
$arr_js_config[] = JQPLUGINS . "/datatable/jquery.dataTables.min.js";
$arr_js_config[] = JQPLUGINS . "/datatable/ZeroClipboard.js";
//$arr_js_config[] = JQPLUGINS . "/datatable/TableTools.js";
$arr_js_config[] = JQPLUGINS . "/datatable/jqDataTableSingleRowSelect.js";
$arr_js_config[] = "js/fastsearch.js";
$arr_js_config[] = "js/searchfamilyn.js";


$menu = getOrrMenu();

$objSmarty = new Smarty();

$objSmarty->assign("title", $title);
$objSmarty->assign("shortcuticon", $shortcuticon);
$objSmarty->assign('arr_style_config', $arr_style_config);
$objSmarty->assign('arr_js_config', $arr_js_config);
$objSmarty->assign('menu', $menu);

$objSmarty->display('tpl/searchfamilyn.tpl');


?>