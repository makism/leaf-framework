<?php

// Your Controller must:
// 1) extend "leaf_Controller",
// 2) have a name suffixed with "_Controller".
// 3) *never* implement a constructor,
//    UNLESS it has the following signature:
//    public function __construct($controllerName)
//
// If the two top requirements, are not met,
// your Controller will be ignored, and an error
// will be raised.
//
// If you implement your own constructor, the first
// statement inside your constructor should be:
//  parent::__construct($controllerName);
// in case you supply  a different signature, the
// whole application will not work as expected,
// or not work at all...

use leaf\Core\Controller;


// Method execution sequence:
// 1) __construct (provided by the parent class)
// 2) init
// 3) user-defined method or, index
// 4) destroy
// 5) __destruct  (provided by the parent class)
final class WelcomeApp_Controller extends Controller {

    // Prohibit other Controllers, to call this one.
    const ALLOW_CALL = FALSE;

    // Allow access to this application, from any IP.
    const RESTRICT_ACCESS = FALSE;

    // Enable this application.
    const IS_ENABLED = TRUE;

    // Disable hooks for this application.
    #const ALLOW_HOOKS = TRUE;
    
    // Set the output buffer handler.
    #const OUTPUT_HANDLER = "gz";
    
    
    /*
     * This method is called after the default class
     * Constructor, provided by the leaf_Controller
     * abstract class.
     */
    public function init()
    {
        $this->Local->model("SampleModel");
    }
    
    /*
     * This method is called after the specified Action
     * and before the default class Destructor, provided
     * by the leaf_Controller abstract class.
     */
    public function destroy()
    {

    }

    /*
     * This is the default method that all Controllers,
     * must implement.
     * 
     * You can optionally support the method with two
     * arguments. Then, two objects ($this->Request and
     * $this->Response) will be passed by reference to
     * the method`s scope.
     * That is why there are no abstract declarations
     * of the methods "init", "destroy" and "index"
     * in the parent class.
     */
     public function index()
     {
        $data['title']= $this->SampleModel->getPageTitle();
        $this->View->render("main", $data);
     }

}

