<?php
require_once('inc/header.php');
// Verificar si el formulario de login fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar la contraseña (puedes cambiarla por la contraseña que desees)
    $password = PASS_LOGIN;

    if ($_POST['password'] === $password) {
        // Iniciar sesión y redirigir al usuario a la página de inicio
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = 'BSJC'; // Puedes cambiarlo por el nombre de usuario real

        header('Location: index.php');
        exit();
    } else {
        $error = 'Incorrect password';
    }
}
?>

<div class="container login">
    <form method="post" class="col-md-4 offset-md-4 mt-4 bg-login" action="login.php">
        <h2 class="text-center mb-4">Restricted access</h2>
        <div class="row g-3 justify-content-center">
            <div class="col-12">
                <label for="password" class="visually-hidden">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required="">
                    <button type="button" class="btn btn-outline-secondary" id="toggle-password">
                        <i class="bi bi-eye-fill"></i>
                    </button>
                </div>
            </div>
            <div class="col-12 d-grid gap-2 mx-auto">
                <button type="submit" class="btn btn-primary mb-3">Confirm</button>
            </div>
            <?php if (isset($error)) : ?>
                <div class="text-danger text-center" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
        </div>
    </form>


    <script>
        const togglePasswordButton = document.getElementById('toggle-password');
        const passwordInput = document.getElementById('password');

        togglePasswordButton.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            togglePasswordButton.querySelector('i').classList.toggle('bi-eye-fill');
            togglePasswordButton.querySelector('i').classList.toggle('bi-eye-slash-fill');
        });
    </script>
</div>

<?php require_once('inc/footer.php'); ?>