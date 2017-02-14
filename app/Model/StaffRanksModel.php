<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StaffRanksModel extends Model {
  protected $table = 'staffranks';
  public $timestamps = false;
  public $primarykey = 'rankid';
  public $guarded = [];
}
 ?>
