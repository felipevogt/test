<?php

include_once 'db.php';

//Clase para ejecutar las consultas sql
class Usuario extends DB
{

    function nuevoUsuario($usuario)
    {
        $query = $this->connect()->prepare('INSERT INTO usuario (correo, password) VALUES (:correo, :password)');
        $query->execute([
            'correo' => $usuario['correo'],
            'password' => password_hash($usuario['password'], PASSWORD_DEFAULT),
        ]);
        return $query;
    }

    function obtenerUsuario($user)
    {
        $query = $this->connect()->prepare('SELECT * FROM usuario WHERE correo = :correo');
        $query->execute(['correo' => $user['correo']]);
        return $query;
    }

    function crearToken($data)
    {
        $query = $this->connect()->prepare('INSERT INTO usuario_token (token, fecha, estado, id_usuario) VALUES (:token, :fecha, :estado, :id_usuario)');
        $query->execute([
            'token' => $data['token'],
            'fecha' => $data['fecha'],
            'estado' => $data['estado'],
            'id_usuario' => $data['id_usuario'],
        ]);
        return $query;
    }

    function buscarToken($token)
    {
        $query = $this->connect()->query("SELECT * FROM usuario_token WHERE token='$token' AND estado='1'");
        return $query;
    }

    function actualizarToken($token)
    {
        $query = $this->connect()->prepare('UPDATE usuario_token SET fecha=:fecha WHERE id=:id');
        $query->execute([
            'id' => $token['id'],
            'fecha' => $token['fecha'],
        ]);
        return $query;
    }
}
