<?php

use App\User;

require_once __DIR__ . "/src/user.php";

if (!isset($_GET['type']))
    header('Location: index.php');

if ($_GET['type'] === 'unsubscribe' && !isset($_GET['email']))
    header('Location: index.php');

if ($_GET['type'] === 'unsubscribe') {
    $user = new User('', $_GET['email']);
    $is_present = $user->check_email();

    if ($is_present['is_present']) {
        $delete_user = $user->delete_user();
        if ($delete_user['is_error']) {
            echo $delete_user['message'];
            return;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emaaail - Success</title>
    <link rel="icon" href="./assets/favicon.ico" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/reset.css">
    <link rel="stylesheet" href="./assets/css/styles.css">
</head>

<body>
    <?php include __DIR__ . "/components/navbar.php"; ?>
    <main class="container main">
        <section class="hero">
            <h1 class="display hero-heading">
                Get comics in <span class="blue">your email</span>
            </h1>
            <?php echo isset($_GET['type']) && $_GET['type'] === 'subscribe' ? "<p class='p hero-text'>You&apos;ve subscribed to Emaaail successfully. We&apos;'ll email you every 5 minutes with random webcomic.</p>" : "<p class='p hero-text'>You&apos;ve unsubscribed from Emaaail successfully. From now on we&apos;'ll not send you email every 5 minutes with random webcomic.</p>" ?>
        </section>
    </main>
    <?php include __DIR__ . "/components/footer.php"; ?>
</body>

</html>
