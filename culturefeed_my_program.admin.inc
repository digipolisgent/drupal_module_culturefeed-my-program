<?php

/**
 * @file
 * Culturefeed my program admin forms.
 */

/**
 * Admin form.
 *
 * @param array $form
 *   The form structure.
 * @param array $form_state
 *   The form state.
 *
 * @return array
 *   The form structure.
 */
function culturefeed_my_program_admin_form(array $form, array &$form_state) {
  $form['culturefeed_my_program_empty_text'] = [
    '#type' => 'textarea',
    '#title' => t('Empty text'),
    '#description' => t('Text shown when a user visits /my-program when there are no items in his list.'),
    '#default_value' => variable_get('culturefeed_my_program_empty_text'),
  ];

  return system_settings_form($form);
}
