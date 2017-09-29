<?php
namespace backend\forms\manage\Shop;

use backend\forms\manage\MetaForm;
use shop\entities\Meta;
use shop\entities\Shop\Brand\Brand;
use shop\forms\CompositeForm;
use shop\validators\SlugValidator;

/**
 * Class BrandForm
 * @package backend\forms\manage\Shop
 * @property Meta $meta
 */
class BrandForm extends CompositeForm
{
    public $name;
    public $slug;

    private $_brand;

    public function internalForms(): array
    {
        return ['meta'];
    }

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
            $this->meta = new MetaForm($brand->meta);
            $this->_brand = $brand;
        } else {
            $this->meta = new MetaForm();
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'slug'], 'string', 'max' => 255],
            ['slug', SlugValidator::class],
            [['name', 'slug'], 'unique', 'targetClass' => Brand::class, 'filter' => $this->_brand ? ['<>', 'id', $this->_brand->id] : null],
        ];
    }
}