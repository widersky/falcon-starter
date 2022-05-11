<header class="py-3">
	Testuje :P
    
    <a href="<?= home_url() ?>">Home</a>
    
    <span class="fs-24">Font 24</span>
    
    <div class="pt-48 fs-20 ml-32 text-primary">PT48</div>
    
    <div class="grid cols-4 gap-x fs-16">
        <div>1</div>
        <div>2</div>
        <div>3</div>
        <div>4</div>
        <div>5</div>
        <div>6</div>
        <div>7</div>
        <div>8</div>
    </div>
    
    <div class="container fs-14 p-8 text-white bg-primary my-8">
        Container
    </div>
    
    <?php
      wp_nav_menu([
        'menu' => 'top',
        'theme_location' => 'top'
      ]);
    ?>
</header>