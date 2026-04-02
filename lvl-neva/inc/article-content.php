<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'lvl_neva_equipment_article_has_content' ) ) {
	function lvl_neva_equipment_article_has_content( $section ) {
		$title = isset( $section['title'] ) ? trim( wp_strip_all_tags( (string) $section['title'] ) ) : '';
		$texts = isset( $section['texts'] ) && is_array( $section['texts'] ) ? $section['texts'] : array();

		if ( '' !== $title ) {
			return true;
		}

		foreach ( $texts as $text_html ) {
			if ( '' !== trim( wp_strip_all_tags( (string) $text_html ) ) ) {
				return true;
			}
		}

		return false;
	}
}

if ( ! function_exists( 'lvl_neva_get_dom_node_inner_html' ) ) {
	function lvl_neva_get_dom_node_inner_html( $node ) {
		if ( ! $node || ! isset( $node->ownerDocument ) ) {
			return '';
		}

		$html = '';

		foreach ( $node->childNodes as $child_node ) {
			$html .= $node->ownerDocument->saveHTML( $child_node );
		}

		return $html;
	}
}

if ( ! function_exists( 'lvl_neva_get_dom_node_outer_html' ) ) {
	function lvl_neva_get_dom_node_outer_html( $node ) {
		if ( ! $node || ! isset( $node->ownerDocument ) ) {
			return '';
		}

		return $node->ownerDocument->saveHTML( $node );
	}
}

if ( ! function_exists( 'lvl_neva_get_first_element_inner_html' ) ) {
	function lvl_neva_get_first_element_inner_html( $html ) {
		$html = trim( (string) $html );

		if ( '' === $html ) {
			return '';
		}

		if ( ! class_exists( 'DOMDocument' ) ) {
			return $html;
		}

		$previous_state = libxml_use_internal_errors( true );
		$document       = new DOMDocument( '1.0', 'UTF-8' );
		$wrapped_html   = sprintf( '<div>%s</div>', $html );

		$document->loadHTML(
			'<?xml encoding="utf-8" ?>' . $wrapped_html,
			LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
		);

		libxml_clear_errors();
		libxml_use_internal_errors( $previous_state );

		$root = null;

		if ( class_exists( 'DOMXPath' ) ) {
			$xpath     = new DOMXPath( $document );
			$root_list = $xpath->query( '//*[@id="lvl-neva-root"]' );
			$root      = $root_list instanceof DOMNodeList && $root_list->length > 0 ? $root_list->item( 0 ) : null;
		}

		if ( ! $root ) {
			return $html;
		}

		foreach ( $root->childNodes as $child_node ) {
			if ( XML_ELEMENT_NODE === $child_node->nodeType ) {
				return lvl_neva_get_dom_node_inner_html( $child_node );
			}
		}

		return $html;
	}
}

if ( ! function_exists( 'lvl_neva_flush_equipment_article_section' ) ) {
	function lvl_neva_flush_equipment_article_section( &$output, &$section ) {
		if ( ! lvl_neva_equipment_article_has_content( $section ) ) {
			$section = array(
				'title' => '',
				'texts' => array(),
			);

			return;
		}

		$output .= '<div class="div flex-direction-vertical size-width-full equipment-article__section">';

		if ( '' !== trim( wp_strip_all_tags( $section['title'] ) ) ) {
			$output .= sprintf(
				'<div class="equipment-article__title">%s</div>',
				$section['title']
			);
		}

		foreach ( $section['texts'] as $text_html ) {
			if ( '' === trim( wp_strip_all_tags( (string) $text_html ) ) ) {
				continue;
			}

			$output .= sprintf(
				'<div class="equipment-article__text">%s</div>',
				$text_html
			);
		}

		$output .= '</div>';

		$section = array(
			'title' => '',
			'texts' => array(),
		);
	}
}

