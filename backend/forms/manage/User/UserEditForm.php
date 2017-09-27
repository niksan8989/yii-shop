<?php
namespace backend\forms\manage\User;

use shop\entities\User\User;
use yii\base\Model;

class UserEditForm extends Model
{
    public $username;
    public $email;
    private $_user;

    public function __construct(User $user, $config = [])
    {
        $this->username = $user->username;
        $this->email = $user->email;
        $this->_user = $user;
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['username', 'email'], 'required'],
            [['email'], 'email'],
            [['username', 'email'], 'string', 'max' => 255],
            // Проверяем username и email на уникальность, но при этом исключаем id текущего редактируемого пользователя из поиска в БД
            [['username', 'email'], 'unique', 'targetClass' => User::class, 'filter'=> ['<>', 'id', $this->_user->id]],
        ];
    }
}