<?php

namespace frontend\models;

use Yii;
use common\models\User;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "profile".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $birthdate
 * @property integer $gender_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Gender $gender
 * @property User $user
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'gender_id'], 'required'],
            [['user_id', 'gender_id'], 'integer'],
            [['first_name', 'last_name'], 'string'],
            [['birthdate', 'created_at', 'updated_at'], 'safe'],
            [['gender_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gender::className(), 'targetAttribute' => ['gender_id' => 'id']],
            [['gender_id'], 'in', 'range' => array_keys($this->getGenderList())],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'birthdate' => 'Birthdate',
            'gender_id' => 'Gender ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'genderName' => Yii::t('app', 'Gender'),
            'userLink' => Yii::t('app', 'User'),
            'profileIdLink' => Yii::t('app', 'Profile')
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGender()
    {
        return $this->hasOne(Gender::className(), ['id' => 'gender_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getGenderName()
    {
        return $this->gender->gender_name;
    }

    public function getGenderList()
    {
        $droptions = $this->find()->asArray()->all();
        return ArrayHelper::map($droptions, 'id', 'gender_name');
    }

    public function getUserName()
    {
        return $this->user->username;
    }

    public function getUserId()
    {
        return $this->user ? $this->user->id : '-No user-';
    }

    public function getUserLink()
    {
        $url = Url::to(['user/view', 'id' => $this->userId]);
        $options = [];
        return Html::a($this->getUserName(), $url, $options);
    }

    public function getProfileIdLink()
    {
        $url = Url::to(['profile/update', 'id' => $this->id]);
        $options = [];
        return Html::a($this->id(), $url, $options);
    }
}
