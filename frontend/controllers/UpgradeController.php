<?php

namespace frontend\controllers;

class UpgradeController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $name = Yii::$app->user->identity->username;
        return $this->render('index', ['name' => $name]);
    }

}
