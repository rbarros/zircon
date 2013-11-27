module.exports = function(grunt) {
    'use strict';
    grunt.initConfig({
        pkg: grunt.file.readJSON('Zircon.json'),
        banner: '/*! <%= pkg.title || pkg.name %> - v<%= pkg.version %> - ' +
              '<%= grunt.template.today("yyyy-mm-dd") %>\n' +
              '<%= pkg.homepage ? "* " + pkg.homepage + "\\n" : "" %>' +
              '* Copyright (c) <%= grunt.template.today("yyyy") %> <%= pkg.author.name %>;' +
              ' Licensed <%= _.pluck(pkg.licenses, "type").join(", ") %> */\n',
        min: {
          dist: {
            src: ['src/<%= pkg.name %>.js'],
            dest: 'dist/<%= pkg.name %>.min.js'
          }
        },
        // Task configuration.
        clean: {
            files: ['dist','<%= concat.dist.dest %>']
        },
        connect: {
            server: {
                options: {
                    port: 9001,
                    hostname: '*',
                    keepalive: true
                }
            }
        },
        less: {
            development: {
                options: {
                    paths: ['css', 'src']
                },
                files: {
                    "css/zircon.css": "css/zircon.less"
                }
            }
        },
        qunit: {
            files: ['test/**/*.html']
        },
        uglify: {
            options: {
                banner: '<%= banner %>'
            },
            dist: {
              files: {
                'dist/<%= pkg.name %>.min.js': ['src/<%= pkg.name %>.js'],
                'dist/<%= pkg.name %>.concat.min.js': ['src/<%= pkg.name %>.concat.js'],
              }
            }
        },
        concat: {
          options: {
            banner: '<%= banner %>',
            stripBanners: true
          },
          dist: {
            src: ['src/**/*.js','libs/**/*.js'],
            dest: 'src/<%= pkg.name %>.concat.js'
          }
        },
        watch: {
          files: ['src/<%= pkg.name %>.js'],
          tasks: ['clean', 'concat', 'uglify']
        }
    });

    grunt.loadNpmTasks('grunt-contrib-connect');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-qunit');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-clean');

    grunt.registerTask('default', ['connect:server', 'less', 'qunit', 'uglify', 'concat', 'watch', 'clean']);
}