if ( ! function_exists( 'lvl_neva_build_equipment_article_image_html' ) ) {
	function lvl_neva_build_equipment_article_image_html( $src, $alt = '', $title = '' ) {
		$src = esc_url( (string) $src );

		if ( '' === $src ) {
			return '';
		}

		$title_attribute = '' !== trim( (string) $title ) ? sprintf( ' title="%s"', esc_attr( $title ) ) : '';

		return sprintf(
			'<img class="equipment-article__image border-radius" src="%1$s" alt="%2$s"%3$s>',
			$src,
			esc_attr( (string) $alt ),
			$title_attribute
		);
	}
}

if ( ! function_exists( 'lvl_neva_extract_quote_html_from_node' ) ) {
	function lvl_neva_extract_quote_html_from_node( $quote_node ) {
		$parts = array();

		foreach ( $quote_node->childNodes as $child_node ) {
			if ( XML_TEXT_NODE === $child_node->nodeType ) {
				$text_value = trim( $child_node->textContent );

				if ( '' !== $text_value ) {
					$parts[] = esc_html( $text_value );
				}

				continue;
			}

			if ( XML_ELEMENT_NODE !== $child_node->nodeType ) {
				continue;
			}

			$tag_name = strtolower( $child_node->nodeName );

			if ( 'cite' === $tag_name ) {
				continue;
			}

			if ( 'p' === $tag_name ) {
				$parts[] = lvl_neva_get_dom_node_inner_html( $child_node );
				continue;
			}

			$parts[] = lvl_neva_get_dom_node_inner_html( $child_node );
		}

		$parts = array_filter(
			$parts,
			static function ( $part ) {
				return '' !== trim( wp_strip_all_tags( (string) $part ) );
			}
		);

		if ( empty( $parts ) ) {
			return lvl_neva_get_dom_node_inner_html( $quote_node );
		}

		return implode( '<br><br>', $parts );
	}
}

if ( ! function_exists( 'lvl_neva_build_equipment_article_quote_html' ) ) {
	function lvl_neva_build_equipment_article_quote_html( $quote_html ) {
		$quote_html = trim( (string) $quote_html );

		if ( '' === trim( wp_strip_all_tags( $quote_html ) ) ) {
			return '';
		}

		return sprintf(
			'<div class="div flex-direction-vertical size-width-full equipment-article__quote"><div class="equipment-article__quote-text">%s</div></div>',
			$quote_html
		);
	}
}

