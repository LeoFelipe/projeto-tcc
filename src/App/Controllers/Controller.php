<?php

namespace App\Controllers;

abstract class Controller
{
    protected $entity, $model;

    public function __construct()
    {        
        $controller = str_replace('App\Controllers\\', '', get_class($this));
        $controller = str_replace('Controller', '', $controller);
        
        if (!empty($controller) && $controller != 'Index') {
            $this->entity = $this->getEntity($controller);
            $model = 'App\Models\\'.$controller;
            $this->model = new $model($GLOBALS['em'], $this->entity);
        }
    }
    
    public function execute($action)
    {
        $this->$action();
        require_once('src/App/Views/' . FrontController::getController() . DS . FrontController::getAction() . '.phtml');
    }
    
    protected function getEM()
    {
        return $GLOBALS['em'];
    }
    
    protected function getEntity($controller)
    {
        return 'App\Entities\\'.$controller;
    }
}