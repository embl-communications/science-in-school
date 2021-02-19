/**
 * VF-WP Gulp
 */
const gulp = require('gulp');
require('./gulp-tasks/vf-core');

/**
 * Watch tasks
 */
gulp.task('watch', gulp.parallel('vf-watch'));

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