if ( ! function_exists( 'lvl_neva_render_equipment_article_dom_nodes' ) ) {
	function lvl_neva_render_equipment_article_dom_nodes( $node_list, &$output, &$section ) {
		foreach ( $node_list as $node ) {
			if ( XML_TEXT_NODE === $node->nodeType ) {
				$text_value = trim( $node->textContent );

				if ( '' !== $text_value ) {
					$section['texts'][] = esc_html( $text_value );
				}

				continue;
			}

			if ( XML_ELEMENT_NODE !== $node->nodeType ) {
				continue;
			}

			$tag_name = strtolower( $node->nodeName );
			$class    = ' ' . trim( (string) $node->getAttribute( 'class' ) ) . ' ';

			if ( in_array( $tag_name, array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ), true ) ) {
				lvl_neva_flush_equipment_article_section( $output, $section );
				$section['title'] = lvl_neva_get_dom_node_inner_html( $node );
				continue;
			}

			if ( 'p' === $tag_name ) {
				$section['texts'][] = lvl_neva_get_dom_node_inner_html( $node );
				continue;
			}

			if ( in_array( $tag_name, array( 'ul', 'ol', 'table', 'pre' ), true ) ) {
				$section['texts'][] = lvl_neva_get_dom_node_outer_html( $node );
				continue;
			}

			if ( false !== strpos( $class, ' video-player-block ' ) || false !== strpos( $class, ' equipment-article__quote ' ) || false !== strpos( $class, ' equipment-article__section ' ) ) {
				lvl_neva_flush_equipment_article_section( $output, $section );
				$output .= lvl_neva_get_dom_node_outer_html( $node );
				continue;
			}

			if ( 'figure' === $tag_name ) {
				$image_nodes = $node->getElementsByTagName( 'img' );

				if ( $image_nodes->length > 0 ) {
					$image_node = $image_nodes->item( 0 );
					$image_html = lvl_neva_build_equipment_article_image_html(
						(string) $image_node->getAttribute( 'src' ),
						(string) $image_node->getAttribute( 'alt' ),
						(string) $image_node->getAttribute( 'title' )
					);

					if ( '' !== $image_html ) {
						lvl_neva_flush_equipment_article_section( $output, $section );
						$output .= $image_html;
						continue;
					}
				}
			}

			if ( 'img' === $tag_name ) {
				$image_html = lvl_neva_build_equipment_article_image_html(
					(string) $node->getAttribute( 'src' ),
					(string) $node->getAttribute( 'alt' ),
					(string) $node->getAttribute( 'title' )
				);

				if ( '' !== $image_html ) {
					lvl_neva_flush_equipment_article_section( $output, $section );
					$output .= $image_html;
				}

				continue;
			}

			if ( 'blockquote' === $tag_name ) {
				$quote_html = lvl_neva_build_equipment_article_quote_html(
					lvl_neva_extract_quote_html_from_node( $node )
				);

				if ( '' !== $quote_html ) {
					lvl_neva_flush_equipment_article_section( $output, $section );
					$output .= $quote_html;
				}

				continue;
			}

			if ( in_array( $tag_name, array( 'iframe', 'video' ), true ) ) {
				lvl_neva_flush_equipment_article_section( $output, $section );
				$output .= lvl_neva_get_dom_node_outer_html( $node );
				continue;
			}

			if ( in_array( $tag_name, array( 'div', 'section', 'article' ), true ) ) {
				lvl_neva_render_equipment_article_dom_nodes( $node->childNodes, $output, $section );
				continue;
			}

			lvl_neva_flush_equipment_article_section( $output, $section );
			$output .= lvl_neva_get_dom_node_outer_html( $node );
		}
	}
}

if ( ! function_exists( 'lvl_neva_render_equipment_article_html_fragment' ) ) {
	function lvl_neva_render_equipment_article_html_fragment( $html, &$output, &$section ) {
		$html = trim( (string) $html );

		if ( '' === $html ) {
			return;
		}

		if ( ! class_exists( 'DOMDocument' ) ) {
			$section['texts'][] = $html;
			return;
		}

		$previous_state = libxml_use_internal_errors( true );
		$document       = new DOMDocument( '1.0', 'UTF-8' );
		$wrapped_html   = sprintf( '<div>%s</div>', $html );

		$document->loadHTML(
			'<?xml encoding="utf-8" ?>' . $wrapped_html,
			LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
		);

		libxml_clear_errors();
		libxml_use_internal_errors( $previous_state );

		$root = null;

		if ( class_exists( 'DOMXPath' ) ) {
			$xpath     = new DOMXPath( $document );
			$root_list = $xpath->query( '//*[@id="lvl-neva-content-root"]' );
			$root      = $root_list instanceof DOMNodeList && $root_list->length > 0 ? $root_list->item( 0 ) : null;
		}

		if ( ! $root ) {
			$section['texts'][] = $html;
			return;
		}

		lvl_neva_render_equipment_article_dom_nodes( $root->childNodes, $output, $section );
	}
}

