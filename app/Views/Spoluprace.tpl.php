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

    <!--- Here starts text --->
    <div class="row justify-content-center mt-4 ">
        <div class="row justify-content-start min-cont mt-4 mb-4">
            <div class="col-lg-8 bckg-light-blue min-cont">
                <div class="row m-2">
                    <div class="col text-center">
                        <b>Oslovení pro Malé Autory</b>
                    </div>
                </div>
                <div class="row">
                    <div class="col text-center m-2 min-cont">
                        rádi bychom vás oslovili s nabídkou spolupráce, která by mohla obohatit jak vás, tak naše knihkupectví <em>Booksie</em>. Věříme, že vaše jedinečné příběhy a perspektivy si zaslouží být slyšeny, a chceme vám pomoci dostat se k širšímu publiku.
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-4 min-cont mb-4">
            <div class="col-lg-9 bckg-light-blue min-cont">
                <div class="row m-2">
                    <div class="col text-center m-2">
                        <b>Proč Spolupracovat s Námi?</b>
                    </div>
                </div>
                <div class="row m-2">
                    <div class="col-lg-4">
                        <em>Podpora Vaší Tvorby</em>
                        <br>
                        Naše knihkupectví se zaměřuje na propagaci malých autorů a jejich děl. Každý titul, který nabízíme, je pečlivě vybrán, abychom podpořili vaši kreativitu.
                    </div>
                    <div class="col-lg-4">
                        <em>Zviditelnění</em>
                        <br>
                        Na našich stránkách můžete mít možnost prezentovat svou knihu, účastnit se autorských čtení a být součástí naší komunity, která sdílí vášeň pro literaturu.
                    </div>
                    <div class="col-lg-4">
                        <em>Zpětná Vazba</em>
                        <br>
                        Rádi s vámi spolupracujeme na rozvoji vašich projektů a poskytneme vám cennou zpětnou vazbu, která vám pomůže růst jako autorovi.
                    </div>
                </div>
            </div>
        </div>
        <div class="row  justify-content-end mt-4 mb-2 min-cont">
            <div class="col-lg-7 bckg-light-blue text-center min-cont">
                <div class="row mt-2">
                    <div class="col">
                        <b>Jak Můžete Začít?</b>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-lg">
                        Pokud máte zájem o spolupráci, neváhejte nás kontaktovat. Pošlete nám krátký popis vaší knihy a vašeho autorského příběhu. Rádi se s vámi spojíme a probereme možnosti, jak vás podpořit.
                        <br>
                        <svg width="30" height="30" viewBox="0 1 25 25" fill="#343C54" xmlns="http://www.w3.org/2000/svg" transform="rotate(0 0 0)">
                            <path d="M21.0791 12.519C21.0744 12.7044 21.0013 12.8884 20.8599 13.0299L14.8639 19.0301C14.5711 19.3231 14.0962 19.3233 13.8032 19.0305C13.5103 18.7377 13.5101 18.2629 13.8029 17.9699L18.5233 13.2461L4.32813 13.2461C3.91391 13.2461 3.57813 12.9103 3.57812 12.4961C3.57812 12.0819 3.91391 11.7461 4.32812 11.7461L18.5158 11.7461L13.8029 7.03016C13.5101 6.73718 13.5102 6.2623 13.8032 5.9695C14.0962 5.6767 14.5711 5.67685 14.8639 5.96984L20.813 11.9228C20.976 12.0603 21.0795 12.2661 21.0795 12.4961C21.0795 12.5038 21.0794 12.5114 21.0791 12.519Z" fill="#343C54"/>
                        </svg>
                        <em>booksie@chcikvam.cz</em>
                        <svg width="30" height="30" viewBox="0 1 25 25" fill="#343C54" xmlns="http://www.w3.org/2000/svg" transform="rotate(0 0 0)">
                            <path d="M3.57813 12.4981C3.5777 12.6905 3.65086 12.8831 3.79761 13.0299L9.7936 19.0301C10.0864 19.3231 10.5613 19.3233 10.8543 19.0305C11.1473 18.7377 11.1474 18.2629 10.8546 17.9699L6.13418 13.2461L20.3295 13.2461C20.7437 13.2461 21.0795 12.9103 21.0795 12.4961C21.0795 12.0819 20.7437 11.7461 20.3295 11.7461L6.14168 11.7461L10.8546 7.03016C11.1474 6.73718 11.1473 6.2623 10.8543 5.9695C10.5613 5.6767 10.0864 5.67685 9.79362 5.96984L3.84392 11.9233C3.68134 12.0609 3.57812 12.2664 3.57812 12.4961L3.57813 12.4981Z" fill="#343C54"/>
                        </svg>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>