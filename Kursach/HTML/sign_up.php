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
    <link
      href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />
    <title>Регистрация</title>
    <link rel="stylesheet" href="../CSS/style.css" />
</head>
<body>
    <div class="log">
        <img src="" alt="" />
        <div class="main">
            <form action="../src/actions/sign_up.php" class="card" method="post">
                <h2>Register</h2>
                <div class="inputbox">
                    <input 
                    type="text" 
                    name="name" 
                    value="<?php echo old('name') ?>"
                    <?php validationErrorAttr('name'); ?>
                    />
                    <?php if(hasValidationError('name')): ?>
                        <span class="error-message"><?php validationErrorMessage('name'); ?></span>
                    <?php endif; ?>
                    <label for="">Name</label>
                </div>
                <div class="inputbox">
                    <input 
                    type="email" 
                    name="email"
                    value="<?php echo old('email') ?>"
                    <?php validationErrorAttr('email'); ?>
                    />
                    <?php if(hasValidationError('email')): ?>
                        <span class="error-message"><?php validationErrorMessage('email'); ?></span>
                    <?php endif; ?>
                    <label for="">Email</label>
                </div>
                <div class="inputbox">
                    <input 
                    type="text" 
                    name="phone"
                    value="<?php echo old('phone') ?>"
                    <?php validationErrorAttr('phone'); ?>
                    />
                    <?php if(hasValidationError('phone')): ?>
                        <span class="error-message"><?php validationErrorMessage('phone'); ?></span>
                    <?php endif; ?>
                    <?php if(hasValidationError('phone') && empty(validationErrorMessage('phone'))): ?>
                        <span class="error-message">Номер телефона должен содержать ровно 12 символов</span>
                    <?php endif; ?>
                    <label for="">Phone</label>
                </div>
                <div class="inputbox password_fields">
                    <input 
                    type="password" 
                    name="password"
                    <?php validationErrorAttr('password'); ?>
                    />
                    <?php if(hasValidationError('password')): ?>
                        <span class="error-message"><?php validationErrorMessage('password'); ?></span>
                    <?php endif; ?>
                    <label for="">Password</label>
                    <div class="inputbox password_fields">
                        <input 
                        type="password" 
                        name="conf_pass"
                        <?php validationErrorAttr('password'); ?>
                        />
                        <?php if(hasValidationError('password')): ?>
                        <small><?php validationErrorMessage('password'); ?></small>
                    <?php endif; ?>
                        <label for="">Confirm Password</label>
                    </div>
                </div>
                <button type="submit">Sign up</button>
            </form>
        </div>
    </div>
</body>
</html>
