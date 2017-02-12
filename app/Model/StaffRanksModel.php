<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StaffRanksModel extends Model {
  private $table = 'staffranks';
  protected $timestamps = false;
  protected $primarykey = 'rankid';
  protected $guarded = [];
}
 ?>
