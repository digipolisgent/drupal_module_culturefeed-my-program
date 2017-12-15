<?php

/**
 * @file
 * Culturefeed My program item summary template.
 */
?>

<div class="first">
  <?php foreach(array_values($items) as $row_id => $item): ?>
    <article class="row-<?php print $row_id; ?>">
      <?php print render($item); ?>
    </article>
  <?php endforeach; ?>
</div>
<div class="second">
  <?php if(!empty($clear_form)): ?>
    <?php print $clear_form; ?>
  <?php endif; ?>
  <a href="javascript:window.print();"><?php print t('Print program'); ?></a>
</div>
