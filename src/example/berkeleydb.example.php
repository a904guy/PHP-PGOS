<?php

define('BerkeleyDBm_Path', __DIR__.'/../tmp/database.fs');

include_once(__DIR__.'/../pgos.php');

class User extends PGOS_BerkeleyDB {
    
    protected $id;
    
    /* Construct arguements must be protected or below */
    function __construct($id)
    {
        $this->id = $id;
        /* Must construct parent after all values are defined
        that will be constant to the object */
        parent::__construct();
    }
}

$user = new User(1);

$user->name = 'Andy Hawkins';
$user->company = 'BombSquad Inc';
$user->occupation = 'Cylon';

var_dump($user);

$andy = new User(3);

if(isset($andy->fname))
{
    //$andy->fname = 'Andrew';
}else{
    $andy->fname = 'Andy';
    $andy->lname = 'Hawkins';
}

var_dump($andy);