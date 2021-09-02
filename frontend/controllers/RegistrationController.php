<?php


namespace frontend\controllers;


use frontend\models\Registration;
use http\Client\Response;
use Yii;
use yii\web\Controller;
use yii\widgets\ActiveForm;

class RegistrationController extends Controller
{
     public function actionIndex() {

             $model = new Registration();
             $model->load(Yii::$app->request->post());
             if ($model->validate()) {
                 $this->goHome();
             }



         return $this->render('index', ['model' => $model]);
     }
}
