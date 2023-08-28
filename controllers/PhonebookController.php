<?php

namespace app\controllers;

use Yii;
use app\models\TestPeople;
use app\models\TestPhonesNumber;
use yii\rest\ActiveController;

class PhoneBookController extends ActiveController{

    public $modelClass = 'app\models\TestPeople';

    // public function actionIndex()
    // {
    //     $model = TestPeople::find()->all();

    //     return $this->render('index', [
    //     'model' => $model,
    // ]);
    // }
    

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create'], $actions['update'], $actions['delete']);
        return $actions;
    }

    public function actionCreate(){
        $model = new TestPeople();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        if ($model->safe()) {
            return ['status' => 'success', 'data' => $model];
        } else {
            return ['status' => 'error', 'data' => $model->getErrors()];
        }
    }

    public function actionUpdate($id){
        $model = TestPeople::findOne($id);

        if (!$model) {
            throw new \yii\web\NotAcceptableHttpException("Человек с таким идентификатором ($id) не найден");
        }

        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        if ($model->safe()) {
            return ['status' => 'success', 'data' => $model];
        } else {
            return ['status' => 'error', 'data' => $model->getErrors()];
        }
    }

    public function actionView($id){
        $model = TestPeople::findOne($id);

        if (!$model) {
            throw new \yii\web\NotAcceptableHttpException("Человек с таким идентификатором ($id) не найден");
        }

        $phoneNumbers = TestPhonesNumber::find()->where(['person_id' => $id])->all();
        return ['status' => 'success', 'data' => $model, 'phone_numbers' => $phoneNumbers];
    }

    public function actionDelete($id){
        $model = TestPeople::findOne($id);

        if (!$model) {
            throw new \yii\web\NotAcceptableHttpException("Человек с таким идентификатором ($id) не найден");
        }

        TestPhonesNumber::deleteAll(['person_id' => $id]);

        if ($model->delete()) {
            return ['status' => 'success', 'message' => 'Данные удалены'];
        } else {
            return ['status' => 'error' , 'message' => 'Ошибка при удалении'];
        }
    }
}
