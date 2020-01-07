#!/usr/bin/env node

const
	gulpInstance = require( '../llms-scaffold-file.js' ),
	argv = require( 'minimist' )( process.argv.slice( 2 ) );

let tasks = argv._.slice();

tasks = tasks.length ? tasks : [ 'default' ];

gulpInstance.series( tasks )();