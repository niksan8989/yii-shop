<?php

use yii\db\Migration;

class m171009_182340_add_shop_product_description_field extends Migration
{
    public function up()
    {
        $this->addColumn('{{%shop_products}}', 'description', $this->text()->after('name'));
    }
    public function down()
    {
        $this->dropColumn('{{%shop_products}}', 'description');
    }
}
