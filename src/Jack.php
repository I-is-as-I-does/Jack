<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */
namespace SSITU\Jack;

class Jack
{
 use \SSITU\Copperfield\SingletonFacadeOverload;

    private $tradesPattern;
    private $subNameSpace;
    private $tradesArgm = [];
    
    public function __construct()
    {
        $this->tradesPattern = __DIR__ . '/Trades/*[!(_i)].php';
        $this->subNameSpace = __NAMESPACE__ . '\Trades';
    }

}
