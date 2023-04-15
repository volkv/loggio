<?php

namespace Volkv\Loggio\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Eloquent
 */
class LoggioModel extends Model
{

    public $timestamps = false;
    protected $guarded = [];
    protected $table = 'loggio';

}
