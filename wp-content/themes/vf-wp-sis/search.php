<?php
get_header();
?>
<?php include(locate_template('partials/vf-global-header.php', false, false)); ?>
<?php include(locate_template('partials/vf-navigation.php', false, false)); ?>
<main class="tmpl-search">

    <section class="embl-grid | vf-u-fullbleed vf-u-background-color-ui--grey--light vf-stack">
        <div></div>
        <div>
            <h1 class="vf-text vf-text-heading--1">Search</h1>
            <p class="vf-text-body">
                If you need a description about the service or context of the search.
            </p>

            <form action="<?php echo esc_url(home_url('/')); ?>" class="vf-form vf-form--search vf-form--search--responsive | vf-sidebar vf-sidebar--end">
                <div class="vf-sidebar__inner">
                    <div class="vf-form__item">
                        <label class="vf-form__label vf-u-sr-only | vf-search__label" for="searchitem">Search</label>
                        <input type="search" value="<?php echo esc_attr(get_search_query()); ?>" placeholder="Enter your search terms"
                               name="s"
                               id="searchitem" class="vf-form__input">
                        <input type="hidden" name="post_type" value="sis-article" />
                    </div>

                    <button type="submit" class="vf-search__button | vf-button vf-button--primary">
                        <span class="vf-button__text">Search</span>
                        <svg class="vf-icon vf-icon--search-btn | vf-button__icon" aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                             xmlns:svgjs="http://svgjs.com/svgjs" viewBox="0 0 140 140" width="140" height="140">
                            <g transform="matrix(5.833333333333333,0,0,5.833333333333333,0,0)">
                                <path d="M23.414,20.591l-4.645-4.645a10.256,10.256,0,1,0-2.828,2.829l4.645,4.644a2.025,2.025,0,0,0,2.828,0A2,2,0,0,0,23.414,20.591ZM10.25,3.005A7.25,7.25,0,1,1,3,10.255,7.258,7.258,0,0,1,10.25,3.005Z"
                                      fill="#FFFFFF" stroke="none" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="0"></path>
                            </g>
                        </svg>
                    </button>
                </div>

                <?php
                if ( get_query_var('sis-article-types') ) {
                    print '<input type="hidden" name="sis-article-types" value="' . get_query_var('sis-article-types') . '">';
                }
                if ( get_query_var('sis-ages') ) {
                    print '<input type="hidden" name="sis-ages" value="' . get_query_var('sis-ages') . '">';
                }
                if ( get_query_var('sis-categories') ) {
                    print '<input type="hidden" name="sis-categories" value="' . get_query_var('sis-categories') . '">';
                }
                ?>
            </form>
            <!-- p class="vf-form__helper">Related or examples: <a href="JavaScript:Void(0);" class="vf-link">Cheese</a>, <a
                        href="JavaScript:Void(0);" class="vf-link">Brie</a>. You can also use the <a
                        href="JavaScript:Void(0);" class="vf-link">advanced search</a>.</p -->
            <br/>
            <br/>
        </div>
    </section>

    <section class="embl-grid">
        <div class="vf-stack vf-stack--800">
            <?php include(locate_template('partials/vf-search-filters.php', false, false)); ?>
        </div>

        <div class="vf-stack">

            <p class="vf-text-body vf-text-body--4">
                <?php
                echo 'Showing ' . $GLOBALS['wp_query']->post_count . ' results from a total of ' . $GLOBALS['wp_query']->found_posts;
                ?>
            <p>

                <?php
                if (have_posts()) {
                    while (have_posts()) {
                        the_post();
                        include(locate_template('partials/vf-search-articleTeaser.php', false, false));
                    }
                } else {
                    echo '<p>', __('No posts found', 'vfwp'), '</p>';
                }
                ?>


                <!-- nav class="vf-pagination" aria-label="Pagination">
                    <ul class="vf-pagination__list">
                        <li class="vf-pagination__item">
                            <span class="vf-u-sr-only">Result </span> 1 - 10 of 1,345
                        </li>
                        <li class="vf-pagination__item vf-pagination__item--jump-back">
                            <a href="JavaScript:Void(0);" class="vf-pagination__link">
                                << <span class="vf-u-sr-only">First set</span>
                            </a>
                        </li>
                        <li class="vf-pagination__item vf-pagination__item--previous-page">
                            <a href="JavaScript:Void(0);" class="vf-pagination__link">
                                < Previous <span class="vf-u-sr-only">set</span>
                            </a>
                        </li>
                        <li class="vf-pagination__item vf-pagination__item--next-page">
                            <a href="JavaScript:Void(0);" class="vf-pagination__link">
                                Next > <span class="vf-u-sr-only">set</span>
                            </a>
                        </li>
                        <li class="vf-pagination__item vf-pagination__item--jump-forward">
                            <a href="JavaScript:Void(0);" class="vf-pagination__link">
                                >> <span class="vf-u-sr-only">Last set</span>
                            </a>
                        </li>
                    </ul>
                </nav --->

        </div>
    </section>

    <div class="vf-grid"> <?php vf_pagination(); ?></div>


</main>
<?php include(locate_template('partials/vf-footer.php', false, false)); ?>
<?php get_footer(); ?>
