<?php


class migration_sample extends BaseMigration
{


    public function migrate($options = array())
    {

        $this->execSql("There the sql sentences");

        return true;

    }


}