<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if( ! function_exists('debug')) {
	function debug(){
		$sapi_name=php_sapi_name();

		$args=func_get_args();
		$style2="word-break:break-all;word-wrap:break-word;";
		$style="margin:5px 0px 5px 0px;color:white;background-color:black;line-height:1.5em;font-size:11px;font-family:Verdana;padding:5px;text-align:left;float:none;clear:both;display:block;position: static;";
		if( preg_match('/msie ([\d\.]+)/i', $_SERVER['HTTP_USER_AGENT']) ) $style2="word-break:break-all;word-wrap:break-word;";
		$_DEBUG_ID='nKDebug';
		/*스타일 적용*/
		if(is_string($args[0])) {
			if(preg_match('/^(style=)(.+)/i', $args[0])){
				$style .=str_replace(array('\'', "\"", "style="), '', array_shift($args) );
			}
			else if(preg_match('/^(id=)(.+)/i', $args[0])) {
				$_DEBUG_ID =str_replace(array('\'', "\"", "style="), '', array_shift($args) );
			}
		}
		if($sapi_name!='cli') echo "\n<!--{{".$_DEBUG_ID."}}-->\n<div style=\"$style\">\n<xmp style='$style2;white-space:pre-wrap;'>";
		print_r(count($args)>1?$args:$args[0]);
		if($sapi_name!='cli')  echo "</xmp></div>\n";
	}
}

?>