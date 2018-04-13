<?php
/**
 * Plugin Name:     Action Email
 * Plugin URI:
 * Description:     generate form to format email to send to a target from your personnal email
 * Author:          fobrice
 * Author URI:
 * Text Domain:
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         ActionEmail
 */

/**
 * My Plugin class
 */
class My_Plugin {


}

function form_actionemail($atts, $content='') {

  $atts = shortcode_atts(array(
        'name' => 'unknown',
        'bcc' => 'contact@animalsace.org'
    ), $atts);

   $form_html= <<< EOT
<script>
var context="{$atts['name']}";
var bcc="{$atts['bcc']}";
</script>

<form>Ton Nom:<input id="{$atts['name']}_nom" type="text" />
<select id="{$atts['name']}_mairies"></select></form><script type="text/javascript" src="/scripts/action_email.js"></script>
<span id="{$atts['name']}_providers"></span>
<span id="{$atts['name']}_content_email">{$content}</span>
<script>init_action_email();</script>
EOT;

   return $form_html;

}

add_shortcode('actionemail', 'form_actionemail' );
wp_enqueue_script( 'action_email', plugin_dir_url( __FILE__ ) . 'action_email/action_email.js' );
