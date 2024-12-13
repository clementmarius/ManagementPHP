<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="color-scheme" content="light dark" />
    <!-- Pico.css -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@picocss/pico@2.0.6/css/pico.min.css" />
    <title>Main Page</title>
</head>

<body>

    <!-- ./ Header -->
    <header class="class container">
        <hgroup>
            <h1>Home Page</h1>
            <h2>Welcome</h2>
            <p>This is the home page, more coming soon..</p>
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
            <h3>Create post :</h3>
            <p>You can add a post to your wall</p>
            <div class="grid">
                <button class="primary" onclick="location.href = 'localhost/PhpPoo/ManagementPHP/views/create_post.php';" id="myButton" class="float-left submit-button">Create Post</button>

            </div>

            <br>
            <h3>View profile :</h3>
            <p>View the content profile's : </p>
            <div class="grid">
                <button class="primary" onclick="location.href = 'user';" id="myButton" class="float-left submit-button">View Profile</button>

            </div>
            <br>

        </section>
    </main>
    <!-- ./ Preview -->

    <!-- Minimal theme switcher -->
    <script src="/public/assets/js/minimal-theme-switcher.js"></script>


    <!-- Modal -->
    <script src="/public/assets/js/modal.js"></script>

</body>

</html>