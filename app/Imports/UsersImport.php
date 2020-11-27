<?php

namespace App\Imports;

use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class UsersImport implements
    ToCollection,
    WithHeadingRow,
    SkipsOnError,
    // WithValidation,
    SkipsOnFailure,
    WithChunkReading,
    ShouldQueue,
    WithEvents
{
    use Importable, SkipsErrors, SkipsFailures, RegistersEventListeners;
    private $class;
    public function __construct($class) {
        $this->class = $class;
    }

    public function collection(Collection $rows)
    {

        foreach ($rows as $row) {
            $name = changeTitle($row['name']);
            $words = explode("-", $name);
            $lastName = array_pop($words);
            $lastName = ucfirst( $lastName );
            $acronym = "";


            foreach ($words as $w) {
                $str = lowercaseToUppercase($w[0]);
                $acronym .= $str;
            }

            $lastName = $lastName .= $acronym;
            $lastName1 = $lastName;
            $dem = 0;

            do {
              $dem++;

              $lastName = $lastName1.''.$dem;
              $user = User::where('account', $lastName)->get()->first();
            } while ($user != null);
            

            $user = User::create([
                'name' => $row['name'],
                'account' => $lastName,
                'password' => Hash::make("123456"),
                'position' => 1,
                'class_id' => $this->class,
                'status'   => 1,
            ]);
           
        }
    }

    // public function rules(): array
    // {

    // }


    public function chunkSize(): int
    {
        return 1000;
    }

    public static function afterImport(AfterImport $event)
    {
    }

    public function onFailure(Failure ...$failure)
    {
    }
}