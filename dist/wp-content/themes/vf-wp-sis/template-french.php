<?php

/**
* Template Name: French
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
            <h2 class="vf-hero__heading">À propos de Science in School</h2>
        </div>
    </section>
    <div class="vf-grid | vf-grid__col-3 | vf-u-padding__bottom--400 vf-content">

<div class="vf-grid__col--span-2">
    <h3>Découvrez la science de pointe, des expériences pratiques intéressantes et des ressources pédagogiques gratuites dans le domaine des sciences, de la technologie et de l'ingénierie.
    </h3>
    <p class="fontSize18">
    Science in School vise à soutenir les enseignants dans l'application de leurs programmes STIM en les mettant en contact avec des sciences et des technologies de pointe inspirantes, afin d’encourager une attitude positive à l'égard des sciences qui façonnent notre quotidien et d'attirer les étudiants vers des carrières dans ces domaines. Le magazine est publié et financé par <a href="https://www.scienceinschool.org/about-eiroforum/">EIROforum</a>, une collaboration entre huit des plus grandes organisations intergouvernementales de recherche scientifique en Europe. 
    </p>
        
        <p class="fontSize18">Le magazine soutient l'enseignement des sciences dans toutes les disciplines, en mettant en avant les meilleures pratiques pédagogiques et avancées scientifiques récentes. Il couvre non seulement la biologie, la physique et la chimie, mais aussi les sciences de la terre, l'ingénierie, la santé et le développement durable.</p>
            
            <p class="fontSize18">Tous les articles sont en accès libre : ils comprennent des expériences à passer en classe et du matériel pédagogique, des actualités sur les sciences et leurs applications concrètes, des projets dans le domaine de la didactique des sciences et d'autres ressources utiles pour les professeurs de sciences.
            </p>
                
                <p class="fontSize18">La langue principale de publication est l'anglais, mais nous soutenons la traduction volontaire vers d'autres langues européennes, de sorte que de nombreux articles traduits sont également disponibles. Vous pouvez filtrer les articles en français dans les pages de recherche.
                </p>
                </div>
                <div id="covers-fr">
                <figure class="vf-figure wp-block-image size-large"><img fetchpriority="high" decoding="async" class="vf-figure__image" src="http://www.scienceinschool.org/wp-content/uploads/2024/12/SiS-Issue-covers.png" alt="Science in School Issue covers" ></figure>
                </div>
            </div>
            
            <hr class="vf-divider">

            <?php include(locate_template('partials/languages/french/vf-front-discover.php', false, false)); ?>
            
            <?php include(locate_template('partials/languages/french/vf-front-currentIssue.php', false, false)); ?>

            <?php include(locate_template('partials/languages/french/vf-front-feature.php', false, false)); ?>
            
            
            <?php include(locate_template('partials/languages/french/vf-front-articleOfWeek.php', false, false)); ?>
            <?php include(locate_template('partials/languages/french/vf-front-contribute.php', false, false)); ?>
            
            
        </main>
        <?php include(locate_template('partials/vf-footer.php', false, false)); ?>
<?php get_footer(); ?>