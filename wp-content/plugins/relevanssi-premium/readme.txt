=== Relevanssi Premium - A Better Search ===
Contributors: msaari
Donate link: https://www.relevanssi.com/
Tags: search, relevance, better search
Requires at least: 4.9
Requires PHP: 7.0
Tested up to: 5.7
Stable tag: 2.14.5

Relevanssi Premium replaces the default search with a partial-match search that sorts results by relevance. It also indexes comments and shortcode content.

== Description ==

Relevanssi replaces the standard WordPress search with a better search engine, with lots of features and configurable options. You'll get better results, better presentation of results - your users will thank you.

= Key features =
* Search results sorted in the order of relevance, not by date.
* Fuzzy matching: match partial words, if complete words don't match.
* Find documents matching either just one search term (OR query) or require all words to appear (AND query).
* Search for phrases with quotes, for example "search phrase".
* Create custom excerpts that show where the hit was made, with the search terms highlighted.
* Highlight search terms in the documents when user clicks through search results.
* Search comments, tags, categories and custom fields.

= Advanced features =
* Adjust the weighting for titles, tags and comments.
* Log queries, show most popular queries and recent queries with no hits.
* Restrict searches to categories and tags using a hidden variable or plugin settings.
* Index custom post types and custom taxonomies.
* Index the contents of shortcodes.
* Google-style "Did you mean?" suggestions based on successful user searches.
* Automatic support for [WPML multi-language plugin](http://wpml.org/).
* Automatic support for [s2member membership plugin](http://www.s2member.com/).
* Advanced filtering to help hacking the search results the way you want.
* Search result throttling to improve performance on large databases.
* Disable indexing of post content and post titles with a simple filter hook.
* Multisite support.

= Premium features (only in Relevanssi Premium) =
* PDF content indexing.
* Search result throttling to improve performance on large databases.
* Improved spelling correction in "Did you mean?" suggestions.
* Searching over multiple subsites in one multisite installation.
* Indexing and searching user profiles.
* Weights for post types, including custom post types.
* Limit searches with custom fields.
* Index internal links for the target document (sort of what Google does).
* Search using multiple taxonomies at the same time.

Relevanssi is available in two versions, regular and Premium. Regular Relevanssi is and will remain free to download and use. Relevanssi Premium comes with a cost, but will get all the new features. Standard Relevanssi will be updated to fix bugs, but new features will mostly appear in Premium. Also, support for standard Relevanssi depends very much on my mood and available time. Premium pricing includes support.

= Relevanssi in Facebook =
You can find [Relevanssi in Facebook](https://www.facebook.com/relevanssi). Become a fan to follow the development of the plugin, I'll post updates on bugs, new features and new versions to the Facebook page.

= Other search plugins =
Relevanssi owes a lot to [wpSearch](https://wordpress.org/extend/plugins/wpsearch/) by Kenny Katzgrau. Relevanssi was built to replace wpSearch, when it started to fail.

Search Unleashed is a popular search plugin, but it hasn't been updated since 2010. Relevanssi is in active development and does what Search Unleashed does.



== Installation ==

1. Extract all files from the ZIP file, and then upload the plugin's folder to /wp-content/plugins/.
1. If your blog is in English, skip to the next step. If your blog is in other language, rename the file *stopwords* in the plugin directory as something else or remove it. If there is *stopwords.yourlanguage*, rename it to *stopwords*.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Go to the plugin settings and build the index following the instructions there.

To update your installation, simply overwrite the old files with the new, activate the new version and if the new version has changes in the indexing, rebuild the index.

= Note on updates =
If it seems the plugin doesn't work after an update, the first thing to try is deactivating and reactivating the plugin. If there are changes in the database structure, those changes do not happen without a deactivation, for some reason.

= Changes to templates =
None necessary! Relevanssi uses the standard search form and doesn't usually need any changes in the search results template.

If the search does not bring any results, your theme probably has a query_posts() call in the search results template. That throws Relevanssi off. For more information, see [The most important Relevanssi debugging trick](http://www.relevanssi.com/knowledge-base/query_posts/).

= How to index =
Check the options to make sure they're to your liking, then click "Save indexing options and build the index". If everything's fine, you'll see the Relevanssi options screen again with a message "Indexing successful!"

If something fails, usually the result is a blank screen. The most common problem is a timeout: server ran out of time while indexing. The solution to that is simple: just return to Relevanssi screen (do not just try to reload the blank page) and click "Continue indexing". Indexing will continue. Most databases will get indexed in just few clicks of "Continue indexing". You can follow the process in the "State of the Index": if the amount of documents is growing, the indexing is moving along.

If the indexing gets stuck, something's wrong. I've had trouble with some plugins, for example Flowplayer video player stopped indexing. I had to disable the plugin, index and then activate the plugin again. Try disabling plugins, especially those that use shortcodes, to see if that helps. Relevanssi shows the highest post ID in the index - start troubleshooting from the post or page with the next highest ID. Server error logs may be useful, too.

= Using custom search results =
If you want to use the custom search results, make sure your search results template uses `the_excerpt()` to display the entries, because the plugin creates the custom snippet by replacing the post excerpt.

If you're using a plugin that affects excerpts (like Advanced Excerpt), you may run into some problems. For those cases, I've included the function `relevanssi_the_excerpt()`, which you can use instead of `the_excerpt()`. It prints out the excerpt, but doesn't apply `wp_trim_excerpt()` filters (it does apply `the_content()`, `the_excerpt()`, and `get_the_excerpt()` filters).

To avoid trouble, use the function like this:

`<?php if (function_exists('relevanssi_the_excerpt')) { relevanssi_the_excerpt(); }; ?>`

See Frequently Asked Questions for more instructions on what you can do with Relevanssi.

= The advanced hacker option =
If you're doing something unusual with your search and Relevanssi doesn't work, try using `relevanssi_do_query()`. See [Knowledge Base](http://www.relevanssi.com/knowledge-base/relevanssi_do_query/).

= Uninstalling =
To uninstall the plugin remove the plugin using the normal WordPress plugin management tools (from the Plugins page, first Deactivate, then Delete). If you remove the plugin files manually, the database tables and options will remain.

= Combining with other plugins =
Relevanssi doesn't work with plugins that rely on standard WP search. Those plugins want to access the MySQL queries, for example. That won't do with Relevanssi. [Search Light](http://wordpress.org/extend/plugins/search-light/), for example, won't work with Relevanssi.

Some plugins cause problems when indexing documents. These are generally plugins that use shortcodes to do something somewhat complicated. One such plugin is [MapPress Easy Google Maps](http://wordpress.org/extend/plugins/mappress-google-maps-for-wordpress/). When indexing, you'll get a white screen. To fix the problem, disable either the offending plugin or shortcode expansion in Relevanssi while indexing. After indexing, you can activate the plugin again.

== Frequently Asked Questions ==

= Where is the Relevanssi search box widget? =
There is no Relevanssi search box widget.

Just use the standard search box.

= Where are the user search logs? =
See the top of the admin menu. There's 'User searches'. There. If the logs are empty, please note showing the results needs at least MySQL 5.

= Displaying the number of search results found =

The typical solution to showing the number of search results found does not work with Relevanssi. However, there's a solution that's much easier: the number of search results is stored in a variable within $wp_query. Just add the following code to your search results template:

`<?php echo 'Relevanssi found ' . $wp_query->found_posts . ' hits'; ?>`

= Advanced search result filtering =

If you want to add extra filters to the search results, you can add them using a hook. Relevanssi searches for results in the _relevanssi table, where terms and post_ids are listed. The various filtering methods work by listing either allowed or forbidden post ids in the query WHERE clause. Using the `relevanssi_where` hook you can add your own restrictions to the WHERE clause.

These restrictions must be in the general format of ` AND doc IN (' . {a list of post ids, which could be a subquery} . ')`

For more details, see where the filter is applied in the `relevanssi_search()` function. This is stricly an advanced hacker option for those people who're used to using filters and MySQL WHERE clauses and it is possible to break the search results completely by doing something wrong here.

There's another filter hook, `relevanssi_hits_filter`, which lets you modify the hits directly. The filter passes an array, where index 0 gives the list of hits in the form of an array of post objects and index 1 has the search query as a string. The filter expects you to return an array containing the array of post objects in index 0 (`return array($your_processed_hit_array)`).

= Direct access to query engine =
Relevanssi can't be used in any situation, because it checks the presence of search with the `is_search()` function. This causes some unfortunate limitations and reduces the general usability of the plugin.

You can now access the query engine directly. There's a new function `relevanssi_do_query()`, which can be used to do search queries just about anywhere. The function takes a WP_Query object as a parameter, so you need to store all the search parameters in the object (for example, put the search terms in `$your_query_object->query_vars['s']`). Then just pass the WP_Query object to Relevanssi with `relevanssi_do_query($your_wp_query_object);`.

Relevanssi will process the query and insert the found posts as `$your_query_object->posts`. The query object is passed as reference and modified directly, so there's no return value. The posts array will contain all results that are found.

= Sorting search results =
If you want something else than relevancy ranking, you can use orderby and order parameters. Orderby accepts $post variable attributes and order can be "asc" or "desc". The most relevant attributes here are most likely "post_date" and "comment_count".

If you want to give your users the ability to sort search results by date, you can just add a link to http://www.yourblogdomain.com/?s=search-term&orderby=post_date&order=desc to your search result page.

Order by relevance is either orderby=relevance or no orderby parameter at all.

= Filtering results by date =
You can specify date limits on searches with `by_date` search parameter. You can use it your search result page like this: http://www.yourblogdomain.com/?s=search-term&by_date=1d to offer your visitor the ability to restrict their search to certain time limit (see [RAPLIQ](http://www.rapliq.org/) for a working example).

The date range is always back from the current date and time. Possible units are hour (h), day (d), week (w), month (m) and year (y). So, to see only posts from past week, you could use by_date=7d or by_date=1w.

Using wrong letters for units or impossible date ranges will lead to either defaulting to date or no results at all, depending on case.

Thanks to Charles St-Pierre for the idea.

= Displaying the relevance score =
Relevanssi stores the relevance score it uses to sort results in the $post variable. Just add something like

`echo $post->relevance_score`

to your search results template inside a PHP code block to display the relevance score.

= Did you mean? suggestions =
To use Google-style "did you mean?" suggestions, first enable search query logging. The suggestions are based on logged queries, so without good base of logged queries, the suggestions will be odd and not very useful.

To use the suggestions, add the following line to your search result template, preferably before the have_posts() check:

`<?php if (function_exists('relevanssi_didyoumean')) { relevanssi_didyoumean(get_search_query(), "<p>Did you mean: ", "?</p>", 5); }?>`

The first parameter passes the search term, the second is the text before the result, the third is the text after the result and the number is the amount of search results necessary to not show suggestions. With the default value of 5, suggestions are not shown if the search returns more than 5 hits.

= Search shortcode =
Relevanssi also adds a shortcode to help making links to search results. That way users can easily find more information about a given subject from your blog. The syntax is simple:

`[search]John Doe[/search]`

This will make the text John Doe a link to search results for John Doe. In case you want to link to some other search term than the anchor text (necessary in languages like Finnish), you can use:

`[search term="John Doe"]Mr. John Doe[/search]`

Now the search will be for John Doe, but the anchor says Mr. John Doe.

One more parameter: setting `[search phrase="on"]` will wrap the search term in quotation marks, making it a phrase. This can be useful in some cases.

= Restricting searches to categories and tags =
Relevanssi supports the hidden input field `cat` to restrict searches to certain categories (or tags, since those are pretty much the same). Just add a hidden input field named `cat` in your search form and list the desired category or tag IDs in the `value` field - positive numbers include those categories and tags, negative numbers exclude them.

This input field can only take one category or tag id (a restriction caused by WordPress, not Relevanssi). If you need more, use `cats` and use a comma-separated list of category IDs.

You can also set the restriction from general plugin settings (and then override it in individual search forms with the special field). This works with custom taxonomies as well, just replace `cat` with the name of your taxonomy.

If you want to restrict the search to categories using a dropdown box on the search form, use a code like this:

`<form method="get" action="<?php bloginfo('url'); ?>">
	<div><label class="screen-reader-text" for="s">Search</label>
	<input type="text" value="<?php the_search_query(); ?>" name="s" id="s" />
<?php
	wp_dropdown_categories(array('show_option_all' => 'All categories'));
?>
	<input type="submit" id="searchsubmit" value="Search" />
	</div>
</form>`

This produces a search form with a dropdown box for categories. Do note that this code won't work when placed in a Text widget: either place it directly in the template or use a PHP widget plugin to get a widget that can execute PHP code.

= Restricting searches with taxonomies =

You can use taxonomies to restrict search results to posts and pages tagged with a certain taxonomy term. If you have a custom taxonomy of "People" and want to search entries tagged "John" in this taxonomy, just use `?s=keyword&people=John` in the URL. You should be able to use an input field in the search form to do this, as well - just name the input field with the name of the taxonomy you want to use.

It's also possible to do a dropdown for custom taxonomies, using the same function. Just adjust the arguments like this:

`wp_dropdown_categories(array('show_option_all' => 'All people', 'name' => 'people', 'taxonomy' => 'people'));`

This would do a dropdown box for the "People" taxonomy. The 'name' must be the keyword used in the URL, while 'taxonomy' has the name of the taxonomy.

= Automatic indexing =
Relevanssi indexes changes in documents as soon as they happen. However, changes in shortcoded content won't be registered automatically. If you use lots of shortcodes and dynamic content, you may want to add extra indexing. Here's how to do it:

`if (!wp_next_scheduled('relevanssi_build_index')) {
	wp_schedule_event( time(), 'daily', 'relevanssi_build_index' );
}`

Add the code above in your theme functions.php file so it gets executed. This will cause WordPress to build the index once a day. This is an untested and unsupported feature that may cause trouble and corrupt index if your database is large, so use at your own risk. This was presented at [forum](http://wordpress.org/support/topic/plugin-relevanssi-a-better-search-relevanssi-chron-indexing?replies=2).

= Highlighting terms =
Relevanssi search term highlighting can be used outside search results. You can access the search term highlighting function directly. This can be used for example to highlight search terms in structured search result data that comes from custom fields and isn't normally highlighted by Relevanssi.

Just pass the content you want highlighted through `relevanssi_highlight_terms()` function. The content to highlight is the first parameter, the search query the second. The content with highlights is then returned by the function. Use it like this:

`if (function_exists('relevanssi_highlight_terms')) {
    echo relevanssi_highlight_terms($content, get_search_query());
}
else { echo $content; }`

= Multisite searching =
To search multiple blogs in the same WordPress network, use the `searchblogs` argument. You can add a hidden input field, for example. List the desired blog ids as the value. For example, searchblogs=1,2,3 would search blogs 1, 2, and 3.

The features are very limited in the multiblog search, none of the advanced filtering works, and there'll probably be fairly serious performance issues if searching common words from multiple blogs.

= What is tf * idf weighing? =

It's the basic weighing scheme used in information retrieval. Tf stands for *term frequency* while idf is *inverted document frequency*. Term frequency is simply the number of times the term appears in a document, while document frequency is the number of documents in the database where the term appears.

Thus, the weight of the word for a document increases the more often it appears in the document and the less often it appears in other documents.

= What are stop words? =

Each document database is full of useless words. All the little words that appear in just about every document are completely useless for information retrieval purposes. Basically, their inverted document frequency is really low, so they never have much power in matching. Also, removing those words helps to make the index smaller and searching faster.

== Known issues and To-do's ==
* Known issue: In general, multiple Loops on the search page may cause surprising results. Please make sure the actual search results are the first loop.
* Known issue: Relevanssi doesn't necessarily play nice with plugins that modify the excerpt. If you're having problems, try using relevanssi_the_excerpt() instead of the_excerpt().
* Known issue: When a tag is removed, Relevanssi index isn't updated until the post is indexed again.

== Thanks ==
* Cristian Damm for tag indexing, comment indexing, post/page exclusion and general helpfulness.
* Marcus Dalgren for UTF-8 fixing.
* Warren Tape.
* Mohib Ebrahim for relentless bug hunting.
* John Blackbourn for amazing internal link feature and other fixes.
* John Calahan for extensive 2.0 beta testing.

== Changelog ==
= 2.14.5 =
* New feature: New WP CLI command `wp relevanssi remove_attachment_errors` clears out all attachment reading errors.
* Changed behaviour: `relevanssi_excerpt_custom_field_content` now gets the post ID and list of custom field names as a parameter.
* Changed behaviour: Attachments tab will now prevent reading the attachments if the options have been changed and aren't saved.
* Changed behaviour: Instead of setting the attachment reading server to 'us', Relevanssi install process will now guess whether 'eu' would be a better option based on the site locale.
* Minor fix: Avoids admin ajax request flooding when removing lots of posts at once.
* Minor fix: Adds trailing slash to the blog URL in Did you mean links.
* Minor fix: When the contents for an attached attachment are read, Relevanssi will now automatically index the parent post if the setting is enabled.

= 2.14.4 =
* New feature: New action hooks `relevanssi_pre_the_content` and `relevanssi_post_the_content` fire before and after Relevanssi applies `the_content` filter to the post excerpts. Some Relevanssi default behaviour has been moved to these hooks so it can be modified.
* Changed behaviour: The `relevanssi_do_not_index` gets the post object as a third parameter.
* Minor fix: Remove errors from `relevanssi_strip_all_tags()` getting a `null` parameter.
* Minor fix: Updating posts still used `relevanssi_update_doc_count()`, which can sometimes be really slow.
* Minor fix: Corrected misleading instructions about indexing AND synonyms.

= 2.14.3 =
* Major fix: Post type weights did not work; improving the caching had broken them.
* Minor fix: 'Read all unread attachments' did not include 'key is not valid' errors. Now it rereads those attachments.
* Minor fix: Stops indexing error messages in WPML.
* Minor fix: Synonyms are now used for highlighting titles in AND searches if 'Index synonyms for AND searches' is enabled.
* Minor fix: Relevanssi works better with soft hyphens now, removing them in indexing and excerpt-building.

= 2.14.2 =
* Major fix: Stops more problems with ACF custom field indexing.
* Major fix: Fixes a bug in search result caching that caused Relevanssi to make lots of unnecessary database queries.
* Minor fix: Pinning didn't work correctly when the post content indexing was disabled. Now the pinned words are included in the post title, if the post content is not available.

= 2.14.1 =
* Major fix: Stops TypeError crashes from null custom field indexing.

= 2.14.0 =
* New feature: New filter hook `relevanssi_excerpt_gap` lets you adjust the first line of excerpt optimization.
* New feature: Phrase matching now works also for taxonomy terms and user profiles.
* New feature: New filter hook `relevanssi_phrase_queries` can be used to add phrase matching queries to support more content types.
* New feature: New WP CLI command `wp relevanssi refresh` reindexes all posts (and only posts) without truncating the index first. This is very useful for regular reindexing of production sites, as the search won't stop working during the reindexing.
* New feature: New function `relevanssi_update_words_option()` can be used to update the `relevanssi_words` option directly, in case the AJAX update action fails for some reason.
* New feature: You can now reset the `relevanssi_words` cache option from the Relevanssi debugging settings tab.
* Changed behaviour: The `relevanssi_tag_before_tokenize` filter hook parameters were changed in order to be actually useful and to match what the filter hook is supposed to do.
* Changed behaviour: Relevanssi now automatically optimizes excerpt creation in long posts. You can still use `relevanssi_optimize_excerpts` for further optimization, but it's probably not necessary.
* Changed behaviour: The `relevanssi_admin_search_element` filter hook now gets the post object as the second parameter, rendering the filter hook more useful.
* Minor fix: WPML couldn't digest post type archives in the search results. Relevanssi now handles that and also takes errors from WPML more gracefully.
* Minor fix: Taxonomy terms in WPML were not indexed correctly. Instead of the post language, the current language was used, so if your admin dashboard is in English, German posts would get English translations of the terms, not German. This is now fixed.
* Minor fix: Excerpt creation is now faster when multiple excerpts are not used.
* Minor fix: The SEO plugin noindex setting did not actually work. That has been fixed now.
* Minor fix: Multisite searching didn't work correctly in HyperDB environments.
* Minor fix: Improved fringe cases in nested taxonomy queries.
* Minor fix: Indexing would remove content where less than or greater than symbols were interpreted as HTML tags.
* Minor fix: In some cases Relevanssi wouldn't highlight the last word of the title. This is more reliable now.
* Minor fix: Relevanssi will now add the `highlight` parameter only to search results, and not to other links on the search results page.
* Minor fix: Disables stemming for words that are inside phrases to make post part targeted searches more precise.

= 2.13.1 =
* Major fix: User and taxonomy term search did not work correctly, thanks to a complicated mix of small issues that didn't show up in the automated testing. The problem was caused be `relevanssi_premium_get_post()` returning WP_Post objects for these non-posts, so the function is now returning stdClass objects again.
* Major fix: The type hinting introduced for some functions turned out to be too strict, causing fatal errors. The type hinting has been relaxed (using nullable types would help, but that's a PHP 7.4 feature, and we don't want that).

= 2.13.0 =
* New feature: New filter hook `relevanssi_rendered_block` filters Gutenberg block content after the block has been rendered with `render_block()`.
* New feature: New filter hook `relevanssi_log_query` can be used to filter the search query before it's logged. This can be used to log instead the query that includes synonyms (available as a parameter to the filter hook).
* New feature: New filter hook `relevanssi_add_all_results` can be used to make Relevanssi add a list of all result IDs found to `$query->relevanssi_all_results`. Just make this hook return `true`.
* New feature: New filter hook `relevanssi_acceptable_hooks` can be used to adjust where in WP admin the Relevanssi admin javascripts are enqueued.
* New feature: Support for All-in-One SEO. Posts marked as 'Robots No Index' are not indexed by Relevanssi.
* New feature: New setting in advanced indexing settings to control whether Relevanssi respects the SEO plugin 'noindex' setting or not.
* Changed behaviour: Type hinting has been added to Relevanssi functions, which may cause errors if the filter functions are sloppy with data types.
* Changed behaviour: Relevanssi no longer logs queries with the added synonyms. You can use the `relevanssi_log_query` filter hook to return to the previous behaviour of logging the synonyms too. Thanks to Jan Willem Oostendorp.
* Changed behaviour: `relevanssi_the_title()` now supports the same parameters as `the_title()`, so you can just replace `the_title()` with it and keep everything else the same. The old behaviour is still supported.
* Changed behaviour: When using ACF and custom fields indexing set to 'all', Relevanssi will no longer index the meta fields (where the content begins with `field_`).
* Minor fix: In some cases, having less than or greater than symbols in PDF content would block that PDF content from being indexed.
* Minor fix: PDF content wasn't being indexed in some cases where custom field indexing was otherwise disabled.
* Minor fix: The Oxygen compatibility made it impossible to index other custom fields than the Oxygen `ct_builder_shortcodes`. This has been improved now.
* Minor fix: In Related posts, random posts from the same category could include duplicates of posts in the related posts.
* Minor fix: Old legacy scripts that caused Javascript warnings on admin pages have been removed.
* Minor fix: relevanssi_premium_get_post() always returns WP_Post objects now, never stdClass objects.
* Minor fix: The search results log export did not do anything useful when no data was found. Now the export provides a message "No search keywords logged". Thanks to Jan Willem Oostendorp.

= 2.12.2 =
* New feature: You can force Relevanssi to be active by setting the query variable `relevanssi` to `true`. Thanks to Jan Willem Oostendorp.
* Changed behaviour: Relevanssi has been moved from `the_posts` filter to `posts_pre_query`. This change doesn't do much, but increases performance slightly as WordPress needs to do less useless work, as now the default query is no longer run. Thanks to Jan Willem Oostendorp.
* Minor fix: Highlighting didn't work properly when highlighting something immediately following a HTML tag.
* Minor fix: WPML search results that included non-post results caused fatal errors and crashes. This fixes the crashing and makes non-post results work better in both WPML and Polylang.
* Minor fix: Pinning could cause warnings when using `fields` and non-post results.
* Minor fix: Importing options broke synonym and stopword settings.
* Minor fix: Improves the Rank Math SEO compatibility to avoid errors in plugin activation.
* Minor fix: You can no longer set the value of minimum word length to less than 1 or higher than 9 from the settings page.

= 2.12.1 =
* Major fix: The multilingual stopwords and synonyms were used based on the global language. Now when indexing posts, the post language is used instead of the global language.
* Minor fix: Fixes the broken AND indexing for synonyms.

= 2.12.0 =
* New feature: Relevanssi now supports multilingual synonyms and stopwords. Relevanssi now has a different set of synonyms and stopwords for each language. This feature is compatible with WPML and Polylang.
* New feature: SEO by Rank Math compatibility is added: posts marked as 'noindex' with Rank Math are not indexed by Relevanssi.
* New feature: New filter hook `relevanssi_sidebar_capability` adjusts the minimum capability required for seeing the Gutenberg sidebar and the Classic editor metabox. Default value is `manage_options`, ie. Editor.
* Minor fix: Attachment weren't affected by `relevanssi_indexing_restriction` filters when a new attachment was added. Now the filters apply as they should.
* Minor fix: With keyword matching set to 'whole words' and the 'expand highlights' disabled, words that ended with an 's' weren't highlighted correctly.
* Minor fix: The 'Post exclusion' setting didn't work correctly. It has been fixed.
* Minor fix: It's now impossible to set negative weights in searching settings. They did not work as expected anyway.
* Minor fix: Contributors could see the Relevanssi Gutenberg sidebar, but it didn't work. Now the sidebar is only shown by default to Editors and above.
* Minor fix: Relevanssi had an unnecessary index on the `doc` column in the `wp_relevanssi` database table. It is now removed to save space. Thanks to Matthew Wang.
* Minor fix: Improved Oxygen Builder support makes sure `ct_builder_shortcodes` custom field is always indexed.

= 2.11.1 =
* Changed behaviour: The `relevanssi_excerpt_part` filter hook now gets the post ID as a second parameter. The documentation for the filter has been fixed to match actual use: this filter is applied to the excerpt part after the highlighting and the ellipsis have been added.
* Changed behaviour: The `relevanssi_index_custom_fields` filter hook is no longer used when determining which custom fields are used for phrase searching. If you have a use case where this change matters, please contact us.
* Minor fix: The `relevanssi_excerpt` filter hook was removed in 2.11.0. It is now restored and behaves the way it did before, except that when doing multi-part excerpts, this filter is applied separately for each excerpt part.
* Minor fix: The debugging tab no longer shows the 'Buy Premium' note to Premium users.
* Minor fix: Avoids undefined variable warnings from the Pretty Links compatibility code.
* Minor fix: In Premium, phrase matching in custom fields didn't work correctly when the custom field indexing setting was 'all' or 'visible'.
* Minor fix: The Oxygen Builder compatibility has been improved. Now shortcodes in Oxygen Builder content are expanded, if that setting is enabled in Relevanssi settings.
* Minor fix: Adding new redirects when there were none was impossible. This is now fixed, and in a more future-proof way.
* Minor fix: The default value for the number of excerpts was 3. It's now 1.

= 2.11.0 =
* New feature: There's now a "Debugging" tab in the Relevanssi settings, letting you see how the Relevanssi index sees posts. This is familiar to Premium users, but is now available in the free version as well.
* New feature: The SEO Framework plugin is now supported and posts set excluded from the search in SEO Framework settings will be excluded from the index.
* New feature: There's a new option, "Expand highlights". Enabling it makes Relevanssi expand partial-word highlights to cover the full word. This is useful when doing partial matching and when using a stemmer.
* New feature: Relevanssi can now generate excerpts that show multiple snippets from the post. You can adjust the number of excerpts displayed from the excerpt settings. Individual excerpt parts are wrapped in `span` tags with the class `excerpt_part` for styling.
* New feature: New filter hook `relevanssi_excerpt_part` allows you to modify the excerpt parts before they are combined together.
* New feature: New filter hook `relevanssi_excerpts` lets you filter the array of excerpts before the highlights are added.
* New feature: Relevanssi now supports an arbitrary number of levels in the `field_%_subfield_%_subfield` notation for flexible ACF fields.
* New feature: Improved compatibility with Oxygen Builder. Relevanssi automatically indexes the Oxygen Builder content and cleans it up. New filter hooks `relevanssi_oxygen_section_filters` and `relevanssi_oxygen_section_content` allow easier filtering of Oxygen content to eg. remove unwanted sections.
* Changed behaviour: The "Uncheck this for non-ASCII highlights" option has been removed. Highlights are now done in a slightly different way that should work in all cases, including for example Cyrillic text, thus this option is no longer necessary.
* Changed behaviour: The `index_pdfs` WP CLI command has been retired. It has been replaced with two separate commands: `remove_attachment_contents` removes all read attachment contents from the database and `read_attachments` reads all attachment content from files that haven't been read yet.
* Changed behaviour: Relevanssi excerpts are now wrapped in `span` tags.
* Minor fix: Removes the warning about non-numeric values when using a redirect for the first time.
* Minor fix: Fixes phrase searching using non-US alphabet.
* Minor fix: Sometimes the `relevanssi_user_index_ok` filter would get a user ID and not the object. This is now fixed: it's always an object.
* Minor fix: Excluding posts from the block editor didn't work properly: the post would be marked excluded, but would not actually be removed from the index until the next reindexing of the whole database. This works now as expected.
* Minor fix: Relevanssi would break admin searching for hierarchical post types. This is now fixed, Relevanssi won't do that anymore.
* Minor fix: Relevanssi indexing now survives better shortcodes that change the global `$post`.
* Minor fix: Warnings about missing `relevanssi_update_counts` function are now removed.
* Minor fix: Paid Membership Pro support now takes notice of the "filter queries" setting.
* Minor fix: OR logic didn't work correctly when two phrases both had the same word (for example "freedom of speech" and "free speech"). The search would always be an AND search in those cases. That has been fixed.
* Minor fix: Relevanssi no longer blocks the Pretty Links admin page search.
* Minor fix: The "Respect 'exclude_from_search'" setting did not work if no post type parameter was included in the search parameters.
* Minor fix: The category inclusion and exclusion setting checkboxes on the Searching tab didn't work. The setting was saved, but the checkboxes wouldn't appear.

== Upgrade notice ==
= 2.14.5 =
* Minor bug fixes, stops admin ajax flooding issues.

= 2.14.4 =
* Fixes minor bugs, speeds up post updates a lot in some cases.

= 2.14.3 =
* Fixes post type weights and WPML indexing problems.

= 2.14.2 =
* Stops Relevanssi from crashing when saving posts with ACF fields, major performance boost.

= 2.14.1 =
* Stops Relevanssi from crashing when saving posts.

= 2.14.0 =
* Bug fixes and new features.

= 2.13.1 =
* Fixes broken user and taxonomy term search.

= 2.13.0 =
* Bug fixes and new filter hooks.

= 2.12.2 =
* Switch from `the_posts` to `posts_pre_query`, bug fixes.

= 2.12.1 =
* Fixes problems with the multilingual stopwords and synonyms.

= 2.12.0 =
* Multilingual stopwords and synonyms.

= 2.11.1 =
* Bug fixes.

= 2.11.0 =
* Improved excerpts, all around bug fixes.