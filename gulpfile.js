/**
 * Arquivo de Configuração do Gulp
 * @author Roberto de Abreu Bento <dti@garopaba.sc.gov.br>
 */

// Including plugins
var gulp = require('gulp')
    , minifyHtml = require("gulp-minify-html")
    , cleanCSS = require('gulp-clean-css')
    , uglify = require("gulp-uglify-es").default
    , image = require('gulp-image')
    , del = require('del');

// Clean destiny directory
gulp.task('clean', function () {
    return del([
        'dist/**/*'
    ]);
});

// HTML
gulp.task('view-html', function () {
    return gulp.src('./view/**/*.html')
        .pipe(minifyHtml())
        .pipe(gulp.dest('dist/view'));
});

// JS
gulp.task('view-js', function () {
    return gulp.src('./view/**/*.js')
        .pipe(uglify())
        .pipe(gulp.dest('dist/view'));
});

// CSS / FONTS
gulp.task('view-css', function () {
    return gulp.src('./view/**/*.css.map')
        .pipe(gulp.dest('dist/view')) &&
        gulp.src('./view/fonts/**/*')
        .pipe(gulp.dest('dist/view/fonts')) &&
        gulp.src('./view/**/*.css')
        .pipe(cleanCSS())
        .pipe(gulp.dest('dist/view'));
});

// IMG
gulp.task('view-img', function () {
    return gulp.src('./view/images/icons/**/*')
        .pipe(gulp.dest('dist/view/images/icons')) &&
        gulp.src('./view/**/*.png')
        .pipe(image())
        .pipe(gulp.dest('dist/view'));
});

// PHP
gulp.task('controller', function () {
    return gulp.src('./controller/**/*')
        .pipe(gulp.dest('dist/controller'));
});

gulp.task('model', function () {
    return gulp.src('./model/**/*')
        .pipe(gulp.dest('dist/model'));
});

gulp.task('index', function () {
    return gulp.src('./index.php')
        .pipe(gulp.dest('dist/'));
});

// Watch
gulp.task('watch', function () {
    gulp.watch('./view/**/*.html', gulp.series('view-html')); 
    gulp.watch('./view/**/*.js', gulp.series('view-js')); 
    gulp.watch('./view/**/*.css', gulp.series('view-css')); 
    gulp.watch('./controller/**/*', gulp.series('controller')); 
    gulp.watch('./model/**/*', gulp.series('model')); 
});

// Default
gulp.task('default', gulp.series(
    'clean',
    'view-html',
    'view-js',
    'view-css',
    'view-img',
    'controller',
    'model',
    'index'
)
);