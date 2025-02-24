<?php

/**
* Template Name: Spanish
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
            <h2 class="vf-hero__heading">Sobre Science in School</h2>
        </div>
    </section>
    <div class="vf-grid | vf-grid__col-3 | vf-u-padding__bottom--400 vf-content">

<div class="vf-grid__col--span-2">
    <h3>Descubra la ciencia más innovadora, experimentos prácticos atractivos y recursos didácticos CTIM (Ciencia, Tecnología, Ingeniería y Matemáticas) gratuitos.

    </h3>
    <p class="fontSize18">
    El objectivo de Science in School es ayudar a los profesores a impartir las materias de ciencia, tecnología, ingeniería y matemáticas poniéndolos en contacto con la ciencia y la tecnología más avanzadas e inspiradoras, con el fin de fomentar actitudes positivas hacia la ciencia que da forma a nuestras vidas y atraer a los estudiantes hacia carreras en estos campos. La publica y financia <a href="https://www.scienceinschool.org/about-eiroforum/">EIROforum</a>, una colaboración entre ocho de las mayores organizaciones intergubernamentales de investigación científica de Europa.

    </p>
        
        <p class="fontSize18">La revista apoya la enseñanza de las ciencias en todas las disciplinas, destacando lo mejor de la enseñanza y la ciencia de vanguardia. Abarca no solo la biología, la física y la química, sino también las ciencias de la tierra, la ingeniería, la salud y la sostenibilidad.</p>
            
            <p class="fontSize18">Todos los artículos son de acceso gratuito: incluyen experimentos y materiales didácticos para el aula, información actualizada sobre ciencia de vanguardia y aplicaciones en el mundo real, proyectos de enseñanza de las ciencias y otros recursos útiles para profesores de ciencias.
            </p>
                
                <p class="fontSize18">El idioma principal de publicación es el inglés, pero apoyamos la traducción voluntaria a otros idiomas europeos, por lo que también hay disponibles muchos artículos traducidos. Puede filtrar por artículos en español en las páginas de búsqueda.
                </p>
                </div>
                <div id="covers-es">
                <figure class="vf-figure wp-block-image size-large"><img fetchpriority="high" decoding="async" class="vf-figure__image" src="http://www.scienceinschool.org/wp-content/uploads/2024/12/SiS-Issue-covers.png" alt="Science in School Issue covers" ></figure>
                </div>
            </div>
            
            <hr class="vf-divider">

            <?php include(locate_template('partials/languages/spanish/vf-front-discover.php', false, false)); ?>
            
            <?php include(locate_template('partials/languages/spanish/vf-front-currentIssue.php', false, false)); ?>

            <?php include(locate_template('partials/languages/spanish/vf-front-feature.php', false, false)); ?>
            
            
            <?php include(locate_template('partials/languages/spanish/vf-front-articleOfWeek.php', false, false)); ?>
            <?php include(locate_template('partials/languages/spanish/vf-front-contribute.php', false, false)); ?>
            
            
        </main>
        <?php include(locate_template('partials/vf-footer.php', false, false)); ?>
<?php get_footer(); ?>