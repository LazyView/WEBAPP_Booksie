<?php
if (!isset($_SESSION['user'])) {
    ?>
        <div class="container-fluid">
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
        </div>
    <?php
} else {
    ?>
    <div class="container-fluid">
        <div class="row heading-margin">
            <div class="col text-center">
                <h1 class="display-5">Bookni si zábavu na večer!</h1>
            </div>
        </div>
        <!-- Search Form -->
        <div class="row justify-content-center">
            <div class="col-lg-6 mb-4">
                <form class="form-inline" method="get">
                    <div class="input-group">
                        <input class="form-control my-1 lg-0" type="search" name="search" placeholder="Hledat" aria-label="Search">
                        <button class="btn btn-outline-dark my-1 lg-0 general-button-color" type="submit">Hledat</button>
                    </div>
                </form>
                <?php if (!empty($templateData['searchError'])): ?>
                    <p class="text-danger mt-2"><?= htmlspecialchars($templateData['searchError']) ?></p>
                <?php endif; ?>
            </div>
        </div>
        <!-- Top book -->
        <div class="row justify-content-center ">
            <div class="col-lg-5 bckg-light-blue">
                <h2 class="text-center best-sellers">Poslední novinka!</h2>
                <?php if (!empty($templateData['featuredBook'])): ?>
                    <div class="row justify-content-center">
                        <div class="col-6 text-center">
                            <?php if (!empty($templateData['featuredBook']['logo'])): ?>
                                <img src="<?= htmlspecialchars($templateData['featuredBook']['logo']) ?>"
                                     class="img-fluid rounded shadow w-50"
                                     alt="<?= htmlspecialchars($templateData['featuredBook']['nazev']) ?>">
                            <?php else: ?>
                                <img src="uploads/default-logo.jpg"
                                     class="d-block w-100 picture-position rounded"
                                     alt="Default Image">
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-10">
                            <div class="text-black text-center mt-2">
                                <h5><b><?= htmlspecialchars($templateData['featuredBook']['nazev']) ?></b></h5>
                                <p><?= htmlspecialchars($templateData['featuredBook']['popis']) ?></p>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <p class="text-center text-danger">No books available in the database.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php
}
?>



