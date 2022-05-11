<?php

    $data = Block::compose_data($block);
            Block::preview($block);

?>


<div id="<?= esc_attr($block['id']); ?>" class="<?= esc_attr($block['name'] . $block['class']); ?>">

    banner :)

</div>
