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
 * @subpackage  front.helpers
 * @author      Avraam Marimpis <makism@users.sf.net>
 * @version		$Id$
 * @filesource
 * @todo
 * <ol>
 *   <li>Document.</li>
 *   <li>Possible removal.</li>
 * </ol>
 */


/*************************************************************
 * It is suggested to used XDebug`s functions since they are *
 * natively implemented thus much faster.                    *
 *************************************************************/


/**
 *
 *
 * @param   mixed   $var
 * @param   boolean|integer $depth
 * @return  void
 */
function i_var($var, $depth=NULL)
{
    inspect_var($var, $depth);
}

/**
 *
 *
 * @param   mixed   $var
 * @param   boolean|integer $depth
 * @return  void
 */
function inspect_var($var, $depth=NULL)
{
    $varType = gettype($var);

    echo "<div>"
        ."<pre style=\"font-family: Arial, sans; font-size: 14px;\">";

    switch ($varType) {
        case "integer":
        case "int":
        case "double":
        case "float":
            _inspect_var_Number($var);
        break;
        case "string":
            _inspect_var_String($var);
        break;
        case "object":
            _inspect_var_Object($var, (boolean)$depth);
        break;
        case "array":
            _inspect_var_Array($var, (integer)$depth);
        break;
        case "resource":
            _inspect_var_Resource($var);
        break;
        case "boolean":
            _inspect_var_Boolean($var);
        break;
        default:
            _inspect_var_Generic($var);
        break;
    }
    
    echo "</pre>"
        ."</div>";
}

/**
 *
 *
 * @access  private
 * @param   resource    $var
 * @return  void
 */
function _inspect_var_Resource($var)
{
    $resourceName = get_resource_type($var);

    echo
        "<span style=\"font-size: 11px; color: #56a0ee\">(resource)</span> " .
        "<span style=\"color: #f06f00;\">{$resourceName}</span> "            .
        "<span style=\"color: #3f6b5b; font-style: italic; font-size: 12px;\">({$var})</span>";
}

/**
 *
 *
 * @access  private
 * @param   mixed
 * @return  void
 */
function _inspect_var_Generic($var)
{

}

/**
 *
 *
 * @access  private
 * @param   integer|double
 * @return  void
 */
function _inspect_var_Number($num)
{
    $varType = gettype($num);
    echo
        "<span style=\"font-size: 11px; color: #000000\">({$varType})</span> " .
        "<span style=\"color: #ff0000;\">{$num}</span> ";
}

/**
 *
 *
 * @access  private
 * @param   string
 * @return  void
 */
function _inspect_var_String($str)
{
    $len = strlen($str);

    echo
        "<span style=\"font-size: 11px; color: #4e9a06\">(string)</span> " .
        "<span style=\"color: #0000ff;\">'{$str}'</span> "               .
        "<span style=\"font-style: italic; font-size: 12px;\">(length={$len})</span>";
}

/**
 *
 *
 * @access  private
 * @param   boolean $flag
 * @return  string
 */
function _inspect_var_Boolean($flag)
{
    $str = ($flag===TRUE) ? "TRUE" : "FALSE";

    echo
        "<span style=\"font-size: 11px; color: #999999\">(boolean)</span> " .
        "<span style=\"color: #75507b; font-weight: bold;\">{$str}</span> ";
}

/**
 *
 *
 * @access  private
 * @param   array   $arr
 * @param   integer $recursionLevel
 * @return  mixed
 */
function _inspect_var_Array(array $arr, $recursionLevel=5)
{

}


/**
 *
 *
 * @access  private
 * @param   object  $obj
 * @param   boolean $inDepth
 * @return  void
 */
