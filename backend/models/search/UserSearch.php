<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

/**
 * UserSearch represents the model behind the search form about `common\models\User`.
 */
class UserSearch extends User
{

    public $roleName;
    public $userTypeName;
    public $user_type_name;
    public $user_type_id;
    public $statusName;
    public $profileId;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'role_id', 'user_type_id', 'status_id'], 'integer'],
            [['username', 'email', 'created_at', 'updated_at', 'roleName', 'statusName', 'userTypeName', 'profileId', 'user_type_name'], 'safe'],
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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = User::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'userIdLink' => [
                    'asc' => ['user.id' => SORT_ASC],
                    'desc' => ['user.id' => SORT_DESC],
                    'label' => 'User'
                ],
                'userLink' => [
                    'asc' => ['user.username' => SORT_ASC],
                    'desc' => ['user.username' => SORT_DESC],
                    'label' => 'User'
                ],
                'profileLink' => [
                    'asc' => ['profile.id' => SORT_ASC],
                    'desc' => ['profile.id' => SORT_DESC],
                    'label' => 'Profile'
                ],
                'roleName' => [
                    'asc' => ['role.role_name' => SORT_ASC],
                    'desc' => ['role.role_name' => SORT_DESC],
                    'label' => 'Role'
                ],
                'statusName' => [
                    'asc' => ['status.status_name' => SORT_ASC],
                    'desc' => ['status.status_name' => SORT_DESC],
                    'label' => 'Status'
                ],
                'userTypeName' => [
                    'asc' => ['user_type.user_type_name' => SORT_ASC],
                    'desc' => ['user_type.user_type_name' => SORT_DESC],
                    'label' => 'User Type'
                ],
                'created_at' => [
                    'asc' => ['created_at' => SORT_ASC],
                    'desc' => ['created_at' => SORT_DESC],
                    'label' => 'Created At'
                ],
                'email' => [
                    'asc' => ['email' => SORT_ASC],
                    'desc' => ['email' => SORT_DESC],
                    'label' => 'Email'
                ]
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');

            $query->joinWith(['role'])
                ->joinWith(['status'])
                ->joinWith(['profile'])
                ->joinWith(['userType']);

            return $dataProvider;
        }

        $this->addSearchParameter($query, 'user.id');
        $this->addSearchParameter($query, 'username', true);
        $this->addSearchParameter($query, 'email', true);
        $this->addSearchParameter($query, 'role_id');
        $this->addSearchParameter($query, 'status.id');
        $this->addSearchParameter($query, 'user_type_id');
        $this->addSearchParameter($query, 'created_at');
        $this->addSearchParameter($query, 'updated_at');

        //filter by role

        $query->joinWith(['role' => function($q) {
            $q->where('role.role_name LIKE "%' . $this->roleName . '%"');
            }])
        //filter by status
            ->joinWith(['status' => function($q) {
                $q->where('status.status_name LIKE "%' . $this->statusName . '%"');
            }])
        //filter by user type
            ->joinWith(['userType' => function($q) {
                $q->where('user_type.user_type_name LIKE "%' . $this->userTypeName . '%"');
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
            $modelAttribute = substr($attribute, $pos+1);
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

        $attribute = "user.$attribute";

        if ($partialMatch) {
            $query->andWhere(['like', $attribute, $value]);
        } else {
            $query->andWhere([$attribute => $value]);
        }


    }
}
