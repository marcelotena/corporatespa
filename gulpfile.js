var gulp = require('gulp'),
    gutil = require('gulp-util'),
    concat = require('gulp-concat');

var jsSources = [
    'assets/js/customizer.js',
    'assets/js/navigation.js',
    'assets/js/skip-link-focus-fix.js'
]

gulp.task('js', function() {
    gulp.src(jsSources)
        .pipe(concat('script.js'))
        .pipe(gulp.dest('assets/js/min/'));
    gutil.log('> Scripts joined');
});