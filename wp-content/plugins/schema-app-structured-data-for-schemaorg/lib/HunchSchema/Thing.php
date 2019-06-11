<?php defined('ABSPATH') OR die('This script cannot be accessed directly.');
/**
 * Description of SchemaThing
 *
 * @author mark
 */
class HunchSchema_Thing {

        /**
         * Schema.org Array
         * 
         * @var type 
         */
        protected $schema;
        protected $SchemaBreadcrumb;
        protected $Settings;

        /**
         * Construuctor
         */
        public function __construct() {
                $this->Settings = get_option('schema_option_name');
        }

        public static function factory($postType) {
                // Check for specific Page Types
                if (is_search())
                {
                        $postType = 'Search';
                } elseif (is_author())
                {
                        $postType = 'Author';
                } elseif (is_category())
                {
                        $postType = 'Category';
                } elseif (is_tag())
                {
                        $postType = 'Tag';
                } elseif (!is_front_page() && is_home() || is_home())
                {
                        $postType = 'Blog';
                }

				$postType = apply_filters( 'hunch_schema_thing_post_type', $postType );

                $class = 'HunchSchema_' . $postType;

                if (class_exists($class))
                {
                        return new $class;
                } else
                {
                        return new HunchSchema_Thing;
                }
        }

        /**
         * 
         */
        public function getResource($pretty = false) {
                // To override in child classes
        }

        public function getWebSite($Pretty = false) {
                $this->SchemaWebSite['@context'] = 'http://schema.org';
                $this->SchemaWebSite['@type'] = 'WebSite';
                $this->SchemaWebSite['@id'] = home_url( '/#website' );
                $this->SchemaWebSite['name'] = get_bloginfo('name');
                $this->SchemaWebSite['url'] = home_url();
                $this->SchemaWebSite['potentialAction'] = array(
                        '@type' => 'SearchAction',
                        'target' => home_url('/?s={search_term_string}'),
                        'query-input' => 'required name=search_term_string',
                );

                return $this->toJson($this->SchemaWebSite, $Pretty);
        }

        public function getBreadcrumb($Pretty = false) {
                return false;
        }

        public static function getPermalink() {
                $Permalink = '';

                if (is_author())
                {
                        $Permalink = get_author_posts_url(get_the_author_meta('ID'));
                } elseif (is_category())
                {
                        $Permalink = get_category_link(get_query_var('cat'));
                } elseif (is_singular())
                {
                        $Permalink = get_permalink();
                } elseif (is_front_page() && is_home() || is_front_page())
                {
                        $Permalink = home_url();
                } elseif (is_home())
                {
                        $Permalink = get_permalink(get_option('page_for_posts'));
                }

                return $Permalink;
        }


		protected function getExcerpt()
		{
			global $post;

			if ( post_password_required( $post ) )
			{
				return 'This is a protected post.';
			}

			if ( class_exists( 'WPSEO_Frontend' ) ) {

				$WPSEO_Frontend = WPSEO_Frontend::get_instance();

				$wpseo_meta_description = $WPSEO_Frontend->metadesc( false );

				if ( ! empty( $wpseo_meta_description ) )
				{
					return $wpseo_meta_description;
				}
			}

			if ( ! empty( $post->post_excerpt ) )
			{
				return apply_filters( 'get_the_excerpt', $post->post_excerpt, $post );
			}

			if ( ! empty( $post->post_content ) )
			{
				$text = $post->post_content;
				$text = strip_shortcodes( $text );

				$text = apply_filters( 'the_content', $text );
				$text = str_replace( ']]>', ']]&gt;', $text );
				$text = wp_strip_all_tags( $text );

				$excerpt_length = apply_filters( 'excerpt_length', 55 );
				$excerpt_more = apply_filters( 'excerpt_more', ' ' . '[&hellip;]' );

				$text = wp_trim_words( $text, $excerpt_length, $excerpt_more );

				return $text;
			}
		}


