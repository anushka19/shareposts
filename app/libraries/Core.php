<?php

/*
App Core Class
Creates URL & loads core controller
URL FORMAT - /controller/method/params
*/


class Core{
    protected $currentController='Pages';//it everytime keeps on changing as we load url so get url.
    protected $currentMethod='index';
    protected $params=[];

    public function __construct(){
        //print_r($this->getUrl());

        $url=$this->getUrl();

        //Look in controllers for first value
        //here we say are in core but this code is for index.php so we are specifying file path

        if(file_exists('../app/controllers/' . ucwords($url[0]) . '.php')){
            //if exists, set as controller
            $this->currentController=ucwords($url[0]);

            //unset 0 index
            unset($url[0]);
        }

        //Require the controller
        require_once '../app/controllers/' . $this->currentController . '.php';

        //Instantiate controller class
        $this->currentController=new $this->currentController;

        //Check for second part of url -> method
        if(isset($url[1])){
            //Check to see if method exists in controller
            if(method_exists($this->currentController, $url[1])){
                $this->currentMethod= $url[1];
                //unset 1 index
                unset($url[1]);
            }
        }

        //echo $this->currentMethod;
        //Get params
        $this->params=$url ? array_values($url) : [];

        //Call a callback with array of params
        call_user_func_array([$this->currentController,$this->currentMethod],$this->params);

    }

    public function getUrl(){
        if(isset($_GET['url'])){
            $url=rtrim($_GET['url'],'/');
            $url=filter_var($url,FILTER_SANITIZE_URL);//removes all / 
            $url=explode('/',$url);
            return $url;


        }
        
    }
}









?>