function _inspect_var_Object($obj, $inDepth=FALSE)
{
    dependsOn('Reflection');

    $reflect = new ReflectionClass($obj);
    
    /*
     *
     *
     */
    $className  = get_class($obj);
    $parentName = get_parent_class($obj);
    $subClasses = NULL;
    $interfaces = NULL;
    $interfacesStr = NULL;
    $isUserDefined = $reflect->isUserDefined();
    $properties = $reflect->getProperties();
    $constants  = $reflect->getConstants();
    $statics    = $reflect->getStaticProperties();

    
    if ($parentName)
        $subClasses = _inspect_var_Object_getSubclasses($parentName);
    
    $interfaces = $reflect->getInterfaces();
    if (sizeof($interfaces)) {
        foreach ($interfaces as $interface)
            $interfacesStr .= $interface->getName() . ", ";

        $interfacesStr = substr($interfacesStr, 0, strlen($interfacesStr)-2);
    }

    /*
     *
     *
     */
    if ($inDepth==TRUE)
        ;


    /*
     * Class name.
     */
    echo
        "<fieldset style=\"border: 1px solid #c5c5c5;\">"       .
        "<legend> <i>object</i> <b>{$className}</b> </legend>"  .
        "<div style=\"padding: 10px;\">";

    /*
     * Show information.
     */
    echo
        "<div style=\"color: #3f6b5b; float: left; width: 150px; overflow: hidden;\">Defined by</div>";
    echo
        "<span style=\"font-weight: bold; font-style: italic; color: #f06f00;\">" .
        (($isUserDefined==TRUE) ? "User" : "System") . 
        "</span>";
    echo "<hr />";

    echo
        "<div style=\"color: #3f6b5b; float: left; width: 150px; overflow: hidden;\">Is abstract</div>";
    echo
        "<span style=\"font-weight: bold; font-style: italic; color: #f06f00;\">" .
        (($reflect->isAbstract()==TRUE) ? "Yes" : "No") . 
        "</span>";
    echo "<hr />";

    echo
        "<div style=\"color: #3f6b5b; float: left; width: 150px; overflow: hidden;\">Is interface</div>";
    echo
        "<span style=\"font-weight: bold; font-style: italic; color: #f06f00;\">" .
        (($reflect->isInterface()==TRUE) ? "Yes" : "No") . 
        "</span>";
    echo "<hr />";


    /*
     * Class filename.
     */
    echo
        "<div style=\"color: #3f6b5b; float: left; width: 150px; overflow: hidden;\">Filename</div>";
    echo
        "<span style=\"font-weight: bold; font-style: italic; color: #f06f00;\">" .
        $reflect->getFileName() . 
        "</span>";
    echo "<hr />";
    
    /*
     * The name of the classes this object extends.
     */
    echo
        "<div style=\"color: #3f6b5b; float: left; width: 150px; overflow: hidden;\">Extends</div>";
    echo
        "<span style=\"font-weight: bold; font-style: italic; color: #f06f00;\">" .
        (($parentName!=NULL) ? $subClasses : "none") .
        "</span>";
    echo "<hr />";
    
    /*
     * The list of the interfaces of class implements or inherits.
     */
    echo
        "<div style=\"color: #3f6b5b; float: left; width: 150px; overflow: hidden;\">Implements</div>";
    echo
        "<span style=\"font-weight: bold; font-style: italic; color: #f06f00;\">" .
        (($interfacesStr!=NULL) ? $interfacesStr : "none") .
        "</span>";
    

    echo "<br /><br /><br />";

    /*
     * Properties dumping.
     */
    echo "<ul><b>Properties</b>";
    foreach ($properties as $prop) {
        $status =  ($prop->isPublic())
                    ? "public"
                    : (($prop->isPrivate()) ? "private" : "protected"
                    );
        
        $value = "";
        if ($status=="public")
            $value = "(value={$prop->getValue($obj)})";

        echo
            "<li>" .
            "<span style=\"color: #4e9a06; font-size: 12px;\">{$status}</span> " .
            "<span style=\"color: #56a0ee; font-style: italic;\">{$prop->getName()}</span> " .
            "{$value}" .
            "</li>";
    }
    echo "</ul>";

    echo
        "</div>"    .
        "</legend>";
}

/**
 *
 *
 * @access  private
 * @param   object  $obj
 * @return  string
 */
function _inspect_var_Object_getSubclasses($obj)
{
    $parent = get_parent_class($obj);

    if ($parent!=NULL)
        return $obj . ", " . _inspect_var_Object_getSubClasses($parent);
    else
        return $obj;
}

?>
