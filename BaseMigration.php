<?php


/**
 * BaseMigration for db migration process
 *
 * @date 2013-02-08
 * @author Joseluis Laso <info@joseluislaso.es>
 */
class BaseMigration
{


    /**
     * Process sql statement
     *
     * @param string $sql
     */
    protected function execSql($sql)
    {

        $db = ORM::get_db();

        try {

            $db->exec($sql);

        } catch (Exception $e) {

            die($e->getMessage() . PHP_EOL . $sql);

        }


    }


}