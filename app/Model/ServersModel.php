<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ServersModel extends Model {
  protected $table = 'servers';
  public $timestamps = false;
  public $primarykey = 'serverid';
  public $guarded = [];
}
 ?>
