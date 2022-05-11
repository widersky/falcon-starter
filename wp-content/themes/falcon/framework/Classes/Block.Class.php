<?php

	class Block
	{
		
		public static function compose_data ($block) {
			
			// Prepare block name, id and class for HTML markup
			$block_name = 'section-' . str_replace('acf/', '', $block['name']);
			$block_id = !empty($block['anchor']) ? $block['anchor'] : $block_name . '-' . $block['id'];
			$block_class = !empty($block['className']) ? ' ' .$block['className'] : null;
			
			// Get whole block fields data
			$fields = get_fields();
			
			// Construct friendly looked array to return
			$to_return = [
				'name'  => $block_name,
				'id'    => $block_id,
				'class' => $block_class,
				'data'	=> $fields
			];
			
			return $to_return;
		}
		
		
		public static function preview ($block) {
			if (is_admin()) :
				echo '<img src="' . $block['example']['attributes']['data']['preview_img'] . '" alt="' . $block['name'] . '" />';
			endif;
			
			return false;
		}
		
	}
	