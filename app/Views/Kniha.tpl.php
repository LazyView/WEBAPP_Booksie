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
        <div class="row justify-content-center main-margin">
            <div class="col-lg-8">
                <?php if (isset($_SESSION['errors'])): ?>
                    <div class="alert alert-danger">
                        <?php foreach($_SESSION['errors'] as $error): ?>
                            <p><?= htmlspecialchars($error) ?></p>
                        <?php endforeach; ?>
                        <?php unset($_SESSION['errors']); ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success">
                        <?= htmlspecialchars($_SESSION['success']) ?>
                        <?php unset($_SESSION['success']); ?>
                    </div>
                <?php endif; ?>
                <div class="row text-center mb-2">
                    <div class="col">
                        <h1><?= htmlspecialchars($templateData['book']['nazev']) ?></h1>
                    </div>
                </div>
                <?php if ($templateData['editMode']): ?>
                    <form method="post" action="index.php?page=kniha&id=<?= htmlspecialchars($templateData['book']['id_kniha']) ?>" enctype="multipart/form-data">
                        <div class="row mb-3">
                            <div class="col-4 font-weight-bold">Název:</div>
                            <div class="col">
                                <input type="text" name="nazev" value="<?= htmlspecialchars($templateData['book']['nazev']) ?>" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4 font-weight-bold">Autor:</div>
                            <div class="col">
                                <select name="fk_autor" class="form-control">
                                    <?php foreach ($templateData['authors'] as $author): ?>
                                        <option value="<?= htmlspecialchars($author['id_autor']) ?>"
                                            <?= $author['id_autor'] == $templateData['book']['fk_autor'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($author['jmeno'] . ' ' . $author['prijmeni']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4 font-weight-bold">Žánr:</div>
                            <div class="col">
                                <select name="fk_zanr" class="form-control">
                                    <?php foreach ($templateData['genres'] as $genre): ?>
                                        <option value="<?= htmlspecialchars($genre['id_zanr']) ?>"
                                            <?= $genre['id_zanr'] == $templateData['book']['fk_zanr'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($genre['nazev']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4 font-weight-bold">Rok vydání:</div>
                            <div class="col">
                                <input type="text" name="rok_vydani" value="<?= htmlspecialchars($templateData['book']['rok_vydani']) ?>" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4 font-weight-bold">ISBN:</div>
                            <div class="col">
                                <input type="text" name="ISBN" value="<?= htmlspecialchars($templateData['book']['ISBN']) ?>" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4 font-weight-bold">Počet stran:</div>
                            <div class="col">
                                <input type="text" name="pocet_stran" value="<?= htmlspecialchars($templateData['book']['pocet_stran']) ?>" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4 font-weight-bold">Popis:</div>
                            <div class="col">
                                <textarea name="popis" class="form-control"><?= htmlspecialchars($templateData['book']['popis']) ?></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4 font-weight-bold">Book Logo:</div>
                            <div class="col">
                                <input type="file" name="book_logo" class="form-control">
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" name="save" class="btn btn-outline-dark general-button-color">Potvrdit</button>
                            <a href="index.php?page=kniha&id=<?= htmlspecialchars($templateData['book']['id_kniha']) ?>" class="btn btn-outline-dark delete-button-color">Zrušit</a>
                        </div>
                    </form>
                <?php else: ?>
                    <div class="row bckg-light-blue p-4 shadow">
                        <div class="col-lg-8">
                            <div class="row mb-3">
                                <div class="col-4 font-weight-bold">Autor:</div>
                                <div class="col"><?= htmlspecialchars($templateData['book']['autor_name'] ?? 'Unknown') ?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4 font-weight-bold">Žánr:</div>
                                <div class="col"><?= htmlspecialchars($templateData['book']['genre_name'] ?? 'Unknown') ?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4 font-weight-bold">ISBN:</div>
                                <div class="col"><?= htmlspecialchars($templateData['book']['ISBN'] ?? 'N/A') ?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4 font-weight-bold">Počet stran:</div>
                                <div class="col"><?= htmlspecialchars($templateData['book']['pocet_stran'] ?? 'N/A') ?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4 font-weight-bold">Popis:</div>
                                <div class="col"><?= nl2br(htmlspecialchars($templateData['book']['popis'] ?? 'N/A')) ?></div>
                            </div>

                        </div>
                        <div class="col">
                            <div class="row text-center">
                                <div class="col">
                                    <h5>Book Logo:</h5>
                                    <?php if (!empty($templateData['book']['logo'])): ?>
                                        <img src="<?= htmlspecialchars($templateData['book']['logo']) ?>" alt="Book Logo" class="img-fluid rounded shadow w-50">
                                    <?php else: ?>
                                        <p>No logo available for this book.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($templateData['userRole'] === 'Admin' || $templateData['userRole'] === 'SuperAdmin'): ?>
                        <div class="text-center mt-4">
                            <a href="index.php?page=kniha&id=<?= htmlspecialchars($templateData['book']['id_kniha']) ?>&edit=true" class="btn btn-outline-dark general-button-color">Upravit</a>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

<?php endif; ?>
