<?php

namespace app\controllers;

use app\models\Users;
use Yii;
use yii\web\Controller;

class SiteController extends Controller {

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }


    /**
     *
     * Обработчики AJAX-запросов
     *
     */

    /**
     * Получение списка пользователей
     */
    public function actionAjaxGetUsers() {
        return json_encode(['users' => Users::getUsers()]);
    }

    public function actionAjaxSendMoney() {
        return json_encode(Users::sendMoney(Yii::$app->request->post()));
    }
}
