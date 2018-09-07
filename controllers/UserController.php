<?php
class UserController extends Controller 
{
	public $layouts = 'login';
	
	public function actionLogin()
	{
		$login = false;
        $password = false;
		if (isset($_POST['submit'])) {
            $login = $_POST['login'];
            $password = md5($_POST['password']);
            
            $userId = User::checkUserData($login, $password);
			if ($userId == false) {
                echo "<div class='alert alert-danger modal' style='width: 380px;margin: 0 auto; display:block;bottom:initial; overflow-y:hidden'><button class='close' data-dismiss='alert'><i class='fa fa-times'></i></button> <strong>Помилка! </strong> Неправильні дані для входу</div>";
            } else {
                User::auth($userId);
                header("Location: /admin/");
            }
        }
		$this->view->renderView('user/login');		
	}
	public function actionLogout()
    {
        //session_start();
        unset($_SESSION["user"]);
        header("Location: /user/login");
    }
}
?>