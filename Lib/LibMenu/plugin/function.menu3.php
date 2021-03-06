<?php

//Menù tipo Accordion di Pat con bug html superati i 2 livelli
//------------------------------------------------------------------------------
//  SmartyMenu version 1.1                       
//  http://www.phpinsider.com/php/code/SmartyMenu/                           
//                                                                               
//  SmartyMenu is an implementation of the Suckerfish Dropdowns
//  by Patrick Griffiths and Dan Webb.
//  http://htmldog.com/articles/suckerfish/dropdowns/
//
//  Copyright(c) 2004-2005 New Digital Group, Inc.. All rights reserved.                                 
//                                                                               
//  This library is free software; you can redistribute it and/or modify it      
//  under the terms of the GNU Lesser General Public License as published by     
//  the Free Software Foundation; either version 2.1 of the License, or (at      
//  your option) any later version.                                              
//                                                                               
//  This library is distributed in the hope that it will be useful, but WITHOUT  
//  ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or        
//  FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public         
//  License for more details.                                                    
//------------------------------------------------------------------------------
// number of chars to indent unordered list level
define('SMARTYMENU_INDENT', 3);

$output = "";

function smarty_function_menu_render_element($element, $in_list = 0) {

    if (!isset($element['text']))
        return;

    global $_output;

    $link = isset($element['link']) ? htmlspecialchars($element['link']) : "#nogo";

    $append_class = isset($element['class']) ? " " . htmlspecialchars($element['class']) : "";

    $has_submenu = false;
    if (isset($element['submenu']))
        $has_submenu = true;

    if ($has_submenu) { //voce menù principale con sottomenù
        $newclass=($append_class=="") ? " class=\"menuitem submenuheader\"" : " class=\"menuitem submenuheader " . $append_class . "\"";
       if(!$in_list) $_output .= str_repeat(' ', 6 * SMARTYMENU_INDENT) . "<a ".$newclass." href=\"" . $link . "\">" . htmlspecialchars($element['text']) . "</a>\n";
       else $_output .= str_repeat(' ', 6 * SMARTYMENU_INDENT) . "<li><a ".$newclass." href=\"" . $link . "\">" . htmlspecialchars($element['text']) . "</a>\n";
        $_output .= str_repeat(' ', 6 * SMARTYMENU_INDENT) . "<div class = \"submenu\">\n";
        $_output .= str_repeat(' ', 7 * SMARTYMENU_INDENT) . "<ul>\n";

        foreach ($element['submenu'] as $_submenu) {

            $_submenu['link'] = ($_submenu['link'] == "") ? "#" : $_submenu['link'];

            if (!isset($_submenu['submenu'])) {
                $class_sub_item = isset($_submenu['class']) ? "class=\"menuitem " . $_submenu['class'] . "\"" : "class=\"menuitem\"";
                $_output .= str_repeat(' ', 8 * SMARTYMENU_INDENT) . "<li><a " . $class_sub_item . " href = \"" . $_submenu['link'] . "\">" . htmlspecialchars($_submenu['text']) . "</a></li>\n";
            } else {
                // $class_sub_item = isset($_submenu['class']) ? "class=\"menuitem submenuitem " . $_submenu['class'] . "\"" : "class=\"menuitem submenuitem\"";
                // $_output .= str_repeat(' ', 8 * SMARTYMENU_INDENT) . "<li><a " . $class_sub_item . " href = \"" . $_submenu['link'] . "\">" . htmlspecialchars($_submenu['text']) . "</a></li>\n";
                smarty_function_menu_render_element($_submenu, 1);
            }
        }

        $_output .= str_repeat(' ', 7 * SMARTYMENU_INDENT) . "</ul>\n";
        $_output .= str_repeat(' ', 6 * SMARTYMENU_INDENT) . "</div>\n";
        if($in_list) $_output .= str_repeat(' ', 6 * SMARTYMENU_INDENT) . "</li>\n";
        smarty_function_menu_render_element($element['submenu'], true);
    } else { //voce di menù principale senza sottomenù
        if (!$in_list)
            $_output .= str_repeat(' ', 6 * SMARTYMENU_INDENT) . "<a class=\"menuitem" . $append_class . "\" href=\"" . $link . "\">" . htmlspecialchars($element['text']) . "</a>\n";
        else
            $_output .= str_repeat(' ', 6 * SMARTYMENU_INDENT) . "<li><a class=\"menuitem" . $append_class . "\" href=\"" . $link . "\">" . htmlspecialchars($element['text']) . "</a></li>\n";
    }



    /*
      if(!$is_submenu_item){
      $_output .= str_repeat(' ', 6 * SMARTYMENU_INDENT) . "<a class=\"menuitem".$append_class."\" href=\"" . $link . "\">" . htmlspecialchars($element['text']) . "</a>\n";
      if(isset($element['submenu'])){
      smarty_function_menu_render_element($element['submenu'], true);
      }
      }else{   //inserisco come voce con sottomenù e creo il sottomenù
      $_output .= str_repeat(' ', 6*SMARTYMENU_INDENT) ."<a class=\"menuitem submenuheader".$append_class."\" href=\"" . $link . "\">" . htmlspecialchars($element['text']) . "</a>\n";
      $_output .= str_repeat(' ', 6*SMARTYMENU_INDENT) ."<div class = \"submenu\">\n";
      $_output .= str_repeat(' ', 7*SMARTYMENU_INDENT) . "<ul>\n";


      }
     */
    /*
      if (isset($element['submenu'])) {

      $_output .= str_repeat(' ', 6*SMARTYMENU_INDENT) ."<a class=\"menuitem submenuheader".$append_class."\" href=\"" . $link . "\">" . htmlspecialchars($element['text']) . "</a>\n";

      $_output .= str_repeat(' ', 6*SMARTYMENU_INDENT) ."<div class = \"submenu\">\n";

      $_output .= str_repeat(' ', 7*SMARTYMENU_INDENT) . "<ul>\n";



      foreach ($element['submenu'] as $_submenu) {
      $_output .= smarty_function_menu_render_element($_submenu, true);
      }

      $_output .= str_repeat(' ', 7*SMARTYMENU_INDENT) . "</ul>\n";
      $_output .= str_repeat(' ', 6*SMARTYMENU_INDENT) . "</div>\n";
      } else {
      if ($is_submenu_item) {
      $class_sub_item = trim($append_class);
      if ($class_sub_item != "")
      $class_sub_item = "class=\"" . $class_sub_item . "\" ";
      $_output .= str_repeat(' ', 8 * SMARTYMENU_INDENT) . "<li><a ".$class_sub_item."href = \"" . $link . "\">" . htmlspecialchars($element['text']) . "</a></li>\n";
      }else
      $_output .= str_repeat(' ', 6 * SMARTYMENU_INDENT) . "<a class=\"menuitem".$append_class."\" href=\"" . $link . "\">" . htmlspecialchars($element['text']) . "</a>\n";
      }

     */
    return;
}

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     function
 * Name:     menu
 * Purpose:  generate menu
 * -------------------------------------------------------------
 */

