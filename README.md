# PHP-PGOS
 
## PHP: Persistent Generic Object Storage
 
#### Modeled after [ZODB](http://www.zodb.org/en/latest/) for Python
 
## Features
- NoSQL Style Persistent Generic Object Storage
- Easy to use / code, simply extend the desired adapter
- Saves / Loads the objects dynamic data automatically
- Manual commit object method ___save() added.
- Extendable, contribute your own adapter easily
- Autoloader class for adapters
 
## Future (TODO)
- Composer
- Mysql, Postgres, ElasticSearch, Redis Adapters
- Single context to __save __load methods.
 
### Changelog
- Added AutoClass Loader (adapter schema class PGOS_{name} : /adapter/{name}.adapter.php)
- Added manual transaction save method ___save() for special cases when execution may fatal exit (No destructors)
 
========= 
 
## Usage 

### Below is a BerkeleyDB Adapter Example
We welcome contributions of new adapters!

### First Run

```php

/* Define path to a writeable area */
define('BerkeleyDBm_Path', '../tmp/database.fs');

/* Include Autoloader */
include_once('pgos.php');

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

exit(); /* Object is stored and on next load will be available for reference */

```

### Output

```
object(User)#1 (6) {
  ["id":protected]=>
  int(1)
  ["__pgos_object_name":"PGOS_Interface":private]=>
  int(1881791562)
  ["__pgos_object_data":"PGOS_Interface":private]=>
  array(1) {
    ["id"]=>
    int(1)
  }
  ["__pgos_dynamic_data":"PGOS_Interface":private]=>
  array(3) {
    ["name"]=>
    string(12) "Andy Hawkins"
    ["company"]=>
    string(13) "BombSquad Inc"
    ["occupation"]=>
    string(5) "Cylon"
  }
  ["__pgos_object_loaded":"PGOS_Interface":private]=>
  bool(true)
  ["__pgos_object_changed":"PGOS_Interface":private]=>
  bool(true)
}
```

### Second Run

```php

$user = new User(1);
var_dump($user);
var_dump($user->name);
var_dump($user->company);
var_dump($user->occupation);

exit(); /* Not needed, just denoting execution end */
```

### Ouput

```
object(User)#1 (6) {
  ["id":protected]=>
  int(1)
  ["__pgos_object_name":"PGOS_Interface":private]=>
  int(1881791562)
  ["__pgos_object_data":"PGOS_Interface":private]=>
  array(1) {
    ["id"]=>
    int(1)
  }
  ["__pgos_dynamic_data":"PGOS_Interface":private]=>
  array(3) {
    ["name"]=>
    string(12) "Andy Hawkins"
    ["company"]=>
    string(13) "BombSquad Inc"
    ["occupation"]=>
    string(5) "Cylon"
  }
  ["__pgos_object_loaded":"PGOS_Interface":private]=>
  bool(true)
  ["__pgos_object_changed":"PGOS_Interface":private]=>
  bool(false)
}
string(12) "Andy Hawkins"
string(13) "BombSquad Inc"
string(5) "Cylon"
```



=========

## Contributing

Please fork, add adapters, performance fixes, anything. We welcome the love.

Thanks,
~@ndy

### Adapter Base Example

File Schema:
`src/adapter/{name}.adapter.php`;

Class Schema
```php
class PGOS_{name} extends PGOS_Interface
{

    public function __construct()
    {
        $this->___init();
    }
    
    protected function ___save_object()
    {
        /* Code to save the object on destruct */
    }
    
    protected function ___load_object()
    {
        /* Code to load object data on init */
        $this->__pgos_object_loaded = true;
    }

}
```

=========

# License
### Creative Commons Attribution-ShareAlike 3.0 Unported
http://creativecommons.org/licenses/by-sa/3.0/


