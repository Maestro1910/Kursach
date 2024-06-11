<?php

require_once __DIR__ . '/../src/helpers.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet" />
    <title>Авторизация</title>
    <link rel="stylesheet" href="../CSS/style.css" />
</head>
<body>
    <div class="log">
        <img src="" alt="" />
        <div class="main">
            <form class="card" action="../src/actions/log_in.php" method="post">
                <h2>Login</h2>

                <?php if(hasMessage('error')): ?>
                    <div class="notice-error"><?php echo getMessage('error'); ?></div>
                <?php endif; ?>

                <div class="inputbox">
                    <input 
                        type="email"
                        name="email" 
                        value="<?php echo old('email') ?>"
                        <?php validationErrorAttr('email'); ?>
                    />
                    <label for="email">Email</label>
                    <?php if(hasValidationError('email')): ?>
                        <label class="error-message" for="email"><?php validationErrorMessage('email'); ?></label>
                    <?php endif; ?>
                </div>

                <div class="inputbox">
                    <input
                        type="password"
                        name="password"
                        <?php validationErrorAttr('password'); ?>
                    />
                    <label for="password">Password</label>
                    <?php if(hasValidationError('password')): ?>
                        <label class="error-message" for="password"><?php validationErrorMessage('password'); ?></label>
                    <?php endif; ?>
                </div>
                <button>Log in</button>
                <div class="log_in">
                    <p>У вас нет учетной записи? <a href="/Kursach/HTML/sign_up.php">Регистрация</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
