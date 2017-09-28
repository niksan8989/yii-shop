<?php
namespace shop\repositories\Shop\Tag;

use SebastianBergmann\GlobalState\RuntimeException;
use shop\entities\Shop\Tag\Tag;
use shop\repositories\NotFoundException;

class TagRepository
{
    public function get($id): Tag
    {
        if (!$tag = Tag::findOne($id)) {
            throw new NotFoundException('Tag is not found');
        }

        return $tag;
    }

    public function save(Tag $tag): void
    {
        if(!$tag->save()){
            throw new \RuntimeException('Saving error');
        }
    }

    public function delete(Tag $tag): void
    {
        if(!$tag->delete()){
            throw new \RuntimeException('Removing error');
        }
    }
}