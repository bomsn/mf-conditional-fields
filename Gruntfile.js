module.exports = function (grunt) {

    var prod = grunt.option('build') === 'production';
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

        // Remove previously minified files & any related temp files
        clean: {
            js: [
                '<%= dirs.dist %>/*.js',
                '<%= dirs.dist %>/*.map',
            ]
        },
        // Copy type declaration files
        copy: {
            main: {
                files: [
                    { expand: true, src: ['<%= dirs.src %>/types.d.ts'], dest: '<%= dirs.dist %>/', flatten: true }
                ]
            }
        },
        // Minify JavaScript
        uglify: {
            options: {
                sourceMap: !prod,
                sourceMapIncludeSources: !prod,
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
                        '<%= dirs.src %>/script.js',
                    ],
                    '<%= dirs.dist %>/mf-conditional-fields.module.min.js': [
                        '<%= dirs.src %>/mf-conditional-fields.js',
                        '<%= dirs.src %>/module.js',
                    ]
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

    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-watch');

    // Uglify task
    grunt.registerTask('js', ['clean', 'copy', 'uglify']);

    // Register Default tasks.
    grunt.registerTask('default', ['js']);

};