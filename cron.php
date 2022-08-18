<?php

use App\Email;
use App\User;

require_once __DIR__ . '/src/user.php';
require_once __DIR__ . '/src/email.php';

if (isset($_GET['secret']) && $_GET['secret'] === $_ENV['CRON_SECRET']) {
    $user = new User('', '');
    $users = $user->get_all_users();

    foreach ($users as $user) {
        $email = new Email($user['name'], $user['email']);
        $comic = $email->get_random_comic();
        $email->send_comic($comic['title'], $comic['alt'], $comic['url']);
    }
    echo 'OK';
} else
    echo 'Unauthorised access';
