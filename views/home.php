<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light dark">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <title>Home Page</title>
</head>

<body>

    <header class="class container">
        <hgroup>
            <h1>Home Page</h1>
            <h2>Welcome</h2>
            <p>This is the home page, where you can either login or register</p>
        </hgroup>
        <nav>
            <ul>
                <li>
                    <details class="dropdown">
                        <summary role="button" class="primary">Theme</summary>
                        <ul>
                            <li><a href="#" data-theme-switcher="auto">Auto</a></li>
                            <li><a href="#" data-theme-switcher="light">Light</a></li>
                            <li><a href="#" data-theme-switcher="dark">Dark</a></li>
                        </ul>
                    </details>
                </li>
            </ul>
        </nav>
    </header>
    <!-- ./ Header -->

    <!-- ./ Main -->
    <main class="container">
        <!-- ./ Preview -->
        <section id="preview">
            <h2>Preview</h2>
            <br>
            <h3>Register :</h3>
            <p>If you haven't an account yet, you can register with the button bellow</p>
            <button class="primary" onclick="location.href = 'register';">Register</button>

            <br>
            <h3>Log in :</h3>
            <p>Log in to your account : </p>
        </section>
    </main>
    <!-- ./ Preview -->




    <!-- 
    <div id="parent">
        <h2>This is the home page while you are log out:</h2>
        <div id="btn">
            <button class="btn" onclick="location.href = 'register';">Register</button>
            <button class="btn" onclick="location.href = 'login';">Login</button>
        </div>
    </div>
 -->
</body>

</html>