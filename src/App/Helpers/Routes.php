<?php

namespace App\Helpers;

abstract class Routes
{
    private static $explode;
    protected static $controllerClass, $controller, $action, $params, $paramString, $namespaceControllerClass;

    protected static function init($url)
    {
        self::$explode = explode(DS, $url);
        
        self::$controller  = (!isset(self::$explode[0]) || self::$explode[0] == null || self::$explode[0] == 'index') ? 'index' : self::$explode[0];
                
        self::$controllerClass = ucwords(self::$controller) . 'Controller';
        
        self::$namespaceControllerClass = '\App\Controllers\\' . self::$controllerClass;
        
        self::$action = (!isset(self::$explode[1]) || self::$explode[1] == null || self::$explode[1] == 'index') ? 'index' : self::$explode[1];
        
        self::setParams();
    }
    
    private static function setParams()
    {
        unset(self::$explode[0], self::$explode[1]);
        
        if (end(self::$explode) == null)
            array_pop (self::$explode);

        if (count(self::$explode) % 2 == 0) {

            if (!empty(self::$explode)) {

                $i = 0;
                foreach (self::$explode as $value) {
                    if ($i % 2 == 0)
                        $exp_idx[] = $value;
                    else
                        $exp_val[] = $value;

                    $i++;
                }
            } else {
                $exp_idx = array();
                $exp_val = array();
            }

            if (count($exp_idx) == count($exp_val) && !empty($exp_idx) && !empty($exp_val))
                self::$params = array_combine($exp_idx, $exp_val);
            else
                self::$params = array();
            
            self::$paramString = implode('/', self::$explode);

        } else {
            echo "<script>alert('Parâmetros incorretos!');</script>";
            echo "<script>window.location = '".PATH_ROOT."'</script>";
        }
    }
}