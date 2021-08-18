/**
 * VF-WP Gulp
 */
const gulp = require('gulp');
require('./gulp-tasks/vf-core');
const {blocksTask, blocksGlob} = require('./gulp-tasks/vf-gutenberg');

/**
 * VF-SiS Gutenberg blocks
 */
gulp.task('vf-gutenberg', blocksTask);

/**
 * Watch tasks
 */
gulp.task('watch', gulp.parallel('vf-watch'));
gulp.task('vf-gutenberg-watch', () =>
  gulp.watch(blocksGlob, gulp.series('vf-gutenberg'))
);

/**
 * Build tasks
 */
gulp.task(
  'build',
  gulp.series(
    'vf-wp-clean:assets',
    'vf-css:generate-component-css',
    gulp.parallel('vf-css', 'vf-scripts'),
    'vf-component-assets',
    'vf-css:production'
  )
);

/**
 * Default task
 */
gulp.task('default', gulp.series('build', 'watch'));
