<?php

/**
 * Class CulturefeedMyProgram.
 */
class CulturefeedMyProgram {

  /**
   * The owner of this 'my program'.
   *
   * @var \stdClass
   */
  protected $account;

  /**
   * List of my program items.
   *
   * @var CulturefeedMyProgramItem[]
   */
  protected $items;

  /**
   * CulturefeedMyProgram constructor.
   *
   * @param \stdClass $account
   *   The owner of this 'my program', default to the current user.
   */
  public function __construct(\stdClass $account = NULL) {
    global $user;

    $this->account = $account ? $account : $user;

    // Populate list with the items in the database.
    foreach ($this->getItemsFromDb() as $item) {
      $this->addItem($item);
    }
  }

  /**
   * Items getter.
   *
   * @return \CulturefeedMyProgramItem[]
   *   List of items.
   */
  public function getItems() {
    return $this->items;
  }

  /**
   * Delete all items from database, essentially clearing this 'my program'.
   */
  public function deleteAllItems() {
    foreach ($this->getItems() as $item) {
      $item->delete();
    }
    // Clear items property.
    $this->items = [];
  }

  /**
   * Add an item to the list.
   *
   * @param CulturefeedMyProgramItem $item
   *   The item to add.
   */
  private function addItem(CulturefeedMyProgramItem $item) {
    $this->items[$item->getItemId()] = $item;
  }

  /**
   * Return all items currently in the database.
   *
   * @return CulturefeedMyProgramItem[]
   *   The items in the database.
   */
  private function getItemsFromDb() {
    $query = db_select(CulturefeedMyProgramItem::CULTUREFEED_MY_PROGRAM_TABLE, 'p');
    $query->fields('p', []);
    $query->condition('p.uid', $this->account->uid);
    $query->orderBy('p.end_date');
    $result = $query->execute();

    $items = [];
    while ($row = $result->fetchAssoc()) {
      $items[] = new CulturefeedMyProgramItem($row);
    }

    return $items;
  }

}
