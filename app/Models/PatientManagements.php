<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class PatientManagements extends Model
{
    public function procedureList(): HasMany
    {
        return $this->hasMany(ProcedureList::class, 'patmanage_id', 'id');
    }
}
