<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ServersModel extends Model {
  private $table = 'servers';
  protected $timestamps = false;
  protected $primarykey = 'serverid';
  protected $guarded = [];
}
 ?>
