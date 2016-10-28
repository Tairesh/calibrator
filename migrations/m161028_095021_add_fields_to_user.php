<?php

use yii\db\Migration;

class m161028_095021_add_fields_to_user extends Migration
{
    
    public function safeUp()
    {
        $this->renameTable('users', 'users_old');
        $this->createTable('users', [
            'id' => 'INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL',
            'name' => 'VARCHAR(255) NOT NULL',
            'photo' => 'VARCHAR(255) NOT NULL',
            'gender' => 'UNSIGNED INTEGER(1) NOT NULL DEFAULT 0',
            'score' => 'REAL NOT NULL DEFAULT 0',
            'answersCount' => 'UNSIGNED REAL NOT NULL DEFAULT 0',
            'ninetyCount' => 'UNSIGNED INTEGER NOT NULL DEFAULT 0',
            'fiftyCount' => 'UNSIGNED INTEGER NOT NULL DEFAULT 0',
            'role' => 'UNSIGNED INTEGER(1) NOT NULL DEFAULT 0',
            'questionsCount' => 'UNSIGNED INTEGER NOT NULL DEFAULT 0',
        ]);
        $this->execute('
            INSERT INTO users
                (id, name, score, answersCount, ninetyCount, fiftyCount, photo)
            SELECT 
                id, name, score, answersCount, ninetyCount, fiftyCount, \'http://placehold.it/50x50\'
            FROM users_old
        ');
        $this->dropTable('users_old');
    }

    public function safeDown()
    {
        $this->renameTable('users', 'users_old');
        $this->createTable('users', [
            'id' => 'INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL',
            'name' => 'VARCHAR(255) NOT NULL',
            'score' => 'REAL NOT NULL DEFAULT 0',
            'answersCount' => 'UNSIGNED REAL NOT NULL DEFAULT 0',
            'ninetyCount' => 'UNSIGNED INTEGER NOT NULL DEFAULT 0',
            'fiftyCount' => 'UNSIGNED INTEGER NOT NULL DEFAULT 0',
        ]);
        $this->execute('
            INSERT INTO users
                (id, name, score, answersCount, ninetyCount, fiftyCount)
            SELECT 
                id, name, score, answersCount, ninetyCount, fiftyCount 
            FROM users_old
        ');
        $this->dropTable('users_old');
    }
    
}
