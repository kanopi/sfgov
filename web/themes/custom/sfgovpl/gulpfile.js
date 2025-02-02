"use strict";

const gulp = require('gulp');
const sass = require('gulp-sass');
const sassLint = require('gulp-sass-lint');
const sourcemaps = require('gulp-sourcemaps');
const imagemin = require('gulp-imagemin');
const concat = require('gulp-concat');
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const browsersync = require('browser-sync').create();

const config = require('./config');

function css() {
  const plugins = [
    autoprefixer()
  ];
  return gulp
    .src(config.css.source)
    // .pipe(sassLint())
    // .pipe(sassLint.format())
    // .pipe(sassLint.failOnError())
    .pipe(sourcemaps.init())
    .pipe(sass({ outputStyle: 'expanded'}))
    .pipe(postcss(plugins))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest(config.css.dest))
    .pipe(browsersync.stream());
}

// not currently doing anything with images
function images() {
  return gulp
    .src(config.images.source)
    .pipe(imagemin())
    .pipe(gulp.dest(config.images.dest));
}

function serve() {
  browsersync.init({
    proxy: 'https://sfgov.lndo.site/'
  });
}

function watch() {
  gulp.watch(config.css.source, css);
}

exports.css = gulp.series(css);

exports.default = gulp.series(
  gulp.parallel(css),
  gulp.parallel(watch, serve)
);