if ( ! function_exists( 'lvl_neva_render_equipment_article_blocks' ) ) {
	function lvl_neva_render_equipment_article_blocks( $blocks, &$output, &$section ) {
		foreach ( $blocks as $block ) {
			$block_name = isset( $block['blockName'] ) ? $block['blockName'] : '';

			if ( '' === $block_name && ! empty( $block['innerHTML'] ) ) {
				lvl_neva_render_equipment_article_html_fragment( $block['innerHTML'], $output, $section );
				continue;
			}

			switch ( $block_name ) {
				case 'core/paragraph':
					$paragraph_html = lvl_neva_get_first_element_inner_html( render_block( $block ) );

					if ( '' !== trim( wp_strip_all_tags( $paragraph_html ) ) ) {
						$section['texts'][] = $paragraph_html;
					}
					break;

				case 'core/list':
					$list_html = trim( render_block( $block ) );

					if ( '' !== trim( wp_strip_all_tags( $list_html ) ) ) {
						$section['texts'][] = $list_html;
					}
					break;

				case 'core/heading':
					lvl_neva_flush_equipment_article_section( $output, $section );
					$section['title'] = lvl_neva_get_first_element_inner_html( render_block( $block ) );
					break;

				case 'core/image':
					$image_attrs = isset( $block['attrs'] ) && is_array( $block['attrs'] ) ? $block['attrs'] : array();
					$image_url   = isset( $image_attrs['url'] ) ? $image_attrs['url'] : '';
					$image_alt   = isset( $image_attrs['alt'] ) ? $image_attrs['alt'] : '';
					$image_title = '';

					if ( empty( $image_url ) && ! empty( $image_attrs['id'] ) ) {
						$image_url   = wp_get_attachment_image_url( (int) $image_attrs['id'], 'full' );
						$image_title = get_the_title( (int) $image_attrs['id'] );

						if ( '' === $image_alt ) {
							$image_alt = get_post_meta( (int) $image_attrs['id'], '_wp_attachment_image_alt', true );
						}
					}

					$image_html = lvl_neva_build_equipment_article_image_html( $image_url, $image_alt, $image_title );

					if ( '' !== $image_html ) {
						lvl_neva_flush_equipment_article_section( $output, $section );
						$output .= $image_html;
					}
					break;

				case 'core/quote':
				case 'core/pullquote':
					lvl_neva_flush_equipment_article_section( $output, $section );
					lvl_neva_render_equipment_article_html_fragment( render_block( $block ), $output, $section );
					break;

				case 'core/group':
				case 'core/columns':
				case 'core/column':
					if ( ! empty( $block['innerBlocks'] ) ) {
						lvl_neva_render_equipment_article_blocks( $block['innerBlocks'], $output, $section );
					}
					break;

				case 'core/freeform':
				case 'core/html':
					lvl_neva_render_equipment_article_html_fragment( render_block( $block ), $output, $section );
					break;

				case 'lvl-neva/video-player':
				case 'lvl-neva/equipment-image':
					lvl_neva_flush_equipment_article_section( $output, $section );
					$output .= render_block( $block );
					break;

				default:
					if ( ! empty( $block['innerBlocks'] ) ) {
						lvl_neva_render_equipment_article_blocks( $block['innerBlocks'], $output, $section );
						break;
					}

					$rendered_block = trim( render_block( $block ) );

					if ( '' !== $rendered_block ) {
						lvl_neva_flush_equipment_article_section( $output, $section );
						$output .= $rendered_block;
					}
					break;
			}
		}
	}
}

if ( ! function_exists( 'lvl_neva_get_equipment_article_content' ) ) {
	function lvl_neva_get_equipment_article_content( $post = null ) {
		$post = get_post( $post );

		if ( ! $post instanceof WP_Post ) {
			return '';
		}

		$raw_content = (string) get_post_field( 'post_content', $post->ID );

		if ( '' === trim( $raw_content ) ) {
			return '';
		}

		$output  = '';
		$section = array(
			'title' => '',
			'texts' => array(),
		);

		if ( has_blocks( $raw_content ) ) {
			lvl_neva_render_equipment_article_blocks( parse_blocks( $raw_content ), $output, $section );
		} else {
			lvl_neva_render_equipment_article_html_fragment( apply_filters( 'the_content', $raw_content ), $output, $section );
		}

		lvl_neva_flush_equipment_article_section( $output, $section );

		return $output;
	}
}
