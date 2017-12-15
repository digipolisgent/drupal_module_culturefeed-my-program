<?php

/**
 * Class CulturefeedMyProgram.
 */
class CulturefeedMyProgramItem {

  const CULTUREFEED_MY_PROGRAM_TABLE = 'culturefeed_my_program';

  /**
   * The user id of this program item.
   *
   * @var int
   */
  protected $uid;

  /**
   * Id of the culturefeed item.
   *
   * @var string
   */
  protected $itemId;

  /**
   * End date of the culturefeed item.
   *
   * @var int
   */
  protected $endDate;

  /**
   * Last updated time of the culturefeed item.
   *
   * @var int
   */
  protected $lastUpdated;

  /**
   * CulturefeedMyProgramItem constructor.
   *
   * The values paramter is a key value array with these values:
   *   - uid: The user id of the program item.
   *   - item_id: Id of the culturefeed item.
   *   - end_date: The end date of the culturefeed item.
   *   - last_updated: Last updated time of the culturefeed item.
   *
   * @param array $values
   *   Values array.
   */
  public function __construct(array $values) {
    $this->setUid($values['uid']);
    $this->setItemId($values['item_id']);
    $this->setEndDate($values['end_date']);
    $this->setLastUpdated($values['last_updated']);
  }

  /**
   * Uid getter.
   *
   * @return int
   *   The uid.
   */
  public function getUid() {
    return $this->uid;
  }

  /**
   * Uid setter.
   *
   * @param int $value
   *   The uid value.
   */
  public function setUid($value) {
    $this->uid = $value;
  }

  /**
   * Item id getter.
   *
   * @return string
   *   The item id.
   */
  public function getItemId() {
    return $this->itemId;
  }

  /**
   * Uid setter.
   *
   * @param string $value
   *   The item id value.
   */
  public function setItemId($value) {
    $this->itemId = $value;
  }

  /**
   * End date getter.
   *
   * @return int
   *   The end date.
   */
  public function getEndDate() {
    return $this->endDate;
  }

  /**
   * End date setter.
   *
   * @param int $value
   *   The end date value.
   */
  public function setEndDate($value) {
    $this->endDate = $value;
  }

  /**
   * Last updated getter.
   *
   * @return int
   *   The last updated date.
   */
  public function getLastUpdated() {
    return $this->lastUpdated;
  }

  /**
   * Last updated setter.
   *
   * @param int $value
   *   The last updated value.
   */
  public function setLastUpdated($value) {
    $this->lastUpdated = $value;
  }

  /**
   * Load a CulturefeedMyProgramItem from the DB given the uid and item_id.
   *
   * @param int $uid
   *   The user id of the program item.
   * @param string $item_id
   *   The culturefeed id of the program item.
   *
   * @return CulturefeedMyProgramItem|null
   *   A fully loaded CulturefeedMyProgramItem or null if not found.
   */
  public static function load($uid, $item_id) {
    $query = db_select(self::CULTUREFEED_MY_PROGRAM_TABLE, 'p');
    $query->fields('p');
    $query->condition('p.uid', $uid);
    $query->condition('p.item_id', $item_id);

    $result = $query->execute();

    if (!$result || !$result->rowCount()) {
      return NULL;
    }

    $values = $result->fetchAssoc();
    return new static($values);
  }

  /**
   * Save the current item to the DB.
   *
   * @see drupal_write_record()
   *
   * @return bool|int
   *   Return value of drupal_write_record().
   */
  public function save() {
    $row = [
      'uid' => $this->getUid(),
      'item_id' => $this->getItemId(),
      'end_date' => $this->getEndDate(),
      'last_updated' => $this->getLastUpdated(),
    ];

    // Update if item exists.
    if (self::load($this->getUid(), $this->getItemId())) {
      return drupal_write_record(self::CULTUREFEED_MY_PROGRAM_TABLE, $row, [
        'uid' => $this->getUid(),
        'item_id' => $this->getItemId(),
      ]);
    }

    // Create item.
    return drupal_write_record(self::CULTUREFEED_MY_PROGRAM_TABLE, $row);
  }

  /**
   * Delete the current item from the DB.
   *
   * @return bool
   *   True if the item was deleted.
   */
  public function delete() {
    return (bool) db_delete(self::CULTUREFEED_MY_PROGRAM_TABLE)
      ->condition('uid', $this->getUid())
      ->condition('item_id', $this->getItemId())
      ->execute();
  }

}
