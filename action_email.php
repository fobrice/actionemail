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


function form_actionemail_data($atts, $content='') {
   $result="<script>var actionemail_data={";

   foreach(explode("\n", $content) as $line) {
     list($name, $email, $contact_name) = explode(",", $line);
     if ($name != "<br />" and $name != "") {
       $result .= "'{$name}':{'email': '{$email}', 'contact_name':'{$contact_name}' },";
     }
   }
   $result .= "};</script>";
   return $result;
}

function form_actionemail($atts, $content='') {

  $atts = shortcode_atts(array(
        'name' => 'unknown',
        'bcc' => 'contact@animalsace.org'
    ), $atts);

   $form_html= <<< EOT

<div class="action_form action_{$atts['name']}"
<form><label>Ton Nom:</label><input id="{$atts['name']}_nom" type="text" />
<label>Le message qui sera envoyé:</label>
<textarea id="{$atts['name']}_content_email">{$content}</textarea>
<select id="{$atts['name']}_contact"></select></form><script type="text/javascript" src="/scripts/action_email.js"></script>
<span id="{$atts['name']}_providers"></span>
</div>
<script>
var context="{$atts['name']}";
var bcc="{$atts['bcc']}";
init_action_email();
</script>
EOT;

   return $form_html;

}

add_shortcode('actionemail_data', 'form_actionemail_data' );
add_shortcode('actionemail', 'form_actionemail' );

wp_enqueue_script( 'action_email_script', plugin_dir_url( __FILE__ ) . 'www/action_email.js' );
wp_register_style('action_email_style', plugin_dir_url(__FILE__ ) . 'www/action_email.css');
wp_enqueue_style('action_email_style');
include 'options.php'
