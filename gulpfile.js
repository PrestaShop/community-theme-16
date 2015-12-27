var gulp   = require('gulp');
var del    = require('del');
var mkdirp = require('mkdirp');
var glob   = require('glob');
var exec   = require('child_process').exec;
var argv   = require('yargs').argv;
var fs     = require('fs-extra');
var zip    = require('gulp-zip');

var createFolders = [
    './themes/community-theme-16/cache/',
    './themes/community-theme-16/pdf/',
    './themes/community-theme-16/pdf/lang/'
];

var copyIndexIgnore = [];

var removeTrash = [
    './themes/community-theme-16/.sass-cache/',
    './themes/community-theme-16/cache/*',
    './themes/community-theme-16/css/**/*.css.map'
];

gulp.task('create-folders', function(){
    createFolders.map(function(path){
        mkdirp(path, function (err) {
            if (err) {
                console.error(err);
            } else {
                console.log('Created folder : ' + path);
            }
        });
    });
});

gulp.task('build-css', function(){
    var options = '';
    if (argv.f || argv.force) {
        options += ' --force';
    }
    var compassCompile = exec('compass compile ./themes/community-theme-16'+ options);
    compassCompile.stdout.pipe(process.stdout);
});

gulp.task('remove-trash', function(){
    del(removeTrash).then(function() {
        console.log('Deleted files and folders:\n', removeTrash.join('\n'));
    });
});

gulp.task('copy-index', function(){
    glob('themes/community-theme-16/**/', { ignore : copyIndexIgnore }, function(err, folders) {
        folders.forEach(function(folder) {
            fs.copy('index.php', folder + '/index.php', function(err) {
                if (err) {
                    return console.error(err);
                }
            });
        });
    });
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

        gulp.src(['./themes/**', './Config.xml'])
            .pipe(zip('v' + themeVersion + '-community-theme-16.zip'))
            .pipe(gulp.dest('./'));
    });
});

gulp.task('build', ['create-folders', 'build-css', 'remove-trash', 'copy-index', 'create-zip']);

gulp.task('default', ['build']);
