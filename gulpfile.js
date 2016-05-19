var gulp        = require('gulp');
var del         = require('del');
var mkdirp      = require('mkdirp');
var glob        = require('glob-all');
var fs          = require('fs-extra');
var zip         = require('gulp-zip');
var runSequence = require('run-sequence');
var jscs        = require('gulp-jscs');
var sass        = require('gulp-sass');
var sourcemaps  = require('gulp-sourcemaps');
var notify      = require("gulp-notify");
var bourbon     = require('node-bourbon');
var gulpif      = require('gulp-if');
var rename      = require('gulp-rename');
/** @var {{ themeName, themeModulePrefix, sourcemaps }} options **/
var options     = require('./package.json').options;

var createFolders = [
  './themes/' + options.themeName + '/cache/',
  './themes/' + options.themeName + '/pdf/',
  './themes/' + options.themeName + '/pdf/lang/'
];

var copyIndexIgnore = [];

var cleanUp = [
  './themes/' + options.themeName + '/.sass-cache/',
  './themes/' + options.themeName + '/cache/*',
  './themes/' + options.themeName + '/css/**/*.css.map'
];

gulp.task('create-folders', function(callback){
  var total = createFolders.length;
  var done  = 0;

  if (total < 1 && callback) {
    callback();
  }

  createFolders.forEach(function(path){
    mkdirp(path, function (err) {
      if (err) {
        console.error(err);
      } else {
        console.log('Created folder : ' + path);
      }

      done++;
      if (done == total && callback) {
        callback();
      }
    });
  });
});

function displayNotification(msg){
  return notify(msg);
}

gulp.task('compile-css', function(){
  return gulp.src('./themes/' + options.themeName + '/sass/**/*.scss')
    .pipe(sass({
      includePaths: bourbon.includePaths,
      outputStyle: 'expanded',
      precision: 8
    })
    .on('error', function() {
      displayNotification(sass.logError);
    }))
    .pipe(gulpif(options.sourcemaps, sourcemaps.init()))
    .pipe(gulpif(options.sourcemaps, sourcemaps.write('./')))
    .pipe(gulp.dest('./themes/' + options.themeName + '/css/'))
    .pipe(displayNotification({
      message: 'Theme CSS compilation successful for ' + options.themeName,
      onLast: true
    }));
});

gulp.task('compile-module-css', function(){
  return gulp
    .src('./modules/' + options.themeModulePrefix + '*/views/sass/**/*.scss')
    .pipe(sass({
      includePaths: bourbon.includePaths,
      outputStyle: 'expanded',
      precision: 8
    })
    .on('error', function() {
      displayNotification(sass.logError);
    }))
    .pipe(gulpif(options.sourcemaps, sourcemaps.init()))
    .pipe(gulpif(options.sourcemaps, sourcemaps.write('./')))
    .pipe(rename(function(path) {
      path.dirname = path.dirname.replace('/views/sass', '/views/css');
    }))
    .pipe(gulp.dest('./modules/'))
    .pipe(displayNotification({
      message: 'Theme module CSS compilation successful for ' + options.themeName,
      onLast: true
    }));
});

gulp.task('sass:watch', function () {
  gulp.watch('./themes/' + options.themeName + '/sass/**/*.scss', ['compile-css']);
});

gulp.task('clean-up', function(){
  return del(cleanUp).then(function() {
    console.log('Deleted files and folders:\n', cleanUp.join('\n'));
  });
});

gulp.task('copy-index', function(callback){
  var total;
  var done  = 0;
  glob(['themes/' + options.themeName + '/**/', 'modules/*/**/'], { ignore : copyIndexIgnore }, function(err, folders) {
    total = folders.length;
    if (total < 1 && callback) {
      callback();
    }

    // console.log('Copy to folders: \n', folders.join('\n'));
    folders.forEach(function(folder) {
      fs.copy('index.php.copy', folder + '/index.php', function(err) {
        if (err) {
          return console.error(err);
        }

        done++;
        if (done == total && callback) {
          callback();
        }
      });
    });
  });
});

gulp.task('format-js', function () {

  return gulp.src([
    './themes*/' + options.themeName + '/js/**/*.js',
    '!./themes*/' + options.themeName + '/js/**/*.min.js',
    '!./themes*/' + options.themeName + '/js/autoload/**/*.js',
    '!./themes*/' + options.themeName + '/js/debug/**/*.js'
  ])
  .pipe(jscs({ fix : true }))
  .pipe(gulp.dest('./'));
});

gulp.task('create-zip', function(){
  fs.readFile('./Config.xml', 'utf8', function (err, data) {
    if (err) {
      return console.error(err);
    }

    var themeVersion = '';
    var matches = data.match(/<theme\s[^>]*?version="(.*?)"/i);

    if (matches !== null && typeof matches[1] == 'string') {
      themeVersion = matches[1].trim();
    }

    return gulp.src([
      './themes*/' + options.themeName + '*/**',
      './modules*/ct*/**',
      './Config.xml'
    ])
      .pipe(zip('v' + themeVersion + '-' + options.themeName + '.zip'))
      .pipe(gulp.dest('./'));
  });
});

gulp.task('build', function(callback) {
  runSequence(
    ['create-folders', 'compile-css', 'compile-module-css'],
    'clean-up',
    'format-js',
    'copy-index',
    'create-zip',
    callback
  );
});

gulp.task('default', ['build']);
