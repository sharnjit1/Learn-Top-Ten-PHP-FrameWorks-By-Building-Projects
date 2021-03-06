<?php
namespace app\models;
use yii;

use yii\base\Model;
use yii\base\Security;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{

     public $password_repeat;
    public static function tableName()
    {
        return '{{%tbl_user}}';
    }


    public function rules()
    {
        return [
            [['full_name', 'email', 'username', 'password', 'password_repeat'], 'required'],
           
            ['email', 'email'],
            ['password_repeat', 'compare','compareAttribute' => 'password'],
        ];
    }








    /**
     * Finds an identity by the given ID.
     *
     * @param string|integer $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }




    public function validatePassword($password) {


        return $this->password ===md5($password);
    }


     public function findByUsername($username) {

        return User::findOne(['username' => $username]);
     }


    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return boolean if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }



    public function beforeSave($insert) {

        if(parent::beforeSave($insert)){

            if($this->isNewRecord){
                $this->auth_key = \Yii::$app->security->generateRandomString();
            }


            if(isset($this->password)){

        $this->password=md5($this->password);
        return parent::beforeSave($insert);
            }
        }
        return true;
    }



     public function getJob(){

        return $this->hasMany(Job::className() , ['user_id' => 'id']);
    }
}
