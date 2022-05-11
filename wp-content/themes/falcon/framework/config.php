<?php

    require get_template_directory() . "/framework/Classes/Falcon.Class.php";

    // Rendeer Falcon's welcome box on WP admin cockpit
    $falcon = new Falcon();
    $falcon -> render_welcome_box();
