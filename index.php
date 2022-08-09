<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emaaail</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/reset.css">
    <link rel="stylesheet" href="./assets/css/styles.css">
    <script src="./assets/js/index.js" defer></script>
</head>

<body>
    <?php include __DIR__ . "./components/navbar.php"; ?>
    <main class="container main">
        <section class="hero">
            <h1 class="display hero-heading">
                Get comics in <span class="blue">your email</span>
            </h1>
            <p class="p hero-text">
                Just enter your email address and we&apos;ll send you webcomic every 5 minutes.
            </p>
            <button class="small button hero-button" get-started>
                <span>Get Started</span>
                <svg class="button-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </section>
    </main>
    <?php include __DIR__ . "./components/footer.php"; ?>
</body>

</html>
