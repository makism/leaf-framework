<?php
/**
 * leaf framework
 *
 * <i>PHP version 5</i>
 * 
 * leaf is a Greek open source MVC framework in PHP.
 * Simple, fast, with a small footprint, easily extensible
 * using PHP5`s new Object Oriented capabilities and well documented.
 *
 *
 * @package		leaf
 * @subpackage  front
 * @author		Avraam Marimpis <makism@venus.cs.teicrete.gr>
 * @link        http://leaf-framework.sourceforge.net
 * @copyright	Copyright &copy; 2007 Avraam Marimpis
 * @license     http://leaf-framework.sourceforge.net/licence/  New BSD License
 * @version		$Id$
 * @filesource
 * @todo
 * <ol>
 *   <li>Document.</li>
 *   <li>Recheck the information displayed under the tab "Config Settings".</li>
 * </ol>
 */


if (LEAF_REL_STATUS=='DEV') {
    dependsOn('xdebug');
    dependsOnFunc('memory_get_usage');

    $parseTime      = xdebug_time_index();
    $memoryUsage    = memory_get_usage();
    $memoryUsageKbs = sprintf("%1.2fkbs", $memoryUsage/1024);
	$baseUrl		= $reg->config['base_url'];
 
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

if ($reg->config['allow_hooks']=="Yes") {
    echo
        "<li><a href=\"#leaf_Debug_Hooks\"><em>Hooks</em></a></li>";
}

if ($reg->config['log_level']!="None") {
    echo
        "<li><a href=\"#leaf_Debug_Log_Buffer\"><em>Log Buffer</em></a></li>";
}
		 
if ($reg->config['allow_endorsed']=="Yes") {
	echo
		 "<li><a href=\"#leaf_Debug_Endorsed\"><em>Endorsed Classes</em></a></li>";
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
            . "  <span style=\"color: #4e9a06;\"><b>leaf Version</b></span>\n"
            . "  <span style=\"color: #ff0000;\">  " . LEAF_REL_VERSION . " " . LEAF_REL_STATUS . "\n"
            . "  <span style=\"color: #4e9a06;\"><b>Script memory usage</b></span>\n"
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

        echo
            "<fieldset style=\"border: 0px solid #ffffff;\"><legend><small><b>General</b></small></legend>";
        foreach($reg->config->getByHashKey("general") as $Var => $Val) {
            echo
                "<span style=\"color: #4e9a06;\"><b>{$Var}</b></span>\n    "
              . "<span style=\"color: #ff0000;\"><small>{$Val}</small></span>\n";
        }
        echo "</fieldset>";

        echo "<br/>";

        echo
            "<fieldset style=\"border: 0px solid #ffffff;\"><legend><small><b>Autoload</b></small></legend>";
        foreach($reg->config->getByHashKey("autoload") as $Var => $Val) {
            echo
                "<span style=\"color: #4e9a06;\"><b>{$Var}</b></span>\n    "
              . "<span style=\"color: #ff0000;\"><small>{$Val}</small></span>\n";
        }
        echo "</fieldset>";

        echo
            "<fieldset style=\"border: 0px solid #ffffff;\"><legend><small><b>Endorsed</b></small></legend>";
        echo "</fieldset>";

        echo "<br/>";

        echo
            "<fieldset style=\"border: 0px solid #ffffff;\"><legend><small><b>Hooks</b></small></legend>";
        echo "</fieldset>";

        echo
            " </pre>"
            . "</div>";

        //
        // Registry
        //
        echo
            "<div id=\"leaf_Degug_Registry\" style=\"display: none;\">"
            . " <pre style=\"font-size: 12px; font-family: Verdana, Arial, helvetica, sans-serif;\">";
            
            foreach($reg->toArray() as $InstanceName => $ClassType)
                echo
                    " key: <span style=\"color: #4e9a06\"><b>{$InstanceName}</b></span>\n"
                  . "type: <span style=\"color: #ff0000\"><i>{$ClassType}</i></span>\n\n";
            
        echo
            " </pre>"
            . "</div>";
            
		//
        // Request
		//
        $className  = $reg->router->getClassName();
        $methodName = $reg->router->getMethodName();
        $segments   = implode(" ", (array)$reg->router->segments());
        $queryString= $reg->request->getQueryStringAsString();
        
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
        if ($reg->config['allow_hooks']=="Yes") {
            echo
                "<div id=\"leaf_Debug_Hooks\" style=\"display: none;\">"
                . "</div>";
        }
            

        //
        // Log Buffer
        //
        if ($reg->config['log_level']!="None") {
            echo
                "<div id=\"leaf_Debug_Log_Buffer\" style=\"display: none;\">"
                . "</div>";
        }

		//
        // Endorsed
		//
		if ($reg->config['allow_endorsed']=="Yes") {
			echo
				"<div id=\"leaf_Debug_Endorsed\" style=\"display: block;\">"
				. " <pre style=\"font-size: 14px; font-family: Verdana, Arial, helvetica, sans-serif;\">";
				
				foreach($reg->endorse_man->getEndorsedClasses() as $Key => $Value)
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
    
/*
 * End Main Div
 */
    echo
        "</div>" .
        "</div>";
}

?>
