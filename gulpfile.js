/*
 * This file is part of con4gis, the gis-kit for Contao CMS.
 * @package con4gis
 * @version 8
 * @author con4gis contributors (see "authors.txt")
 * @license LGPL-3.0-or-later
 * @copyright (c) 2010-2022, by Küstenschmiede GmbH Software & Design
 * @link https://www.con4gis.org
 */

const gulp = require('gulp');
const plumber = require('gulp-plumber');
const sass = require('gulp-sass')(require('sass'));
const autoprefixer = require('gulp-autoprefixer');
const notify = require('gulp-notify');
const cleanCSS = require('gulp-clean-css');
const rename = require('gulp-rename');

const customPath = 'src/Resources/public/';

const paths = {
    src: {
        styles: customPath + 'src/scss/*.scss',
    },
    dist: {
        styles: customPath + 'dist/css',
        stylesMin: customPath + 'dist/css',
    },
    watch: {
        styles: customPath + 'src/scss/**/*.scss',
    },
};

// reading your sass files, add autoprefixer options, create sourcemaps, generate css file, inject css via browser-sync
const styles = function () {
    return gulp.src(paths.src.styles)
        .pipe(plumber({errorHandler: notify.onError('Error: <%= error.message %>')}))
        .pipe(sass())
        .pipe(autoprefixer({
            cascade: false
        }))
        .pipe(cleanCSS({format: "beautify"}))
        .pipe(gulp.dest(paths.dist.styles));
};
exports.styles = styles;

// nearly the same that ['styles'] does, but minify css via cleanCSS
const minifyCss = function () {
    return gulp.src(paths.src.styles)
        .pipe(plumber())
        .pipe(sass())
        .pipe(autoprefixer({
            cascade: false
        }))
        .pipe(cleanCSS())
        .pipe(rename({extname: '.min.css'}))
        .pipe(gulp.dest(paths.dist.styles));
};
exports.minify_css = minifyCss;

const watch = function (done) {
    gulp.watch(paths.watch.styles, gulp.series([styles]));
    done();
};

exports.default = gulp.parallel([watch]);
exports.deploy = gulp.series([styles, minifyCss]);
