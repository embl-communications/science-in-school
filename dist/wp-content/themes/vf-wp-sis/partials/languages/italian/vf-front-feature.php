<!-- Featured articles -->
<section class="vf-card-container | vf-content"
         style="padding-top: 1rem !important; margin-bottom: 0 !important;">
    <div class="vf-card-container__inner">
        <?php
        // Get the current issue
        $currentIssue = get_field('current_issue');

        // Get the link to the issue
        $currentIssueLink = $currentIssue ? get_permalink($currentIssue->ID) : '#';
        ?>

        <div class="vf-section-header">
            <h2 class="vf-section-header__heading vf-section-header__heading--is-link">
                <a href="<?php echo esc_url($currentIssueLink); ?>">Nell’ultimo numero</a>
                <svg aria-hidden="true" class="vf-section-header__icon | vf-icon vf-icon-arrow--inline-end" width="1em" height="1em" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 12c0 6.627 5.373 12 12 12s12-5.373 12-12S18.627 0 12 0C5.376.008.008 5.376 0 12zm13.707-5.209l4.5 4.5a1 1 0 010 1.414l-4.5 4.5a1 1 0 01-1.414-1.414l2.366-2.367a.25.25 0 00-.177-.424H6a1 1 0 010-2h8.482a.25.25 0 00.177-.427l-2.366-2.368a1 1 0 011.414-1.414z" fill="" fill-rule="nonzero"></path>
                </svg>
            </h2>
        </div>

        <?php
        // Disable WPML filters to get only original language posts
        remove_all_filters('pre_get_posts');

        // Step 1: Query all possible posts in the original language (EN)
        $args = array(
            'post_type'      => 'sis-article',
            'posts_per_page' => -1, // Get all possible posts
            'post_status'    => 'publish',
            'suppress_filters' => true, // Disable WPML filtering
            'tax_query'      => array(
                array(
                    'taxonomy' => 'sis-issues',
                    'field'    => 'slug',
                    'terms'    => $currentIssue ? $currentIssue->post_title : '',
                ),
            ),
            'meta_query'     => array(
                array(
                    'key'      => 'art_slider_exclude',
                    'value'    => '1',
                    'compare'  => '!=',
                ),
            ),
        );

        $query = new WP_Query($args);
        $original_posts = [];
        $italian_posts = [];

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $original_id = apply_filters('wpml_object_id', get_the_ID(), 'sis-article', false, 'en'); // Get the English ID
                $italian_id = apply_filters('wpml_object_id', get_the_ID(), 'sis-article', false, 'it'); // Get the italian ID
                
                if ($original_id && !in_array($original_id, $original_posts)) {
                    $original_posts[] = $original_id; // Only add if it's not already in the array
                }
                if ($italian_id && !in_array($italian_id, $italian_posts)) {
                    $italian_posts[] = $italian_id; // Only add if it's not already in the array
                }
            }
        }
        wp_reset_postdata();

        // Make sure there are no duplicates by using array_unique()
        $original_posts = array_unique($original_posts);
        $italian_posts = array_unique($italian_posts);

        // Step 2: Determine how many posts to show and in what order
        $posts_to_show = [];

        if (count($italian_posts) == 1) {
            // If there is 1 italian post, show it first, then fill with 2 English posts
            shuffle($italian_posts); // Shuffle to display randomly if there are more than one
            $posts_to_show[] = array_shift($italian_posts); // First italian post
            
            // Add 2 random English posts
            shuffle($original_posts); // Shuffle the remaining English posts
            $posts_to_show = array_merge($posts_to_show, array_slice($original_posts, 0, 3));

        } elseif (count($italian_posts) == 2) {
            // If there are 2 italian posts, display them first, then 1 random English post
            shuffle($italian_posts); // Shuffle to display randomly
            $posts_to_show[] = array_shift($italian_posts); // First italian post
            $posts_to_show[] = array_shift($italian_posts); // Second italian post
            
            // Add 1 random English post
            shuffle($original_posts); // Shuffle the remaining English posts
            $posts_to_show = array_merge($posts_to_show, array_slice($original_posts, 0, 3));

        } elseif (count($italian_posts) >= 3) {
            // If there are 3 or more italian posts, display 3 random italian posts
            shuffle($italian_posts); // Shuffle to display randomly
            $posts_to_show = array_merge($posts_to_show, array_slice($italian_posts, 0, 3));
        
        } else {
            // If there are no italian posts, display 3 random English posts
            shuffle($original_posts); // Shuffle the English posts
            $posts_to_show = array_slice($original_posts, 0, 3);
        }

        // Step 3: Fetch the selected posts
        if (!empty($posts_to_show)) {
            $featureLoop = new WP_Query(array(
                'post_type'      => 'sis-article',
                'post__in'       => $posts_to_show, // Fetch the selected posts
                'orderby'        => 'post__in', // Keep the order as specified
                'posts_per_page' => 3,
                'post_status'    => 'publish',
                'suppress_filters' => true, // Disable WPML filtering
            ));

            while ($featureLoop->have_posts()) :
                $featureLoop->the_post();
                include locate_template('partials/vf-front-currentIssueArticleTeaser.php');
            endwhile;
            wp_reset_postdata();
        } else {
            echo '<p>No articles found.</p>';
        }
        ?>
    </div>
</section>
