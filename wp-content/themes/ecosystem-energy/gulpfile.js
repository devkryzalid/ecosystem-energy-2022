'use strict';

// Load plugins
var autoprefixer = require('autoprefixer');
var cssnano = require('cssnano');
var del = require('del');
var eslint = require('gulp-eslint');
var gulp = require('gulp');
var imagemin = require('gulp-imagemin');
var newer = require('gulp-newer');
var plumber = require('gulp-plumber');
var postcss = require('gulp-postcss');
var rename = require('gulp-rename');
var sass = require('gulp-sass');
var uglify = require('gulp-uglify');

// Clean assets
function clean() {
  return del(['./dist/']);
}

// Optimize Images
function images() {
  return gulp
    .src('./assets/images/**/*')
    .pipe(newer('./dist/images'))
    .pipe(
      imagemin([
        imagemin.gifsicle({ interlaced: true }),
        imagemin.jpegtran({ progressive: true }),
        imagemin.optipng({ optimizationLevel: 5 }),
        imagemin.svgo({
          plugins: [
            {
              removeViewBox: false,
              collapseGroups: true
            }
          ]
        })
      ])
    )
    .pipe(gulp.dest('./dist/images'));
}

// Fonts task 
function fonts() {
  return gulp
    .src('./assets/fonts/**/*')
    .pipe(gulp.dest('dist/fonts'));
}

// CSS task
function css() {
  return gulp
    .src('./assets/styles/**/*.scss')
    .pipe(plumber())
    .pipe(sass({ outputStyle: 'expanded' }))
    .pipe(gulp.dest('./dist/styles/'))
    .pipe(rename({ suffix: '.min' }))
    .pipe(postcss([autoprefixer(), cssnano()]))
    .pipe(gulp.dest('./dist/styles/'));
}

// Lint scripts
function scriptsLint() {
  return gulp
    .src(['./assets/scripts/**/*', './gulpfile.js'])
    .pipe(plumber())
    .pipe(eslint({
      'rules':{
          'quotes': [1, 'single'],
          'semi': [1, 'always']
      }
    }))
    .pipe(eslint.format())
    .pipe(eslint.failAfterError());
}

// Transpile, concatenate and minify scripts
function scripts() {
  return (
    gulp
      .src(['./assets/scripts/**/*'], { nodir: true })
      .pipe(plumber())
      .pipe(rename({ suffix: '.min' }))
      .pipe(uglify())
      .pipe(gulp.dest('./dist/scripts/'))
  );
}

// Watch files
function watchFiles() {
  gulp.watch('./assets/styles/**/*.scss', css);
  gulp.watch('./assets/scripts/**/*.js', gulp.series(scriptsLint, scripts));
  gulp.watch('./assets/images/**/*', images);
  gulp.watch('./assets/fonts/**/*', fonts);
}

// define complex tasks
var js = gulp.series(scriptsLint, scripts);
var build = gulp.series(clean, gulp.parallel(css, fonts, images, js));
var watch = gulp.parallel(watchFiles);

// export tasks
exports.images = images;
exports.css = css;
exports.js = js;
exports.clean = clean;
exports.build = build;
exports.fonts = fonts;
exports.watch = watch;
exports.default = build;