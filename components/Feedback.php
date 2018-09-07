<?php
class Feedback
{
	public function success($msg)
	{
		$_SESSION['feedback'] = null;
		
		if(!empty($msg))
            $html =  '<div class="alert alert-success"><button class="close" data-dismiss="alert"><i class="fa fa-times"></i></button><strong>Успіх!</strong> '. $msg.'</div>';
            $_SESSION['feedback'] =  $html;
	}
	
	public function error($msg)
    {
    	$_SESSION['feedback'] = null;
        if(!empty($msg))
            $html = '<div class="alert alert-danger"><button class="close" data-dismiss="alert"><i class="fa fa-times"></i></button><strong>Помилка!</strong> '. $msg.'</div>';
            $_SESSION['feedback'] =  $html;
    }
    
    public function warning($msg)
    {
    	$_SESSION['feedback'] = null;
        if(!empty($msg))
            $html = '<div class="alert alert-warning"><button class="close" data-dismiss="alert"><i class="fa fa-times"></i></button><strong>Увага!</strong> '. $msg.'</div>';
            $_SESSION['feedback'] =  $html;
    }
    
    public function get()
    {
		$feedback = $_SESSION['feedback'];	
		$_SESSION['feedback'] = null;	
		return $feedback;
	}	
}
?>