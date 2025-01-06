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
        <div class="row h-100">
            <!-- Sidebar -->
            <div class="col-lg-3 py-3">
                <div class="sidebar navbar-custom overflow-auto">
                    <form method="get" action="index.php">
                        <input type="hidden" name="page" value="knihy">
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
                                            <p>No authors available.</p>
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
                                            <p>No genres available.</p>
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
                                            <p>No years available.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Filter Button -->
                                <div class="text-center mt-3">
                                    <button type="submit" class="btn btn-outline-dark general-button-color">Filtrovat</button>
                                </div>
                            </ul>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Book List -->
            <div class="col-lg-9 py-3">
                <div class="row">
                    <div class="col-sm mr-5">
                        <div class="overflow-auto bg-body-tertiary p-3 rounded-2 bckg-light-blue sidebar" >
                            <?php if (isset($templateData['books']) && !empty($templateData['books'])): ?>
                                <?php foreach ($templateData['books'] as $book): ?>
                                    <div class="list-item">
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <!-- Book image -->
                                                <?php if (!empty($book['logo'])): ?>
                                                    <img src="<?= htmlspecialchars($book['logo']) ?>" alt="<?= htmlspecialchars($book['nazev']) ?>" class="img-fluid rounded">
                                                <?php else: ?>
                                                    <img src="uploads/default-logo.jpg" alt="Default Image" class="img-fluid">
                                                <?php endif; ?>
                                            </div>
                                            <div class="col-lg-8 align-content-center">
                                                <h4><b><?= htmlspecialchars($book['nazev']) ?></b></h4>
                                                <p>
                                                    Autor: <?= htmlspecialchars($book['autor_name'] ?? 'Unknown') ?><br>
                                                    Rok vydání: <?= htmlspecialchars($book['rok_vydani'] ?? 'N/A') ?><br>
                                                    Žánr: <?= htmlspecialchars($book['genre_name'] ?? 'Unknown') ?>
                                                </p>
                                            </div>
                                            <div class="col-lg-2 justify-content mt-5 align-content-center">
                                                <a href="index.php?page=kniha&id=<?= htmlspecialchars($book['id_kniha']) ?>">
                                                    <button type="button" class="btn btn-outline-dark general-button-color">Detaily</button>
                                                </a>
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
