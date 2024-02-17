<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * ContactForm is the model behind the contact form.
 */
class FormRegistration extends Model
{
    public $username;
    public $password;
    public $password_2;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'password', 'password_2'], 'required'],
            ['username', 'unique', 'targetClass' => User::className(),  'message' => 'Этот логин уже занят'],
            [['username', 'password', 'password_2'], 'safe'],
            ['password', 'validateUserPassword'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
            'password_2' => 'Повторите пароль',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }
    public function validateUserPassword($attribute)
    {
        if (strlen($this->password) < 8) {
            $this->addError($attribute, 'Слишком короткий пароль, придумайте другой.');
        }
    }

}


