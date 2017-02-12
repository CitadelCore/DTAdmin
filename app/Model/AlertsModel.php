<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AlertsModel extends Model {
  private $table = 'alerts';
  protected $timestamps = false;
  protected $primaryKey = 'alertid';
}
 ?>
