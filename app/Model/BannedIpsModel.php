<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BannedIpsModel extends Model {
  private $table = 'bannedips';
  protected $timestamps = false;
  protected $primaryKey = 'ipid';
}
 ?>
