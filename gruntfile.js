module.exports = function(grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    concat: {
      options: {
        separator: ';',
      },
      dist: {
        libraries: [
          "js/libraries/jquery.easing.js"
        ],
        theme : [
          // "js/uw.intro.js",
          "js/uw.core.js",
          "js/uw.init.js",
          "js/uw.search.js",
          "js/uw.slideshow.js",
          "js/uw.player.js",
          "js/uw.vimeo.js",
          "js/uw.checkbox.js",
          "js/uw.radio.js",
          "js/uw.dropdowns.js",
          "js/uw.accordion.js",
          "js/uw.select.js",
          "js/uw.image.js",
          "js/uw.social.js",
          // "js/uw.outro.js"
        ],
        components : [
          // todo: put just external components here for the uw.js we will give out
        ],
        src: [ 'js/uw.intro.js', '<%= concat.dist.libraries %>', '<%= concat.dist.theme %>', 'js/uw.outro.js' ],
        dest: 'js/site.dev.js'
      }
    },
    uglify: {
      options: {
        banner: '/*! <%= pkg.name %> <%= grunt.template.today() %> */\n'
      },
      dist: {
        files: {
          'js/site.js': ['<%= concat.dist.dest %>']
        }
      }
    },
    jshint: {
      files: [ 'Gruntfile.js', '<%= concat.dist.theme %>' ],
      options: {
        asi: true,
        smarttabs: true,
        laxcomma: true,
        lastsemic: true,
        // options here to override JSHint defaults
        globals: {
          jQuery: true,
          console: true,
          module: true,
          document: true
        }
      }
    },
    notify: {
      watch: {
        options: {
          title: 'Task Complete',
          message: 'JS uglified successfully'
        }
      }
    },
    less: {
        production: {
	        options: {
		        cleancss: true
			},
			files: {
				'style.css': 'less/style.less'
			}
		},
		development: {
			files: {
				'style.dev.css': 'less/style.less'
			}
		}
	},
    watch: {
      js: {
        files: ['<%= concat.dist.src %>'],
        tasks: ['js']
      },
      css: {
        files: ['less/*.less'],
        tasks: ['less']
      }
    }
  });

  grunt.loadNpmTasks('grunt-notify');
  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-watch');


  grunt.registerTask('default', ['jshint', 'concat', 'uglify', 'notify', 'less']);
  grunt.registerTask('js', ['jshint', 'concat', 'uglify', 'notify' ]);

};