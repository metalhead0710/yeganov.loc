<?php
class User extends Model
{
	public static function checkUserData($login, $password)
    {
        $user  = R::findOne( 'yeg_us', ' log = :log and pass = :pass ', [ ':log' => $login, ':pass' => $password ] );	
        if ($user) {
            return $user->id;
        }
        return false;
    }
	
	public static function auth($userId)
    {
        $_SESSION['user'] = $userId;
    }
	
	public static function checkLogged()
    {
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }
        else
        {
			header("Location: /user/login");
		}        
    }
}
?>