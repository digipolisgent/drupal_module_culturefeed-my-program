# CultureFeed My program

This Drupal module extends the 
[CultureFeed Drupal module suite][link-culturefeed].

It adds the functionality to create a personal list of events a person would
like to attend.

> **NOTE** : Items are automatically removed once they are passed via a cron
hook.


## Requirements
* [CultureFeed Drupal module suite][link-culturefeed]

## Installation
* [Install culturefeed module suite][link-culturefeed-install].
* Enable this module (culturefeed_my_program).
* Add `<?php print $add_to_my_program; ?>` to the `culturefeed-event.tpl.php`
in your theme.

## Usage
* All logged in users can add events to their my program via the added button.
* All logged in users can view the `/my-program` page to view, clear or print their program.


[link-culturefeed]: https://github.com/cultuurnet/culturefeed
[link-culturefeed-install]: https://github.com/cultuurnet/culturefeed#install
