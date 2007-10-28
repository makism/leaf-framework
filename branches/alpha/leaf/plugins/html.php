<?php
/**
 * leaf Framework<br>
 *
 * PHP version 5<br>
 *
 *
 * @package		leaf
 * @subpackage	plugins
 * @author		Avraam Marimpis <makism@venus.cs.teicrete.gr>
 * @copyright		-
 * @license		-
 * @filesource
 */


/**
 * extract_links
 *
 *
 * @param	mixed   $source
 * @param   string  $domain
 * @return  mixed
 */
function extract_links($source, $domain=NULL)
{
    dependsOn("dom");
    
    $result = array();
    
    $handler = new DOMDocument();
    $handler->loadHTMLFile($source);
    $allLinks= $handler->getElementsByTagName("a");


    for ($i=0; $i<$allLinks->length; $i++) {
        $curr = $allLinks->item($i);

        if ($curr->hasAttributes())
            if ($curr->getAttribute("href"))
                $result[] = $curr->getAttribute("href");
    }
    

    return (sizeof($result)>0) ? $result : NULL;
}


?>
