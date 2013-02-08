<?php

/**
 *
 * Copy this file in ../../server.php and fix correct data for db access
 *
 * @author Joseluis Laso <info@joseluislaso.es>
 *
 */

ORM::configure('mysql:host=localhost;dbname=database');
ORM::configure('username', 'root');
ORM::configure('password', 'root');
