<?php

/* Oracle Berkeley DB 4/5 Storage */
class PGOS_BerkeleyDB extends PGOS_Interface
{
    
    protected function ___save_object()
    {
        $handle = dba_open(BerkeleyDBm_Path, "c", "db4");
        dba_replace($this->__pgos_object_name,serialize($this->__pgos_dynamic_data),$handle);
        dba_sync($handle);
        dba_close($handle);
    }
    
    protected function ___load_object()
    {
        if(is_file(BerkeleyDBm_Path))
        {
            $handle = dba_open(BerkeleyDBm_Path, "r", "db4");
            if(dba_exists($this->__pgos_object_name,$handle))
            {
                foreach((array) @unserialize(dba_fetch($this->__pgos_object_name,$handle)) as $k => $v)
                {
                    $this->{$k} = $v;
                }
            }
            dba_close($handle);
        }
        $this->__pgos_object_loaded = true;
    }
    
}