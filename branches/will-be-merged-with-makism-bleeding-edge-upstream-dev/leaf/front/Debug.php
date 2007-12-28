<?php
/**
 * This source file is part of the leaf framework and
 * is licensed under the New BSD license.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     http://leaf-framework.sourceforge.net/LICENSE/  New BSD License
 * @link        http://leaf-framework.sourceforge.net
 *
 * @package     leaf
 * @subpackage  front
 * @author      Avraam Marimpis <makism@users.sf.net>
 * @version		$Id$
 * @filesource
 */


/*
 * The statistics will be produced only if leaf`s version
 * is tagged as "dev".
 * This is most surely that will change.
 */
dependsOn('xdebug');
dependsOnFunc('memory_get_usage');

leaf_Registry::getInstance()->Load->plugin("misc");

$parseTime      = sprintf("%1.2f", xdebug_time_index());
$memoryUsage    = memory_get_usage();
$memoryUsageKbs = sprintf("%1.2fkbs", $memoryUsage/1024);
$baseUrl		= $reg->Config['base_url'];

echo "<br /><br /><br /><br /><br />";

echo <<<DEBUG_STYLES
<link rel="stylesheet" type="text/css" href="{$baseUrl}yui/tabview.css">
<link rel="stylesheet" type="text/css" href="{$baseUrl}yui/border_tabs.css">
<script type="text/javascript" src="{$baseUrl}yui/yahoo.js"></script>
<script type="text/javascript" src="{$baseUrl}yui/event.js"></script>
<script type="text/javascript" src="{$baseUrl}yui/dom.js"></script>
<script type="text/javascript" src="{$baseUrl}yui/element-beta.js"></script>
<script type="text/javascript" src="{$baseUrl}yui/tabview.js"></script>
<style type="text/css">
#leaf_debugDiv .yui-content { padding:1em; }
.yui-nav li a:visited { color: #0000FF; }
</style>
<script type="text/javascript">
YAHOO.example.init = function() {
var leafDebug = new YAHOO.widget.TabView('leaf_debugDiv');
};
YAHOO.example.init();
</script>
DEBUG_STYLES;

/*
 * Start Main Div
 */
echo
	"<div style=\"width: 600px;\">" .
	"<div id=\"leaf_debugDiv\" class=\"yui-navset yui-navset-left\">" .
	"<ul class=\"yui-nav\">";

// tabs
echo
	 "<li title=\"active\" class=\"selected\"><a href=\"#leaf_Debug_leaf_Statistics\"><em>leaf Statistics</em></a></li>" .
	 "<li><a href=\"#leaf_Debug_Global_Settings\"><em>Global Settings</em></a></li>" .
	 "<li><a href=\"#leaf_Degug_Registry\"><em>Registry</em></a></li>" . 
	 "<li><a href=\"#leaf_Debug_Request\"><em>Request Information</em></a></li>";

if ($reg->Config['allow_hooks']) {
	echo
	"<li><a href=\"#leaf_Debug_Hooks\"><em>Hooks</em></a></li>";
}

	echo
	"<li><a href=\"#leaf_Debug_Log_Buffer\"><em>Log Buffer</em></a></li>";

	 
if ($reg->Config['allow_endorsed']) {
	echo
	 "<li><a href=\"#leaf_Debug_Endorsed\"><em>Endorsed Classes</em></a></li>";
}

if ($reg->Load->libraryLoaded("Db")) {
	echo
	 "<li><a href=\"#leaf_Debug_Database\"><em>Database</em></a></li>";
}

// tabs (end)
echo "</ul>";


/*
 * Data
 */
echo
	"<div class=\"yui-content\">";
	
	//
	// Status
	//
	echo
		"<div id=\"leaf_Debug_leaf_Statistics\" style=\"display: block;\">"
		. " <pre style=\"font-size: 12px; font-family: Verdana, Arial, helvetica, sans-serif;\">"
		. "  <span style=\"color: #4e9a06;\"><b>leaf framework Release</b></span>\n"
		. "  <span style=\"color: #ff0000;\">  " . LEAF_REL_VERSION . " " . LEAF_REL_STATUS . "\n"
		. "  <span style=\"color: #4e9a06;\"><b>Framework memory usage</b></span>\n"
		. "  <span style=\"color: #ff0000;\">  {$memoryUsageKbs} <small><i>({$memoryUsage} bytes)</i></small></span>\n"
		. "  <span style=\"color: #4e9a06;\"><b>Total parsing time</b></span>\n"
		. "  <span style=\"color: #ff0000;\">  {$parseTime} seconds</span>"
		. " </pre>"
		. "</div>";
	
	//
	// Settings
	//
	echo
		"<div id=\"leaf_Debug_Global_Settings\" style=\"display: none;\">"
		. " <pre style=\"font-size: 12px; font-family: Verdana, Arial, helvetica, sans-serif;\">";
	
	// general
	echo
		"<fieldset style=\"border: 0px solid #ffffff;\"><legend><small><b>General</b></small></legend>";
	foreach($reg->Config->getByHashKey("general") as $Var => $Val) {
		echo
			"<span style=\"color: #4e9a06;\"><b>{$Var}</b></span>\n    "
		  . "<span style=\"color: #ff0000;\"><small>" . boolean2text($Val) . "</small></span>\n";
	}
	echo "</fieldset><br/>";
	
	// autoload
	echo
		"<fieldset style=\"border: 0px solid #ffffff;\"><legend><small><b>Autoload</b></small></legend>";
	foreach($reg->Config->getByHashKey("autoload") as $Var => $Val) {
		echo
			"<span style=\"color: #4e9a06;\"><b>{$Var}</b></span>\n    "
		  . "<span style=\"color: #ff0000;\"><small>{$Val}</small></span>\n";
	}
	echo "</fieldset>";
	
	// endorsed
	echo
		"<fieldset style=\"border: 0px solid #ffffff;\"><legend><small><b>Endorsed</b></small></legend>";
	foreach($reg->Config->getByHashKey("endorsed") as $Var => $Val) {
		echo
		  "<span style=\"color: #ff0000;\"><small>{$Val}</small></span><br />\n";
	}
	echo
	"</fieldset>"
	. "<br/>";
	
	// hooks
	 echo
		"<fieldset style=\"border: 0px solid #ffffff;\"><legend><small><b>Hooks</b></small></legend>"
		. "</fieldset>"
		. "<br/>";
		
	// db settings
	 echo
		"<fieldset style=\"border: 0px solid #ffffff;\"><legend><small><b>Database Settings</b></small></legend>"
		. "</fieldset>"
		. "<br/>";
		
	echo
		"</pre>"
		. "</div>";
	
	//
	// Registry
	//
	echo
		"<div id=\"leaf_Degug_Registry\" style=\"display: none;\">"
		. " <pre style=\"font-size: 12px; font-family: Verdana, Arial, helvetica, sans-serif;\">";
		
		foreach($reg->toArray() as $InstanceName => $ClassType)
			echo
				"<small> key: </small><span style=\"color: #4e9a06\"><b><u>{$InstanceName}</u></b></span>\n"
			  . "<small>type: </small><span style=\"color: #ff0000\"><i>{$ClassType}</i></span>\n\n";
		
	echo
		" </pre>"
		. "</div>";
   
	//
	// Request
	//
	$className  = $reg->Router->getClassName();
	$methodName = $reg->Router->getMethodName();
	$segments   = implode(" ", (array)$reg->Router->segments());
	$queryString= $reg->Request->getFormattedQueryString();
	
	echo
		"<div id=\"leaf_Debug_Request\" style=\"display: none;\">"
		. " <pre style=\"font-size: 12px; font-family: Verdana, Arial, helvetica, sans-serif;\">"
		. "  <span style=\"color: #4e9a06;\"><b>Controller (Class)</b></span>\n"
		. "  <span style=\"color: #ff0000;\">  {$className}</span>\n"
		. "  <span style=\"color: #4e9a06;\"><b>Action (Method)</b></span>\n"
		. "  <span style=\"color: #ff0000;\">  {$methodName}</span>\n"
		. "  <span style=\"color: #4e9a06;\"><b>Extra segments</b></span>\n"
		. "  <span style=\"color: #ff0000;\">  {$segments}</span>\n"
		. "  <span style=\"color: #4e9a06;\"><b>Query String</b></span>\n"
		. "  <span style=\"color: #ff0000;\">  {$queryString}</span>"
		. " </pre>"
		. "</div>";

	//
	// Hooks
	//
	if ($reg->Config['allow_hooks']) {
		$hooks = $reg->Config->getByHashKey("hooks");
		echo
			"<div id=\"leaf_Debug_Hooks\" style=\"display: none;\">"
			."<pre style=\"font-size: 12px; font-family: Verdana, Arial, helvetica, sans-serif;\">"
			."<fieldset style=\"border: 0px solid #ffffff;\"><legend><small><b>Pre-Controller Dispatch</b></small></legend>";
			
		foreach($hooks['pre_controller_dispatch'] as $Var) {
			echo
				"<span style=\"color: #4e9a06;\"><b>{$Var}</b></span>\n";					
		}
		
		echo
			"</fieldset><br/>"
			."<fieldset style=\"border: 0px solid #ffffff;\"><legend><small><b>Post-Controller Dispatch</b></small></legend>";
			
		foreach($hooks['post_controller_dispatch'] as $Var) {
			echo
				"<span style=\"color: #4e9a06;\"><b>{$Var}</b></span>\n";					
		}
		
		echo
			"</fieldset><br/>"
			."<fieldset style=\"border: 0px solid #ffffff;\"><legend><small><b>Post-Front Contoller Dispatch</b></small></legend>";
			
		foreach($hooks['post_front_controller'] as $Var) {
			echo
				"<span style=\"color: #4e9a06;\"><b>{$Var}</b></span>\n";					
		}
		echo
			"</fieldset><br/>"
			."</pre>"
			."</div>";
	}
 

	//
	// Log Buffer
	//
	echo
		"<div id=\"leaf_Debug_Log_Buffer\" style=\"display: none;\">"
		. " <pre style=\"font-size: 14px; font-family: Verdana, Arial, helvetica, sans-serif;\">"
		. "<fieldset style=\"border: 0px solid #ffffff;\"><legend><small><b>Log buffer</b></small></legend>";
		
		if ($reg->Log->getBackend()->supportsBuffering())
			echo leaf_Registry::getInstance()->Log->getBuffer();
		else
			echo "<i>Current backend, does not support buffering.</i>";
		
	echo
		"</fieldset>"
		. "</pre>"
		. "</div>";

	//
	// Endorsed
	//
	if ($reg->Config['allow_endorsed']) {
		echo
			"<div id=\"leaf_Debug_Endorsed\" style=\"display: block;\">"
			. " <pre style=\"font-size: 14px; font-family: Verdana, Arial, helvetica, sans-serif;\">";
			
			foreach($reg->EndorsementMan->getEndorsedClasses() as $Key => $Value)
			{
				$endorsedClass  = key($Value);
				$classObject    = $Value[$endorsedClass]['reg_key'];
				echo
					"<span style=\"color: #4e9a06;\">"
					. "<b>{$endorsedClass}</b>\n    "
					. "<small style=\"color: #b91f49\">{$reg->$classObject}</small>" .
					"</span>\n\n";
			}
			
		echo
			" </pre>"
			. "</div>";
	}
	
	//
	// Database
	//
	if ($reg->Load->libraryLoaded("Db")) {
		echo
			"<div id=\"leaf_Debug_Database\" style=\"display: block;\">"
			. " <pre style=\"font-size: 14px; font-family: Verdana, Arial, helvetica, sans-serif;\">";
			
			
		echo
			" </pre>"
			. "</div>";
	}

/*
* End Main Div
*/
echo
	"</div>" .
	"</div>";

?>
