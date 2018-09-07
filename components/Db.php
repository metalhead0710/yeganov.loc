<?php

class Db extends R
{

   public static function connect()
    {
    	$paramsPath = ROOT . '/config/db_params.php';
        $params = include($paramsPath);
		R::setup( "mysql:host={$params['host']};dbname={$params['dbname']}",
        $params['user'], $params['password'] );        
	}

}
