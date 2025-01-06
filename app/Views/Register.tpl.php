<div class="container-fluid">
    <?php if(isset($templateData['errors'])): ?>
        <div class="alert alert-danger text-center">
            <?php foreach($templateData['errors'] as $error): ?>
                <p class="mb-0"><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if(isset($templateData['error'])): ?>
        <div class="alert alert-danger text-center">
            <?= htmlspecialchars($templateData['error']) ?>
        </div>
    <?php endif; ?>
    <div class="row h-100 justify-content-center main-margin">
        <div class="bckg-light-blue col-6 mt-5 mb-5">
            <div class="text-center mt-3">
                <h4>Registrace do systému</h4>
            </div>
            <?php if(isset($templateData['error'])): ?>
                <div class="alert alert-danger text-center">
                    <?= htmlspecialchars($templateData['error']) ?>
                </div>
            <?php endif; ?>
            <form method="post" action="index.php?page=Register">
                <div class="row">
                    <div class="col-lg">
                        <div class="mb-3">
                            <label for="username" class="form-label">Uživatelské jméno<sup>*</sup></label>
                            <input type="text" id="username" name="username" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-lg">
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail<sup>*</sup></label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg">
                        <div class="mb-3">
                            <label for="password" class="form-label">Heslo<sup>*</sup></label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-lg">
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Potvrzení hesla<sup>*</sup></label>
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-7">
                        <div class="mb-3">
                            <label for="city" class="form-label">Město</label>
                            <input type="text" id="city" name="city" class="form-control">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="mb-3">
                            <label for="number" class="form-label">ČP</label>
                            <input type="number" id="number" name="number" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="mb-3">
                            <label for="psc" class="form-label">PSČ</label>
                            <input type="text" id="psc" name="psc" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" name="register" class="btn btn-outline-dark general-button-color mb-3">Registrovat se</button>
                </div>
            </form>
        </div>
    </div>
</div>