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
<div class="admin-wrapper container-fluid">
    <div class="row h-100 justify-content-center mt-5">
        <div class="col text-center">
            <h1>Nový uživatel</h1>
        </div>
    </div>
    <div class="row h-100 justify-content-center">
        <div class="col-sm-8  navbar-custom main-margin mb-5 min-cont">
            <?php if (!empty($data['error'])): ?>
                <div class="alert alert-danger text-center">
                    <?= htmlspecialchars($data['error']) ?>
                </div>
            <?php endif; ?>
            <form method="post" action="index.php?page=Pridat_uzivatele">
                <div class="row">
                    <div class="form-group col-lg-6 mt-2">
                        <label for="inputName">Jméno<sup>*</sup></label>
                        <input type="text" class="form-control" id="inputName" name="username" placeholder="Přihlašovací jméno" required>
                    </div>
                    <div class="form-group col-lg-6 mt-2">
                        <label for="inputPassword4">Heslo<sup>*</sup></label>
                        <input type="password" class="form-control" id="inputPassword4" name="password" placeholder="Heslo" required>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="form-group col-lg-4 mt-2">
                        <label for="inputEmail">E-mail<sup>*</sup></label>
                        <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email" required>
                    </div>
                    <div class="form-group col-lg-4 mt-2">
                        <div class="row">
                            <div class="col-2">
                                Role:
                            </div>
                            <div class="col-10">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="role" id="radioAdmin" value="Admin" checked>
                                    <label class="form-check-label" for="radioAdmin">
                                        Admin
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="role" id="radioAutor" value="Autor">
                                    <label class="form-check-label" for="radioAutor">
                                        Autor
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="role" id="radioUzivatel" value="Uzivatel">
                                    <label class="form-check-label" for="radioUzivatel">
                                        Uživatel
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="form-group col-lg-3 mt-2">
                        <label for="inputNumber">Číslo popisné<sup>*</sup></label>
                        <input type="number" class="form-control" id="inputNumber" name="number" placeholder="Číslo popisné" required>
                    </div>
                    <div class="form-group col-lg-7 mt-2">
                        <label for="inputCity">Město<sup>*</sup></label>
                        <input type="text" class="form-control" id="inputCity" name="city" placeholder="Město" required>
                    </div>
                    <div class="form-group col-lg-2 mt-2">
                        <label for="inputPSC">PSČ<sup>*</sup></label>
                        <input type="text" class="form-control" id="inputPSC" name="psc" placeholder="PSČ" required>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-3 mt-4 text-center">
                        <button type="submit" class="btn btn-outline-dark general-button-color m-2">Přidat uživatele</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>
