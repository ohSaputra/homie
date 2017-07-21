/**
 *
 * The packages we are using
 * Not using gulp-load-plugins as it is nice to see whats here.
 *
 **/
var gulp = require('gulp');
var sass = require('gulp-sass');
var prefix = require('gulp-autoprefixer');
var plumber = require('gulp-plumber');
var uglify = require('gulp-uglify');
var concat = require('gulp-concat');
var rename = require("gulp-rename");
var imagemin = require("gulp-imagemin");
var pngquant = require('imagemin-pngquant');

/**
 *
 * Styles
 * - Compile
 * - Catch errors (gulp-plumber)
 * - Autoprefixer
 *
 **/
gulp.task('sass', function() {
    gulp.src('assets/src/sass/**/*.scss')
        .pipe(sass())
        .pipe(prefix('last 2 versions', '> 1%', 'ie 8', 'Android 2', 'Firefox ESR'))
        .pipe(plumber())
        .pipe(gulp.dest('assets/dist/css'));
});

/**
 *
 * Styles Minify
 * - Compile
 * - Compress/Minify
 * - Catch errors (gulp-plumber)
 * - Autoprefixer
 *
 **/
gulp.task('sass:clean', function() {
    gulp.src('assets/src/sass/**/*.scss')
        .pipe(sass({ outputStyle: 'compressed' }))
        .pipe(prefix('last 2 versions', '> 1%', 'ie 8', 'Android 2', 'Firefox ESR'))
        .pipe(plumber())
        .pipe(gulp.dest('assets/dist/css'));
});

/**
 *
 * Javascript
 * - Concat
 *
 **/
gulp.task('scripts', function() {
    gulp.src('assets/src/js/*.js')
        .pipe(concat('main.js'))
        .pipe(gulp.dest('assets/dist/js'))
});

/**
 *
 * Javascript
 * - Concat
 * - Uglify
 *
 **/
gulp.task('scripts:clean', function() {
    gulp.src('assets/src/js/*.js')
        .pipe(concat('main.js'))
        .pipe(gulp.dest('assets/dist/js'))
        .pipe(uglify())
        .pipe(rename({
            dirname: "min",
            suffix: ".min",
        }))
        .pipe(gulp.dest('assets/dist/js'))
});

/**
 *
 * Images
 * - Compress them!
 *
 **/
gulp.task('images', function() {
    return gulp.src('assets/src/images/*')
        .pipe(imagemin({
            progressive: true,
            svgoPlugins: [{ removeViewBox: false }],
            use: [pngquant()]
        }))
        .pipe(gulp.dest('assets/dist/images'));
});


/**
 *
 * Default task
 * - Runs sass,scripts and image tasks
 * - Watchs for file changes for images, scripts and sass/css
 *
 **/
gulp.task('default', ['sass', 'scripts', 'images'], function() {
    gulp.watch('assets/src/sass/**/*.scss', ['sass']);
    gulp.watch('assets/src/js/**/*.js', ['scripts']);
    gulp.watch('assets/src/images/*', ['images']);
});


/**
 *
 * Build task
 * - Runs sass:clean, scripts:clean and image tasks
 *
 **/
gulp.task('build', ['sass:clean', 'scripts:clean', 'images']);