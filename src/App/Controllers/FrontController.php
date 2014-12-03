<?php

namespace App\Controllers;

final class FrontController extends \App\Helpers\Routes
{
    public static function run($url)
    {
        parent::init($url);
        unset($_GET, $url);
        
        try{
            $nsController = new parent::$namespaceControllerClass();
            $nsController->execute(parent::$action);
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
        }
    }
    
    public static function getController()
    {
        return parent::$controller;
    }

    public static function getAction()
    {
        return parent::$action;
    }
    
    public static function getParams($param = null)
    {
        if (parent::$params != '' && $param != null)
            if (array_key_exists($param, parent::$params))
                return parent::$params[$param];
            else
                return false;
        else
            return parent::$params;
    }
}