<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\TimeHelper;
use App\Core\Validator;
use App\Core\Database;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class LoginController extends Controller
{
    protected string $table = 'register';
    protected ?string $token;
    protected ?object $statement;


    public function __construct()
    {
        parent::__construct();
        $this->statement = new Database();
        $this->statement = $this->statement->connection;
        $this->token = getallheaders()['Authorization'] ?? null;
    }
    public function login(): void
    {
        $nama_lengkap = $this->input->post('nama_lengkap');
        $password = $this->input->post('password');

        $validator = Validator::validate([
            'nama_lengkap' => [
                'required' => true,

            ],
            'password' => [
                'required' => true,
            ]
        ], [
            'nama_lengkap' => $nama_lengkap,
            'password' => $password
        ]);

        if ($validator->fails()) {
            $this->response(400, [
                'message' => 'Login failed',
                'errors' => $validator->errors()
            ]);
        }

        $user = $this->model('Reg')->findWhere([
            'nama_lengkap' => $nama_lengkap,
            'password' => md5($password)
        ]);
        if ($user) {
            $expiredTime = TimeHelper::setMinutes(30);
            $payload = [
                'exp' => $expiredTime,
                'data' => [
                    'id_reg' => $user->id_reg,
                    'nama_lengkap' => $user->nama_lengkap,
                ]
            ];
            $token = $this->generateToken($payload, $this->env->get('ACCESS_TOKEN_SECRET_KEY'));
            $this->response(200, [
                'token' => $token,
                'message' => 'Login success',
                'expired_time' => date('Y-m-d H:i:s', $expiredTime)
            ]);
        } else {
            $this->response(401, [
                'message' => 'Login failed'
            ]);
        }
    }

    public function check(): void
    {
        // jika token tidak ada
        if (!$this->token) {
            // membuat response
            $response = [
                'message' => 'Token tidak ada'
            ];
            http_response_code(401);
            echo json_encode($response, JSON_PRETTY_PRINT);
            exit;
        }

        // memecah token
        $token = explode(' ', $this->token);

        // jika token tidak sesuai
        if ($token[0] !== 'Bearer') {
            // membuat response
            $response = [
                'message' => 'Token tidak sesuai'
            ];
            http_response_code(401);
            echo json_encode($response, JSON_PRETTY_PRINT);
            exit;
        }

        // dekripsi / decrypt token
        try {
            $jwt = JWT::decode($token[1], new Key($_ENV['ACCESS_TOKEN_SECRET_KEY'], 'HS256'));
        } catch (\Exception $e) {
            // membuat response
            $response = [
                'message' => $e->getMessage()
            ];
            http_response_code(401);
            echo json_encode($response, JSON_PRETTY_PRINT);
            exit;
        }

        // cek jika data sesuai dengan database
        $query = "SELECT * FROM {$this->table} WHERE nama_lengkap = :nama_lengkap";
        $statement = $this->statement->prepare($query);
        // binding data
        $statement->bindParam(':nama_lengkap', $jwt->data->nama_lengkap);
        // eksekusi query
        $statement->execute();
        // jika data tidak ditemukan
        if ($statement->rowCount() === 0) {
            // membuat response
            $response = [
                'message' => 'Token tidak valid'
            ];
            http_response_code(401);
            echo json_encode($response, JSON_PRETTY_PRINT);
            exit;
        }

        // membuat response
        $response = [
            'message' => 'Token valid',
            'data' => $jwt->data
        ];
        http_response_code(200);
        echo json_encode($response, JSON_PRETTY_PRINT);
    }
    public function logout(): void
    {
        // cek token bearer
        if (!$this->token) {
            // membuat response
            $response = [
                'message' => 'Token tidak ada'
            ];
            http_response_code(401);
            echo json_encode($response, JSON_PRETTY_PRINT);
            exit;
        }

        $token = explode(' ', $this->token);
        // decode data token
        try {
            $jwt = JWT::decode($token[1], new Key($_ENV['ACCESS_TOKEN_SECRET_KEY'], 'HS256'));
        } catch (\Exception $e) {
            // membuat response
            $response = [
                'message' => $e->getMessage()
            ];
            http_response_code(401);
            echo json_encode($response, JSON_PRETTY_PRINT);
            exit;
        }

        // cek jika data sesuai dengan database
        $query = "SELECT * FROM {$this->table} WHERE nama_lengkap = :nama_lengkap";
        $statement = $this->statement->prepare($query);
        // binding data
        $statement->bindParam(':nama_lengkap', $jwt->data->nama_lengkap);
        // eksekusi query
        $statement->execute();
        // jika data tidak ditemukan
        if ($statement->rowCount() === 0) {
            // membuat response
            $response = [
                'message' => 'Token tidak valid'
            ];
            http_response_code(401);
            echo json_encode($response, JSON_PRETTY_PRINT);
            exit;
        }

        // membuat response
        $response = [
            'message' => 'Logout Berhasil'
        ];
        http_response_code(200);
        echo json_encode($response, JSON_PRETTY_PRINT);
    }

    public function reset(int $id)
    {
        $reg = $this->model('Reg')->find($id);
        if (!$reg) {
            $this->response(404, [
                'message' => 'User not found'
            ]);
        }else{
            $data = $this->input->put();
            $reset = $this->model('Reg')->update($id,$data);
            $this->response(200, [
                'message' => 'Password berhasil diubah',
                'data' => $reset,$data
            ]);
        }
    }

    public function lupaPassword(string $nama_lengkap)
    {
        $res= $this->model('Reg')->findWhere([
            'nama_lengkap' => $nama_lengkap,
        ]);
        if ($res == null)
        {
            $this->response(404, [
                'message' => 'nama_lengkap '.$nama_lengkap.' Tidak ditemukan'
            ]);
        }else
        {
            $query = "UPDATE `register` 
            SET password = :password
            WHERE nama_lengkap = :nama_lengkap";
            $statement = $this->statement->prepare($query);

            $pw = md5($this->input->put('password'));
            $statement->bindParam(':password', $pw);
            $statement->bindParam(':nama_lengkap', $nama_lengkap);
            $statement->execute();

            $this->response(200, [
                'message' => 'Password berhasil diubah menjadi '.$pw.'',
          
            ]);
        }
    }

}
