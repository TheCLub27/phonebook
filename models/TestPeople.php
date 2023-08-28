<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "test_people".
 *
 * @property int $id
 * @property string $last_name
 * @property string $first_name
 * @property string $surname
 * @property string|null $time_of_last_edit
 */
class TestPeople extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'test_people';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['last_name', 'first_name', 'surname'], 'required'],
            [['time_of_last_edit'], 'safe'],
            [['last_name', 'first_name', 'surname'], 'string', 'max' => 255],
        ];
    }

    public function behaviors()
    {
        return[
            'class' => TimestampBehavior::className(),
            'attributes' => [
                ActiveRecord::EVENT_BEFORE_INSERT => ['time_of_last_edit'],
                ActiveRecord::EVENT_BEFORE_UPDATE => ['time_of_last_edit'],
            ],
            'value' => new \yii\db\Exception('NOW()'),
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'last_name' => 'Last Name',
            'first_name' => 'First Name',
            'surname' => 'Surname',
            'time_of_last_edit' => 'Time Of Last Edit',
        ];
    }

    public function getTestPhonesNumber(){
        return $this->hasMany(TestPhonesNumber::class, ['person_id' => 'id']);
    }

    public function beforeDelete(){
        if (parent::beforeDelete()) {
            TestPhonesNumber::deleteAll(['person_id' => $this->id]);
            return true;
        }
        return false;
    }
}
