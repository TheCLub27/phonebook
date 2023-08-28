<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "test_phones_number".
 *
 * @property int $id
 * @property string $phone_number
 * @property int $person_id
 */
class TestPhonesNumber extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'test_phones_number';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone_number', 'person_id'], 'required'],
            [['person_id'], 'integer'],
            [['phone_number'], 'string', 'max' => 18, 'match', 'pattern' => '/^\+7 \(\d{3}\) \d{2}-\d{3}-\d{3}$/', 'message' => 'Неверно введен номер. Требуется номер формата: +7 (xxx) xx-xxx-xx'],
            [['person_id'], 'exist', 'skipOnError' => true, 'targetClass' => TestPeople::className(), 'targetAttribute' => ['person_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phone_number' => 'Phone Number',
            'person_id' => 'Person ID',
        ];
    }

    public function getTestPeople(){
        return $this->hasOne(TestPeople::class,['id' => 'person_id']);
    }
}
