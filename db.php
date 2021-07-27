<?php

/**Clase para la conexion a la bd */
class DB
{
    private $host;
    private $db;
    private $user;
    private $password;
    private $charset;

    public function __construct()
    {
        $this->host     = 'bhmcgn0almtrwclc8kdg-mysql.services.clever-cloud.com';
        $this->port     = '3306';
        $this->db       = 'bhmcgn0almtrwclc8kdg';
        $this->user     = 'urjpfmwk56bbf931';
        $this->password = 'RqhO2kWDEJAy2n5wXZe5';
        $this->charset  = 'utf8mb4';
    }

    function connect()
    {

        try {
            $connection = "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db . ";charset=" . $this->charset;
            $pdo = new PDO($connection, $this->user, $this->password);
            return $pdo;
        } catch (PDOException $e) {
            print_r('Error connection: ' . $e->getMessage());
        }
    }
}
