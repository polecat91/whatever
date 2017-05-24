/**
 * 
 * @type String
 * 
 * SASS outputStyle:
 * https://web-design-weekly.com/2014/06/15/different-sass-output-styles/
 * 
 * Task:
 ** style>          pages scss to css
 ** sys_style>      admin scss to css
 ** script>         pages js to js
 ** sys_script>     admin js to js
 ** images>         pages images to images
 ** sys_images>     admin images to images
 * 
 ** clean>          remove assets/page dir
 ***    clean_image>        remove assets/page/images dir
 ***    clean_js>           remove assets/page/js dir
 ***    clean_css>          remove assets/page/css dir
// ***    clean_vendor        remove assets/vendor dir
 *
 ** sys_clean>      remove assets/admin dir
 ***    sys_clean_image>    remove assets/page/images dir
 ***    sys_clean_js>       remove assets/page/js dir
 ***    sys_clean_css>      remove assets/page/css dir
 *
// ** vendor>         sys/assets/vendor to assets/vendor
 *
 ** > gulp
 *[style, script, images] - watch
 *
 ** > gulp sys
 *[style, script, images] - watch
 *
 ** > gulp clean-all
 *[clean, sys_clean]
 * 
 */

//require
var gulp            = require('gulp'); // Gulp of-course
var sass            = require('gulp-sass'); // Gulp pluign for Sass compilation
var autoprefixer    = require('gulp-autoprefixer'); // Autoprefixing magic
var minifycss       = require('gulp-uglifycss'); // Minifies CSS files
var concat          = require('gulp-concat'); // Concatenates JS files
var uglify          = require('gulp-uglify'); // Minifies JS files
var rename          = require('gulp-rename'); // Renames files E.g. style.css -> style.min.css
var notify          = require('gulp-notify'); // Sends message notification to you
var plumber         = require('gulp-plumber'); // removes standard onerror handler on error event
var clean           = require('gulp-clean'); // remove old file
var imageMin        = require('gulp-imagemin'); // Minifies image files
var cache           = require('gulp-cache'); // Clearing the cache

/*--------------------------------------------------*/
//dir path

var main            = './assets/';
//css
var styleMixin      = './sys/assets/page/css/mixin.scss';
var styleConfig     = './sys/assets/page/css/config.scss';
var scssStyle       = './sys/assets/page/css/page/*.scss';
var scssOut         = './assets/page/css/';
var scssMinOut      = './assets/page/css/optimized/';
var concatFile      = 'main';
//sys css
var sys_styleMixin  = './sys/assets/admin/css/mixin.scss';
var sys_styleConfig = './sys/assets/admin/css/config.scss';
var sys_scssStyle   = './sys/assets/admin/css/page/*.scss';
var sys_scssOut     = './assets/admin/css/';
var sys_scssMinOut  = './assets/admin/css/optimized/';
var sys_concatFile  = 'main';
//js
var jsStyle         = './sys/assets/page/js/*.js';
var jsOut           = './assets/page/js/';
var jsMinOut        = './assets/page/js/optimized/';
var concatJsFile    = 'main';
//sys js
var sys_jsStyle     = './sys/assets/admin/js/*.js';
var sys_jsOut       = './assets/admin/js/';
var sys_jsMinOut    = './assets/admin/js/optimized/';
var sys_concatJsFile= 'main';
//images
var imageIn         = './sys/assets/page/images/**/*';
var imageOut        = './assets/page/images/';
//sys images
var sys_imageIn     = './sys/assets/admin/images/**/*';
var sys_imageOut    = './assets/admin/images/';
//vendor
//var vendorIn        = './sys/assets/vendors/**/*'
//var vendorOut       = './assets/vendors/'

