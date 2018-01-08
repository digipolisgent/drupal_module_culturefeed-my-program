<?php

/**
 * @file
 * Page callbacks for Culturefeed My program.
 */

use \CultuurNet\Search\ActivityStatsExtendedEntity;

/**
 * My program page.
 */
function culturefeed_my_program_page() {
  global $user;

  if ($user->uid === 0) {
    drupal_goto('culturefeed/oauth/connect', ['query' => drupal_get_destination()]);
    return FALSE;
  }

  $my_program = new CulturefeedMyProgram($user);

  $items = $my_program->getItems();
  if (empty($items)) {
    return [
      '#markup' => variable_get('culturefeed_my_program_empty_text', t('No items have been added to your program yet.')),
    ];
  }

  $output = [
    '#theme' => 'culturefeed_my_program_list',
    '#items' => [],
  ];

  foreach ($items as $item) {
    $item_id = $item->getItemId();

    /* @var $cultsure_feed_item \CultuurNet\Search\ActivityStatsExtendedEntity */
    $culture_feed_item = culturefeed_agenda_event_load($item_id);
    $output['#items'][sprintf('item-%s', $item_id)] = [
      // Using a different template because my_program_items have different
      // fields than the normal teasers.
      '#theme' => 'culturefeed_my_program_item_summary',
      '#item' => $culture_feed_item,
    ];
  }

  return $output;
}

/**
 * Confirmation form to remove item from my program.
 *
 * @param array $form
 *   Form build array.
 * @param array $form_state
 *   Form state array.
 * @param \CultuurNet\Search\ActivityStatsExtendedEntity $culturefeed_event
 *   The Culture feed event.
 *
 * @return array
 *   Form build array.
 */
function culturefeed_my_program_confirm_remove(array $form, array &$form_state, ActivityStatsExtendedEntity $culturefeed_event) {
  $form['id'] = [
    '#type' => 'hidden',
    '#value' => $culturefeed_event->getId(),
  ];

  $title = $culturefeed_event->getTitle(culturefeed_search_get_preferred_language());
  $description = t('Remove %name from your program?', ['%name' => $title]);
  $url = culturefeed_search_detail_url($culturefeed_event->getType(), $culturefeed_event->getId(), $title);

  return confirm_form($form, $description, $url, $description);
}

/**
 * Confirmation form to remove item from my program submit handler.
 */
function culturefeed_my_program_confirm_remove_submit($form, &$form_state) {
  global $user;
  $my_program_item = CulturefeedMyProgramItem::load($user->uid, $form_state['values']['id']);
  if ($my_program_item) {
    $culturefeed_event = culturefeed_agenda_event_load($my_program_item->getItemId());
    $title =  $culturefeed_event->getTitle(culturefeed_search_get_preferred_language());
    drupal_set_message(t('%title has been removed from <a href="@url">your program</a>.', [
      '%title' => $title,
      '@url' => url('my-program'),
    ]));

    $my_program_item->delete();
    $form_state['redirect'] = culturefeed_search_detail_url($culturefeed_event->getType(), $culturefeed_event->getId(), $title);
  }


}
