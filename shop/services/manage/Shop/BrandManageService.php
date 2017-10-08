<?php

namespace shop\services\manage\Shop;

use shop\forms\manage\Shop\BrandForm;
use shop\entities\Meta;
use shop\entities\Shop\Brand;
use shop\repositories\Shop\BrandRepository;
use shop\repositories\Shop\ProductRepository;
use Yii;
use yii\helpers\Inflector;

class BrandManageService
{
    private $brands;
    private $products;

    public function __construct(BrandRepository $brands, ProductRepository $products)
    {
        $this->brands = $brands;
        $this->products = $products;
    }

    public function create(BrandForm $form)
    {
        $brand = Brand::create(
            $form->name,
            $form->slug ? $form->slug : Inflector::slug($form->name),
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );

        $this->brands->save($brand);

        return $brand;
    }

    public function edit($id, BrandForm $form)
    {
        $brand = $this->brands->get($id);

        $brand->edit(
            $form->name,
            $form->slug ? $form->slug : Inflector::slug($form->name),
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );

        $this->brands->save($brand);
    }

    public function delete($id)
    {

        $brand = $this->brands->get($id);

        if ($this->products->existsByBrand($brand->id)) {
            throw new \DomainException('Unable to remove brand with products.');
        }

        $this->brands->remove($brand);
    }
}