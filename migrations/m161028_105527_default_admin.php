<?php

use yii\db\Migration;

class m161028_105527_default_admin extends Migration
{
    public function up()
    {
        $this->update('users', ['role' => 2], ['id' => 1]);
    }

    public function down()
    {
        
    }

}
