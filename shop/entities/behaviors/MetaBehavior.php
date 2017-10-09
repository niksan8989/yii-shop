<?php

namespace shop\entities\behaviors;

use shop\entities\Meta;
use shop\entities\Shop\Brand;
use yii\base\Behavior;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class MetaBehavior extends Behavior
{
    public $attribute = 'meta';
    public $json_attribute = 'meta_json';

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'onAfterFind',
            ActiveRecord::EVENT_BEFORE_INSERT => 'onBeforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'onBeforeSave'
        ];
    }

    public function onAfterFind(Event $event): void
    {
        $brand = $event->sender;
        $meta = Json::decode($brand->getAttribute($this->json_attribute));
        $brand->{$this->attribute} = new Meta(
            ArrayHelper::getValue($meta, 'title'),
            ArrayHelper::getValue($meta, 'description'),
            ArrayHelper::getValue($meta, 'keywords')
        );
    }

    public function onBeforeSave(Event $event): void
    {
        $brand = $event->sender;
        $brand->setAttribute($this->json_attribute, Json::encode([
            'title' => $brand->{$this->attribute}->title,
            'description' => $brand->{$this->attribute}->description,
            'keywords' => $brand->{$this->attribute}->keywords,
        ]));
    }
}