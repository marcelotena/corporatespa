var gulp = require('gulp'),
    gutil = require('gulp-util'),
    browserify = require('gulp-browserify'),
    compass = require('gulp-compass'),
    concat = require('gulp-concat');

var jsSources = [
    'assets/js/navigation.js',
    'assets/js/skip-link-focus-fix.js',
    'assets/js/angular_app/app.module.js',
    'assets/js/angular_app/app.route.js',
    'assets/js/angular_app/components/post.factory.js',
    'assets/js/angular_app/components/menu.service.js',
    'assets/js/angular_app/components/navbarctrl.controller.js',
    'assets/js/angular_app/components/postlistctrl.controller.js',
    'assets/js/angular_app/components/detailctrl.controller.js',
    'assets/js/angular_app/components/totrusted.filter.js',
    'assets/js/angular_app/app.config.js'
];

var sassSources = [
    'assets/stylesheets/style.scss'
];

gulp.task('js', function() {
    gulp.src(jsSources)
        .pipe(concat('script.js'))
        .pipe(browserify())
        .pipe(gulp.dest('assets/js/min/'));
    gutil.log('>> Scripts joined <<');
});

gulp.task('compass', function() {
    gulp.src(sassSources)
        .pipe(compass({
            sass: 'assets/stylesheets',
            image: 'assets/images',
            style: 'expanded'
        }))
        .pipe(gulp.dest('assets/css/'));
    gutil.log('>> SASS files processed <<');
});

gulp.task('watch', function() {
    gulp.watch(jsSources, ['js']);
    gulp.watch('assets/stylesheets/**/*.scss', ['compass']);
});

gulp.task('default', ['js', 'compass', 'watch']);