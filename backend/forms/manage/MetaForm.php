<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 28.09.2017
 * Time: 16:27
 */

namespace backend\forms\manage;


use shop\entities\Meta;
use yii\base\Model;

class MetaForm extends Model
{
    public $metaTitle;
    public $metaDescription;
    public $metaKeywords;

    public function __construct(Meta $meta = null, $config = [])
    {
        if ($meta) {
            $this->metaTitle = $meta->title;
            $this->metaDescription = $meta->description;
            $this->metaKeywords = $meta->keywords;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['title'], 'string', 'max' => 255],
            [['description', 'keywords'], 'string'],
        ];
    }

}