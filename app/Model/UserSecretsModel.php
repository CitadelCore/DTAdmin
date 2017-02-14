<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserSecretsModel extends Model {
  protected $table = 'usersecrets';
  public $timestamps = false;
  public $primarykey = 'secretid';
  public $guarded = [];
}
 ?>
