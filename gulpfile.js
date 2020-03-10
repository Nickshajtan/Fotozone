/*
* run "npm install" to install all dependencies from package.json or run those manually
*
*/

'use strict';
var gulp           = require('gulp'),
    gutil          = require('gulp-util' ),
    data           = require('gulp-data'),
    path           = require('path'),
    sass           = require('gulp-sass'),
    less           = require('gulp-less'),
    stylus         = require('gulp-stylus').stylus,
    concat         = require('gulp-concat'),
    uglify         = require('gulp-uglify-es').default,
    sourcemaps     = require('gulp-sourcemaps'),
    autoprefixer   = require('gulp-autoprefixer'),
    LessAutoprefix = require('less-plugin-autoprefix'),
    autoprefix     = new LessAutoprefix({ browsers: ['last 2 versions'] }),
    fontmin        = require('gulp-fontmin'),
    htmlmin        = require('gulp-htmlmin'),
    imagemin       = require('gulp-imagemin'),
    imageminSvgo   = require('imagemin-svgo'),
    browsersync    = require('browser-sync').create(),
    notify         = require('gulp-notify');
    
var notifyOptions = {
  message : 'Error:: <%= error.message %> \nLine:: <%= error.line %> \nCode:: <%= error.extract %>'
};

var syntax = [ 'scss' ]; // Include your css syntax into array;

function browserSync(done) {
	browsersync.init({
        //Domen name or main directory ( choose server or proxy )
        //server: "passagency",  //server + /sync-options = settings 
        proxy: "avto.com", //proxy + /sync-options = settings; OSpanel domen name
        notify: false,
        //port: 8080, 3000
        //open: true,
        //files: ;
	});
    done();
}

function browserSyncReload() {
  browsersync.reload();
}

/*
* compile base theme scss
*/
gulp.task('base-theme-styles', function(){
  return gulp
  .src('./assets/styles/base/base-theme-styles.scss')
  .pipe(sourcemaps.init())
  .pipe(sass({outputStyle: 'compressed'}).on('error',  notify.onError(notifyOptions)))
  .pipe(autoprefixer({ overrideBrowserslist: ['last 99 versions'], cascade: false }))
  .pipe(concat('base-theme-styles.min.css'))
  .pipe(sourcemaps.write('.'))
  .pipe(gulp.dest('./assets/public/'));
});

/*
* compile theme scss
*/
if( syntax.indexOf( 'scss' ) != -1 ){
    
    // Styles for first site screen
    gulp.task('scss-head-styles', function(){
      return gulp
      .src('./assets/styles/scss/theme/head/first-screen.scss')
      .pipe(sourcemaps.init())
      .pipe(sass({outputStyle: 'compressed'}).on('error',  notify.onError(notifyOptions)))
      .pipe(autoprefixer({ overrideBrowserslist: ['last 99 versions'], cascade: false }))
      .pipe(concat('scss-header-theme-styles.min.css'))
      .pipe(sourcemaps.write('.'))
      .pipe(gulp.dest('./assets/public/'));
    });
    
    // Other site styles
    gulp.task('scss-other-styles', function(){
      return gulp
      .src('./assets/styles/scss/theme/other/main.scss')
      .pipe(sourcemaps.init())
      .pipe(sass({outputStyle: 'compressed'}).on('error',  notify.onError(notifyOptions)))
      .pipe(autoprefixer({ overrideBrowserslist: ['last 99 versions'], cascade: false }))
      .pipe(concat('scss-other-theme-styles.min.css'))
      .pipe(sourcemaps.write('.'))
      .pipe(gulp.dest('./assets/public/'));
    });
    
    // Vendor styles
    gulp.task('scss-vendor-styles', function(){
      return gulp
      .src('./assets/styles/scss/vendor/vendor.scss')
      .pipe(sourcemaps.init())
      .pipe(sass({outputStyle: 'compressed'}).on('error',  notify.onError(notifyOptions)))
      .pipe(autoprefixer({ overrideBrowserslist: ['last 99 versions'], cascade: false }))
      .pipe(concat('scss-vendor-styles.min.css'))
      .pipe(sourcemaps.write('.'))
      .pipe(gulp.dest('./assets/public/'));
    });
    
    console.log( 'SCSS syntax: Enable' );
}

