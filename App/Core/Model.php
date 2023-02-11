<?php

namespace App\Core;

use App\Core\Database;
use PDO;

class Model
{
    protected object $statement;
    protected string $table;
    protected string $primaryKey;

    public function __construct()
    {
        $this->statement = new Database();
        $this->statement = $this->statement->connection;
    }

    public function all(): array
    {
        $query = "SELECT * FROM {$this->table}";
        $statement = $this->statement->prepare($query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function find(int $id) : object
    {
        $query = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id";
        $statement = $this->statement->prepare($query);
        $statement->bindParam(':id', $id);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_OBJ);
    }

    public function findWhere(array $data)
    {
        $query = "SELECT * FROM {$this->table} WHERE ";
        $query .= implode(' AND ', array_map(function ($key) {
            return $key . ' = :' . $key;
        }, array_keys($data)));
        $statement = $this->statement->prepare($query);
        foreach ($data as $key => $value) {
            $statement->bindValue(':' . $key, $value);
        }
        $statement->execute();
        return $statement->fetch(PDO::FETCH_OBJ);
    }

    public function row(): int
    {
        $query = "SELECT * FROM {$this->table}";
        $statement = $this->statement->prepare($query);
        $statement->execute();
        return $statement->rowCount();
    }

    public function create(array $data): bool
    {
        $query = "INSERT INTO {$this->table} SET ";
        $query .= implode(', ', array_map(function ($key) {
            return $key . ' = :' . $key;
        }, array_keys($data)));
        $statement = $this->statement->prepare($query);
        foreach ($data as $key => $value) {
            $statement->bindValue(':' . $key, $value);
        }
        return $statement->execute();
    }

    public function update(int $id, array $data): bool
    {
        $query = "UPDATE {$this->table} SET ";
        $query .= implode(', ', array_map(function ($key) {
            return $key . ' = :' . $key;
        }, array_keys($data)));
        $query .= " WHERE {$this->primaryKey} = :id";
        $statement = $this->statement->prepare($query);
        foreach ($data as $key => $value) {
            $statement->bindValue(':' . $key, $value);
        }
        $statement->bindValue(':id', $id);
        return $statement->execute();
    }

    public function delete(int $id): bool
    {
        $query = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id";
        $statement = $this->statement->prepare($query);
        $statement->bindValue(':id', $id);
        return $statement->execute();
    }

    public function pro(int $id)
    {
        $query = "SELECT
        `peserta`.`id_peserta`,
        `profile_peserta`.`nama_lengkap`, 
        `profile_peserta`.`tempat_lahir`, 
        `profile_peserta`.`tanggal_lahir`, 
        `profile_peserta`.`agama`,
        `profile_peserta`.`jenis_kelamin`,
        `profile_peserta`.`alamat`,
        `profile_peserta`.`nisn`,
        `profile_peserta`.`prodi`, 
        `profile_peserta`.`citacita`, 
        `profile_peserta`.`motivasi`
        FROM `peserta`
            , `profile_peserta`
            WHERE `peserta`.`id_peserta` = `profile_peserta`.`id_profile`";
        $statement = $this->statement->prepare($query);
        $statement->bindParam(':id', $id);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function reg()
    {
        $nama_lengkap = $_POST['nama_lengkap'];
        $no_telepon = $_POST['no_telepon'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $query = "INSERT INTO {$this->table} 
        (nama_lengkap, no_telepon, email, password) 
        VALUES
        (:nama_lengkap, :no_telepon, :email, :password)";
        $statement = $this->statement->prepare($query);

        $pw = md5($password);
        $statement->bindParam(':nama_lengkap', $nama_lengkap);
        $statement->bindParam(':no_telepon', $no_telepon);
        $statement->bindParam(':email', $email);
        $statement->bindParam(':password', $pw);
        return $statement->execute();
        
    }

}
