<?php
class Model extends R
{
	function __construct()
	{
		$paramsPath = ROOT . '/config/db_params.php';
        $params = include($paramsPath);
		R::setup( "mysql:host={$params['host']};dbname={$params['dbname']}",
        $params['user'], $params['password'] );
	}			
}
?>