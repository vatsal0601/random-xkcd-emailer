<?php

use App\Email;
use App\User;

require_once __DIR__ . "/src/user.php";
require_once __DIR__ . "/src/email.php";

$user = new User('', '');
$users = $user->get_all_users();

echo '<pre>';
foreach ($users as $user) {
    echo "Sending email to {$user['name']} ({$user['email']})\n";
    $email = new Email($user['name'], $user['email']);
    $comic = $email->get_random_comic();
    $email->send_comic($comic['title'], $comic['alt'], $comic['url']);
    echo "Done\n\n";
}
echo '</pre>';
