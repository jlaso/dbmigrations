<?php


class migration_with_fixture_sample extends BaseMigration
{

    public function migrate($options = array())
    {
        $fixtures   = Fixture::getInstance()
          ->addFixture(array(
            "nick"     => 'user1',
            "email"    => 'user1@domain.com',
        ))->addFixture(array(
            "nick"     => 'user2',
            'email'    => 'user2@domain.com',
        ))->addFixture(array(
            "nick"     => 'user3',
            'email'    => 'user3@domain.com',
        ))->end();

        $sql = "INSERT INTO `user` (`nick`, `email`) VALUES ";
        $template = "( '%s', '%s' )";


        $index = 0;
        foreach ($fixtures as $fixture) {

            $sql .= ( $index ? "," : "") . sprintf($template,
                $fixture['nick'],
                $fixture['email']
            );
            $index++;

        }

        $this->execSql($sql);

        return true;

    }


}