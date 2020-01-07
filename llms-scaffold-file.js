/*
 * LifterLMS Add-On Plugin Scaffolding
 * thanks to https://github.com/stevenquiroa/slush-wordpress
 */

'use strict';

var gulp = require('gulp'),
    exec = require( 'gulp-exec' ),
    install = require('gulp-install'),
    conflict = require('gulp-conflict'),
    template = require('gulp-template'),
    rename = require('gulp-rename'),
    inquirer = require('inquirer'),
    fs = require( 'fs' ),
    path = require('path');

var working_dir_name = path.basename( process.cwd() );

var defaults = ( function () {

    var uri = 'https://lifterlms.com/';

    return {
        plugin_slug: working_dir_name,
        plugin_name_unprefixed: 'Add-On',
        plugin_uri: uri,
        plugin_description: '',
        plugin_version: '1.0.0',
        plugin_author_name: 'LifterLMS',
        plugin_author_uri: uri,
        plugin_text_domain: working_dir_name,
        plugin_text_domain_path: '/i18n',
        plugin_shortname: 'LLMS',
        plugin_type: 'plugin',
        plugin_min_lifterlms_version: '3.21.0'
    };

} )();

function getConfig() {

    var config = {};

    if ( fs.existsSync( './.llmsconfig' ) ) {
      config = JSON.parse( fs.readFileSync( './.llmsconfig', 'utf8' ) );
    }

    return config;

};

function getScaffoldConfigOption( key, default_val = '' ) {
    var config = getConfig();
    if ( config && config.scaffold ) { // use new stuff
        return config.scaffold[ key ] ? config.scaffold[ key ] : default_val;
    } else if ( config && config.slush ) { // fallback to legacy
        return config.slush[ key ] ? config.slush[ key ] : default_val;
    }
    return default_val;
}

function getShortname() {
    return getScaffoldConfigOption( 'shortname' )
}


function generateClassname( name, shortname ) {

    var parts = [ 'LLMS' ];
    shortname = shortname || getShortname();

    if ( shortname ) {
        // parts.push( shortname.toUpperCase() );
        parts.push( shortname );
    }
    if ( name ) {
        name = name.split( ' ' ).join( '_' );
        name = name.split( '-' ).join( '_' );
        parts.push( name );
    }

    return parts.join( '_' );

};

function generateFilename( name, shortname, ext ) {

    var parts = [ 'class', 'llms' ];
    shortname = shortname || getShortname();

    if ( shortname ) {
        parts.push( shortname.toLowerCase() );
    }

    if ( name ) {
        name = name.split( ' ' ).join( '-' );
        name = name.split( '_' ).join( '-' );
        parts.push( name.toLowerCase() );
    }

    if ( ! ext ) {
        ext = 'php';
    }

    return parts.join( '-' ) + '.' + ext;
};


/**
 * Generate a new plugin in the current working directory
 */
gulp.task( 'default', function ( done ) {

    var prompts = [
        {
            name: 'plugin_slug',
            message: 'Plugin Slug:',
            default: defaults.plugin_slug,
        },
        {
            name: 'plugin_name_unprefixed',
            message: 'Plugin Name (without LifterLMS Prefix):',
            default: defaults.plugin_name,
        },
        {
            name: 'plugin_uri',
            message: 'Plugin URI:',
            default: defaults.plugin_uri,
        },
        {
            name: 'plugin_description',
            message: 'Plugin Description:',
            default: defaults.plugin_description,
        },
        {
            name: 'plugin_version',
            message: 'Plugin Version:',
            default: defaults.plugin_version,
        },
        {
            name: 'plugin_author_name',
            message: 'Author Name:',
            default: defaults.plugin_author_name,
        },
        {
            name: 'plugin_author_uri',
            message: 'Author URI:',
            default: defaults.plugin_author_uri,
        },
        {
            name: 'plugin_text_domain',
            message: 'Text Domain:',
            default: defaults.plugin_text_domain,
        },
        {
            name: 'plugin_text_domain_path',
            message: 'Text Domain Path:',
            default: defaults.plugin_text_domain_path,
        },
        {
            name: 'plugin_shortname',
            message: 'Plugin Shortname / Initials:',
            default: defaults.plugin_shortname,
        },
        {
            name: 'plugin_type',
            message: 'Plugin Type:',
            choices: [
                {
                    name: 'Standard Plugin',
                    value: 'plugin',
                },
                {
                    name: 'LifterLMS Integration',
                    value: 'integration',
                },
                // {
                //     name: 'LifterLMS Payment Gateway',
                //     value: 'gateway',
                // },
            ],
            default: defaults.plugin_type,
            type: 'list',
        },
        {
            name: 'plugin_min_lifterlms_version',
            message: 'Minimum LifterLMS Version:',
            default: defaults.plugin_min_lifterlms_version,
        },
        {
            type: 'confirm',
            name: 'moveon',
            message: 'Proceed?'
        }
    ];

    inquirer.prompt( prompts, function ( answers ) {

        if ( ! answers.moveon ) {
            return done()
        }

        answers.plugin_name = 'LifterLMS ' + answers.plugin_name_unprefixed;
        answers.plugin_main_class = answers.plugin_name.split( ' ' ).join( '_' );
        answers.plugin_main_function = answers.plugin_main_class.replace( 'LifterLMS', 'LLMS' );
        answers.plugin_integration_class = answers.plugin_main_function.replace( 'LLMS', 'LLMS_Integration' );
        answers.plugin_constant_prefix = answers.plugin_main_function.toUpperCase() + '_';

        answers.plugin_main_file = working_dir_name + '.php';

        answers.package = answers.plugin_name.replace( / /g, '_' );

        answers.plugin_shortname_lower = answers.plugin_shortname.toLowerCase();
        answers.plugin_name_unprefixed_lower = answers.plugin_name_unprefixed.toLowerCase();
        answers.plugin_name_unprefixed_lower_slugged = answers.plugin_name_unprefixed.toLowerCase().replace( / /g, '_' );
        answers.plugin_main_class_slugged = answers.plugin_main_class.replace( /_/g, '-' ).toLowerCase();

        var d = new Date(),
            mon = d.getMonth() + 1,
            day = d.getDate();

        if ( mon < 10 ) { mon = '0' + mon.toString(); }
        if ( day < 10 ) { day = '0' + day.toString();}

        answers.today = d.getFullYear() + '-' + mon + '-' + day;

        answers.generateClassname = generateClassname;
        answers.generateFilename = generateFilename;

        gulp.src( __dirname + '/templates/**' )
            .pipe( template( answers ) )
            .pipe( rename( function( file ) {
                // rename dotfiles
                if ( '-' === file.basename[0] ) {
                    file.basename = '.' + file.basename.slice( 1 );
                }
                // rename plugin base file
                else if ( '+' === file.basename[0] ) {
                    file.basename = working_dir_name;
                }
                // replace shortname in other files
                else if ( -1 !== file.basename.indexOf( '{shortname}' ) ) {
                    file.basename = file.basename.replace( '{shortname}', answers.plugin_shortname_lower );
                }
                // replace name_unprefixed in other files
                else if ( -1 !== file.basename.indexOf( '{name_unprefixed}' ) ) {
                    file.basename = file.basename.replace( '{name_unprefixed}', answers.plugin_name_unprefixed_lower_slugged.replace( /_/g, '-' ) );
                } else if ( -1 !== file.basename.indexOf( '{plugin_main_class}' ) ) {
                    file.basename = file.basename.replace( '{plugin_main_class}', answers.plugin_main_class_slugged );
                }
            } ) )
            .pipe( conflict( './' ) )
            .pipe( gulp.dest( './' ) )
            .pipe( install() )
            .on( 'end', function () {
                done();
            } );

    } );
} );

