<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LoginAttemptsModel extends Model {
  protected $table = 'login_attempts';
  public $timestamps = false;
  public $primaryKey = 'user_id';
  public $incrementing = false;
}
 ?>
