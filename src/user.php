<?php

declare(strict_types=1);

namespace App;

require_once dirname(__DIR__, 1) . '/configs/database.php';


class User
{
    public string $name;
    public string $email;

    public function __construct(string $name, string $email)
    {
        $this->name = $name;
        $this->email = $email;
    }

    public function validate_name(): array
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

    public function validate_email(): array
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

    public function check_email(): array
    {
        global $connection;
        $message = ['is_present' => true, 'message' => ''];
        $query = $connection->prepare('SELECT COUNT(email) as email FROM user WHERE email = ?');
        $query->bind_param('s', $this->email);
        $query->execute();
        $count = $query->get_result();
        $count = $count->fetch_all(MYSQLI_ASSOC);
        if ($count[0]['email'] > 0) {
            $message['message'] = 'Email already exists';
            return $message;
        }
        $message['is_present'] = false;
        return $message;
    }

    public function generate_token(): string
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

    public function validate_token(string $token): array
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

    public function add_user(): array
    {
        global $connection;
        $message = ['is_error' => true, 'message' => ''];
        $query = $connection->prepare('INSERT INTO user (name, email) VALUES (?, ?)');
        $query->bind_param('ss', $this->name, $this->email);
        if ($query->execute()) {
            $message['is_error'] = false;
            return $message;
        }
        $message['message'] = $connection->error;
        return $message;
    }

    public function delete_user(): array
    {
        global $connection;
        $message = ['is_error' => true, 'message' => ''];
        $query = $connection->prepare('DELETE FROM user WHERE email = ?');
        $query->bind_param('s', $this->email);
        if ($query->execute()) {
            $message['is_error'] = false;
            return $message;
        }
        $message['message'] = $connection->error;
        return $message;
    }

    public function get_all_users(): array
    {
        global $connection;
        $query = $connection->prepare('SELECT name, email FROM user');
        $query->execute();
        $users = $query->get_result();
        $users = $users->fetch_all(MYSQLI_ASSOC);
        return $users ? $users : [];
    }
}
