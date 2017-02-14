<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AlertsModel extends Model {
  protected $table = 'alerts';
  public $timestamps = false;
  public $primaryKey = 'alertid';
}
 ?>
