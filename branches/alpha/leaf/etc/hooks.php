<?php
/**
 * leaf Framework
 *
 * <i>PHP version 5</i>
 * 
 * 
 * The first greek open source PHP5 framework, fast, with small
 * footprint and easily extensible.<br>
 * Το πρώτο ελληνικό framework PHP5 ανοικτού κώδικα, γρήγορο,
 * μικρό σε μέγεθος και εύκολα επεκτάσιμο.<br>
 *
 *
 * @package		leaf
 * @author		Avraam Marimpis <makism@venus.cs.teicrete.gr>
 * @copyright	-
 * @license		-
 * @version		1.0-dev
 * @filesource
 */


global $hooks;

$hooks = array (
    /*
     * Response
     */
    "pre_response"  => array(),
    "post_response" => array(),

	/*
     * Controller
     */
    "pre_controller_dispatch"   => array(),
    "post_controller_dispatch"  => array(),

    /*
     * Front_Controller
     */
    "post_front_controller"  => array(
        array (
            "className1",
            "methodName1",
            "args2"
        ),
        array (
            "className2",
            "args2",
            "methodName2",
            "args2"
        ),
        array (
            "className3",
            "args3"
        ),
        array (
            "className4",
            "args4",
            "methodName"
        )
    )
);

?>
