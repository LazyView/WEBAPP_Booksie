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
<?php elseif (isset($templateData['authorNotFound'])): ?>
    <div class="row">
        <div class="col-lg-12 text-center mt-5">
            <h2>Pro možnost přidání knihy prosím kontaktujte náš tým.</h2>
            <a href="index.php?page=main" class="btn btn-outline-dark general-button-color">Zpět na hlavní stránku</a>
        </div>
    </div>
<?php elseif (!in_array($_SESSION['role'], ['Admin', 'SuperAdmin', 'Autor'])): ?>
    <div class="row">
        <div class="col-lg-12 text-center mt-5">
            <h2>Access Denied</h2>
            <p>You don't have permission to access this page.</p>
            <a href="index.php?page=main" class="btn btn-outline-dark general-button-color">Back to Main Page</a>
        </div>
    </div>
<?php else: ?>
    <div class="admin-wrapper container-fluid">
        <div class="row h-100">
            <div class="col">
                <div class="row">
                    <div class="col-lg text-center main-margin mb-5">
                        <h1>Přidat novou knihu</h1>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-8 bckg-light-blue mb-3">
                        <form method="post" action="index.php?page=Pridat_knihu" enctype="multipart/form-data">
                            <!-- Image Upload Section -->
                            <div class="row justify-content-center mt-4">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="book_image">Nahrát fotografii</label>
                                        <input type="file" class="form-control" name="book_image" id="book_image" accept="image/*">
                                    </div>
                                    <div class="mt-3 text-center">
                                        <img id="imagePreview" src="uploads/default-logo.jpg" alt="Preview"
                                             class="img-fluid rounded shadow" style="max-width: 200px; display: none;">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <!-- First Row of Inputs -->
                                    <div class="row justify-content-center">
                                        <div class="form-group col-lg-4 mt-4">
                                            <label for="fk_autor">Autor<sup>*</sup></label>
                                            <select class="form-control" name="fk_autor" id="fk_autor" required
                                                <?= $_SESSION['role'] === 'Autor' ? 'disabled' : '' ?>>
                                                <option value="">Vyberte autora</option>
                                                <?php foreach($templateData['authors'] as $author): ?>
                                                    <option value="<?= htmlspecialchars($author['id_autor']) ?>"
                                                        <?= (($_SESSION['role'] === 'Autor' && $author['id_autor'] === $templateData['preselectedAuthorId']) ||
                                                            ($templateData['preselectedAuthorId'] === $author['id_autor'])) ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($author['jmeno'] . ' ' . $author['prijmeni']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <?php if ($_SESSION['role'] === 'Autor'): ?>
                                                <input type="hidden" name="fk_autor" value="<?= htmlspecialchars($templateData['preselectedAuthorId']) ?>">
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group col-lg-4 mt-4">
                                            <label for="nazev">Název knihy<sup>*</sup></label>
                                            <input type="text" class="form-control" name="nazev" id="nazev" required>
                                        </div>
                                        <div class="form-group col-lg-4 mt-4">
                                            <label for="rok_vydani">Rok vydání<sup>*</sup></label>
                                            <input type="number" class="form-control" name="rok_vydani" id="rok_vydani"
                                                   min="1" max="<?= date('Y') ?>" required>
                                        </div>
                                    </div>

                                    <!-- Second Row of Inputs -->
                                    <div class="row justify-content-center">
                                        <div class="form-group col-lg-4 mt-4">
                                            <label for="fk_zanr">Žánr<sup>*</sup></label>
                                            <select class="form-control" name="fk_zanr" id="fk_zanr" required>
                                                <option value="">Vyberte žánr</option>
                                                <?php foreach($templateData['genres'] as $genre): ?>
                                                    <option value="<?= htmlspecialchars($genre['id_zanr']) ?>">
                                                        <?= htmlspecialchars($genre['nazev']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-4 mt-4">
                                            <label for="ISBN">ISBN<sup>*</sup></label>
                                            <input type="text" class="form-control" name="ISBN" id="ISBN"
                                                   pattern="^(?:ISBN(?:-13)?:?\ )?(?=[0-9]{13}$|(?=(?:[0-9]+[-\ ]){4})[-\ 0-9]{17}$)97[89][-\ ]?[0-9]{1,5}[-\ ]?[0-9]+[-\ ]?[0-9]+[-\ ]?[0-9]$"
                                                   title="Please enter a valid ISBN-13 number" required>
                                        </div>
                                        <div class="form-group col-lg-4 mt-4">
                                            <label for="pocet_stran">Počet stran<sup>*</sup></label>
                                            <input type="number" class="form-control" name="pocet_stran" id="pocet_stran"
                                                   min="1" required>
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <div class="row justify-content-center">
                                        <div class="col-lg-12 mt-4">
                                            <label for="popis">Popis<sup>*</sup></label>
                                            <textarea class="form-control" name="popis" id="popis" rows="4" required></textarea>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="row justify-content-center">
                                        <div class="col-lg mt-4 mb-4 text-center">
                                            <button type="submit" name="add_book" class="btn btn-outline-dark general-button-color">
                                                Přidat knihu
                                            </button>
                                            <a href="index.php?page=Sprava_knih" class="btn btn-outline-dark delete-button-color ms-2">
                                                Zrušit
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Image Preview -->
    <script>
        document.getElementById('book_image').onchange = function(evt) {
            const [file] = this.files;
            if (file) {
                const preview = document.getElementById('imagePreview');
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';
            }
        };

        // ISBN validation and formatting
        document.getElementById('ISBN').addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^\d]/g, '');
            if (value.length > 13) value = value.substr(0, 13);
            if (value.length > 0) {
                value = value.match(/.{1,3}/g).join('-');
            }
            e.target.value = value;
        });
    </script>
<?php endif; ?>