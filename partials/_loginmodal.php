<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('HTTP/1.0 403 Forbidden', TRUE, 403);
    die("<h2>Access Denied!</h2> This file is protected and not available to the public.");
}
?>
<!-- Modal -->
<div class="modal fade" id="loginmodal" tabindex="-1" aria-labelledby="loginmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark"  style="box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-white" id="loginmodalLabel">Login to Prog's HUB</h1>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="./partials/_handleLogin.php" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label text-white">Username</label>
                        <input type="text" class="form-control" name="username" id="username" aria-describedby="emailHelp" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label text-white">Password</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-block" style="background: linear-gradient(to right, #f900e6, #00ff6c);
">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
