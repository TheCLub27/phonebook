<?php

use yii\db\Migration;

/**
 * Class m230828_005206_test_sixth_create_tabley
 */
class m230828_005206_test_sixth_create_tabley extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('test_people', [
            'id' => $this->primaryKey(),
            'last_name' => $this->string()->notNull(),
            'first_name' => $this->string()->notNull(),
            'surname' => $this->string()->notNull(),
            'time_of_last_edit' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->createTable('test_phones_number', [
            'id' => $this->primaryKey(),
            'phone_number' => $this->string(18)->notNull(),
            'person_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk_phones_people', 'test_phones_number', 'person_id', 'test_people', 'id', 'CASCADE', 'CASCADE');

        $this->insert('test_people', [
            'last_name' => 'Иванов',
            'first_name' => 'Иван',
            'surname' => 'Иванович',
        ]);

        $this->insert('test_people', [
            'last_name' => 'Петров',
            'first_name' => 'Петр',
            'surname' => 'Петрович',
        ]);

        $this->insert('test_people', [
            'last_name' => 'Алексеев',
            'first_name' => 'Алексей',
            'surname' => 'Алексеевич',
        ]);

        $this->insert('test_phones_number',[
            'phone_number' => '+7 (999) 00-909-00',
            'person_id' => 1,
        ]);

        $this->insert('test_phones_number',[
            'phone_number' => '+7 (999) 14-228-88',
            'person_id' => 2,
        ]);

        $this->insert('test_phones_number',[
            'phone_number' => '+7 (913) 11-222-33',
            'person_id' => 2,
        ]);

        $this->insert('test_phones_number',[
            'phone_number' => '+7 (800) 55-535-55',
            'person_id' => 3,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_phones_people', 'test_phones_number');
        $this->dropTable('test_people');
        $this->dropTable('test_phones_numbers');
        
    }
}
