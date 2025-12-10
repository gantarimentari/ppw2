<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobVacancy extends Model
{
    use HasFactory;
    
    // Menentukan nama tabel secara eksplisit
    protected $table = 'job_vacancies';
    
    // Mendefinisikan kolom yang boleh diisi
    protected $fillable = [
        'title', 'description', 'company', 
        'location', 'salary',
    ];

    // Relasi one-to-many ke Application
    public function applications()
    {
        return $this->hasMany(Application::class, 'job_id');
    }
}