/*
* compile theme sass
*/
if( syntax.indexOf( 'sass' ) != -1 ){
    
    // Styles for first site screen
    gulp.task('sass-head-styles', function(){
      return gulp
      .src('./assets/styles/sass/theme/head/first-screen.scss')
      .pipe(sourcemaps.init())
      .pipe(sass({outputStyle: 'compressed'}).on('error',  notify.onError(notifyOptions)))
      .pipe(autoprefixer({ overrideBrowserslist: ['last 99 versions'], cascade: false }))
      .pipe(concat('sass-header-theme-styles.min.css'))
      .pipe(sourcemaps.write('.'))
      .pipe(gulp.dest('./assets/public/'));
    });
    
    // Other site styles
    gulp.task('sass-other-styles', function(){
      return gulp
      .src('./assets/styles/sass/theme/other/main.scss')
      .pipe(sourcemaps.init())
      .pipe(sass({outputStyle: 'compressed'}).on('error',  notify.onError(notifyOptions)))
      .pipe(autoprefixer({ overrideBrowserslist: ['last 99 versions'], cascade: false }))
      .pipe(concat('sass-other-theme-styles.min.css'))
      .pipe(sourcemaps.write('.'))
      .pipe(gulp.dest('./assets/public/'));
    });
    
    // Vendor styles
    gulp.task('sass-vendor-styles', function(){
      return gulp
      .src('./assets/styles/sass/vendor/vendor.scss')
      .pipe(sourcemaps.init())
      .pipe(sass({outputStyle: 'compressed'}).on('error',  notify.onError(notifyOptions)))
      .pipe(autoprefixer({ overrideBrowserslist: ['last 99 versions'], cascade: false }))
      .pipe(concat('sass-vendor-styles.min.css'))
      .pipe(sourcemaps.write('.'))
      .pipe(gulp.dest('./assets/public/'));
    });
    
    console.log( 'SASS syntax: Enable' );
}

/*
* compile theme less
*/
if( syntax.indexOf( 'less' ) != -1 ){
    
    // Styles for first site screen
    gulp.task('less-head-styles', function () {
      return gulp
        .src('./assets/styles/less/theme/head/first-screen.less')
        .pipe(sourcemaps.init())
        .pipe(less({ paths: [ path.join(__dirname, 'less', 'includes') ], plugins: [autoprefix] }).on('error',  notify.onError(notifyOptions)))
        .pipe(concat('less-header-theme-styles.min.css'))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./assets/public/'));
    });
    
    // Other site styles
    gulp.task('less-other-styles', function () {
      return gulp
        .src('./assets/styles/less/theme/other/main.less')
        .pipe(sourcemaps.init())
        .pipe(less({ paths: [ path.join(__dirname, 'less', 'includes') ], plugins: [autoprefix] }).on('error',  notify.onError(notifyOptions)))
        .pipe(concat('less-other-theme-styles.min.css'))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./assets/public/'));
    });
    
    // Vendor styles
    gulp.task('less-vendor-styles', function () {
      return gulp
        .src('./assets/styles/less/vendor/vendor.less')
        .pipe(sourcemaps.init())
        .pipe(less({ paths: [ path.join(__dirname, 'less', 'includes') ], plugins: [autoprefix] }).on('error',  notify.onError(notifyOptions)))
        .pipe(concat('less-vendor-styles.min.css'))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./assets/public/'));
    });
    
    console.log( 'LESS syntax: Enable' );
}

/*
* compile theme stylus
*/
if( syntax.indexOf( 'stylus' ) != -1 ){
    var data = {red: '#ff0000'};
    
    // Styles for first site screen
    gulp.task('stylus-head-styles', function () {
      return gulp
        .src('./assets/styles/stylus/theme/head/first-screen.styl')
        .pipe(data(function(file){return {
            componentPath: '/' + (file.path.replace(file.base, '').replace(/\/[^\/]*$/, ''))
        };}))
        .pipe(sourcemaps.init())
        .pipe(stylus({
            compress: true,
            linenos: true,
            'include css': true,
            rawDefine: { data: data }
        }))
        .pipe(concat('stylus-header-theme-styles.min.css'))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./assets/public/'));
    });
    
    // Other site styles
    gulp.task('stylus-other-styles', function () {
      return gulp
        .src('./assets/styles/stylus/theme/other/main.styl')
        .pipe(data(function(file){return {
            componentPath: '/' + (file.path.replace(file.base, '').replace(/\/[^\/]*$/, ''))
        };}))
        .pipe(sourcemaps.init())
        .pipe(stylus({
            compress: true,
            linenos: true,
            'include css': true,
            rawDefine: { data: data }
        }))
        .pipe(concat('stylus-other-theme-styles.min.css'))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./assets/public/'));
    });
    
    // Vendor styles
    gulp.task('stylus-vendor-styles', function () {
      return gulp
        .src('./assets/styles/stylus/vendor/vendor.styl')
        .pipe(data(function(file){return {
            componentPath: '/' + (file.path.replace(file.base, '').replace(/\/[^\/]*$/, ''))
        };}))
        .pipe(sourcemaps.init())
        .pipe(stylus({
            compress: true,
            linenos: true,
            'include css': true,
            rawDefine: { data: data }
        }))
        .pipe(concat('stylus-vendor-styles.min.css'))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./assets/public/'));
    });
    
    console.log( 'STYLUS syntax: Enable' );
}

