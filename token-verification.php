<?php

use App\User;

require_once __DIR__ . "/src/user.php";

session_start();

if (!isset($_SESSION['name']) && !isset($_SESSION['email']) && !isset($_SESSION['token'])) {
    header('Location: getting-started.php');
}

if (isset($_POST['verification-code'])) {
    $token = filter_input(INPUT_POST, 'verification-code', FILTER_SANITIZE_SPECIAL_CHARS);

    $user = new User($_SESSION['name'], $_SESSION['email']);
    $is_token_valid = $user->validate_token($token);

    if ($is_token_valid['is_valid']) {
        $add_user = $user->add_user();
        if ($add_user['is_error']) {
            echo $add_user['message'];
            return;
        }
        session_destroy();
        header('Location: success.php?type=subscribe');
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emaaail - Token Verification</title>
    <link rel="icon" href="./assets/favicon.ico" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/reset.css">
    <link rel="stylesheet" href="./assets/css/styles.css">
    <script src="./assets/js/token-verification.js" defer></script>
</head>

<body>
    <?php include __DIR__ . "/components/navbar.php"; ?>
    <main class="container main">
        <section class="hero">
            <h1 class="display hero-heading">
                Get comics in <span class="blue">your email</span>
            </h1>
            <p class="p hero-text">We&apos;ve sent you an email with a 6 digit verification code; please enter it below.</p>
            <?php echo isset($is_token_valid['is_valid']) && !$is_token_valid['is_valid'] ?
                "<div class='small error-block'>
                    <svg xmlns='http://www.w3.org/2000/svg' class='button-svg' viewBox='0 0 20 20' fill='currentColor'>
                        <path fill-rule='evenodd' d='M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z' clip-rule='evenodd' />
                    </svg>
                    <span>{$is_token_valid['message']}</span>
                </div>" : null
            ?>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="form" verification-form>
                <div class="small">
                    <label for="verification-code" class="input-label">
                        Verification code
                    </label>
                    <input type="text" id="verification-code" name="verification-code" placeholder="Verification Code" class="input" verification-input>
                    <p class="small input-error" verification-error></p>
                </div>
                <button class="button">Verifiy Email</button>
            </form>
        </section>
    </main>
    <?php include __DIR__ . "/components/footer.php"; ?>
</body>

</html>
