<?php

use yii\db\Migration;

class m161025_081227_start extends Migration
{
    public function up()
    {
        $this->createTable('users', [
            'id' => 'INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL',
            'name' => 'VARCHAR(255) NOT NULL',
            'score' => 'REAL NOT NULL DEFAULT 0',
            'answersCount' => 'UNSIGNED REAL NOT NULL DEFAULT 0',
        ]);
        $this->createIndex('usersScore', 'users', ['score']);
        $this->createIndex('usersAnswersCount', 'users', ['answersCount']);
        
        $this->createTable('accounts', [
            'id' => 'INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL',
            'userId' => 'UNSIGNED INTEGER REFERENCES users(id) NOT NULL',
            'sourceType' => 'UNSIGNED INTEGER(1) NOT NULL',
            'sourceId' => 'VARCHAR(255) NOT NULL'
        ]);
        $this->createIndex('accountsSources', 'accounts', ['sourceType', 'sourceId'], true);
        
        $this->createTable('questions', [
            'id' => 'INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL',
            'text' => 'TEXT NOT NULL',
            'answer' => 'REAL NOT NULL',
            'answersCount' => 'UNSIGNED INTEGER NOT NULL DEFAULT 0',
            'ninetyCount' => 'UNSIGNED INTEGER NOT NULL DEFAULT 0',
            'fiftyCount' => 'UNSIGNED INTEGER NOT NULL DEFAULT 0',
            'dateSubmitted' => 'UNSIGNED INTEGER NOT NULL',
            'dateApproved' => 'UNSIGNED INTEGER DEFAULT NULL',
        ]);
        $this->createIndex('questionsText', 'questions', ['text']);
        
        $this->createTable('answers', [
            'id' => 'INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL',
            'userId' => 'UNSIGNED INTEGER REFERENCES users(id) NOT NULL',
            'questionId' => 'UNSIGNED INTEGER REFERENCES questions(id) NOT NULL',
            'fiftyStart' => 'REAL NOT NULL',
            'fiftyEnd' => 'REAL NOT NULL',
            'ninetyStart' => 'REAL NOT NULL',
            'ninetyEnd' => 'REAL NOT NULL',
            'isCorrect' => 'UNSIGNED INTEGER(1) NOT NULL',
            'score' => 'REAL NOT NULL',
            'dateSubmitted' => 'UNSIGNED INTEGER NOT NULL',
        ]);
        $this->createIndex('answerUserQuestion', 'answers', ['userId', 'questionId'], true);
    }

    public function down()
    {
        $this->dropTable('users');
        $this->dropTable('accounts');
        $this->dropTable('questions');
        $this->dropTable('answers');
    }

}
