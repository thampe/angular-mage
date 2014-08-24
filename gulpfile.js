var gulp = require('gulp');
var gutil = require('gulp-util');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');
var sourcemaps = require('gulp-sourcemaps');
var ngAnnotate = require('gulp-ng-annotate');
var del = require('del');

gulp.task('default', ['clean', 'js']);

gulp.task('js', function(){
    gulp.src(['src/js/angular-mage/src/**/*.module.js','src/js/angular-mage/src/**/*.js'])
        .pipe(sourcemaps.init())
        .pipe(concat('angular-mage.js'))
        .pipe(ngAnnotate())
        .pipe(gulp.dest('src/js/angular-mage'))
        .pipe(uglify())
        .pipe(rename({suffix: '.min'}))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('src/js/angular-mage'))
    ;

});

gulp.task('clean', function(cb) {
    del(['src/js/angular-mage/*.{js,map}',], cb);
});