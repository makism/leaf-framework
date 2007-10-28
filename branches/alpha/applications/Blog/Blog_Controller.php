<?php

class Blog_Controller extends leaf_Controller {

	public function __construct()
	{
		parent::__construct();
        $this->loader->model('Blog', array('As'=>'blog'));
	}
	
	public function index()
	{
        echo "Success! This is a test controller.<br/>\n";
        echo $this->request->getQueryString('var2');
	}
}

?>
