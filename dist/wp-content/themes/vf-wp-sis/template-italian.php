<?php

/**
* Template Name: Italian
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
            <h2 class="vf-hero__heading">Informazioni su Science in School
            </h2>
        </div>
    </section>
    <div class="vf-grid | vf-grid__col-3 | vf-u-padding__bottom--400 vf-content">

<div class="vf-grid__col--span-2">
    <h3>Scopri l’innovazione nella ricerca scientifica, esperimenti pratici e coinvolgenti e risorse didattiche STEM gratuite.
    </h3>
    <p class="fontSize18">
    Science in School ha l'obiettivo di sostenere gli insegnanti nello svolgimento dei loro programmi STEM, mettendoli in contatto con la scienza e la tecnologia d’avanguardia, al fine di promuovere atteggiamenti positivi nei confronti della scienza che plasma le nostre vite e di attrarre gli studenti verso le carriere in questi campi. È pubblicata e finanziata da <a href="https://www.scienceinschool.org/about-eiroforum/">EIROforum</a>, una collaborazione tra otto delle più grandi organizzazioni intergovernative di ricerca scientifica in Europa.

    </p>
        
        <p class="fontSize18">La rivista sostiene l'insegnamento delle scienze in tutte le discipline, mettendo in evidenza il meglio dell'insegnamento e dell’innovazione scientifica. Copre non solo la biologia, la fisica e la chimica, ma anche le scienze della terra, l'ingegneria, la medicina e la sostenibilità.</p>
            
            <p class="fontSize18">Tutti gli articoli sono ad accesso libero, ed includono: esperimenti in classe e materiali didattici, informazioni aggiornate sulle nuove ricerche in ambito scientifico e sulle loro applicazioni pratiche, progetti di educazione scientifica e altre risorse utili per gli insegnanti.
            </p>
                
                <p class="fontSize18">La principale lingua di pubblicazione è l'inglese, ma supportiamo la traduzione volontaria dei testi anche in altre lingue europee, per cui sono disponibili molti articoli tradotti. Nelle pagine di ricerca è possibile filtrare gli articoli in italiano.
                </p>
                </div>
                <div id="covers-it">
                <figure class="vf-figure wp-block-image size-large"><img fetchpriority="high" decoding="async" class="vf-figure__image" src="http://www.scienceinschool.org/wp-content/uploads/2024/12/SiS-Issue-covers.png" alt="Science in School Issue covers" ></figure>
                </div>
            </div>
            
            <hr class="vf-divider">

            <?php include(locate_template('partials/languages/italian/vf-front-discover.php', false, false)); ?>
            
            <?php include(locate_template('partials/languages/italian/vf-front-currentIssue.php', false, false)); ?>

            <?php include(locate_template('partials/languages/italian/vf-front-feature.php', false, false)); ?>
            
            
            <?php include(locate_template('partials/languages/italian/vf-front-articleOfWeek.php', false, false)); ?>
            <?php include(locate_template('partials/languages/italian/vf-front-contribute.php', false, false)); ?>
            
            
        </main>
        <?php include(locate_template('partials/vf-footer.php', false, false)); ?>
<?php get_footer(); ?>