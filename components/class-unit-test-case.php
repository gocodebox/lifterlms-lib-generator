<?php
/**
 * <%= description %>
 *
<% if ( package ) { %> * @package <%= package %>
 * <% } %>
<% if ( group ) { %> * @group <%= group %>
 * <% } %>
 * @since <%= version %>
 * @version <%= version %>
 */
class <%= classname %> extends <%= testcase_classname %> {

	/**
	 * Setup the test case.
	 *
	 * @since [version]
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
	}

	/**
	 * Test something
	 *
	 * @since [version]
	 *
	 * @return void
	 */
	public function test_() {

	}

	/**
	 * Tear down the test case.
	 *
	 * @since [version]
	 *
	 * @return void
	 */
	public function tearDown() {
		parent::tearDown();
	}

}
