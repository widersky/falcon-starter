<?php

	class Falcon
	{
		
		
		/**
		 * Render options page for Falcon
		 *
		 * @return void
		 */
		public function render_welcome_box () {
            add_action('wp_dashboard_setup', function () {
                global $wp_meta_boxes;
                 
                wp_add_dashboard_widget('falcon_about', 'Falcon', function () {
                    echo '
                        <div style="display: flex; justify-content: center; padding: 24px 0;">
                            <img src="' . get_template_directory_uri() . '/framework/logo.png" />
                        </div>
                        <h2>Strona używa motywu zbudowanego z pomocą Falcona.</h2>
                        <br>
                        <strong>O co chodzi?</strong>
                        <p>
                            Jako narzędzie, które pierwotnie było kierowane do blogerów WordPress domyślnie jest skonfigurowany w sposób nieoptymalny z punktu widzenia innych zastosowań. 
                            Dziś ten system można używać do przeróżnych celów, ale konieczność zachowania wstecznej kompatybilności wymusza na twórcach, by pewne opcje były domyślnie włączone.
                            Falcon niewielkim narzutem dodatkowego kodu dokonuje pewnych optymalizacji oraz ułatwia tworzenie motywów dla WordPressa korzystających z bloków i wtyczki ACF Pro.
                            Dzięki Falconowi tworzenie bloków dla edytora Gutenberg jest jeszcze prostsze, a struktura kodu bardziej logiczna i przejrzysta.
                        </p>
                        <p>Falcon optymalizuje WP poprzez:</p>
                        <ol>
                            <li>wyczyszczenie sekcji head strony z meta znaczników, z których korzystają jedynie blogi,</li>
                            <li>wyłączenie niepotrzebnych opcji w panelu admina,</li>
                            <li>usunięcie domyślnych bloków edytora Gutenberg wraz z ich stylami,</li>
                            <li>usunięcie styli dla emoji,</li>
                            <li>przeniesienie skryptów JS do stopki strony,</li>
                            <li>włączenie możliwości dodawania plików SVG poprzez panel admina</li>
                        </ol>
                        <a class="button">Dowiedz się więcej</a>
                    ';
                }, null, null, "normal", "high");
            });
		}
		
		
	}
 