function smarty_function_menu($params, &$smarty) {
    global $_output;
    if (empty($params['data'])) {
        return false;              // E' il caso in cui passo un array vuoto. Succede se il menù non ha elementi.
    }

    $_id = isset($params['id']) ? " id=\"" . $params['id'] . "\"" : '';

    $_class = "";
    if (isset($params['class']))
        $_class = " class=\"" . $params['class'] . "\" ";

    $_output .= "<div id=\"ext_menu_div\">\n";
    $_output .= str_repeat(' ', 4 * SMARTYMENU_INDENT) . "<div id=\"ext_menu_div_gradient1\"></div>\n";
    $_output .= str_repeat(' ', 4 * SMARTYMENU_INDENT) . "<div id=\"ext_menu_div_gradient2\"></div>\n";

    $_output .= str_repeat(' ', 4 * SMARTYMENU_INDENT) . "<div id=\"s_up\"></div>\n";



    $_output .= str_repeat(' ', 4 * SMARTYMENU_INDENT) . "<div id=\"menu_container\">\n";

    //$_output .= str_repeat(' ', 4*SMARTYMENU_INDENT)."<div id=\"menu_container_gradient\"></div>\n";

    $_output .= str_repeat(' ', 5 * SMARTYMENU_INDENT) . "<div" . $_id . $_class . ">\n";


    foreach ($params['data'] as $_element) {
        smarty_function_menu_render_element($_element);
    }



    $_output .= str_repeat(' ', 5 * SMARTYMENU_INDENT) . "</div><!--close <div" . $_id . $_class . ">-->\n";



    $_output .= str_repeat(' ', 4 * SMARTYMENU_INDENT) . "</div><!--close <div id=\"menu_container\">-->\n";



    // $_output .= "<div id=\"bottom_fade\"></div>\n";

    $_output .= str_repeat(' ', 4 * SMARTYMENU_INDENT) . "<div id=\"s_down\"></div>\n";

    $_output .= str_repeat(' ', 3 * SMARTYMENU_INDENT) . "</div>\n";




    return $_output;
}

/* vim: set expandtab: */
?>
