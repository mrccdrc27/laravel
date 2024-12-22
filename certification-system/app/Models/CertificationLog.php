<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificationLog extends Model
{
    public $timestamps = false;
   
    use HasFactory;
    // Table name
    protected $table = 'certification_log';

    // Primary key
    protected $primaryKey = 'LogID'; // Capital K is the correct property name

    // Mass assignment for columns
    protected $fillable = [
        'CertificationID',
        'Action',
        'ActionDate',
    ];
    public function certification(){
        return $this->belongsTo(Certification::class,'CertificationID','CertificationID');
    }

}
