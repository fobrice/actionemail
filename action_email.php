<?php
/**
 * Plugin Name:     Action Email
 * Plugin URI:
 * Description:     generate form to format email to send to a target from your personnal email
 * Author:          fobrice
 * Author URI:
 * Text Domain:
 * Domain Path:     /languages
 * Version:         0.2.0
 *
 * @package         ActionEmail
 */


function form_actionemail_data($atts, $content='') {
   $result="<script>var actionemail_data={";

   foreach(explode("\n", $content) as $key=>$line) {
     $line_trim = strip_tags($line);
     if ($line_trim != "") {
       list($name, $contact_name, $email) = explode(",", $line_trim);
       if ($key > 1 ) {
         $result .= ",";
       }
       $result .= "'{$name}':{'email': '{$email}', 'contact_name':'{$contact_name}' }";
     }
   }
   $result .= "};</script>";
   return $result;
}

function form_actionemail($atts, $content='') {

  $atts = shortcode_atts(array(
        'name' => 'unknown',
        'bcc' => 'contact@animalsace.org',
        'subject' => "test",
        'select_target' => 1,
        'subscribe' => 0,
    ), $atts);

   $content_txt = strip_tags($content);
   $form_html= <<< EOT
<div class="action_form action_{$atts['name']}"
<label>Votre prénom et nom :</label><input id="{$atts['name']}_nom" type="text" onkeyup="Javascript:generateText();"/>
<label>Sujet:</label><input id="{$atts['name']}_subject" type="text" value="{$atts['subject']}"/>
<label>Le message qui sera envoyé :</label>
<textarea id="{$atts['name']}_content_email"  rows=10></textarea>
EOT;
if ($atts['select_target'] )
  $form_html.="<select id=\"{$atts['name']}_contact\"></select>";
if ($atts['subscribe'])
  $form_html.="<span><label>m'abonner à la newsletter</label><input type=\"checkbox\" id=\"{$atts['name']}_subscribe\"></span>";
$form_html.= <<< EOT
<label>Envoyez votre message avec :</label>
<span id="{$atts['name']}_providers"></span>
<textarea id="{$atts['name']}_content_email_template" class="action_email_data">{$content_txt}</textarea>
</div>
<script>
var context="{$atts['name']}";
var bcc="{$atts['bcc']}";
init_action_email();
</script>
EOT;

   return $form_html;

}

if( is_admin() ) {
    include( plugin_dir_path( __FILE__ ) . 'options.php');
    $my_settings_page = new EmailActionSettingsPage();
}
else {
  add_shortcode('actionemail_data', 'form_actionemail_data' );
  add_shortcode('actionemail_metadata', 'form_actionemail_metadata' );
  add_shortcode('actionemail', 'form_actionemail' );

  wp_enqueue_script( 'action_email_script', plugin_dir_url( __FILE__ ) . 'www/action_email.js' );
  wp_register_style('action_email_style', plugin_dir_url(__FILE__ ) . 'www/action_email.css');
  wp_enqueue_style('action_email_style');

}
