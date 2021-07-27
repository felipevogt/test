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
        $this->host     = 'localhost';
        $this->port     = '3306';
        $this->db       = 'prueba_felipe_vogt';
        $this->user     = 'root';
        $this->password = '';
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
