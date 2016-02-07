<?php

use yii\db\Schema;
use yii\db\Migration;

class m160206_182829_create_tables extends Migration
{
    /*public function up()
    {}

    public function down()
    {}*/
    private $humansTable = 'human';
    private $familiesTable = 'family';

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable($this->familiesTable, [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING .' NOT NULL'
        ]);

        $this->createTable($this->humansTable, [
            'id' => Schema::TYPE_PK,
            'id_ancestry_family' => Schema::TYPE_INTEGER
                .' references '. $this->familiesTable .'(id) DEFAULT NULL',//семья родителей
            'id_descendant_family' => Schema::TYPE_INTEGER
                .' references '. $this->familiesTable .'(id) DEFAULT NULL',//собственная семья
            'name' => Schema::TYPE_STRING .'(50) NOT NULL',
            'surname' => Schema::TYPE_STRING .'(100) NOT NULL',
            'ancestry' => 'ltree'
        ]);
    }

    public function safeDown()
    {
        $this->dropTable($this->humansTable);
        $this->dropTable($this->familiesTable);
    }

}
