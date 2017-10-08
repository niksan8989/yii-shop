<?php

namespace shop\services\manage\Shop;


use shop\entities\Shop\Tag;
use shop\forms\manage\Shop\TagForm;
use shop\repositories\Shop\TagRepository;
use yii\helpers\Inflector;

class TagManageService
{
    private $tags;

    public function __construct(TagRepository $tags)
    {
        $this->tags = $tags;
    }

    public function create(TagForm $form)
    {
        $tag = Tag::create(
            $form->name,
            $form->slug ? $form->slug : Inflector::slug($form->name)
        );

        $this->tags->save($tag);

        return $tag;
    }

    public function edit($id, TagForm $form)
    {
        $tag = $this->tags->get($id);

        $tag->edit(
            $form->name,
            $form->slug ? $form->slug : Inflector::slug($form->name)
        );

        $this->tags->save($tag);
    }

    public function remove($id)
    {
        $tag = $this->tags->get($id);
        $this->tags->delete($tag);
    }
}