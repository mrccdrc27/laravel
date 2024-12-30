<?php

namespace App\Rules;

use Illuminate\Support\Facades\DB;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;


class ExistsInLMS implements ValidationRule
{
    protected $table;    // Table to query in LMS
    protected $column;  // Column to match the value
    protected $connection = 'sqlsrv_lms';   // Connection name for the LMS database


    /**
     * Create new instance
     *
     * @param  string  $table
     * @param  string  $column
     */
    public function __construct(string $table, string $column)
    {
        $this->table = $table;
        $this->column = $column;
    }


    /**
     * .
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $exists = DB::connection($this->connection)
            ->table($this->table)
            ->where($this->column, $value)
            ->exists();

        if (!$exists) {
            $fail("The {$attribute} does not exist in the LMS database.");
        }
    }
}