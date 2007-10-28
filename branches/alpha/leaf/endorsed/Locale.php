<?php

class leaf_Locale extends leaf_Base {

    const LEAF_REG_KEY = "locale";

    public function __construct()
    {
        parent::__construct(self::LEAF_REG_KEY);
    }
    
    public function __toString()
    {
        return "your-name-goes-here`s implementation of leaf_Locale!";
    }

}

?>