/*
* wrap front styling for gutenberg admin
*/
gulp.task('gtb-styles', function(){
  return gulp
  .src('./assets/styles/base/gtb.scss')
  .pipe(sourcemaps.init())
  .pipe(sass({outputStyle: 'compressed'}).on('error',  notify.onError(notifyOptions)))
  .pipe(autoprefixer({ overrideBrowserslist: ['last 99 versions'], cascade: false }))
  .pipe(concat('gtb.min.css'))
  .pipe(sourcemaps.write('.'))
  .pipe(gulp.dest('./assets/public/'));
});

/*
* compile theme js
*/
gulp.task('theme-scripts', function() {
  return gulp
  .src('./assets/js/theme/*.js')
  .pipe(concat('theme.min.js'))
  .pipe(sourcemaps.init())
  .pipe(uglify())
  .pipe(sourcemaps.write('.'))
  .pipe(gulp.dest('./assets/public/'));
});

/*
* compile vendor scripts
*/
gulp.task('vendor-scripts', function() {
  return gulp
  .src('./assets/js/vendor/*.js')
  .pipe(concat('vendor.min.js'))
  .pipe(sourcemaps.init())
  .pipe(uglify())
  .pipe(sourcemaps.write('.'))
  .pipe(gulp.dest('./assets/public/'));
});

/*
* optimize theme images
*/
gulp.task('compress-img', function(done) {
    return gulp
    .src('./assets/img/**/*')
    .pipe(sourcemaps.init())
    .pipe(imagemin([
            imageminSvgo({
                plugins: [
                    {removeViewBox: true}
                ]
            })
        ]))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest('./assets/public/img/'))
    .on('end', done);
});

/*
* minify html code
*/
gulp.task('compress-html', function(done) {
  return gulp
    .src(['*.html', './**/*.html'])
    .pipe(htmlmin({ collapseWhitespace: true }))
    .pipe(gulp.dest('./assets/public/'))
    .on('end', done);
});

/*
* minify fonts
*/
function minifyFont(text, cb) {
    gulp
    .src('./assets/fonts/**/*.ttf')
    .pipe(fontmin({
            text: text
    }))
    .pipe(gulp.dest('./public/fonts/'))
    .on('end', cb);
}
gulp.task('compress-fonts', function(cb) {
    var buffers = [];
    gulp.src('index.php')
    .on('data', function(file) {
            buffers.push(file.contents);
    })
    .on('end', function() {
            var text = Buffer.concat(buffers).toString('utf-8');
            minifyFont(text, cb);
    });
});

/*
* copy fonts dir
*/
gulp.task('copy-dir-fonts', function(done) {
    return gulp
    .src('./assets/fonts/**/*.*')
    .on('data', function(file){  
			console.log({
                contents: file.contents,                 
                path: file.path,                         
                cwd: file.cwd,                           
                base: file.base,                         
                // path component helpers                
                relative: file.relative,                 
                dirname: file.dirname,                   
                basename: file.basename,                 
                stem: file.stem,                         
                extname: file.extname   
            });                 
    })    
    .pipe(gulp.dest('./assets/public/fonts/') );
});

gulp.task('fonts-styles', function(){
  return gulp
  .src('./assets/fonts/fonts.css')
  .pipe(sourcemaps.init())
  .pipe(sass({outputStyle: 'compressed'}).on('error',  notify.onError(notifyOptions)))
  .pipe(autoprefixer({ browsers: ['last 99 versions'], cascade: false }))
  .pipe(concat('fonts.min.css'))
  .pipe(sourcemaps.write('.'))
  .pipe(gulp.dest('./assets/public/'));
});

