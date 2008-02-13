<?php


class Form_Controller extends leaf_Controller {

    public function init()
    {

    }
    
    public function destroy()
    {

    }

    public function index()
    {
echo <<<TMP
<form name="asdf" method="post" action="/leaf/Form/">
<input type="text" name="TxtField1"/>
<input type="submit"/>
</form>
TMP;
    }

    public function handlePost()
    {
        var_dump ($this->Request->getParameter("TxtField1"));
    }

}

