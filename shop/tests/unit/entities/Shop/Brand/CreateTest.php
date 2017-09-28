<?php
namespace shop\tests\unit\entities\Shop\Tag;

use Codeception\Test\Unit;
use shop\entities\Meta;

class CreateTest extends Unit
{
    public function testSuccess()
    {
        $tag = Brand::create(
            $name = 'Name',
            $slug = 'slug',
            $meta = new Meta('Title', 'Description', 'Keywords')
        );

        $this->assertEquals($name, $tag->name);
        $this->assertEquals($slug, $tag->slug);
    }
}