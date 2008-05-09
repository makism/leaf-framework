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

// Method execution summary:
// 1) __construct (provided by the parent class)
// 2) init
// 3) user-defined method or, index
// 4) destroy
// 5) __destruct  (provided by the parent class)
final class WelcomeApp_Controller extends leaf_Controller {

    const ALLOW_CALL = FALSE;

    const RESTRICT_ACCESS = TRUE;

    const IS_ENABLED = TRUE;

    const ALLOW_HOOKS = FALSE;
    
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
     * You can optionally support the method with two
     * arguments. Then, two objects ($this->Request and
     * $this->Response) will be passed by reference to
     * the method`s scope.
     *
     * That is why there are no abstract declarations
     * of the methods "init", "destroy" and "index"
     * in the parent class.
     */
	public function index($Request, $Response)
	{
        //echo __METHOD__ . "<br>\n";
#        var_dump ($Response);
#        var_dump ($Request);
        //$result = $this->Dispatcher->invokeInBuffer("AnotherApp", "someAction", TRUE);
        #echo $result;

        $data['title']= $this->SampleModel->getPageTitle();
        $this->View->render("main", $data);
        
        /*var_dump ($Request->getSegmentsSize());
        var_dump ($Request->getSegment(2));
        var_dump ($Request->getRawSegments());*/
        #var_dump ($Request->getSegmentsAsArray());


        /*echo "<hr/>";
        echo "getPreparedQueryString(): ";
        var_dump ($Request->getPreparedQueryString());

        echo "getRawQueryString(): ";
        var_dump ($Request->getRawQueryString());
        echo "<hr/>";

        echo "getQueryString(): ";
        var_dump ($Request->getQueryString("var1"));

        echo "queryStringKeyExists(): ";
        var_dump ($Request->queryStringKeyExists("var2"));

        echo "queryStringKeyExists(): ";
        var_dump ($Request->queryStringKeyExists("var3526"));

        echo "<br />";*/
        /*$Request->mergeQueryStrings();


        $Request->appendQueryString("var1", "val5");
        var_dump ($Request->getPreparedQueryString());
        echo "<hr/>";

        $this->Dispatcher->invoke("AnotherApp", "someAction");*/
	}

}

