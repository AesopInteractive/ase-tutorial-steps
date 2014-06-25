<?php

/*
* Plugin Name: ASE Tutorial Steps
*/

class aseTutorialSteps {

	function __construct(){
		add_filter( 'cmb_meta_boxes', array($this,'meta') );
		add_shortcode('ase_step_list', array($this,'shortcode'));
	}

	function meta( array $meta_boxes ) {
		$meta_boxes[] = array(
			'title' => __('Post Tutorial Steps', 'aesop-core'),
			'pages' => array('post','ase_docs'),
			'fields' => array(
				array(
					'id' 			=> 'ase_post_tutorial_steps',
					'name' 			=> __('Tutorial Steps', 'aesop-core'),
					'type' 			=> 'group',
					'repeatable'     => true,
					'repeatable_max' => 20,
					'sortable'		=> true,
					'desc'			=> __('Add text and image for each step. use this shortcode in the post to show the step list', 'aesop-core'),
					'fields' 		=> array(
						array(
							'id' 	=> 'img',
							'name' 	=> __('Image', 'aesop-core'),
							'type' 	=> 'image',
							'cols'	=> 4
						),
						array(
							'id' 	=> 'text',
							'name' 	=> __('Text', 'aesop-core'),
							'type' 	=> 'textarea',
							'cols'	=> 8
						),
						array(
							'id' 	=> 'lb',
							'name' 	=> __('Enable Lightbox for this Image', 'aesop-core'),
							'type' 	=> 'checkbox'
						)
					)
				)
			)
		);

		return $meta_boxes;

	}

	function shortcode($atts, $content) {
		ob_start();

		$steps = get_post_meta( get_the_ID(), 'ase_post_tutorial_steps', false);


		if($steps):

			?><ul class="ase-step-list unstyled"><?php

			foreach($steps as $step){

				$getimg = isset($step['img']) ? $step['img'] : null;
				$text = isset($step['text']) ? $step['text'] : null;
				$lb  = $step['lb'];

				$img = $getimg ? wp_get_attachment_url( $getimg ) : false;

				$noimgclass = $getimg ? '' : 'class="no-img"';
				?>
					<li <?php echo $noimgclass;?> >
						<p><?php echo $text;?></p>

						<?php if ($getimg) {

							if ($lb) {
								?><a class="aesop-lb-link aesop-lightbox" href="<?php echo $img;?>"><img class="ase-step-img" src="<?php echo $img;?>"></a><?php
							} else {
								?><img class="ase-step-img" src="<?php echo $img;?>"><?php
							}

						} ?>
					</li>
				<?php

			}

			?></ul><?php

		endif;

		return ob_get_clean();
	}
}
new aseTutorialSteps;