<?php


namespace Pa\Core;


class MiddleWareManager
{
    public function __construct()
    {

    }

    public static function launch(string $method)
    {
        $fileMiddleWare =  $_SERVER['DOCUMENT_ROOT'].'/'.MIDDLEWARE_PATH;
        $files = scandir($fileMiddleWare);
        foreach($files as $file)
        {
            if(strpos($file,'.php'))
            {
                $namespace =  self::extract_namespace($fileMiddleWare.'/'.$file);
                $startMiddleWare = self::start($namespace, rtrim($file, '.php'), $method);
            }
        }
    }

    public static function extract_namespace($file) {
        $ns = NULL;
        $handle = fopen($file, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                if (strpos($line, 'namespace') === 0) {
                    $parts = explode(' ', $line);
                    $ns = rtrim(trim($parts[1]), ';');
                    break;
                }
            }
            fclose($handle);
        }
        return $ns;
    }

    public static function start(string $namespace, string $class, string $method)
    {
        $class = $namespace.'\\'.$class;
        $reflection = new \ReflectionMethod($class, $method);
        $params = $reflection->getParameters();
        $paramsToLaunch = [];
        for( $i = 0; $i <count($params); $i++)
        {
            $param =  $params[$i]->getType()->getName();
            if(class_exists($param))
            {
                $paramToLaunch = new $param;
                $paramsToLaunch[] = $paramToLaunch;
            }
            elseif($param == 'int' || $param == 'string')
            {
                $paramsToLaunch[] = 0;
            }
        }
        $reflection->invokeArgs(new $class, $paramsToLaunch);
    }
}