<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */
namespace SSITU\Jack;

class Jack
{
 use \SSITU\Copperfield\SingletonOverload;
    
    public function __construct()
    {
        $this->initOverload();
    }

}
