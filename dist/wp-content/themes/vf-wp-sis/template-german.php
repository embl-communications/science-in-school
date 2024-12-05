<?php

/**
* Template Name: German
*/

get_header();
?>

<?php include(locate_template('partials/vf-global-header.php', false, false)); ?>
<?php include(locate_template('partials/vf-navigation.php', false, false)); ?>
<main class="tmpl-home">
<?php
        $heroImage = get_field('hero_image');
        if($heroImage && array_key_exists('url', $heroImage)){
            $heroImageUrl = $heroImage['url'];
        }
    ?>
    <section class="vf-hero | vf-u-fullbleed vf-u-margin__bottom--600"
             style="--vf-hero--bg-image: url('<?php echo $heroImageUrl; ?>');">
        <div class="vf-hero__content | vf-box | vf-stack vf-stack--400">
            <h2 class="vf-hero__heading">Über Science in School</h2>
        </div>
    </section>
    <div class="vf-grid | vf-grid__col-3 | vf-u-padding__bottom--400 vf-content">

<div class="vf-grid__col--span-2">
    <h3>Entdecken Sie modernste Wissenschaft, spannende praktische Experimente und kostenlose MINT-Lehrmaterialien.
    </h3>
    <p class="fontSize18">
    Science in School unterstützt Lehrkräfte bei der Umsetzung ihres MINT-Lehrplans, indem es sie mit inspirierender Spitzenwissenschaft und -technologie in Kontakt bringt, um eine positive Einstellung gegenüber der Wissenschaft zu fördern, die unser Leben prägt, und Schüler für Karrieren in diesen Bereichen zu begeistern. Es wird von <a href="https://www.scienceinschool.org/about-eiroforum/">EIROforum</a> veröffentlicht und finanziert, einer Zusammenarbeit zwischen acht der größten zwischenstaatlichen wissenschaftlichen Forschungsorganisationen Europas.

    </p>
        
        <p class="fontSize18">Das Programm unterstützt den naturwissenschaftlichen Unterricht in allen Disziplinen und hebt die besten
            Lehrleistungen und modernsten wissenschaftlichen Erkenntnisse hervor. Es umfasst nicht nur <span
            class="fontWeight600">Biologie</span>, <span class="fontWeight600">Physik</span> und <span
            class="fontWeight600">Chemie</span>, sondern auch <span
            class="fontWeight600">Geowissenschaften</span>, <span
            class="fontWeight600">Ingenieurwesen</span>, <span class="fontWeight600">Gesundheit</span>
            und <span class="fontWeight600">Nachhaltigkeit</span>.</p>
            
            <p class="fontSize18">Der Zugriff auf die Artikel ist kostenlos: Sie umfassen Unterrichtsexperimente und Unterrichtsmaterialien, aktuelle Informationen zu Spitzenwissenschaften und praktischen Anwendungen, Projekte im naturwissenschaftlichen Unterricht und andere nützliche Ressourcen für Naturwissenschaftslehrer.
            </p>
                
                <p class="fontSize18">Die Hauptsprache der Veröffentlichung ist Englisch, wir unterstützen jedoch die ehrenamtliche Übersetzung in andere europäische Sprachen, sodass auch viele übersetzte Artikel verfügbar sind. Sie können auf den Suchseiten nach deutschen Artikeln filtern.
                </p>
                </div>
                <div>
                <figure class="vf-figure wp-block-image size-large vf-u-padding__left--600"><img fetchpriority="high" decoding="async" class="vf-figure__image" src="http://www.scienceinschool.org/wp-content/uploads/2024/12/SiS-Issue-covers.png" alt="Science in School Issue covers" ></figure>
                </div>
            </div>
            
            <hr class="vf-divider">
            <?php include(locate_template('partials/languages/german/vf-front-discover.php', false, false)); ?>
            
            <hr class="vf-divider">
            <?php include(locate_template('partials/languages/german/vf-front-currentIssue.php', false, false)); ?>

            <?php include(locate_template('partials/languages/german/vf-front-feature.php', false, false)); ?>
            
            
            <?php include(locate_template('partials/languages/german/vf-front-articleOfWeek.php', false, false)); ?>
            <?php include(locate_template('partials/languages/german/vf-front-contribute.php', false, false)); ?>
            
            
        </main>
        <?php include(locate_template('partials/vf-footer.php', false, false)); ?>
<?php get_footer(); ?>