<?php

namespace shop\entities\Shop\Brand;

use shop\entities\behaviors\MetaBehavior;
use yii\db\ActiveRecord;
use shop\entities\Meta;
use yii\helpers\Json;

/**
 * Class Brand
 * @package shop\entities\Shop\Brand
 * @property string $name
 * @property string $slug
 * @property Meta $meta
 */
class Brand extends ActiveRecord
{
    public $meta;


    public function behaviors()
    {
        return [
            MetaBehavior::classname()
        ];
    }

    public static function create($name, $slug, Meta $meta): self
    {
        $brand = new static();
        $brand->name = $name;
        $brand->slug = $slug;
        $brand->meta = $meta;
        return $brand;
    }

    public function edit($name, $slug, Meta $meta): void
    {
        $this->name = $name;
        $this->slug = $slug;
        $this->meta = $meta;
    }


    public static function tableName(): string
    {
        return '{{%shop_brands}}';
    }
}