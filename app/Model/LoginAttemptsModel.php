<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LoginAttemptsModel extends Model {
  private $table = 'login_attempts';
  protected $timestamps = false;
  protected $primaryKey = 'user_id';
  protected $incrementing = false;
}
 ?>
