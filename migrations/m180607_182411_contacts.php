<?php

use yii\db\Migration;

/**
 * Class m180607_182411_contacts
 */
class m180607_182411_contacts extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180607_182411_contacts cannot be reverted.\n";

        return false;
    }

    
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {		
		return $this->createTable('contacts', array(
		'id' => 'INT PRIMARY KEY AUTO_INCREMENT',
		'name' => 'VARCHAR(255)',
		'email' => 'VARCHAR(255)',
		'subject' => 'VARCHAR(255)',
		'body' => 'TEXT',
		'created_on' => 'TIMESTAMP',
		'updated_on' => 'TIMESTAMP'
		
	));
    }

    public function down()
    {
        return $this->dropTable('contacts');
    }
    
}
