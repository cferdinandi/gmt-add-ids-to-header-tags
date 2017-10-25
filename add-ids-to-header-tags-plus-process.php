<?php

	require_once( dirname( __FILE__) . '/add-ids-to-header-tags-plus-options.php' );

	function add_ids_to_header_tags( $content ) {

		if ( ! is_singular() ) {
			return $content;
		}

		// Variables
		global $post;
		$options = addIDs_get_plugin_settings();
		$post_type = get_post_type( $post );

		$content = str_replace('</code>', '{{{{{/}}}}}', str_replace('<code>', '{{{{{}}}}}', $content));
		$pattern = '#(?P<full_tag><(?P<tag_name>h\d)(?P<tag_extra>[^>]*)>(?P<tag_contents>[^<]*)</h\d>)#i';

		if ( preg_match_all( $pattern, $content, $matches, PREG_SET_ORDER ) ) {
			$find = array();
			$replace = array();
			foreach( $matches as $match ) {

				if ( strlen( $match['tag_extra'] ) && false !== stripos( $match['tag_extra'], 'id=' ) ) {
					continue;
				}

				$find[]    = $match['full_tag'];
				$id        = sanitize_title( $match['tag_contents'] );
				$id_attr   = sprintf( ' id="%s"', $id );

				if ( empty( $options['link_text'] ) || ( array_key_exists( $post_type, $options['post_types'] ) && $options['post_types'][$post_type] === 'on' ) ) {
					$replace[] = sprintf( '<%1$s%2$s%3$s>%4$s</%1$s>', $match['tag_name'], $match['tag_extra'], $id_attr, $match['tag_contents'] );
				} else {
					$extra     = sprintf( ' <a class="gmt-anchor-link" href="#%s" tabindex="-1">' . $options['link_text'] . '</a>', $id );
					$replace[] = sprintf( '<%1$s%2$s%3$s>%4$s%5$s</%1$s>', $match['tag_name'], $match['tag_extra'], $id_attr, $match['tag_contents'], $extra );
				}

			}
			$content = str_replace( $find, $replace, $content );
		}

		$content = str_replace('{{{{{/}}}}}', '</code>', str_replace('{{{{{}}}}}', '<code>', $content));
		return $content;
	}
	add_filter( 'the_content', 'add_ids_to_header_tags' );
