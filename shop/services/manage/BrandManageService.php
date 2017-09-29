<?php

namespace shop\services\msnage;

use backend\forms\manage\Shop\BrandForm;
use shop\entities\Meta;
use shop\entities\Shop\Brand\Brand;
use shop\repositories\Shop\BrandRepository;

class BrandManageService
{
    private $brands;

    public function __construct(BrandRepository $brands)
    {
        $this->brands = $brands;
    }

    public function create(BrandForm $form)
    {
        $brand = Brand::create(
            $form->name,
            $form->slug,
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

        $brand->edit($form->name, $form->slug, $form->meta);

        $this->brands->save($brand);
    }

    public function delete($id)
    {
        $brand = $this->brands->get($id);

        $this->brands->remove($brand);
    }
}