<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SyslogModel extends Model {
  private $table = 'syslog';
  protected $timestamps = false;
  protected $primarykey = 'event';
  protected $guarded = [];
}
 ?>
