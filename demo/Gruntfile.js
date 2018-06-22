// AdminLTE Gruntfile
module.exports = function (grunt) { // jshint ignore:line
    'use strict';
    grunt.initConfig({
        "pkg": grunt.file.readJSON('package.json'),

        "watch": {
            "less": {
                // Compiles less files upon saving
                "files": ['build/less/**/*.less'],
                "tasks": ['less:development', 'less:production', 'notify:less']
            },
            "js": {
                // Compile js files upon saving
                "files": ['build/js/*.js'],
                "tasks": ['concat:dist', 'uglify', 'notify:js']
            }
        },
        // Notify end of tasks
        "notify": {
            "less": {
                "options": {
                    "title": 'AdminLTE',
                    "message": 'LESS finished running'
                }
            },
            "js": {
                "options": {
                    "title": 'AdminLTE',
                    "message": 'JS bundler finished running'
                }
            }
        },
        // 'less'-task configuration
        // This task will compile all less files upon saving to create both AdminLTE.css and AdminLTE.min.css
        "less": {
            // Development not compressed
            "development": {
                "files": {
                    // compilation.css  :  source.less
                    'dist/css/AdminLTE.css': 'build/less/AdminLTE.less',
                    'dist/css/skins/skin-red-light.css': 'build/less/skins/skin-red-light.less',
                    'dist/css/skins/skin-blue-light.css': 'build/less/skins/skin-blue-light.less',

                    // Separate plugins
                    'dist/css/alt/AdminLTE-select2.css': 'build/less/select2.less',
                    'dist/css/alt/AdminLTE-fullcalendar.css': 'build/less/fullcalendar.less',
                    'dist/css/alt/AdminLTE-bootstrap-social.css': 'build/less/bootstrap-social.less'
                }
            },
            // Production compressed version
            "production": {
                "options": {
                    "outputSourceFiles": true
                },
                "files": {
                    // compilation.css  :  source.less
                    'dist/css/AdminLTE.min.css': 'build/less/AdminLTE.less',
                    'dist/css/skins/skin-red-light.min.css': 'build/less/skins/skin-red-light.less',
                    'dist/css/skins/skin-blue-light.min.css': 'build/less/skins/skin-blue-light.less',

                    // Separate plugins
                    'dist/css/alt/AdminLTE-select2.min.css': 'build/less/select2.less',
                    'dist/css/alt/AdminLTE-fullcalendar.min.css': 'build/less/fullcalendar.less',
                    'dist/css/alt/AdminLTE-bootstrap-social.min.css': 'build/less/bootstrap-social.less'
                }
            },
            "options": {
                "sourceMap": true,

            }
        },

        // Concatenate JS Files
        "concat": {
            "options": {
                "separator": '\n\n',
                "banner": '/*! AdminLTE app.js\n' +
                '* ================\n' +
                '* Main JS application file for AdminLTE v2. This file\n' +
                '* should be included in all pages. It controls some layout\n' +
                '* options and implements exclusive AdminLTE plugins.\n' +
                '*\n' +
                '* @Author  Almsaeed Studio\n' +
                '* @Support <https://www.almsaeedstudio.com>\n' +
                '* @Email   <abdullah@almsaeedstudio.com>\n' +
                '* @version <%= pkg.version %>\n' +
                '* @repository <%= pkg.repository.url %>\n' +
                '* @license MIT <http://opensource.org/licenses/MIT>\n' +
                '*/\n\n' +
                '// Make sure jQuery has been loaded\n' +
                'if (typeof jQuery === \'undefined\') {\n' +
                'throw new Error(\'AdminLTE requires jQuery\')\n' +
                '}\n\n'
            },
            "dist": {
                "src": [
                    'build/js/Layout.js',
                    'build/js/PushMenu.js',
                    'build/js/Tree.js',
                    'build/js/ControlSidebar.js',
                    'build/js/BoxWidget.js',
                    'build/js/TodoList.js',
                    'build/js/DirectChat.js'
                ],
                "dest": 'dist/js/adminlte.js'
            }
        },

        // Minify JS
        "uglify": {
            "options": {
                "mangle": true,
                "preserveComments": 'some'
            },
            "production": {
                "files": {
                    'dist/js/adminlte.min.js': ['dist/js/adminlte.js']
                }
            }
        },

        //        // Minify CSS
        //        "cssmin": {
        //            "target": {
        //                "files": [{
        //                    "expand": true,
        //                    "cwd": 'dist/css/vendor',
        //                    "src": 'bower_components.css',
        //                    "dest": 'dist/css/vendor',
        //                    "ext": '.min.css'
        //            }]
        //            }
        //        },

        // Optimize images
        "image": {
            "static": {
                "options": {
                    "pngquant": true,
                    "optipng": false,
                    "zopflipng": true,
                    "jpegRecompress": false,
                    "jpegoptim": true,
                    "mozjpeg": true,
                    "guetzli": false,
                    "gifsicle": true,
                    "svgo": true
                }
            },
            "dynamic": {
                "files": [{
                    "expand": true,
                    "cwd": 'build/img/',
                    "src": ['**/*.{png,jpg,gif,svg,jpeg}'],
                    "dest": 'dist/img/'
                }]
            }
        },

        // Validate JS code
        "jshint": {
            "options": {
                "jshintrc": 'build/js/.jshintrc'
            },
            "grunt": {
                "options": {
                    "jshintrc": 'build/grunt/.jshintrc'
                },
                "src": 'Gruntfile.js'
            },
            "core": {
                "src": 'build/js/*.js'
            }
        },

        "jscs": {
            "options": {
                "config": 'build/js/.jscsrc'
            },
            "core": {
                "src": '<%= jshint.core.src %>'
            }
        },

        // Validate CSS files
        "csslint": {
            "options": {
                "csslintrc": 'build/less/.csslintrc'
            },
            "dist": [
                'dist/css/AdminLTE.css'
            ]

        },

        // Validate Bootstrap HTML
        "bootlint": {
            "options": {
                "relaxerror": ['W005']
            },
            "files": ['pages/**/*.html', '*.html']
        },

        // Delete images in build directory
        // After compressing the images in the build/img dir, there is no need
        // for them
        "clean": {
            "build": ['build/img/*']
        }
    });

    // Load all grunt tasks

    // LESS Compiler
    grunt.loadNpmTasks('grunt-contrib-less');
    // Watch File Changes
    grunt.loadNpmTasks('grunt-contrib-watch');
    // Compress JS Files
    grunt.loadNpmTasks('grunt-contrib-uglify');
    // Compress CSS files
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    // Include Files Within HTML
    grunt.loadNpmTasks('grunt-includes');
    // Optimize images
    grunt.loadNpmTasks('grunt-image');
    // Validate JS code
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-jscs');
    // Delete not needed files
    grunt.loadNpmTasks('grunt-contrib-clean');
    // Lint CSS
    grunt.loadNpmTasks('grunt-contrib-csslint');
    // Lint Bootstrap
    grunt.loadNpmTasks('grunt-bootlint');
    // Concatenate JS files
    grunt.loadNpmTasks('grunt-contrib-concat');
    // Notify
    grunt.loadNpmTasks('grunt-notify');


    // Linting task
    grunt.registerTask('lint', ['jshint', 'csslint', 'bootlint']);
    // Concat js, and css. Then minify them.
    grunt.registerTask('merge', ['less', 'image', 'concat', 'cssmin', 'uglify']);
    // The default task (running 'grunt' in console) is 'watch'
    grunt.registerTask('default', ['watch']);
};
