// Load plugins

var gulp = require('gulp');	
var	sass = require('gulp-sass');
var	notify = require('gulp-notify');

var compile = '../assets';

var sassSRC = 'src/sass/**/style.scss';
var sassWatch = 'src/sass/**/*.scss';


// Compile SASS & reload page

gulp.task('styles', function() {
    gulp.src(sassSRC)
    .pipe(sass().on('error', sass.logError ))
    .pipe(gulp.dest(compile))
});


// Watch changes

gulp.task('default', function() {
    gulp.watch(sassWatch, ['styles'])
});