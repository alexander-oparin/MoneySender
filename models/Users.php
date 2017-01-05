<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property string $id
 * @property string $name
 * @property string $balance
 */
class Users extends \yii\db\ActiveRecord {
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'balance'], 'required'],
            [['balance'], 'number'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'balance' => 'Balance',
        ];
    }

    /**
     * Получение списка пользователей
     * @return Users[]
     */
    public static function getUsers() {
        return Users::find()->asArray()->all();
    }

    /**
     * Перевод средств между пользователями
     * @param $data
     * @return array
     * @throws \yii\db\Exception
     */
    public static function sendMoney($data) {
        if (!$sender = Users::findOne(['id' => $data['sender']])) {
            return ['success' => false, 'error' => 'Отправитель не существует'];
        }

        if (!$receiver = Users::findOne(['id' => $data['receiver']])) {
            return ['success' => false, 'error' => 'Получатель не существует'];
        }

        if (($sender->id == $receiver->id)) {
            return ['success' => false, 'error' => 'Отправитель и получатель - одно лицо'];
        }

        if (($sender) && ($sender->balance < $data['amount'])) {
            return ['success' => false, 'error' => 'У отправителя недостаточно средств на балансе'];
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $sender->balance -= $data['amount'];
            $receiver->balance += $data['amount'];
            if ($sender->save() && $receiver->save()) {
                $transaction->commit();
                return ['success' => true, 'error' => 'Перевод выполнен успешно'];
            } else {
                $transaction->rollBack();
                return ['success' => false, 'error' => 'Ошибка выполнения операции'];
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
