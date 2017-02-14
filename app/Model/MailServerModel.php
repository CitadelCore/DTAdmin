<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MailServerModel extends Model {
  protected $table = 'mailserver';
  public $timestamps = false;
  public $primaryKey = 'serverid';
  public $guarded = [];
}
 ?>
