<?php if (!isset($_SESSION['logged_in'])): ?>
    <div class="row">
        <div class="col-lg-12 text-center mt-5">
            <h2>Pro zobrazení sbírky naší knihovny se prosím přihlaste</h2>
            <p>Vytvořte si účet nebo se přihlaste a prozkoumejte naše knihy</p>
            <div class="mt-3">
                <a href="index.php?page=login" class="btn btn-outline-dark general-button-color">Přihlásit se</a>
                <a href="index.php?page=Register" class="btn btn-outline-dark general-button-color ms-2">Registrovat se</a>
            </div>
        </div>
    </div>
<?php elseif (isset($templateData['accessDenied'])): ?>
    <div class="row">
        <div class="col-lg-12 text-center mt-5">
            <h2>Access Denied</h2>
            <p>You don't have permission to access this page.</p>
            <a href="index.php?page=main" class="btn btn-outline-dark general-button-color">Back to Main Page</a>
        </div>
    </div>
<?php else: ?>
<div class="container-fluid">
    <?php if (isset($_SESSION['errors'])): ?>
        <div class="alert alert-danger text-center">
            <?php foreach($_SESSION['errors'] as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
            <?php unset($_SESSION['errors']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success text-center">
            <?= htmlspecialchars($_SESSION['success']) ?>
            <?php unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger text-center">
            <?= htmlspecialchars($_SESSION['error']) ?>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>
    <div class="row h-100 justify-content-center">
        <div class="col-sm-11 py-3">
            <div class="row">
                <div class="col-sm">
                    <div class="overflow-y-auto bg-body-tertiary p-3 rounded-2 border-login" style="max-height: calc(100vh - 70px - 2rem);">
                        <?php if (isset($templateData['users']) && !empty($templateData['users'])): ?>
                            <?php foreach ($templateData['users'] as $user): ?>
                                <?php if (isset($_GET['edit']) && intval($_GET['edit']) === intval($user['id_uzivatel'])): ?>
                                    <form method="post" action="index.php?page=Sprava_uzivatel">
                                        <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['id_uzivatel']) ?>">
                                        <div class="mb-3">
                                            <label for="username_<?= htmlspecialchars($user['id_uzivatel']) ?>" class="form-label">Uživatelské jméno</label>
                                            <input type="text" id="username_<?= htmlspecialchars($user['id_uzivatel']) ?>" name="username" class="form-control" value="<?= htmlspecialchars($user['jmeno']) ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="email_<?= htmlspecialchars($user['id_uzivatel']) ?>" class="form-label">E-mail</label>
                                            <input type="email" id="email_<?= htmlspecialchars($user['id_uzivatel']) ?>" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="password_<?= htmlspecialchars($user['id_uzivatel']) ?>" class="form-label">Heslo</label>
                                            <input type="password" id="password_<?= htmlspecialchars($user['id_uzivatel']) ?>" name="password" class="form-control" placeholder="Zadejte nové heslo (nepovinné)">
                                        </div>
                                        <?php if ($_SESSION['role'] === 'SuperAdmin'): ?>
                                            <div class="mb-3">
                                                <label for="role_<?= htmlspecialchars($user['id_uzivatel']) ?>" class="form-label">Role</label>
                                                <select id="role_<?= htmlspecialchars($user['id_uzivatel']) ?>" name="role" class="form-control">
                                                    <option value="SuperAdmin" <?= $user['role'] === 'SuperAdmin' ? 'selected' : '' ?>>SuperAdmin</option>
                                                    <option value="Admin" <?= $user['role'] === 'Admin' ? 'selected' : '' ?>>Admin</option>
                                                    <option value="Autor" <?= $user['role'] === 'Autor' ? 'selected' : '' ?>>Autor</option>
                                                    <option value="Ctenar" <?= $user['role'] === 'Ctenar' ? 'selected' : '' ?>>Ctenar</option>
                                                </select>
                                            </div>
                                        <?php endif; ?>
                                        <div class="text-center">
                                            <button type="submit" name="save_user" class="btn btn-outline-dark general-button-color">Potvrdit</button>
                                            <a href="index.php?page=Sprava_uzivatel" class="btn btn-outline-dark delete-button-color">Zrušit</a>
                                        </div>
                                    </form>
                                <?php else: ?>
                                    <div class="list-item">
                                        <div class="row">
                                            <div class="col-lg-10">
                                                <h4><?= htmlspecialchars($user['jmeno']) ?></h4>
                                                <p>
                                                    E-mail: <?= htmlspecialchars($user['email']) ?><br>
                                                    Role: <?= htmlspecialchars($user['role']) ?><br>
                                                    Adresa: <?= !empty($user['mesto']) ? htmlspecialchars($user['mesto'] . " " . $user['cislo_popisne'] . ", " . $user['psc']) : 'Neznámá' ?>
                                                </p>
                                            </div>
                                            <div class="col-2 text-center align-content-center">
                                                <?php if ($_SESSION['user_id'] === $user['id_uzivatel'] || $_SESSION['role'] === 'SuperAdmin' || ($_SESSION['role'] === 'Admin' && $user['role'] !== 'SuperAdmin')): ?>
                                                    <a href="index.php?page=Sprava_uzivatel&edit=<?= htmlspecialchars($user['id_uzivatel']) ?>" class="btn btn-outline-dark general-button-color">Upravit</a>
                                                <?php endif; ?>
                                                <!-- Delete Button (SuperAdmin Only) -->
                                                <?php if ($_SESSION['role'] === 'SuperAdmin'): ?>
                                                    <form method="post" action="index.php?page=Sprava_uzivatel" style="display:inline;">
                                                        <input type="hidden" name="delete_user_id" value="<?= htmlspecialchars($user['id_uzivatel']) ?>">
                                                        <button type="submit" class="btn btn-outline-dark delete-button-color" onclick="return confirm('Opravdu chcete tohoto uživatele smazat?');">
                                                            Smazat
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center p-4">
                                <p>Žádní uživatelé k zobrazení.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
