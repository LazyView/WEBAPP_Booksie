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
<?php else: ?>
<div class="container-fluid">
    <?php if (isset($_SESSION['errors'])): ?>
        <div class="alert alert-danger">
            <?php foreach($_SESSION['errors'] as $error): ?>
                <p class="mb-0"><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
            <?php unset($_SESSION['errors']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($_SESSION['error']) ?>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION['success']) ?>
            <?php unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>
        <!-- Rest of your existing code -->
        <!--- Autori --->
        <div class="row justify-content-center main-margin">
            <div class="col-lg-6 bckg-light-blue">
                <div class="row mt-3">
                    <div class="col text-center">
                        <h3>Naši autoři</h3>
                        <?php if($templateData['isAdmin']): ?>
                            <button type="button" class="btn btn-outline-dark general-button-color mt-2 mb-3" data-bs-toggle="modal" data-bs-target="#addAuthorModal">
                                Přidat autora
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-8 mb-3 mt-3">
                        <?php if(isset($templateData['authors']) && !empty($templateData['authors'])): ?>
                            <ul class="list-group overflow-auto" style="max-height: calc(100vh - 400px);">
                                <?php foreach($templateData['authors'] as $author): ?>
                                    <?php if($templateData['isAdmin'] && isset($_GET['edit']) && $_GET['edit'] == $author['id_autor']): ?>
                                        <li class="list-group-item">
                                            <form method="post" action="index.php?page=Nasi_autori">
                                                <input type="hidden" name="author_id" value="<?= htmlspecialchars($author['id_autor']) ?>">
                                                <div class="row">
                                                    <div class="col-lg-5">
                                                        <label for="jmeno_<?= $author['id_autor'] ?>" class="form-label">Jméno</label>
                                                        <input type="text" id="jmeno_<?= $author['id_autor'] ?>" name="jmeno" class="form-control" value="<?= htmlspecialchars($author['jmeno']) ?>">
                                                    </div>
                                                    <div class="col-lg-5">
                                                        <label for="prijmeni_<?= $author['id_autor'] ?>" class="form-label">Příjmení</label>
                                                        <input type="text" id="prijmeni_<?= $author['id_autor'] ?>" name="prijmeni" class="form-control" value="<?= htmlspecialchars($author['prijmeni']) ?>">
                                                    </div>
                                                    <div class="col-lg-2 mt-4">
                                                        <button type="submit" name="save_author" class="btn btn-outline-dark general-button-color">Potvrdit</button>
                                                        <a href="index.php?page=Nasi_autori" class="btn btn-outline-dark delete-button-color">Zrušit</a>
                                                    </div>
                                                </div>
                                            </form>
                                        </li>
                                    <?php else: ?>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-lg-<?= $templateData['isAdmin'] ? '8' : '12' ?>">
                                                    <h5><?= htmlspecialchars($author['jmeno'] . ' ' . $author['prijmeni']) ?></h5>
                                                    <small class="text-muted">Počet knih: <?= $author['book_count'] ?></small>
                                                </div>
                                                <?php if($templateData['isAdmin']): ?>
                                                    <div class="col-lg-4 justify-content-start align-content-center">
                                                        <div>
                                                            <a href="index.php?page=Nasi_autori&edit=<?= htmlspecialchars($author['id_autor']) ?>"
                                                               class="btn btn-outline-dark general-button-color">Upravit</a>
                                                            <?php if($author['book_count'] == 0): ?>
                                                                <a href="index.php?page=Nasi_autori&delete=<?= htmlspecialchars($author['id_autor']) ?>"
                                                                   onclick="return confirm('Opravdu chcete tohoto autora odebrat?')"
                                                                   class="btn btn-outline-dark delete-button-color">Odebrat</a>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p class="text-center">No authors found.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Author Modal -->
    <?php if($templateData['isAdmin']): ?>
        <div class="modal fade" id="addAuthorModal" tabindex="-1" aria-labelledby="addAuthorModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addAuthorModalLabel">Přidat nového autora</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post" action="index.php?page=Nasi_autori">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="jmeno" class="form-label">Jméno</label>
                                <input type="text" class="form-control" id="jmeno" name="jmeno" required>
                            </div>
                            <div class="mb-3">
                                <label for="prijmeni" class="form-label">Příjmení</label>
                                <input type="text" class="form-control" id="prijmeni" name="prijmeni" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-dark delete-button-color" data-bs-dismiss="modal">Zrušit</button>
                            <button type="submit" name="add_author" class="btn btn-outline-dark general-button-color">Přidat</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>