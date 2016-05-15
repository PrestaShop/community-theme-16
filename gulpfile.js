var gulp        = require('gulp');
var del         = require('del');
var mkdirp      = require('mkdirp');
var glob        = require('glob-all');
var exec        = require('child_process').exec;
var argv        = require('yargs').argv;
var fs          = require('fs-extra');
var zip         = require('gulp-zip');
var runSequence = require('run-sequence');
var jscs        = require('gulp-jscs');
var sass        = require('gulp-sass');
var sourcemaps  = require('gulp-sourcemaps');
var notify      = require("gulp-notify");

var themeName = 'community-theme-16';

var createFolders = [
  './themes/' + themeName + '/cache/',
  './themes/' + themeName + '/pdf/',
  './themes/' + themeName + '/pdf/lang/'
];

var copyIndexIgnore = [];

var cleanUp = [
  './themes/' + themeName + '/.sass-cache/',
  './themes/' + themeName + '/cache/*',
  './themes/' + themeName + '/css/**/*.css.map'
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
  return gulp.src('./themes/' + themeName + '/sass/**/*.scss')
    .pipe(sass({
      includePaths: require('node-bourbon').includePaths,
      outputStyle: 'expanded',
      precision: 8
    })
    .on('error', function() {
      displayNotification(sass.logError);
    }))
    .pipe(sourcemaps.init())
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest('./themes/' + themeName + '/css/'))
    .pipe(displayNotification({ message: 'Compilation successful', onLast: true }));
});

gulp.task('sass:watch', function () {
  gulp.watch('./themes/' + themeName + '/sass/**/*.scss', ['compile-css']);
});

gulp.task('clean-up', function(){
  return del(cleanUp).then(function() {
    console.log('Deleted files and folders:\n', cleanUp.join('\n'));
  });
});

gulp.task('copy-index', function(callback){
  var total;
  var done  = 0;
  glob(['themes/' + themeName + '/**/', 'modules/*/**/'], { ignore : copyIndexIgnore }, function(err, folders) {
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
    './themes*/' + themeName + '/js/**/*.js',
    '!./themes*/' + themeName + '/js/**/*.min.js',
    '!./themes*/' + themeName + '/js/autoload/**/*.js',
    '!./themes*/' + themeName + '/js/debug/**/*.js'
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
    var pattern = new RegExp(/<theme\s[^>]*?version=\"(.*?)\"/i);
    var matches = data.match(pattern);

    if (matches !== null && typeof matches[1] == 'string') {
      themeVersion = matches[1].trim();
    }

    return gulp.src([
      './themes*/' + themeName + '*/**',
      './modules*/ct*/**',
      './Config.xml'
    ])
      .pipe(zip('v' + themeVersion + '-' + themeName + '.zip'))
      .pipe(gulp.dest('./'));
  });
});

gulp.task('build', function(callback) {
  runSequence(
    ['create-folders', 'compile-css'],
    'clean-up',
    'format-js',
    'copy-index',
    'create-zip',
    callback
  );
});

gulp.task('default', ['build']);
