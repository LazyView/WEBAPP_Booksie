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
    <div class="row justify-content-center mt-4">
        <!-- První sekce -->
        <div class="row justify-content-start mt-4 min-cont mb-4">
            <div class="col-lg-8 bckg-light-blue min-cont">
                <div class="row m-2">
                    <div class="col text-center">
                        <b>Představujeme Knihkupectví Booksie</b>
                    </div>
                </div>
                <div class="row m-2">
                    <div class="col">
                        Vítejte na webových stránkách našeho knihkupectví Booksie, které se pyšní svou jedinečnou nabídkou literatury od nadějných a talentovaných autorů. Naším cílem je podpořit malé a nezávislé autory, kteří se nebojí experimentovat s novými příběhy a styly.
                    </div>
                </div>
            </div>
        </div>

        <!-- Druhá sekce -->
        <div class="row justify-content-center mt-4 min-cont mb-4">
            <div class="col-lg-9 bckg-light-blue text-center m-2">
                <div class="row m-2">
                    <div class="col">
                        <b>Naše Mise</b>
                    </div>
                </div>
                <div class="row m-2">
                    <div class="col">
                        V Booksie věříme, že každá kniha má svůj příběh a každý autor zaslouží šanci být slyšen. Proto jsme vytvořili prostor, kde můžete objevovat originální díla, která by jinak mohla zůstat ve stínu velkých nakladatelství. Na našich stránkách najdete nejen knihy, ale i rozhovory s autory, recenze a novinky ze světa literatury.
                    </div>
                </div>
            </div>
        </div>

        <!-- Třetí sekce -->
        <div class="row justify-content-end mt-4 mb-2 min-cont mb-4">
            <div class="col-lg-7 bckg-light-blue text-center ">
                <div class="row m-2">
                    <div class="col">
                        <b>Připojte se k Nám</b>
                    </div>
                </div>
                <div class="row m-2 ">
                    <div class="col">
                        Podporou našeho knihkupectví pomáháte vytvářet prostor pro kreativitu a inovaci v literárním světě. Sledujte nás na sociálních sítích a přihlaste se k našemu newsletteru, abyste nezmeškali žádné novinky a akce.
                    </div>
                    <div class="row m-2">
                        <div class="col">
                            <em>Děkujeme, že jste s námi na této cestě za podporou malých autorů!</em>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>