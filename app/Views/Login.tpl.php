<div class="container-fluid">
    <?php if(isset($templateData['errors'])): ?>
        <div class="alert alert-danger mt-3" role="alert">
            <?php foreach($templateData['errors'] as $error): ?>
                <p class="mb-0"><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <div class="row h-100 justify-content-center">
        <div class="col-sm-6 bckg-light-blue mt-5">
            <div class="row mb-3 justify-content-center mt-3">
                <div class="col-lg text-center mt-3">
                    <h4>Zde se můžeš přihlásit ke svému účtu:</h4>
                </div>
            </div>
            <form method="post" action="index.php?page=login">
                <div class="row justify-content-center">
                    <div class="col-lg-4">
                        <label for="username">Jméno</label>
                        <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp" placeholder="Zadejte zde">
                        <small id="emailHelp" class="form-text text-muted link-help">Vaše osobní údaje jsou u nás v bezpečí.</small>
                    </div>
                    <div class="col-1"></div>
                    <div class="col-lg-4">
                        <label for="password">Heslo</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Zadejte zde">
                        <a class="link-help" href="index.php?page=Register" id="no_account">Ještě nemáte účet?</a>
                    </div>
                </div>
                <div class="row justify-content-center mt-3">
                    <div class="col-lg-9 text-center">
                        <button type="submit" name="login" class="btn btn-outline-dark general-button-color">Přihlásit</button>
                        <?php if(isset($templateData['error'])): ?>
                            <div class="alert alert-danger mt-3" role="alert">
                                <?= htmlspecialchars($templateData['error']) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
            <div class="row justify-content-center mt-4">
                <div class="col-5 sit-picture">
                    <img src="public/pictures/Sit.png" alt="Login decoration">
                </div>
            </div>
        </div>
    </div>
</div>
