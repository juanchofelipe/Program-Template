<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Profile;

/**
 * ProfileSearch represents the model behind the search form about `frontend\models\Profile`.
 */
class ProfileSearch extends Profile
{
    public $genderName;
    public $gender_id;
    public $userId;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'gender_id'], 'integer'],
            [['first_name', 'last_name', 'birthdate', 'genderName', 'userId'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function attributeLabels()
    {
        return [
            'gender_id' => 'Gender',
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Profile::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
         'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'first_name',
                'last_name',
                'birthdate',
                'genderName' => [
                    'asc' => ['user.id' => SORT_ASC],
                    'desc' => ['user.id' => SORT_DESC],
                    'label' => 'Gender'
                ],
                'profileIdLink' => [
                 'asc' => ['profile.id' => SORT_ASC],
                 'desc' => ['profile.id' => SORT_DESC],
                 'label' => 'ID'
                ],
                'userLink' => [
                 'asc' => ['user.username' => SORT_ASC],
                 'desc' => ['user.username' => SORT_DESC],
                 'label' => 'User'
                ],
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');

            $query->joinWith(['gender'])
             ->joinWith(['user']);

            return $dataProvider;
        }

        $this->addSearchParameter($query, 'profile');
        $this->addSearchParameter($query, 'first_name', true);
        $this->addSearchParameter($query, 'last_name', true);
        $this->addSearchParameter($query, 'birthdate');
        $this->addSearchParameter($query, 'gender_id');
        $this->addSearchParameter($query, 'created_at');
        $this->addSearchParameter($query, 'updated_at');
        $this->addSearchParameter($query, 'user_id');

        //filter by role

        $query->joinWith(['gender' => function($q) {
            $q->where('gender.gender_name LIKE "%' . $this->genderName . '%"');
         }])
        //filter by status
         ->joinWith(['user' => function($q) {
             $q->where('user.id LIKE "%' . $this->userId . '%"');
         }]);

        // grid filtering conditions
        /*$query->andFilterWhere([
         'id' => $this->id,
         'role_id' => $this->role_id,
         'user_type_id' => $this->user_type_id,
         'status_id' => $this->status_id,
         'created_at' => $this->created_at,
         'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
         ->andFilterWhere(['like', 'auth_key', $this->auth_key])
         ->andFilterWhere(['like', 'password_hash', $this->password_hash])
         ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
         ->andFilterWhere(['like', 'email', $this->email]);
        */
        return $dataProvider;
    }

    protected function addSearchParameter($query, $attribute, $partialMatch = false)
    {
        $pos = strrpos($attribute, '.');

        if ($pos !== false) {
            $modelAttribute = substr($attribute, $pos + 1);
        } else {
            $modelAttribute = $attribute;
        }

        $value = $this->$modelAttribute;

        if (trim($value) === '') {
            return;
        }

        /**
        * The followin line is addtionally added for right aliasing
        * of columns so filtering happen correctly in the self join
        */

        $attribute = "profile.$attribute";

        if ($partialMatch) {
         $query->andWhere(['like', $attribute, $value]);
        } else {
         $query->andWhere([$attribute => $value]);
        }
    }
}
