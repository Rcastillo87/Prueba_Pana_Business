<?php

class Routing 
{
    private $_uri = array();
    private $_action = array();

    public function add($uri, $action = null) 
    {
        $this->_uri[] = '/' . trim($uri, '/');
        if ($action != null){
            $this->_action[] = $action;
        }
    }

    public function run() 
    {
        $uriGet = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
        $uriGet = "/" . explode('/', $uriGet)[2];
        
        foreach ($this->_uri as $key => $value){
            if ( $uriGet == $value){
                $action = $this->_action[$key];
                $this->runAction($action);
            }
        }
    }

    private function runAction($action) 
    {
        if($action instanceof \Closure){
            $action();
        }  
        else{
            $params = explode('@', $action);
            $obj = new $params[0];
            $obj->{$params[1]}();
        }
    }
}
?>