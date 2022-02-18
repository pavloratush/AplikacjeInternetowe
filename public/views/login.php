<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <title>PROFILE PAGE</title>
</head>
<body>
<div class="container">
    <div class="logo">
        <img src="public/img/logo.svg">
    </div>

    <div class="login-register">
        <div class="login-container">
            <form class="login" action="login" method="POST">
                <div class="messages">
                    <?php if (isset($messages)) {
                        foreach ($messages as $message) {
                            echo $message;
                        }
                    }
                    ?>

                </div>

                <input name="email" type="text" placeholder="email@rmail.com">
                <input name="password" type="password" placeholder="password">
                <button type="submit">LOGIN</button>
                <div class="register-container">
                    <a href="register" class="register">REGISTER</a href>
                </div>
            </form>
        </div>
    </div>


</div>
</body>