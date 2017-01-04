<?php

use yii\db\Migration;

class m170104_170439_db_init extends Migration {
    public function up() {
        $this->execute("CREATE TABLE `users` (
          `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `name` varchar(255) NOT NULL,
          `balance` decimal(10,2) NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

        $this->execute("INSERT INTO `users` (`name`, `balance`) VALUES ('user1', 100);");
        $this->execute("INSERT INTO `users` (`name`, `balance`) VALUES ('user2', 1000);");
        $this->execute("INSERT INTO `users` (`name`, `balance`) VALUES ('user3', 5000);");
    }

    public function down() {
        $this->execute("drop table users");
    }
}