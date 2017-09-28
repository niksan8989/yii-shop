<?php

namespace shop\services\manage;


use backend\forms\manage\Shop\TagForm;
use shop\entities\Shop\Tag\Tag;
use shop\repositories\Shop\Tag\TagRepository;
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