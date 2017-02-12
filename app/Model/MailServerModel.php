<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MailServerModel extends Model {
  private $table = 'mailserver';
  protected $timestamps = false;
  protected $primaryKey = 'serverid';
  protected $guarded = [];
}
 ?>
