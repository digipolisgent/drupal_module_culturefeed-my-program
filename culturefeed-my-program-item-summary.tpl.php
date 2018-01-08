<?php

/**
 * @file
 * Culturefeed My program item summary template.
 */
?>

<?php if (!empty($title)): ?>
  <h2><?php print $title; ?></h2>
<?php endif; ?>
<?php if (!empty($shortdescription)): ?>
  <p class="short-description"><?php print $shortdescription; ?></p>
<?php endif; ?>
<?php if (!empty($remove_from_my_program)): ?>
  <?php print $remove_from_my_program; ?>
<?php endif; ?>
