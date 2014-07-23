<?php

spl_autoload_register(function ($class) {
    if(is_numeric(strpos($class,'pgos'))) return False;
    
    $name = strtolower(str_replace('PGOS_','',$class));
    $path = __DIR__.'/adapter/'.$name.'.adapter.php';
    if(is_file($path))
        return include($path);
        
    return False;
});