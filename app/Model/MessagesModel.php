<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MessagesModel extends Model {
  private $table = 'messages';
  protected $timestamps = false;
  protected $primarykey = 'messageid';
  protected $guarded = [];
}
 ?>