gulp.task( 'component', function( done ) {

    var prompts = [
        {
            name: 'type',
            message: 'Component Type:',
            choices: [
                {
                    name: 'Standard PHP Class',
                    value: 'class-standard.php',
                },
                {
                    name: 'Static PHP Class',
                    value: 'class-static.php',
                },
                {
                    name: 'Singleton PHP Class',
                    value: 'class-singleton.php',
                },
                {
                    name: 'Unit Test Case PHP Class',
                    value: 'class-unit-test-case.php',
                },
            ],
            default: 'class-standard.php',
            type: 'list',
        },
        {
            name: 'name',
            message: 'Class Name (capitalized)',
            default: '',
        },
        {
            name: 'shortname',
            message: 'Plugin Shortname',
            default: getShortname(),
        },
        {
            name: 'description',
            message: 'Component Description',
            default: '',
        },
        {
            name: 'description_class',
            message: 'Component Class Description',
            when: function( answers ) {
                return ( 'class-unit-test-case.php' !== answers.type );
            },
            default: function( answers ) {
                return generateClassname( answers.name, answers.shortname ) + ' class.';
            },
        },
        {
            name: 'package',
            message: 'Component Package',
            default: getScaffoldConfigOption( 'package_main' ),
        },
        {
            name: 'subpackage',
            message: 'Component Subpackage',
            default: function( answers ) {
                if ( 'class-unit-test-case.php' === answers.type ) {
                    return 'Tests';
                }
                return 'Classes';
            },
            when: function( answers ) {
                return ( answers.package );
            },
        },
        {
            name: 'group',
            message: 'Test Suite Group',
            when: function( answers ) {
                return ( 'class-unit-test-case.php' === answers.type );
            },
        },
        {
            name: 'version',
            message: 'Component Version',
            default: '[version]',
        },
        {
            name: 'location',
            message: 'Location (relative to add-on root)',
            default: function( answers ) {
                if ( 'class-unit-test-case.php' === answers.type ) {
                    return './tests/unit-tests/';
                }
                return getScaffoldConfigOption( 'includes_dir', './includes/' );
            },
        },
        {
            type: 'confirm',
            name: 'moveon',
            message: 'Proceed?'
        }

    ];

    inquirer.prompt( prompts, function ( answers ) {

        if ( ! answers.moveon ) {
            return done();
        }

        var config = {
            classname: generateClassname( answers.name, answers.shortname ),
            description: answers.description,
            description_class: answers.description_class ? answers.description_class : answers.description,
            package: answers.package ? answers.package + '/' + answers.subpackage : '',
            version: answers.version,
            group: answers.group,
        };

        if ( 'class-unit-test-case.php' === answers.type ) {
            config.testcase_classname = getScaffoldConfigOption( 'testcase_class_name', generateClassname( 'Unit_Test_Case', answers.shortname ) );
        }

        var filename = generateFilename( answers.name, answers.shortname, answers.type.split( '.' ).reverse()[0] );

        gulp.src( __dirname + '/components/' + answers.type )
            .pipe( template( config ) )
            .pipe( rename( filename ) )
            .pipe( conflict( answers.location ) )
            .pipe( gulp.dest( answers.location ) )
            .on( 'end', function () {
                done();
            } );

    } );

} );

module.exports = gulp;