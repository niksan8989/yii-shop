<?php
namespace backend\forms\manage\Shop;

use backend\forms\manage\MetaForm;
use shop\entities\Meta;
use shop\entities\Shop\Brand\Brand;
use shop\entities\Shop\Tag\Tag;
use yii\base\Model;

class BrandForm extends Model
{
    public $name;
    public $slug;

    private $_brand;
    private $_meta;

    /**
     * BrandForm constructor.
     * @param Brand|null $brand
     * @param array $config
     */
    public function __construct(Brand $brand = null, $config = [])
    {
        if ($brand) {
            $this->name = $brand->name;
            $this->slug = $brand->slug;
            $this->_meta = new MetaForm($brand->meta);
            $this->_brand = $brand;
        } else {
            $this->_meta = new MetaForm();
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['slug'], 'pattern' => '#^[a-z0-9_-]*$#s'],
            [['name', 'slug'], 'unique', 'targetClass' => Brand::class, 'filter' => $this->_brand ? ['<>', 'id', $this->_brand->id] : null],
        ];
    }

    public function load($data, $formName = null)
    {
        $self = parent::load($data, $formName);
        $meta = $this->_meta->load($data, $formName ? null : 'meta');
        return $self && $meta;

    }
}