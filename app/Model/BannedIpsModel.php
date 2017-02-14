<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BannedIpsModel extends Model {
  protected $table = 'bannedips';
  public $timestamps = false;
  public $primaryKey = 'ipid';
}
 ?>
