<?php

// This is an autogenerated file - do not edit!

// @codeCoverageIgnoreStart
spl_autoload_register(
    function($class)
    {
        static $classes = array(
            'spriebsch\\jobqueue\\object' => '/_testdata/Object.php',
            'spriebsch\\hashmap\\difftest' => '/DiffTest.php',
            'spriebsch\\hashmap\\hashmaptest' => '/HashMapTest.php'
       );
       $cn = strtolower($class);
       if (isset($classes[$cn])) {
        require __DIR__ . $classes[$cn];
       }
    }
);
// @codeCoverageIgnoreEnd
