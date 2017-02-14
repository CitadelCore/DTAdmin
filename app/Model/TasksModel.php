<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TasksModel extends Model {
  protected $table = 'tasks';
  public $timestamps = false;
  public $primarykey = 'taskid';
  public $guarded = [];
}
 ?>
