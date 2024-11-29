<?php

/**
* Template Name: German
*/

get_header();
?>

<?php include(locate_template('partials/vf-global-header.php', false, false)); ?>
<?php include(locate_template('partials/vf-navigation.php', false, false)); ?>
<main class="tmpl-home">

    <?php include(locate_template('partials/languages/german/vf-front-articleOfWeek.php', false, false)); ?>
    <div class="embl-grid | vf-u-padding__bottom--400 vf-u-padding__top--800 vf-content">
        <div class="vf-section-header"><a class="vf-section-header__heading vf-section-header__heading--is-link"
                href="/?sis-article-types=understand" id="section-sub-heading-link-text">Über uns
                <svg aria-hidden="true" class="vf-section-header__icon | vf-icon vf-icon-arrow--inline-end" width="1em"
                    height="1em" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M0 12c0 6.627 5.373 12 12 12s12-5.373 12-12S18.627 0 12 0C5.376.008.008 5.376 0 12zm13.707-5.209l4.5 4.5a1 1 0 010 1.414l-4.5 4.5a1 1 0 01-1.414-1.414l2.366-2.367a.25.25 0 00-.177-.424H6a1 1 0 010-2h8.482a.25.25 0 00.177-.427l-2.366-2.368a1 1 0 011.414-1.414z"
                        fill="" fill-rule="nonzero"></path>
                </svg>
            </a>
        </div>
        <div>
            <h3>Science in School ist ein kostenloses Online-Magazin für MINT-Lehrer. Es wird von EIROforum
                veröffentlicht und finanziert, einer Zusammenarbeit zwischen acht der größten zwischenstaatlichen
                wissenschaftlichen Forschungsorganisationen Europas.</h3>

            <p>Das Programm unterstützt den naturwissenschaftlichen Unterricht in allen Disziplinen und hebt die besten
                Lehrleistungen und modernsten wissenschaftlichen Erkenntnisse hervor. Es umfasst nicht nur <span
                    class="fontWeight600">Biologie</span>, <span class="fontWeight600">Physik</span> und <span
                    class="fontWeight600">Chemie</span>, sondern auch <span
                    class="fontWeight600">Geowissenschaften</span>, <span
                    class="fontWeight600">Ingenieurwesen</span>, <span class="fontWeight600">Gesundheit</span>
                und <span class="fontWeight600">Nachhaltigkeit</span>.</p>

            <p>Der Zugriff auf die Artikel ist kostenlos: Sie umfassen Unterrichtsexperimente und
                Unterrichtsmaterialien, aktuelle Informationen zu Spitzenwissenschaften und praktischen Anwendungen,
                Projekte im naturwissenschaftlichen Unterricht und andere nützliche Ressourcen für
                Naturwissenschaftslehrer.</p>

            <p>Die Hauptsprache der Veröffentlichung ist Englisch, wir unterstützen jedoch die ehrenamtliche Übersetzung
                in andere europäische Sprachen, sodass auch viele übersetzte Artikel verfügbar sind. Sie können auf den
                Suchseiten nach deutschen Artikeln filtern.</p>
            <a href="/" class="vf-logo">
                <img class="vf-logo__image vf-u-padding__top--200"
                    src="/wp-content/themes/vf-wp-sis/assets/images/logo/scienceInSchool_logo.png"
                    alt="Science in School" loading="eager" style="height:100px;">
            </a>
        </div>
    </div>

    <hr class="vf-divider">
    <?php include(locate_template('partials/languages/german/vf-front-discover.php', false, false)); ?>

    <?php include(locate_template('partials/languages/german/vf-front-currentIssue.php', false, false)); ?>
    <?php include(locate_template('partials/languages/german/vf-front-feature.php', false, false)); ?>


    <?php include(locate_template('partials/languages/german/vf-front-contribute.php', false, false)); ?>


</main>
<?php include(locate_template('partials/vf-footer.php', false, false)); ?>
<?php get_footer(); ?>