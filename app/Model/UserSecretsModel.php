<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserSecretsModel extends Model {
  private $table = 'usersecrets';
  protected $timestamps = false;
  protected $primarykey = 'secretid';
  protected $guarded = [];
}
 ?>
