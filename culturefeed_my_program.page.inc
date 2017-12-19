<?php

/**
 * @file
 * Page callbacks for Culturefeed My program.
 */

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
