<?php

abstract class PGOS_Interface
{
    private                     $__pgos_object_name;
    private                     $__pgos_object_data = array();
    private                     $__pgos_dynamic_data = array();
    private                     $__pgos_object_loaded = false;
    private                     $__pgos_object_changed = false;
    public function              &__get($k)
    {
        if(property_exists($this,$k))
        {
            return $this->{$k};
        }elseif(array_key_exists($k,$this->__pgos_dynamic_data))
        {
            return $this->__pgos_dynamic_data[$k];
        }else{
            throw new Exception('HackDB: Attempt to access '.$k.' of '.get_class($this).' that does not exist');
        }
    }
    public function              __set($k, $v)
    {
        if($this->__pgos_object_loaded)
            $this->__pgos_object_changed = true;
        
        if(property_exists($this,$k))
        {
            $this->{$k} = $v;
        }else{
            $this->__pgos_dynamic_data[$k] = $v;
        }
    }
    public function              __isset($k)
    {
        if(array_key_exists($k,$this->__pgos_dynamic_data))
        {
            return true;
        }else{
            return false;
        }
    }
    public function              __unset($k)
    {
        unset($this->__pgos_dynamic_data[$k]);
        $this->__pgos_object_changed = true;
    }
    protected function           ___set_object_name()
    {
        $this->__pgos_object_name = crc32(get_class($this).json_encode($this->__pgos_object_data));
    }
    protected function           ___set_object_data()
    {
        foreach(get_object_vars($this) as $k => $v)
        {
            if(strpos($k,'__pgos') === 0) continue;
            $this->__pgos_object_data[$k] = $v;
        }
    }
    protected function           ___init()
    {
        $this->___set_object_data();
        $this->___set_object_name();
        if(method_exists($this,'___load_object'))
            $this->___load_object();
    }
    function                     __destruct()
    {
        /* Make sure parent contains save method */
        if(method_exists($this,'___save_object') && $this->__pgos_object_changed)
            $this->___save_object();
    }
}