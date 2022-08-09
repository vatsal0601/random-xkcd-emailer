<?php

use App\Email;
use App\User;

require_once __DIR__ . "./src/user.php";
require_once __DIR__ . "./src/email.php";

if (isset($_POST['name']) && isset($_POST['email'])) {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    $user = new User($name, $email);
    $is_name_valid = $user->validate_name();
    $is_email_valid = $user->validate_email();
    $is_present = $user->check_email();

    if ($is_name_valid['is_valid'] && $is_email_valid['is_valid'] && !$is_present['is_present']) {
        $token = $user->generate_token();
        $email = new Email($name, $email);
        $res = $email->send_token($token);
        header('Location: token-verification.php');
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emaaail - Getting Started</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/reset.css">
    <link rel="stylesheet" href="./assets/css/styles.css">
    <script src="./assets/js/getting-started.js" defer></script>
</head>

<body>
    <?php include __DIR__ . "./components/navbar.php"; ?>
    <main class="container main">
        <section class="hero">
            <h1 class="display hero-heading">
                Get comics in <span class="blue">your email</span>
            </h1>
            <?php echo isset($is_present['is_present']) && $is_present['is_present'] ?
                "<div class='small error-block'>
                    <svg xmlns='http://www.w3.org/2000/svg' class='button-svg' viewBox='0 0 20 20' fill='currentColor'>
                        <path fill-rule='evenodd' d='M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z' clip-rule='evenodd' />
                    </svg>
                    <span>{$is_present['message']}</span>
                </div>" : null
            ?>
            <?php echo isset($is_name_valid['is_valid']) && !$is_name_valid['is_valid'] ?
                "<div class='small error-block'>
                    <svg xmlns='http://www.w3.org/2000/svg' class='button-svg' viewBox='0 0 20 20' fill='currentColor'>
                        <path fill-rule='evenodd' d='M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z' clip-rule='evenodd' />
                    </svg>
                    <span>{$is_name_valid['message']}</span>
                </div>" : null
            ?>
            <?php echo isset($is_email_valid['is_valid']) && !$is_email_valid['is_valid'] ?
                "<div class='small error-block'>
                    <svg xmlns='http://www.w3.org/2000/svg' class='button-svg' viewBox='0 0 20 20' fill='currentColor'>
                        <path fill-rule='evenodd' d='M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z' clip-rule='evenodd' />
                    </svg>
                    <span>{$is_email_valid['message']}</span>
                </div>" : null
            ?>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="form" user-form>
                <div class="small">
                    <label for="name" class="input-label">
                        Name
                    </label>
                    <input type="text" name="name" id="name" placeholder="Name" class="input" name-input>
                    <p class="small input-error" name-error></p>
                </div>
                <div class="small">
                    <label for="email" class="input-label">
                        Email
                    </label>
                    <input type="email" name="email" id="email" placeholder="Email" class="input" email-input>
                    <p class="small input-error" email-error></p>
                </div>
                <button class="button">Send Comics</button>
            </form>
        </section>
    </main>
    <?php include __DIR__ . "./components/footer.php"; ?>
</body>

</html>
