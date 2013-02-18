<?php

/*
 *
 * @author Joseluis Laso <info@joseluislaso.es>
 *
 *  folder hierarchy
 *
 *  app
 *    - models
 *        - dbmigrations
 *          - migrations*
 *  vendor
 *    - Idiorm
 *  server.php
 *
 */

header("Content-type: text/plain; charset=utf-8");

$baseDir = dirname(dirname(dirname(dirname(__FILE__)))).'/';

if ( ! defined('FAKE') ) {
    require_once($baseDir.'vendor/Idiorm/idiorm.php');
    require_once($baseDir.'server.php');
    ORM::configure('driver_options', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
    ORM::configure('logging',true);
}

require_once('BaseMigration.php');
require_once('Fixture.php');

// find all migrations classes that rebuild entire DB at this moment
$entries = array();

define ('MIGRATIONS_DIR', dirname(dirname(__FILE__)) . '/migrations');
foreach (scandir(MIGRATIONS_DIR) as $entry)
{
    if ($entry!='.' && $entry!='..' && !is_dir(MIGRATIONS_DIR.'/'.$entry)) {
        if (preg_match('/migration(\d{14})/i',$entry,$matches)) {
            $entries[] = $matches[1];
        }
    }

}

/** @var $db PDO */
$db = ORM::get_db();

$exists = $db->query("SHOW TABLES LIKE 'version_info'")->fetch();

if ( ! $exists ) {

    $db->exec("CREATE TABLE `version_info` (
                  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                  `version` varchar(14) NOT NULL DEFAULT '',
                  PRIMARY KEY (`id`),
                  UNIQUE KEY `version` (`version`)
               ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

}

/**
 * Process Migration
 *
 * @param string $version
 *
 * @return bool
 */
function processMigration($version)
{
    $db = ORM::get_db();
    $migrateClass = "migration" . $version;
    $migrateFile  = MIGRATIONS_DIR . '/' . $migrateClass . '.php';
    //print $migrateFile . ' ';
    require $migrateFile;
    $migrate = new $migrateClass();
    $result  = $migrate->migrate(array(
        'db'        => $db,
        'version'   => $version,
    ));
    return $result;
}

// Find all records of version_info
$versionsInDb = ORM::for_table('version_info')->find_many();
$versions = array();
foreach ($versionsInDb as $versionInDb) {
    $versions[] = $versionInDb->version;
}

print "Processing migrations ..." . PHP_EOL;
print "=====================" . PHP_EOL . PHP_EOL;
// Process all migration class that are not process yet
foreach ($entries as $entry) {

    print ' - ' . $entry . ' ';

    if ( ! in_array($entry, $versions) ) {

        $result = processMigration($entry);
        print '... ';

        if ($result) {
            $sql = "INSERT INTO `version_info` (`version`) VALUES ('%s');";
            $db->exec(sprintf($sql, $entry));
            print " ok.";
        } else {
            print " failed.";
        }

    } else {
        print "skipped";
    }

    print PHP_EOL;

}

print PHP_EOL . "Migrating process finished." . PHP_EOL . PHP_EOL;