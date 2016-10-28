<?php

use yii\db\Migration;

class m161028_102543_add_fields_to_question extends Migration
{
    
    public function safeUp()
    {
        $this->renameTable('questions', 'questions_old');
        $this->createTable('questions', [
            'id' => 'INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL',
            'text' => 'TEXT NOT NULL',
            'answer' => 'REAL NOT NULL',
            'source' => 'VARCHAR(255) DEFAULT NULL',
            'submitterId' => 'INTEGER REFERENCES users(id) DEFAULT NULL',
            'dateSubmitted' => 'UNSIGNED INTEGER NOT NULL',
            'dateApproved' => 'UNSIGNED INTEGER DEFAULT NULL',
        ]);
        $this->execute('
            INSERT INTO questions
                (id, text, answer, dateSubmitted, dateApproved)
            SELECT 
                id, text, answer, dateSubmitted, dateApproved
            FROM questions_old
        ');
        $this->dropTable('questions_old');
    }

    public function safeDown()
    {
        $this->renameTable('questions', 'questions_old');
        $this->createTable('questions', [
            'id' => 'INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL',
            'text' => 'TEXT NOT NULL',
            'answer' => 'REAL NOT NULL',
            'dateSubmitted' => 'UNSIGNED INTEGER NOT NULL',
            'dateApproved' => 'UNSIGNED INTEGER DEFAULT NULL',
        ]);
        $this->execute('
            INSERT INTO questions
                (id, text, answer, dateSubmitted, dateApproved)
            SELECT 
                id, text, answer, dateSubmitted, dateApproved
            FROM questions_old
        ');
        $this->dropTable('questions_old');
    }
    
}
