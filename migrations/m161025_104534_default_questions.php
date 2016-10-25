<?php

use yii\db\Migration;
use app\models\Question;

class m161025_104534_default_questions extends Migration
{
    public function up()
    {
        $this->batchInsert('questions', ['text', 'answer', 'dateSubmitted'], [
            ['Сколько сайтов в доменной зоне Северной Кореи?', 28, time()],
            ['Сколько бутылок кока-колы выпивают люди в мире в минуту?', 20000, time()],
            ['Сколько искусственных спутников сейчас работает на орбитах Марса?', 6, time()],
            ['Сколько человек погибло в давке на Ходынском поле во время раздачи подарков по случаю празднования коронации Николая II?', 1379, time()],
            ['Сколько было посетителей на сайте Медузы за сентябрь?', 5200000, time()],
        ]);
        Question::approveAll();
    }

    public function down()
    {
        $this->truncateTable('questions');
    }
}
