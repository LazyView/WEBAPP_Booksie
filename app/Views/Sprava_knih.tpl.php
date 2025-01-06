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
    <div class="row h-100">
        <!-- Sidebar -->
        <div class="col-lg-3 py-3 min-cont">
            <div class="sidebar navbar-custom overflow-y-auto">
                <form method="get" action="index.php">
                    <input type="hidden" name="page" value="Sprava_knih">
                    <div class="sidebar-sticky d-flex flex-column">
                        <ul class="nav flex-column text-center">
                            <div class="row justify-content-center mt-3">
                                <div class="col-auto">
                                    <div class="sidebar-text-color m-2">
                                        <h4>Vyberte si s pomocí našeho filtru knih.</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- Author Filter -->
                            <div class="row mt-3">
                                <div class="col">
                                    <h5><b>Autor</b></h5>
                                    <?php if (isset($templateData['authors']) && is_array($templateData['authors'])): ?>
                                        <?php foreach ($templateData['authors'] as $author): ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                       name="authors[]"
                                                       value="<?= htmlspecialchars($author['id_autor']) ?>"
                                                       id="author_<?= htmlspecialchars($author['id_autor']) ?>"
                                                    <?= isset($_GET['authors']) && in_array($author['id_autor'], $_GET['authors']) ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="author_<?= htmlspecialchars($author['id_autor']) ?>">
                                                    <?= htmlspecialchars($author['jmeno'] . ' ' . $author['prijmeni']) ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <p>Žádný autor dostupný.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <!-- Genre Filter -->
                            <div class="row mt-3">
                                <div class="col">
                                    <h5><b>Žánr</b></h5>
                                    <?php if (isset($templateData['genres']) && is_array($templateData['genres'])): ?>
                                        <?php foreach ($templateData['genres'] as $genre): ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                       name="genres[]"
                                                       value="<?= htmlspecialchars($genre['id_zanr']) ?>"
                                                       id="genre_<?= htmlspecialchars($genre['id_zanr']) ?>"
                                                    <?= isset($_GET['genres']) && in_array($genre['id_zanr'], $_GET['genres']) ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="genre_<?= htmlspecialchars($genre['id_zanr']) ?>">
                                                    <?= htmlspecialchars($genre['nazev']) ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <p>Žadný žánr dostupný.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <!-- Year Filter -->
                            <div class="row mt-3">
                                <div class="col">
                                    <h5><b>Rok vydání</b></h5>
                                    <?php if (isset($templateData['years']) && is_array($templateData['years'])): ?>
                                        <?php foreach ($templateData['years'] as $year): ?>
                                            <?php if (isset($year['rok_vydani'])): ?>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="years[]"
                                                           value="<?= htmlspecialchars($year['rok_vydani']) ?>"
                                                           id="year_<?= htmlspecialchars($year['rok_vydani']) ?>"
                                                        <?= isset($_GET['years']) && in_array($year['rok_vydani'], $_GET['years']) ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="year_<?= htmlspecialchars($year['rok_vydani']) ?>">
                                                        <?= htmlspecialchars($year['rok_vydani']) ?>
                                                    </label>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <p>Žádný rok dostupný.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <!-- Filter Button -->
                            <div class="text-center mt-3 mb-3">
                                <button type="submit" class="btn btn-outline-dark general-button-color">Filtrovat</button>
                            </div>
                            <div class="text-center">
                                <a href="index.php?page=Pridat_knihu">
                                    <button type="button" class="btn btn-outline-dark general-button-color">Přidat knihu</button>
                                </a>
                            </div>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
        <!-- Book List -->
        <div class="col-lg-9 py-3">
            <div class="row">
                <div class="col-sm">
                    <div class="overflow-auto bg-body-tertiary p-3 rounded-2 bckg-light-blue sidebar">
                        <?php if (isset($templateData['books']) && !empty($templateData['books'])): ?>
                            <?php foreach ($templateData['books'] as $book): ?>
                                <div class="list-item">
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <?php if (!empty($book['logo'])): ?>
                                                <img src="<?= htmlspecialchars($book['logo']) ?>" alt="<?= htmlspecialchars($book['nazev']) ?>" class="img-fluid rounded">
                                            <?php else: ?>
                                                <img src="../../uploads/default-logo.jpg" alt="Default Image" class="img-fluid">
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-lg-8 align-content-center">
                                            <?php if (isset($_GET['edit']) && intval($_GET['edit']) === intval($book['id_kniha'])): ?>
                                                <!-- Edit Form -->
                                                <form method="post" action="index.php?page=Sprava_knih">
                                                    <input type="hidden" name="book_id" value="<?= htmlspecialchars($book['id_kniha']) ?>">
                                                    <div class="mb-3">
                                                        <label for="nazev_<?= htmlspecialchars($book['id_kniha']) ?>" class="form-label">Název knihy</label>
                                                        <input type="text" id="nazev_<?= htmlspecialchars($book['id_kniha']) ?>" name="nazev" class="form-control" value="<?= htmlspecialchars($book['nazev']) ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="zanr_<?= htmlspecialchars($book['id_kniha']) ?>" class="form-label">Žánr</label>
                                                        <select id="zanr_<?= htmlspecialchars($book['id_kniha']) ?>" name="fk_zanr" class="form-control">
                                                            <?php foreach ($templateData['genres'] as $genre): ?>
                                                                <option value="<?= htmlspecialchars($genre['id_zanr']) ?>" <?= $book['genre_name'] === $genre['nazev'] ? 'selected' : '' ?>>
                                                                    <?= htmlspecialchars($genre['nazev']) ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="rok_vydani_<?= htmlspecialchars($book['id_kniha']) ?>" class="form-label">Rok vydání</label>
                                                        <input type="number" id="rok_vydani_<?= htmlspecialchars($book['id_kniha']) ?>" name="rok_vydani" class="form-control" value="<?= htmlspecialchars($book['rok_vydani']) ?>">
                                                    </div>
                                                    <div class="text-center">
                                                        <button type="submit" name="save_book" class="btn btn-outline-dark general-button-color">Potvrdit</button>
                                                        <a href="index.php?page=Sprava_knih" class="btn btn-outline-dark delete-button-color">Zrušit</a>
                                                    </div>
                                                </form>
                                            <?php else: ?>
                                                <!-- Book Details -->
                                                <h4><b><?= htmlspecialchars($book['nazev']) ?></b></h4>
                                                <p>
                                                    Autor: <?= htmlspecialchars($book['autor_name'] ?? 'Unknown') ?><br>
                                                    Rok vydání: <?= htmlspecialchars($book['rok_vydani'] ?? 'N/A') ?><br>
                                                    Žánr: <?= htmlspecialchars($book['genre_name'] ?? 'Unknown') ?>
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-lg-2 justify-content mt-3 align-content-center">
                                            <div class="row">
                                                <div class="col">
                                                    <a href="index.php?page=kniha&id=<?= htmlspecialchars($book['id_kniha']) ?>" class="btn btn-outline-dark general-button-color">Detaily</a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <?php if ($_SESSION['role'] === 'SuperAdmin' || $_SESSION['role'] === 'Admin' ||
                                                        ($_SESSION['role'] === 'Autor' && $_SESSION['user'] === $book['autor_name'])): ?>
                                                        <a href="index.php?page=Sprava_knih&edit=<?= htmlspecialchars($book['id_kniha']) ?>"
                                                           class="btn btn-outline-dark general-button-color">Upravit</a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <?php if ($_SESSION['role'] === 'SuperAdmin' || $_SESSION['role'] === 'Admin'): ?>
                                                        <form method="post" action="index.php?page=Sprava_knih" onsubmit="return confirm('Opravdu chcete odstranit tuto knihu?');">
                                                            <input type="hidden" name="book_id" value="<?= htmlspecialchars($book['id_kniha']) ?>">
                                                            <button type="submit" name="delete_book" class="btn btn-outline-dark delete-button-color">Odebrat</button>
                                                        </form>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center p-4">
                                <p>Žádné knihy k zobrazení.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
