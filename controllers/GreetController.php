<?php

class GreetController extends Controller
{

    public function actionIndex()
    {
        if ($this->checkDate()) {
            $this->view->renderPartial('mystery');
        }
    }

    public function actionCats()
    {
        if ($this->checkDate()) {
            $this->view->renderPartial('cats');
        }
    }

    public function actionAtlast()
    {
        if ($this->checkDate()) {
            $this->view->renderPartial('atlast');
        }
    }

    private function checkDate()
    {
        $target_date = new \DateTime('25.09.2018', new \DateTimeZone('Europe/Kiev'));
        $now = new \DateTime('now', new \DateTimeZone('Europe/Kiev'));
        //$now = new \DateTime('25.09.2018 11:59:59', new \DateTimeZone('Europe/Kiev'));

        if ($now < $target_date) {
            $this->view->vars('target_date', $target_date);

            $this->view->renderPartial('timer');
            return false;
        } else {
            if ((int)$now->format('m') === (int)$target_date->format('m') && (int)$now->format('d') === (int)$target_date->format('d')) {
                return true;
            } else {
                echo "You are too late. Magic is over";
                return false;
            }
        }
    }
}

?>