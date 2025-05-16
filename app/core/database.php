<?php
class Database {
  public static function connect() {
    $config = require '../app/config/config.php';
    return new PDO("mysql:host={$config['host']};dbname={$config['dbname']}", $config['username'], $config['password']);
  }
}