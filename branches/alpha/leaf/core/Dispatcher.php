<?php
/**
 * leaf Framework
 *
 * <i>PHP version 5</i>
 * 
 * Το πρώτο ελληνικό php framework ανοικτού κώδικα, γρήγορο, μικρό σε
 * μέγεθος και εύκολα επεκτάσιμο.
 *
 *
 * @package		leaf
 * @author		Avraam Marimpis <makism@venus.cs.teicrete.gr>
 * @copyright	-
 * @license     -
 * @version		1.0-dev
 * @filesource
 */


/**
 * Επιτελεί κάποιους ελέγχους στον Controller και στο Action
 * που ζητήται και επικαλείται το συγκεκριμένο Action (μέθοδο).
 *
 *
 * @package		leaf
 * @subpackage	core
 * @author		Avraam Marimpis <makism@venus.cs.teicrete.gr>
 * @version		1.0
 * @since		1.0-dev
 */
final class leaf_Dispatcher extends leaf_Base {
	
    const LEAF_REG_KEY = "dispatcher";
    
    const LEAF_CLASS_ID = "LEAF_DISPATCHER-1_0_dev";
    

    /**
     * Η πλήρης διαδρομή όπου <i>πρέπει</i> να βρίσκεται ο Controller
     * που ζητήθηκε.
     *
     * @var string
     */
    private $target = NULL;

    /**
     * Το όνομα της κλάσης του Controller που ζητήθηκε.
     *
     * @var string
     */
    private $controllerName = NULL;

    /**
     * Ένα στιγμιότυπο του ζητούμενου Controller.
     *
     * @var object leaf_Controller
     */
    private $controller = NULL;


    /**
     * Ανακαλύπτει τα ολοκληρωμένα ονόματα των Controllers που
     * καλούνται και ελέγχει για την ύπαρξη τους καθώς επίσης
     * και για την ορθότητά τους.
     *
     * @return  void
     */
    public function __construct()
    {
        parent::__construct(self::LEAF_REG_KEY);

        /*
         *
         */
        $this->controllerName = $this->request->getControllerName();

        /*
         *
         */
        $this->target = $this->request->getControllerFileName();

        
        /*
         *
         */
        if (!file_exists($this->target))
            showHtmlMessage("Dispatcher Failure", "Controller \"{$this->controllerName}\", not found!", TRUE);
        
        /*
         *
         */
        require_once $this->target;


        /*
         *
         */
        $this->controller = new $this->controllerName;

        /*
         *
         */
        leaf_Registry::getInstance()->register(new leaf_View());

        /*
         *
         */
        if (!($this->controller instanceof leaf_Controller))
            showHtmlMessage("Dispatcher Failure", "Not a controller", TRUE);
    }

    public function __toString()
    {
        return __CLASS__ . " " . self::LEAF_CLASS_ID;
    }
    
    /**
     * Ελέγχει για την ύπαρξη της μεθόδου που έχει ζητηθεί και την καλεί.
     *
     * @return  void
     */
	public function dispatchController()
	{
        if (method_exists($this->controller, $this->router->getMethodName())) {
            call_user_func(array($this->controller, $this->router->getMethodName()));
        } else {
            showHtmlMessage("Dispatcher Failure", "Action \"{$this->router->getMethodName()}\" is not defined", TRUE);
        }
	}

}

?>
