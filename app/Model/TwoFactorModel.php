<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TwoFactorModel extends Model {
  protected $table = '2fa';
  public $timestamps = false;
  public $primarykey = 'tokenid';
  public $guarded = [];
}
 ?>
