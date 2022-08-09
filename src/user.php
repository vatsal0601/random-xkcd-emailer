<?php

declare(strict_types=1);

namespace App;

require_once dirname(__DIR__, 1) . "/configs/database.php";


class User
{
    public string $name;
    public string $email;

    function __construct(string $name, string $email)
    {
        $this->name = $name;
        $this->email = $email;
    }

    function validate_name(): array
    {
        $message = ['is_valid' => false, 'message' => ''];
        $validator = '/^[a-zA-Z ]+$/';
        if (empty($this->name)) {
            $message['message'] = 'Name cannot be empty';
            return $message;
        }
        if (preg_match($validator, $this->name)) {
            $message['is_valid'] = true;
            return $message;
        }
        $message['message'] = 'Name not valid';
        return $message;
    }

    function validate_email(): array
    {
        $message = ['is_valid' => false, 'message' => ''];
        $validator = '/^([a-z \d \. -]+)@([a-z \d -]+)\.([a-z]{2,})(\.[a-z]{2,})?$/';
        if (empty($this->email)) {
            $message['message'] = 'Email cannot be empty';
            return $message;
        }
        if (preg_match($validator, $this->email)) {
            $message['is_valid'] = true;
            return $message;
        }
        $message['message'] = 'Email not valid';
        return $message;
    }

    function check_email(): array
    {
        global $connection;
        $message = ['is_present' => true, 'message' => ''];
        $query = "SELECT * FROM User WHERE email='{$this->email}'";
        $res = mysqli_query($connection, $query);
        $counts = mysqli_num_rows($res);
        if ($counts > 0) {
            $message['message'] = 'Email already exists';
            return $message;
        }
        $message['is_present'] = false;
        return $message;
    }

    function generate_token(): string
    {
        $token = '';
        for ($i = 0; $i < 6; $i++)
            $token .= mt_rand(0, 9);
        session_start();
        $_SESSION['name'] = $this->name;
        $_SESSION['email'] = $this->email;
        $_SESSION['token'] = $token;
        return $token;
    }

    function validate_token(string $token): array
    {
        $message = ['is_valid' => false, 'message' => ''];
        if (isset($_SESSION['token']) && empty($token)) {
            $message['message'] = 'Token cannot be empty';
            return $message;
        }
        if (isset($_SESSION['token']) && $_SESSION['token'] !== $token) {
            $message['message'] = 'Invalid token';
            return $message;
        }
        $message['is_valid'] = true;
        return $message;
    }

    function add_user(): array
    {
        global $connection;
        $message = ['is_error' => true, 'message' => ''];
        $query = "INSERT INTO user (name, email) VALUES ('{$this->name}', '{$this->email}')";
        if (mysqli_query($connection, $query)) {
            $message['is_error'] = false;
            return $message;
        }
        $message['message'] = mysqli_error($connection);
        return $message;
    }

    function delete_user(): array
    {
        global $connection;
        $message = ['is_error' => true, 'message' => ''];
        $query = "DELETE FROM user WHERE email='{$this->email}'";
        if (mysqli_query($connection, $query)) {
            $message['is_error'] = false;
            return $message;
        }
        $message['message'] = mysqli_error($connection);
        return $message;
    }

    function get_all_users(): array
    {
        global $connection;
        $query = 'SELECT name, email FROM user';
        $res = mysqli_query($connection, $query);
        $users = mysqli_fetch_all($res, MYSQLI_ASSOC);
        return $users;
    }
}
