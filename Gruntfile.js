module.exports = function (grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        bowercopy: {
            options: {
                srcPrefix: 'bower_components',
                destPrefix: 'web'
            },
            scripts: {
                files: {
                    'assets/js/jquery.js': 'jquery/dist/jquery.js',
                    'assets/js/bootstrap.js': 'bootstrap/dist/js/bootstrap.js',
                    'assets/js/angular.min.js': 'angular/angular.min.js',
                    'assets/js/angular-route.min.js': 'angular-route/angular-route.min.js',
                    'assets/js/angular-resource.min.js': 'angular-resource/angular-resource.min.js',
                    'assets/js/angular-sanitize.min.js': 'angular-sanitize/angular-sanitize.min.js'
                }
            },
            stylesheets: {
                files: {
                    'assets/css/bootstrap.css': 'bootstrap/dist/css/bootstrap.css',
                    'assets/css/font-awesome.css': 'font-awesome/css/font-awesome.css'
                }
            },
            fonts: {
                files: {
                    'fonts': 'font-awesome/fonts'
                }
            }
        },
        cssmin : {
            bootstrap:{
                src: 'web/assets/css/bootstrap.css',
                dest: 'web/assets/css/bootstrap.min.css'
            },
            "font-awesome":{
                src: 'web/assets/css/font-awesome.css',
                dest: 'web/assets/css/font-awesome.min.css'
            }
        },
        uglify : {
            js: {
                files: {
                    'web/assets/js/jquery.min.js': ['web/assets/js/jquery.js'],
                    'web/assets/js/bootstrap.min.js': ['web/assets/js/bootstrap.js']
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-bowercopy');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-uglify');

    grunt.registerTask('default', ['bowercopy', 'cssmin', 'uglify']);
};