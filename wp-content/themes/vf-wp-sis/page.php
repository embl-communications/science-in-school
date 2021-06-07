<?php
get_header();
?>
<?php include(locate_template('partials/vf-global-header.php', false, false)); ?>
<?php include(locate_template('partials/vf-navigation.php', false, false)); ?>
<main class="tmpl-post">


    <section class="vf-hero | vf-u-fullbleed"
             style="--vf-hero--bg-image: url('https://acxngcvroo.cloudimg.io/v7/https://www.embl.org/files/wp-content/uploads/vf-hero-intense.png');">
        <div class="vf-hero__content | vf-box | vf-stack vf-stack--400">
            <h2 class="vf-hero__heading"><?php the_title();?></h2>
        </div>
    </section>
    <section class="vf-intro" id="an-id-for-anchor">
        <div>
            <!-- empty -->
        </div>
        <div class="vf-stack">
            <!--<h1 class="vf-intro__heading vf-intro__heading--has-tag">Transversal research themes
              <a href="JavaScript:Void(0);" class="vf-badge vf-badge--primary vf-badge--phases">beta</a>
            </h1>
            <h2 class="vf-intro__subheading">Understanding life in the context of its environment</h2>-->
            <p class="vf-lede"><em>Science in School</em> aims to support teachers in the delivery of their STEM
                curricula, by connecting them to inspiring, cutting-edge science and technology, in order to foster
                positive attitudes towards the science that shapes their lives, and attract students to careers in these
                fields.</p>
            <p class="vf-intro__text">The programme supports science teaching both across Europe and across disciplines:
                highlighting the best in teaching and cutting-edge research. It covers not only biology, physics and
                chemistry, but also earth sciences, engineering and health, focusing on interdisciplinary work.</p>
        </div>
    </section>
    <div class="embl-grid embl-grid--has-centered-content">
        <div class="vf-section-header">
            <h2 class="vf-section-header__heading" id="section-text">Science education</h2>
            <!--<p class="vf-section-header__text">Hello everyone who are doing?</p>-->
        </div>
        <div class="vf-content">
            <p>The contents include teaching materials and projects in science education, up-to-date information on
                cutting-edge science, interviews with inspiring scientists and teachers, reviews of books and other
                resources, and many other useful resources for science teachers. The main language of publication is
                English, and we aim to provide translations when possible in other European languages.</p>
            <p><em>Science in School</em>&nbsp;originated as a quarterly print journal. Following a 2019 review,
                EIROforum decided to move to an online-only model to better reflect changing digital competencies and
                encourage wider take-up. The transition to the new model will occur in late 2020.</p>
        </div>
    </div>
    <hr class="vf-divider"/>
    <div class="embl-grid embl-grid--has-centered-content">
        <div class="vf-section-header">
            <h2 class="vf-section-header__heading" id="section-text">Get involved</h2>
            <!--<p class="vf-section-header__text">Hello everyone who are doing?</p>-->
        </div>
        <div class="vf-content">
            <p>We welcome submissions, reviewer contributions and article translations.</p>
            <p><a href="#" class="vf-button">Learn more about contributing</a></p>
        </div>
    </div>

    <?php include(locate_template('partials/vf-sub-relatedArticles.php', false, false)); ?>

    <br>

    <?php include(locate_template('partials/vf-sub-newsletter.php', false, false)); ?>

</main>
<?php include(locate_template('partials/vf-footer.php', false, false)); ?>
<?php get_footer(); ?>