/*
* copy libs dir
*/
gulp.task('copy-dir-libs', function(done) {
    return gulp
    .src('./assets/libs/**/*.*')
    .on('data', function(file){  
			console.log({
                contents: file.contents,                 
                path: file.path,                         
                cwd: file.cwd,                           
                base: file.base,                         
                // path component helpers                
                relative: file.relative,                 
                dirname: file.dirname,                   
                basename: file.basename,                 
                stem: file.stem,                         
                extname: file.extname   
            });                
    })    
    .pipe(gulp.dest('./assets/public/libs/') );
});

/*
* compile instagram js witheout API
*/
gulp.task('inst-script-no-api', function() {
  return gulp
  .src('./includes/helpers/instagram/assets/jquery.instagramFeed.js')
  .pipe(concat('jquery.instagramFeed.min.js'))
  .pipe(sourcemaps.init())
  .pipe(uglify())
  .pipe(sourcemaps.write('.'))
  .pipe(gulp.dest('./assets/public/'));
});

/*
* compile instagram js with API
*/
gulp.task('inst-script-api', function() {
  return gulp
  .src('./includes/helpers/instagram/assets/instApi.js')
  .pipe(concat('instApi.min.js'))
  .pipe(sourcemaps.init())
  .pipe(uglify())
  .pipe(sourcemaps.write('.'))
  .pipe(gulp.dest('./assets/public/'));
});

/*
*  run task for one time vendor styles, js files compiling
*/
if( syntax.indexOf( 'scss' ) != -1 ){
    gulp.task('vendor', gulp.series('scss-vendor-styles','vendor-scripts', 'copy-dir-libs', 'copy-dir-fonts', 'fonts-styles'));
}
if( syntax.indexOf( 'sass' ) != -1 ){
    gulp.task('vendor', gulp.series('sass-vendor-styles','vendor-scripts', 'copy-dir-libs', 'copy-dir-fonts', 'fonts-styles'));
}
if( syntax.indexOf( 'less' ) != -1 ){
    gulp.task('vendor', gulp.series('less-vendor-styles','vendor-scripts', 'copy-dir-libs', 'copy-dir-fonts', 'fonts-styles'));
}
if( syntax.indexOf( 'stylus' ) != -1 ){
    gulp.task('vendor', gulp.series('stylus-vendor-styles','vendor-scripts', 'copy-dir-libs', 'copy-dir-fonts', 'fonts-styles'));
}

/*
* run task to minify files, main time html files
*/
gulp.task('compress', gulp.series('compress-html'));

/* 
* run task for continuous track of theme files 
*/
gulp.task('watch-theme', function() {
    if( syntax.indexOf( 'scss' ) != -1 ){
        gulp.watch('./assets/styles/scss/theme/**/*.scss',   gulp.series('scss-head-styles','scss-other-styles','gtb-styles','base-theme-styles')).on( 'change', browserSyncReload );
    }
    if( syntax.indexOf( 'sass' ) != -1 ){
        gulp.watch('./assets/styles/sass/theme/**/*.sass',   gulp.series('sass-head-styles','sass-other-styles','gtb-styles','base-theme-styles')).on( 'change', browserSyncReload );
    }
    if( syntax.indexOf( 'less' ) != -1 ){
        gulp.watch('./assets/styles/less/theme/**/*.less',   gulp.series('less-head-styles','less-other-styles','gtb-styles','base-theme-styles')).on( 'change', browserSyncReload );
    }
    if( syntax.indexOf( 'stylus' ) != -1 ){
        gulp.watch('./assets/styles/stylus/theme/**/*.styl', gulp.series('stylus-head-styles','stylus-other-styles','gtb-styles','base-theme-styles')).on( 'change', browserSyncReload );
    }
	gulp.watch('./assets/fonts/fonts.css',  gulp.series('fonts-styles', 'copy-dir-fonts')).on( 'change', browserSyncReload );
	gulp.watch('./assets/js/theme/*.js',  gulp.series('theme-scripts')).on( 'change', browserSyncReload );
	gulp.watch('./includes/helpers/instagram/assets/*.js',  gulp.series('inst-script-api', 'inst-script-no-api')).on( 'change', browserSyncReload );
	gulp.watch(['./assets/img/**/*', './assets/img/*'], gulp.series('compress-img')).on( 'change', browserSyncReload );
    gulp.watch(['./**/*.php', '*.php']).on('change', browserSyncReload );
});

gulp.task('default', gulp.parallel('watch-theme', 'copy-dir-libs', 'copy-dir-fonts', 'fonts-styles', 'vendor', browserSync));