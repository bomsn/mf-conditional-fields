module.exports = function (grunt) {

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        // General options
        opts: {
            project: 'MF Conditional Fields',
            website: 'https://github.com/bomsn/mf-conditional-fields',
        },
        // Setting folder templates.
        dirs: {
            src: 'src',
            dist: 'dist',
        },

        // Minify JavaScript
        uglify: {
            options: {
                sourceMap: true,
                sourceMapIncludeSources: true,
                banner: '/* (c) <%= grunt.template.today("yyyy") %> <%= opts.project %> - <%= opts.website %> */\n',
                report: 'min',
                compress: {
                    drop_console: false,
                    sequences: false
                }
            },
            scripts: {
                files: {
                    '<%= dirs.dist %>/mf-conditional-fields.min.js': [
                        '<%= dirs.src %>/mf-conditional-fields.js',
                    ],
                },
            }
        },
        // Watch changes and run tasks
        watch: {
            js: {
                files: [
                    '<%= dirs.src %>/mf-conditional-fields.js',
                ],
                tasks: ['js']
            },
        },
    });

    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');

    // Uglify task
    grunt.registerTask('js', ['uglify']);
    // Register Default tasks.
    grunt.registerTask('default', [
        'js'
    ]);

};