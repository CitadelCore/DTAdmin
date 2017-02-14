<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SyslogModel extends Model {
  protected $table = 'syslog';
  public $timestamps = false;
  public $primarykey = 'event';
  public $guarded = [];
}
 ?>
