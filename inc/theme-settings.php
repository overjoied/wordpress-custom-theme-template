<?php
/**
 * Theme Settings
 *
 * @link https://developer.wordpress.org/plugins/settings/custom-settings-page/
 * 
 * @author Joanne Joie Cabang
 * @package CustomTheme
 */

namespace CustomTheme;

// Output the content for the Theme Settings page.
function theme_settings_cb() {
?>
  <div class="wrap">
    <h1>Theme Settings</h1>
    <form
      method="post"
      action="options.php"
    >
      <?php
        do_settings_sections( 'theme-settings' );
      ?>
      <?php submit_button(); ?>
    </form>
  </div>
<?php
}

// Output the content for the Custom Code section.
function custom_code_cb() {
?>
  <p>Declare your custom codes here.</p>
<?php
}

// Output the content for the given field.
function append_to( $tag = 'footer' ) {
  $options = get_option( 'theme-settings' );
  $value = esc_attr( $options[ $tag ] ?? '' );
  
  settings_fields( 'theme-settings' );
?>
  <textarea
    name="theme-settings[<?php echo $tag; ?>]"
    id="theme-settings-<?php echo $tag; ?>"
    class="large-text code"
    rows="3"
    value="<?php echo $value; ?>"><?php echo $value; ?></textarea>
<?php
}

/**
 * Register the Theme Settings menu page.
 */
function register_theme_settings() {
  // Add the Theme Settings page as a top-level menu.
  add_menu_page(
    __( 'Theme Settings', TEXT_DOMAIN ),
    __( 'Theme Settings', TEXT_DOMAIN ),
    'manage_options',
    'theme-settings',
    __NAMESPACE__ . '\theme_settings_cb',
  );

  // Register Theme Settings options.
  register_setting(
    'theme-settings',
    'theme-settings',
  );

  // Add 'Custom Code' section in the Theme Settings page.
  add_settings_section(
    'custom-code',
    __( 'Custom Code', TEXT_DOMAIN ),
    __NAMESPACE__ . '\custom_code_cb',
    'theme-settings',
  );

  $custom_code_fields = array(
    'head',
    'body',
    'footer',
  );

  // Add fields in the 'Custom Code' section.
  foreach( $custom_code_fields as $field ) {
    add_settings_field(
      'append-to-' . $field,
      __( 'Append to ' . ucfirst( $field ), TEXT_DOMAIN ),
      fn() => \CustomTheme\append_to( $field ),
      'theme-settings',
      'custom-code',
    );
  }
}
add_action( 'admin_menu', __NAMESPACE__ . '\register_theme_settings' );