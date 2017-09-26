<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 25.09.2017
 * Time: 22:03
 */

namespace shop\entities\User;


use yii\db\ActiveRecord;
use Webmozart\Assert\Assert;

/**
 * @property integer $user_id
 * @property string $network
 * @property string $identity
 */

class Network extends ActiveRecord
{
    public static function create($network, $identity)
    {
        Assert::notEmpty($network);
        Assert::notEmpty($identity);

        $item = new static();
        $item->network = $network;
        $item->identity = $identity;
        return $item;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_networks}}';
    }
}