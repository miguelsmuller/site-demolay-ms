/*global module:false, require:false*/
module.exports = function(grunt) {

	require('load-grunt-tasks')(grunt);

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		dirs: {
			css    : '../assets/css',
			sass   : '../assets/sass',
			js     : '../assets/js',
			img    : '../assets/images',
			root   : '../../../../.'
		},

		// Watch for changes
		watch: {
			options: {
				livereload: false
			},
			css: {
				files: ['<%= dirs.sass %>/{,*/}*.{scss,sass}'],
				tasks: ['compass']
			},
			js: {
				files: ['<%= jshint.all %>'],
				tasks: ['jshint', 'uglify']
			},
			html: {
				files: [
					'/*.{html,htm,shtml,shtm,xhtml,php,jsp,asp,aspx,erb,ctp}'
				]
			}
		},

		// Javascript linting with jshint
		jshint: {
			options: {
				jshintrc: '.jshintrc'
			},
			all: [
				'Gruntfile.js',
				'<%= dirs.js %>/*.js',
				'!<%= dirs.js %>/*.min.js'
			]
		},

		// Uglify to concat and minify
		uglify: {
			options: {
		  		force: true,
		  		mangle: false
			},
			dist: {
		  		files: {
					'<%= dirs.js %>/javascript.min.js': [

					  	//BOOTSTRAP SASS
              '../assets/components/bootstrap-sass/vendor/assets/javascripts/bootstrap/button.js',
              '../assets/components/bootstrap-sass/vendor/assets/javascripts/bootstrap/collapse.js',
              '../assets/components/bootstrap-sass/vendor/assets/javascripts/bootstrap/dropdown.js',
              '../assets/components/bootstrap-sass/vendor/assets/javascripts/bootstrap/tab.js',
              '../assets/components/bootstrap-sass/vendor/assets/javascripts/bootstrap/transition.js',
              '../assets/components/bootstrap-sass/vendor/assets/javascripts/bootstrap/modal.js',
              '../assets/components/bootstrap-sass/vendor/assets/javascripts/bootstrap/tooltip.js',
              '../assets/components/bootstrap-sass/vendor/assets/javascripts/bootstrap/alert.js',
              '../assets/components/owl.carousel/dist/owl.carousel.min.js',

					  	//CUSTOM JS
					  	'<%= dirs.js %>/javascript.js'
					]
				}
			}
		},

		// Compile scss/sass files to CSS
	    compass: {
			dist: {
				options: {
					force: true,

					config: 'config.rb',

					sassDir: 'assets/sass',
					cssDir: 'assets/css',
					imagesDir: 'assets/images',
					fontsDir: 'demolayms-theme/<%= dirs.fonts %>/',
					javascriptsDir: 'demolayms-theme/<%= dirs.scripts %>',

					outputStyle: 'compressed',
					relativeAssets: true,
					noLineComments: true
				}
			}
	    },

		// Image optimization
		imagemin: {
			dist: {
				options: {
					optimizationLevel: 5,
					progressive: true
				},
				files: [{
					expand: true,
					cwd: '<%= dirs.img %>/',
					src: ['**/*.{png,jpg,gif,svg}'],
					dest: '<%= dirs.img %>/'
				}]
			},
			upload: {
				files: [{
					expand: true,
					cwd: '<%= dirs.root %>/arquivos-web/',
					src: ['**/*.{png,jpg,gif}'],
					dest: '<%= dirs.root %>/arquivos-web/'
				}]
			}
		}
	});

	grunt.registerTask( 'default', [ 'compass', 'jshint', 'uglify' ]);
	grunt.registerTask( 'css', [ 'compass' ]);
	grunt.registerTask( 'js', [ 'jshint', 'uglify' ]);
	grunt.registerTask( 'makezip', ['rsync:dist', 'zip', 'clean']);
	grunt.registerTask( 'deploy', ['imagemin', 'rsync', 'clean']);
};