//sass
gulp.task('style', function() {
    gulp.src( [ styleMixin, styleConfig, scssStyle ] )
        .pipe( concat( concatFile + '.css' ) )
		.pipe( sass( {
			errLogToConsole: true,
			outputStyle: 'compressed',
			precision: 10
		} ) )
		.pipe( autoprefixer( 'last 2 version' ) )
		.pipe( gulp.dest( scssOut ) )
		.pipe( notify( { message: 'TASK: "styles" Completed!', onLast: true } ) )
});
gulp.task('sys_style', function() {
    gulp.src( [ sys_styleMixin, sys_styleConfig, sys_scssStyle ] )
        .pipe( concat( sys_concatFile + '.css' ) )
		.pipe( sass( {
			errLogToConsole: true,
			outputStyle: 'compressed',
			precision: 10
		} ) )
		.pipe( autoprefixer( 'last 2 version' ) )
		.pipe( gulp.dest( sys_scssOut ) )
		.pipe( notify( { message: 'TASK: "sys_style" Completed!', onLast: true } ) )
});
//js
gulp.task( 'script', ['clean_js'], function() {
 	gulp.src( jsStyle )
//		.pipe( concat( concatJsFile + '.js' ) )
		.pipe( gulp.dest( jsOut ) )
		
		.pipe( uglify() )
		.pipe( gulp.dest( jsMinOut ) )
		.pipe( notify( { message: 'TASK: "script" Completed!', onLast: true } ) );
});
gulp.task( 'sys_script', function() {
 	gulp.src( sys_jsStyle )
//		.pipe( concat( sys_concatJsFile + '.js' ) )
		.pipe( gulp.dest( sys_jsOut ) )
		
		.pipe( uglify() )
		.pipe( gulp.dest( sys_jsMinOut ) )
		.pipe( notify( { message: 'TASK: "sys_script" Completed!', onLast: true } ) );
});
//images
gulp.task('images', function(){
    gulp.src( imageIn )
        .pipe( plumber({
            handleError: function ( err ) {
                this.emit( 'end' );
            }
        }))
        .pipe( cache( imageMin() ) )
        .pipe( gulp.dest( imageOut ))
		.pipe( notify( { message: 'images task finished!', onLast: true } ) );
});
gulp.task('sys_images', function(){
    gulp.src( sys_imageIn )
        .pipe( plumber({
            handleError: function ( err ) {
                this.emit( 'end' );
            }
        }))
        .pipe( cache( imageMin() ) )
        .pipe( gulp.dest( sys_imageOut ))
		.pipe( notify( { message: 'sys_images task finished!', onLast: true } ) );
});
//clean
gulp.task('clean_image', function () {
    return gulp.src( imageOut, {read: false} )
        .pipe(clean());
});
gulp.task('clean_js', function () {
    return gulp.src( jsOut, {read: false} )
        .pipe(clean());
});
gulp.task('clean_css', function () {
    return gulp.src( scssOut, {read: false} )
        .pipe(clean());
});
//gulp.task('clean_vendor', function () {
//    return gulp.src( vendorOut, {read: false} )
//        .pipe(clean());
//});
gulp.task('sys_clean_image', function () {
    return gulp.src( sys_imageOut, {read: false} )
        .pipe(clean());
});
gulp.task('sys_clean_js', function () {
    return gulp.src( sys_jsOut, {read: false} )
        .pipe(clean());
});
gulp.task('sys_clean_css', function () {
    return gulp.src( sys_scssOut, {read: false} )
        .pipe(clean());
});

gulp.task('clean', ['clean_image', 'clean_js', 'clean_css']);
gulp.task('sys_clean', ['sys_clean_image', 'sys_clean_js', 'sys_clean_css']);

gulp.task( 'default', [ 'style', 'script', 'images' ], function () {
    gulp.watch( scssStyle, [ 'style' ] );
    gulp.watch( jsStyle, [ 'script' ] );
    gulp.watch( imageIn, [ 'images' ] );
});
gulp.task( 'sys', [ 'sys_style', 'sys_script', 'sys_images' ], function () {
    gulp.watch( sys_scssStyle, [ 'sys_style' ] );
    gulp.watch( sys_jsStyle, [ 'sys_script' ] );
    gulp.watch( sys_imageIn, [ 'sys_images' ] );
});
gulp.task( 'clean-all', [ 'clean', 'sys_clean' ]);