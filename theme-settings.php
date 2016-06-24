<?php
/**
 * Implements hook_form_system_theme_settings_alter().
 *
 * @param $form
 *   Nested array of form elements that comprise the form.
 * @param $form_state
 *   A keyed array containing the current state of the form.
 */
function hag-theme-public-copy_form_system_theme_settings_alter(&$form, &$form_state, $form_id = NULL)  {
  // Work-around for a core bug affecting admin themes. See issue #943212.
  if (isset($form_id)) {
    return;
  }
  $form['hag-theme-public-copy_custom'] = array(
    '#type' => 'fieldset',
    '#title' => t('Custom Settings'),
    '#weight' => 5,
    '#collapsible' => FALSE,
    '#collapsed' => FALSE,
  );
  $form['hag-theme-public-copy_custom']['hag_theme_omit'] = array(
    '#type' => 'checkbox',
    '#title' => t('Remove collections from search results.'),
    '#default_value' => theme_get_setting('hag-theme-public-copy_omit'),
    '#description' => t("If checked, this option will automatically omit objects with a collection content model from search results."),
  );
  $form['hag-theme-public-copy_custom']['hag_theme_search_text'] = array(
    '#type' => 'textarea',
    '#title' => t('Search area welcome text.'),
    '#default_value' => theme_get_setting('hag_theme_search_text'),
    '#description' => t("The search text to appear in the simple search box on the front page."),
  );

  $form['hag-theme-public-copy_custom']['hag-theme-public-copy_front_background'] = array(
    '#type' => 'fieldset',
    '#title' => t('Frontpage background image settings'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
  );
  $form['hag-theme-public-copy_custom']['hag-theme-public-copy_front_background']['hag_background_collection_pid'] = array(
    '#type' => 'textfield',
    '#title' => t('Frontpage background collection.'),
    '#default_value' => (theme_get_setting('hag_background_collection_pid') ? theme_get_setting('hag_background_collection_pid') : "islandora:root"),
    '#description' => t("Search within the give collection at random for objects to use as the front page background."),
  );
  $form['hag-theme-public-copy_custom']['hag-theme-public-copy_front_background']['hag_background_dsid'] = array(
    '#type' => 'textfield',
    '#title' => t('Background object datastream.'),
    '#default_value' => (theme_get_setting('hag_background_dsid') ? theme_get_setting('hag_background_dsid') : "TN"),
    '#description' => t("Use this datastream on frontpage background collection pids as the source for the background."),
  );
}
