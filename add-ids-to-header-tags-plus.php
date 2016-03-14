<?php

	/**
	 * Plugin Name: GMT Add IDs to Header Tags Plug
	 * Plugin URI: http://github.com/cferdinandi/add-ids-to-header-tags-plus
	 * GitHub Plugin URI: http://github.com/cferdinandi/add-ids-to-header-tags-plus
	 * Description: Add an `id` attribute to header tags in your posts. Adjust settings under <a href="options-general.php?page=addIDs_plugin_settings">Settings &rarr; Add IDs to Header Tags</a>
	 * Author: Chris Ferdinandi
	 * Author URI: http://gomakethings.com
	 * Version: 1.3.0
	 * License: MIT
	 *
	 * A fork of the Add IDs to Header Tags plugin.
	 * http://wordpress.org/plugins/add-ids-to-header-tags/
	 */

	require_once( dirname( __FILE__) . '/add-ids-to-header-tags-plus-options.php' );
	require_once( dirname( __FILE__) . '/add-ids-to-header-tags-plus-process.php' );