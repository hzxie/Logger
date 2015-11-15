<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'RWMB_Project_Slider_Field' ) )
{
	class RWMB_Project_Slider_Field extends RWMB_Field
	{
		/**
		 * Enqueue scripts and styles
		 *
		 * @return void
		 */
		static function admin_enqueue_scripts()
		{
			wp_enqueue_style( 'thickbox' );
			wp_enqueue_style( 'rwmb-project-slider', RWMB_CSS_URL . 'project-slider.css', array(), RWMB_VER );

			wp_enqueue_script( 'media-upload' );
			wp_enqueue_script( 'thickbox' );
			wp_enqueue_script( 'jquery-ui-core' );
			wp_enqueue_script( 'jquery-ui-tabs' );
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script( 'rwmb-project-slider', RWMB_JS_URL . 'project-slider.js', array( 'jquery' ), RWMB_VER, true );
		}

		/**
		 * Show begin HTML markup for fields
		 *
		 * @param string $html
		 * @param mixed  $meta
		 *
		 * @return string
		 */
		static function begin_html( $meta, $field )
		{

			$html = null;
			return $html;
		}

		/**
		 * Show end HTML markup for fields
		 *
		 * @param string $html
		 * @param mixed $meta
		 *
		 * @return string
		 */
		static function end_html( $meta, $field )
		{
			$html = null;
			return $html;
		}

		/**
		 * Get field HTML
		 *
		 * @param mixed $meta
		 * @param array $field
		 *
		 * @return string
		 */
		static function html( $meta, $field )
		{
			global $post;

			$id = $field['id'];

			$project_slider = get_post_meta( $post->ID, $id, true ) ? get_post_meta( $post->ID, $id, true ) : false;

			$html = '<ul id="project-slider">';

				if( $project_slider ) {
					foreach ( $project_slider as $i => $slide ) {
						$slide_type               = isset( $slide['slide-type'] )               ? $slide['slide-type']               : null;
						$slide_img_src            = isset( $slide['slide-img-src'] )            ? $slide['slide-img-src']            : null;
						$slide_video_mp4          = isset( $slide['slide-video-mp4'] )          ? $slide['slide-video-mp4']          : null;
						$slide_video_webm         = isset( $slide['slide-video-webm'] )         ? $slide['slide-video-webm']         : null;
						$slide_video_ogg          = isset( $slide['slide-video-ogg'] )          ? $slide['slide-video-ogg']          : null;
						$slide_video_aspect_ratio = isset( $slide['slide-video-aspect-ratio'] ) ? $slide['slide-video-aspect-ratio'] : null;
						$slide_video_preview      = isset( $slide['slide-video-preview'] )      ? $slide['slide-video-preview']      : null;
						$slide_audio_mp3          = isset( $slide['slide-audio-mp3'] )          ? $slide['slide-audio-mp3']          : null;
						$slide_audio_ogg          = isset( $slide['slide-audio-ogg'] )          ? $slide['slide-audio-ogg']          : null;
						$slide_custom             = isset( $slide['slide-custom'] )             ? $slide['slide-custom']             : null;

						$html .= '
						<li class="slide postbox">
							<div class="handlediv" title="' . __('Click to toggle', TPLNAME) . '">&nbsp;</div>
							<h3 class="hndle"><span>' . __('Slide', TPLNAME) . '</span></h3>
							<div class="inside">
								<div class="slider-slide-tabs">
									<div id="slide-button" class="tabs-content">
										<div class="rwmb-field">
											<div class="rwmb-label">
												<label>' . __('Slide Type', TPLNAME) . '</label>
											</div><!-- .rwmb-label -->
											<div class="rwmb-input">
												<select name="slide-type[]" class="rwmb-select">
													<option value="image"  ' . selected( $slide_type, 'image', false ) . '>' . __('Image', TPLNAME) . '</option>
													<option value="video" ' . selected( $slide_type, 'video', false ) . '>' . __('Video', TPLNAME) . '</option>
													<option value="audio" ' . selected( $slide_type, 'audio', false ) . '>' . __('Audio', TPLNAME) . '</option>
													<option value="custom" ' . selected( $slide_type, 'custom', false ) . '>' . __('Custom', TPLNAME) . '</option>
												</select>
											</div><!-- .rwmb-input -->
										</div><!-- .rwmb-field -->
										<div class="slide-type image">
											<div class="rwmb-field">
												<div class="rwmb-label">
													<label>' . __('Image URL', TPLNAME) . '</label>
												</div><!-- .rwmb-label -->
												<div class="rwmb-input">
													<input type="text" name="slide-img-src[]" class="rwmb-text" size="30" value="' . $slide_img_src . '">
													<input type="button" name="upload-image" class="upload-image button" value="' . __('Upload Image', TPLNAME) . '">
												</div><!-- .rwmb-input -->
											</div><!-- .rwmb-field -->		
										</div><!-- .slide-type.image -->
										<div class="slide-type video">
											<div class="rwmb-field">
												<div class="rwmb-label">
													<label>' . __('MP4 File URL', TPLNAME) . '</label>
												</div><!-- .rwmb-label -->
												<div class="rwmb-input">
													<input type="text" name="slide-video-mp4[]" class="rwmb-text" size="30" value="' . $slide_video_mp4 . '">
													<p class="description">' . __('For Safari, IE9, iPhone, iPad, Android, and Windows Phone 7.', TPLNAME) . '</p>
												</div><!-- .rwmb-input -->
											</div><!-- .rwmb-field -->
											<div class="rwmb-field">
												<div class="rwmb-label">
													<label>' . __('WebM File URL', TPLNAME) . '</label>
												</div><!-- .rwmb-label -->
												<div class="rwmb-input">
													<input type="text" name="slide-video-webm[]" class="rwmb-text" size="30" value="' . $slide_video_webm . '">
													<p class="description">' . __('For Firefox, Opera, and Chrome.', TPLNAME) . '</p>
												</div><!-- .rwmb-input -->
											</div><!-- .rwmb-field -->
											<div class="rwmb-field">
												<div class="rwmb-label">
													<label>' . __('OGG File URL', TPLNAME) . '</label>
												</div><!-- .rwmb-label -->
												<div class="rwmb-input">
													<input type="text" name="slide-video-ogg[]" class="rwmb-text" size="30" value="' . $slide_video_ogg . '">
													<p class="description">' . __('For older Firefox and Opera versions.', TPLNAME) . '</p>
												</div><!-- .rwmb-input -->
											</div><!-- .rwmb-field -->
											<div class="rwmb-field">
												<div class="rwmb-label">
													<label>' . __('Preview Image URL', TPLNAME) . '</label>
												</div><!-- .rwmb-label -->
												<div class="rwmb-input">
													<input type="text" name="slide-video-preview[]" class="rwmb-text" size="30" value="' . $slide_video_preview . '">
													<p class="description"></p>
												</div><!-- .rwmb-input -->
											</div><!-- .rwmb-field -->
											<div class="rwmb-field">
												<div class="rwmb-label">
													<label>' . __('Aspect Ratio', TPLNAME) . '</label>
												</div><!-- .rwmb-label -->
												<div class="rwmb-input">
													<input type="text" name="slide-video-aspect-ratio[]" class="rwmb-text" size="30" value="' . $slide_video_aspect_ratio . '">
													<p class="description">' . __('Video width / video height. (default: 1.7)', TPLNAME) . '</p>
												</div><!-- .rwmb-input -->
											</div><!-- .rwmb-field -->
										</div><!-- .slide-type.video -->
										<div class="slide-type audio">
											<div class="rwmb-field">
												<div class="rwmb-label">
													<label>' . __('MP3 File URL', TPLNAME) . '</label>
												</div><!-- .rwmb-label -->
												<div class="rwmb-input">
													<input type="text" name="slide-audio-mp3[]" class="rwmb-text" size="30" value="' . $slide_audio_mp3 . '">
													<p class="description">' . __('For Safari, Internet Explorer, Chrome.', TPLNAME) . '</p>
												</div><!-- .rwmb-input -->
											</div><!-- .rwmb-field -->
											<div class="rwmb-field">
												<div class="rwmb-label">
													<label>' . __('Ogg File URL', TPLNAME) . '</label>
												</div><!-- .rwmb-label -->
												<div class="rwmb-input">
													<input type="text" name="slide-audio-ogg[]" class="rwmb-text" size="30" value="' . $slide_audio_ogg . '">
													<p class="description">' . __('For Firefox, Opera, Chrome.', TPLNAME) . '</p>
												</div><!-- .rwmb-input -->
											</div><!-- .rwmb-field -->
										</div><!-- .slide-type.audio -->
										<div class="slide-type custom">
											<div class="rwmb-field">
												<div class="rwmb-label">
													<label>' . __('Content', TPLNAME) . '</label>
												</div><!-- .rwmb-label -->
												<div class="rwmb-input">
													<textarea name="slide-custom[]" class="rwmb-textarea large-text" cols="60" rows="5">' . $slide_custom . '</textarea>
													<p class="description">' . __('HTML tags and WordPress shortcodes are allowed.', TPLNAME) . '</p>
												</div><!-- .rwmb-input -->
											</div><!-- .rwmb-field -->
										</div><!-- .slide-type.custom -->
									</div><!-- #slide-button -->
								</div><!-- .slider-slide-tabs -->
								<input type="hidden" name="' . $id . '[]" class="rwmb-text" size="30" value="">
							</div><!-- .inside -->
						</li>';
					}

				} else {
					$html .= '
					<li class="slide postbox">
						<div class="handlediv" title="' . __('Click to toggle', TPLNAME) . '">&nbsp;</div>
						<h3 class="hndle"><span>' . __('Slide', TPLNAME) . '</span></h3>
						<div class="inside">
							<div class="slider-slide-tabs">
								<div id="slide-button" class="tabs-content">
									<div class="rwmb-field">
										<div class="rwmb-label">
											<label>' . __('Slide Type', TPLNAME) . '</label>
										</div><!-- .rwmb-label -->
										<div class="rwmb-input">
											<select name="slide-type[]" class="rwmb-select">
												<option value="image"  selected>' . __('Image', TPLNAME) . '</option>
												<option value="video">' . __('Video', TPLNAME) . '</option>
												<option value="audio">' . __('Audio', TPLNAME) . '</option>
												<option value="custom">' . __('Custom', TPLNAME) . '</option>
											</select>
										</div><!-- .rwmb-input -->
									</div><!-- .rwmb-field -->
									<div class="slide-type image">
										<div class="rwmb-field">
											<div class="rwmb-label">
												<label>' . __('Image URL', TPLNAME) . '</label>
											</div><!-- .rwmb-label -->
											<div class="rwmb-input">
												<input type="text" name="slide-img-src[]" class="rwmb-text" size="30" value="">
												<input type="button" name="upload-image" class="upload-image button" value="' . __('Upload Image', TPLNAME) . '">
											</div><!-- .rwmb-input -->
										</div><!-- .rwmb-field -->		
									</div><!-- .slide-type.image -->
									<div class="slide-type video">
										<div class="rwmb-field">
											<div class="rwmb-label">
												<label>' . __('MP4 File URL', TPLNAME) . '</label>
											</div><!-- .rwmb-label -->
											<div class="rwmb-input">
												<input type="text" name="slide-video-mp4[]" class="rwmb-text" size="30" value="">
												<p class="description">' . __('For Safari, IE9, iPhone, iPad, Android, and Windows Phone 7.', TPLNAME) . '</p>
											</div><!-- .rwmb-input -->
										</div><!-- .rwmb-field -->
										<div class="rwmb-field">
											<div class="rwmb-label">
												<label>' . __('WebM File URL', TPLNAME) . '</label>
											</div><!-- .rwmb-label -->
											<div class="rwmb-input">
												<input type="text" name="slide-video-webm[]" class="rwmb-text" size="30" value="">
												<p class="description">' . __('For Firefox, Opera, and Chrome.', TPLNAME) . '</p>
											</div><!-- .rwmb-input -->
										</div><!-- .rwmb-field -->
										<div class="rwmb-field">
											<div class="rwmb-label">
												<label>' . __('OGG File URL', TPLNAME) . '</label>
											</div><!-- .rwmb-label -->
											<div class="rwmb-input">
												<input type="text" name="slide-video-ogg[]" class="rwmb-text" size="30" value="">
												<p class="description">' . __('For older Firefox and Opera versions.', TPLNAME) . '</p>
											</div><!-- .rwmb-input -->
										</div><!-- .rwmb-field -->
										<div class="rwmb-field">
											<div class="rwmb-label">
												<label>' . __('Preview Image URL', TPLNAME) . '</label>
											</div><!-- .rwmb-label -->
											<div class="rwmb-input">
												<input type="text" name="slide-video-preview[]" class="rwmb-text" size="30" value="">
												<p class="description"></p>
											</div><!-- .rwmb-input -->
										</div><!-- .rwmb-field -->
										<div class="rwmb-field">
											<div class="rwmb-label">
												<label>' . __('Aspect Ratio', TPLNAME) . '</label>
											</div><!-- .rwmb-label -->
											<div class="rwmb-input">
												<input type="text" name="slide-video-aspect-ratio[]" class="rwmb-text" size="30" value="1.7">
												<p class="description">' . __('Video width / video height. (default: 1.7)', TPLNAME) . '</p>
											</div><!-- .rwmb-input -->
										</div><!-- .rwmb-field -->
									</div><!-- .slide-type.video -->
									<div class="slide-type audio">
										<div class="rwmb-field">
											<div class="rwmb-label">
												<label>' . __('MP3 File URL', TPLNAME) . '</label>
											</div><!-- .rwmb-label -->
											<div class="rwmb-input">
												<input type="text" name="slide-audio-mp3[]" class="rwmb-text" size="30" value="">
												<p class="description">' . __('For Safari, Internet Explorer, Chrome.', TPLNAME) . '</p>
											</div><!-- .rwmb-input -->
										</div><!-- .rwmb-field -->
										<div class="rwmb-field">
											<div class="rwmb-label">
												<label>' . __('Ogg File URL', TPLNAME) . '</label>
											</div><!-- .rwmb-label -->
											<div class="rwmb-input">
												<input type="text" name="slide-audio-ogg[]" class="rwmb-text" size="30" value="">
												<p class="description">' . __('For Firefox, Opera, Chrome.', TPLNAME) . '</p>
											</div><!-- .rwmb-input -->
										</div><!-- .rwmb-field -->
									</div><!-- .slide-type.audio -->
									<div class="slide-type custom">
										<div class="rwmb-field">
											<div class="rwmb-label">
												<label>' . __('Content', TPLNAME) . '</label>
											</div><!-- .rwmb-label -->
											<div class="rwmb-input">
												<textarea name="slide-custom[]" class="rwmb-textarea large-text" cols="60" rows="5"></textarea>
												<p class="description">' . __('HTML tags and WordPress shortcodes are allowed.', TPLNAME) . '</p>
											</div><!-- .rwmb-input -->
										</div><!-- .rwmb-field -->
									</div><!-- .slide-type.custom -->
								</div><!-- #slide-button -->
							</div><!-- .slider-slide-tabs -->
							<button class="remove-slide button-secondary">' . __('Remove Slide', TPLNAME) . '</button>
							<input type="hidden" name="' . $id . '[]" class="rwmb-text" size="30" value="">
						</div><!-- .inside -->
					</li>';
				}
				$html .= '
				</ul><!-- #project-slider -->
				<div class="rwmb-label">
					<button id="add-slider-slide" class="button-primary">' . __('Add New Slide', TPLNAME) . '</button>
				</div>
				<div class="rwmb-input">
					<p id="' . $id . '_description" class="description">' . $field['desc'] . '</p>
				</div>
				<input type="hidden" name="slider-meta-info" value="' . $post->ID . '|' . $id . '">';

			return $html;
		}

		/**
		 * Save slides
		 *
		 * @param mixed $new
		 * @param mixed $old
		 * @param int $post_id
		 * @param array $field
		 *
		 * @return void
		 */
		static function save( $new, $old, $post_id, $field )
		{
				
			$name = $field['id'];

			$project_slider = array();
			
			foreach( $_POST[$name] as $i => $v ) {
				if( $_POST['slide-type'][$i] == 'image' ) {
					$project_slider[] = array(
						'slide-type'               => $_POST['slide-type'][$i],
						'slide-img-src'            => $_POST['slide-img-src'][$i],
						'slide-video-mp4'          => '',
						'slide-video-webm'         => '',
						'slide-video-ogg'          => '',
						'slide-video-preview'      => '',
						'slide-video-aspect-ratio' => '',
						'slide-audio-mp3'          => '',
						'slide-audio-ogg'          => '',
						'slide-custom'             => ''
					);
				} elseif( $_POST['slide-type'][$i] == 'video' ) {
					$project_slider[] = array(
						'slide-type'               => $_POST['slide-type'][$i],
						'slide-img-src'            => '',
						'slide-video-mp4'          => $_POST['slide-video-mp4'][$i],
						'slide-video-webm'         => $_POST['slide-video-webm'][$i],
						'slide-video-ogg'          => $_POST['slide-video-ogg'][$i],
						'slide-video-preview'      => $_POST['slide-video-preview'][$i],
						'slide-video-aspect-ratio' => $_POST['slide-video-aspect-ratio'][$i],
						'slide-audio-mp3'          => '',
						'slide-audio-ogg'          => '',
						'slide-custom'             => ''
					);
				} elseif( $_POST['slide-type'][$i] == 'audio' ) {
					$project_slider[] = array(
						'slide-type'               => $_POST['slide-type'][$i],
						'slide-img-src'            => '',
						'slide-video-mp4'          => '',
						'slide-video-webm'         => '',
						'slide-video-ogg'          => '',
						'slide-video-preview'      => '',
						'slide-video-aspect-ratio' => '',
						'slide-audio-mp3'          => $_POST['slide-audio-mp3'][$i],
						'slide-audio-ogg'          => $_POST['slide-audio-ogg'][$i],
						'slide-custom'             => ''
					);
				} elseif( $_POST['slide-type'][$i] == 'custom' ) {
					$project_slider[] = array(
						'slide-type'               => $_POST['slide-type'][$i],
						'slide-img-src'            => '',
						'slide-video-mp4'          => '',
						'slide-video-webm'         => '',
						'slide-video-ogg'          => '',
						'slide-video-preview'      => '',
						'slide-video-aspect-ratio' => '',
						'slide-audio-mp3'          => '',
						'slide-audio-ogg'          => '',
						'slide-custom'             => $_POST['slide-custom'][$i]
					);
				}
			}

			$new = $project_slider;
			update_post_meta( $post_id, $name, $new );
		}
	}
}
