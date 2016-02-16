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

var createFolders = [
    './themes/community-theme-16/cache/',
    './themes/community-theme-16/pdf/',
    './themes/community-theme-16/pdf/lang/'
];

var copyIndexIgnore = [];

var cleanUp = [
    './themes/community-theme-16/.sass-cache/',
    './themes/community-theme-16/cache/*',
    './themes/community-theme-16/css/**/*.css.map'
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

gulp.task('compile-css', function(callback){
    var options = '';
    if (argv.f || argv.force) {
        options += ' --force';
    }
    var compassCompile = exec('compass compile ./themes/community-theme-16'+ options, function(err, out, code) {
        if (err instanceof Error) {
            throw err;
        }

        if (callback) {
            callback();
        }
    });
    compassCompile.stdout.pipe(process.stdout);
});

gulp.task('clean-up', function(){
    return del(cleanUp).then(function() {
        console.log('Deleted files and folders:\n', cleanUp.join('\n'));
    });
});

gulp.task('copy-index', function(callback){
    var total;
    var done  = 0;
    glob(['themes/community-theme-16/**/', 'modules/*/**/'], { ignore : copyIndexIgnore }, function(err, folders) {
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
    './themes*/community-theme-16/js/**/*.js',
    '!./themes*/community-theme-16/js/**/*.min.js',
    '!./themes*/community-theme-16/js/autoload/**/*.js',
    '!./themes*/community-theme-16/js/debug/**/*.js'
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
            './themes*/community-theme-16*/**',
            './modules*/**',
            './Config.xml'
        ])
            .pipe(zip('v' + themeVersion + '-community-theme-16.zip'))
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