        protected function getImage()
        {
			if ( has_post_thumbnail() )
			{
				$Image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );

				return array
				(
					'@type' => 'ImageObject',
					'@id' => $Image[0],
					'url' => $Image[0],
					'height' => $Image[2],
					'width' => $Image[1]
				);
			}
			else
			{
				global $post;

				if ( $post->post_content )
				{
					$Document = new DOMDocument();
					@$Document->loadHTML( $post->post_content );
					$DocumentImages = $Document->getElementsByTagName( 'img' );

					if ( $DocumentImages->length )
					{
						return array
						(
							'@type' => 'ImageObject',
							'@id' => $DocumentImages->item(0)->getAttribute( 'src' ),
							'url' => $DocumentImages->item(0)->getAttribute( 'src' ),
							'height' => $DocumentImages->item(0)->getAttribute( 'height' ),
							'width' => $DocumentImages->item(0)->getAttribute( 'width' )
						);
					}
					else
					{
						return $this->getDefaultImage();
					}
				}
				else
				{
					return $this->getDefaultImage();
				}
			}
        }


        protected function getDefaultImage()
        {
			if ( ! empty( $this->Settings['SchemaDefaultImage'] ) )
			{
				global $wpdb;

				$Attachment = $wpdb->get_row( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE guid = %s", $this->Settings['SchemaDefaultImage'] ) );

				if ( $Attachment )
				{
					$Image = wp_get_attachment_image_src( $Attachment->ID, 'full' );

					return array
					(
						'@type' => 'ImageObject',
						'@id' => $this->Settings['SchemaDefaultImage'],
						'url' => $this->Settings['SchemaDefaultImage'],
						'width' => $Image[1],
						'height' => $Image[2]
					);
				}
				else
				{
					return array
					(
						'@type' => 'ImageObject',
						'@id' => $this->Settings['SchemaDefaultImage'],
						'url' => $this->Settings['SchemaDefaultImage'],
						'width' => 100,
						'height' => 100
					);
				}
			}
		}


        protected function getTags() {
                global $post;

                $Tags = wp_get_post_terms($post->ID, 'post_tag', array('fields' => 'names'));

                if ($Tags && !is_wp_error($Tags))
                {
                        return $Tags;
                }
        }

        protected function getComments() {
                global $post;

                $Comments = array();
                $PostComments = get_comments(array('post_id' => $post->ID, 'number' => 10, 'status' => 'approve', 'type' => 'comment'));

                if (count($PostComments))
                {
                        foreach ($PostComments as $key => $Item) {
                                $Comments[] = array(
                                        '@type' => 'Comment',
                                        '@id' => get_permalink() . '#Comment' . ( $key + 1 ),
                                        'dateCreated' => $Item->comment_date,
                                        'description' => $Item->comment_content,
                                        'author' => array(
                                                '@type' => 'Person',
                                                'name' => $Item->comment_author,
                                                'url' => $Item->comment_author_url,
                                        ),
                                );
                        }

                        return $Comments;
                }
        }

        protected function getAuthor() {
                global $post;

                $Author = array(
                        '@type' => 'Person',
						'@id' => esc_url(get_author_posts_url(get_the_author_meta('ID', $post->post_author))) . '#Person',
                        'name' => get_the_author_meta('display_name', $post->post_author),
                        'url' => esc_url(get_author_posts_url(get_the_author_meta('ID', $post->post_author))),
                );

                if (get_the_author_meta('description'))
                {
                        $Author['description'] = get_the_author_meta('description');
                }

                if (version_compare(get_bloginfo('version'), '4.2', '>='))
                {
                        $AuthorImage = get_avatar_url(get_the_author_meta('user_email', $post->post_author), 96);

                        if ($AuthorImage)
                        {
                                $Author['image'] = array(
                                        '@type' => 'ImageObject',
                                        '@id' => $AuthorImage,
                                        'url' => $AuthorImage,
                                        'height' => 96,
                                        'width' => 96
                                );
                        }
                }

                return $Author;
        }


        public function getPublisher() {
                static $publisher;

                if (!$publisher)
                {
                        $options = get_option('schema_option_name');

                        if (isset($options['publisher_type']))
                        {

                                // Basic publisher information
                                $publisher = array(
                                        '@type' => $options['publisher_type'],
                                );

                                if (isset($options['publisher_name']))
                                {
                                        $publisher['name'] = $options['publisher_name'];
                                }

                                // Get Publisher Image Attributes
                                if (isset($options['publisher_image']))
                                {
                                        global $wpdb;

                                        $imgProperty = ($options['publisher_type'] === 'Person') ? 'image' : 'logo';

                                        $pubimage = $wpdb->get_row($wpdb->prepare(
                                                        "SELECT ID FROM $wpdb->posts WHERE guid = %s", $options['publisher_image']
                                        ));

                                        // Publisher image found, add it to schema
                                        if (isset($pubimage))
                                        {
                                                $imgAttributes = wp_get_attachment_image_src($pubimage->ID, "full");
                                                $publisher[$imgProperty] = array(
                                                        "@type" => "ImageObject",
                                                        "@id" => $options['publisher_image'],
                                                        "url" => $options['publisher_image'],
                                                        "width" => $imgAttributes[1],
                                                        "height" => $imgAttributes[2]
                                                );
                                        } else
                                        {
                                                $publisher[$imgProperty] = array(
                                                        "@type" => "ImageObject",
                                                        "@id" => $options['publisher_image'],
                                                        "url" => $options['publisher_image'],
                                                        "width" => 600,
                                                        "height" => 60
                                                );
                                        }
                                }
                                
                        }
                }

			return $publisher;
        }


		public function getVideos() {
			global $post;

			$videos = array();
			$urls = wp_extract_urls( $post->post_content );

			if ( count( $urls ) ) {
				foreach ( $urls as $url ) {
					$url = trim( $url );

					if ( filter_var( $url, FILTER_VALIDATE_URL ) != false  &&  stripos( $url, 'vimeo.com' ) !== false ) {
						$videos[] = $this->get_vimeo_video( $url );
					}
				}
			}


			$youtube_video_ids = $this->getYouTubeVideoIds( $post->post_content );

			if ( count( $youtube_video_ids ) ) {
				foreach ( $youtube_video_ids as $youtube_video_id ) {
					$videos[] = $this->getYouTubeVideo( $youtube_video_id );
				}
			}


			if ( count( $videos ) && count( $videos ) == 1 ) {
				return reset( $videos );
			} elseif ( count( $videos ) ) {
				return $videos;
			}

			return;
		}


		protected function getYouTubeVideo( $Id )
		{
			if ( ! empty( $Id ) )
			{
				$TransientId = sprintf( 'HunchSchema-Markup-YouTube-%s', $Id );

				$Transient = get_transient( $TransientId );

				if ( $Transient !== false )
				{
					return $Transient;
				}


				$Response = wp_remote_retrieve_body( wp_remote_get( sprintf( 'https://api.hunchmanifest.com/schemaorg/video.json?ids=%s', $Id ) ) );

				if ( ! empty( $Response ) )
				{
					set_transient( $TransientId, json_decode( $Response ), ( 14 * DAY_IN_SECONDS ) );

					return json_decode( $Response );
				}
			}

			return;
		}


		protected function getYouTubeVideoIds( $String )
		{
			if ( ! empty( $String ) )
			{
				// https?://(?:[0-9A-Z-]+\.)?(?:youtu\.be/|youtube(?:-nocookie)?\.com\S*?[^\w\s-])([\w-]{11})(?=[^\w-]|$)(?![?=&+%\w.-]*(?:[\'"][^<>]*>|</a>))[?=&+%\w.-]*
				// https?://(?:[0-9A-Z-]+\.)?(?:youtu\.be/|youtube(?:-nocookie)?\.com\S*?[^\w\s-])([\w-]{11})(?=[^\w-]|$)[?=&+%\w.-]*
				preg_match_all( '~https?://(?:www\.)?(?:youtu\.be/|youtube(?:-nocookie)?\.com\S*?[^\w\s-])([\w-]{11})(?=[^\w-]|$)[?=&+%\w.-]*~im', $String, $Matches );

				if ( isset( $Matches[1] ) && count( $Matches[1] ) )
				{
					return $Matches[1];
				}
			}

			return array();
		}


		protected function get_vimeo_video( $url ) {
			if ( ! empty( $url ) ) {
				$transient_id = sprintf( 'HunchSchema-Markup-Vimeo-%s', md5( $url ) );
				$transient = get_transient( $transient_id );

				if ( $transient !== false ) {
					return $transient;
				}


				$oembed = wp_remote_retrieve_body( wp_remote_get( 'https://vimeo.com/api/oembed.json?url=' . rawurlencode( $url ) ) );

				if ( ! empty( $oembed )  &&  ( $oembed_json = json_decode( $oembed ) )  ) {
					$schema = array(
						'@type' => 'VideoObject',
						'@id' => $oembed_json->thumbnail_url,
						'name' => $oembed_json->title,
						'description' => $oembed_json->description,
						'thumbnailUrl' => $oembed_json->thumbnail_url,
						'uploadDate' => date( 'c', strtotime( $oembed_json->upload_date ) ),
						'duration' => $this->iso8601_duration( $oembed_json->duration ),
					);

					set_transient( $transient_id, $schema, ( 14 * DAY_IN_SECONDS ) );

					return $schema;
				}
			}
		}


		protected function iso8601_duration( $seconds ) {
			if ( ! empty( $seconds ) ) {
				$days = floor( $seconds / 86400 );
				$seconds = $seconds % 86400;

				$hours = floor( $seconds / 3600 );
				$seconds = $seconds % 3600;

				$minutes = floor( $seconds / 60 );
				$seconds = $seconds % 60;

				return sprintf( 'P%dDT%dH%dM%dS', $days, $hours, $minutes, $seconds );
			}
		}


        /**
         * Converts the schema information to JSON-LD
         * 
         * @return string
         */
        protected function toJson($Array = array(), $pretty = false) {

                foreach ($Array as $key => $value) {
                        if ($value === null)
                        {
                                unset($Array[$key]);
                        }
                }

                if (isset($Array))
                {
                        if ($pretty && strnatcmp(phpversion(), '5.4.0') >= 0)
                        {
                                $jsonLd = json_encode($Array, JSON_PRETTY_PRINT);
                        } else
                        {
                                $jsonLd = json_encode($Array);
                        }
                        return $jsonLd;
                }
        }

}
