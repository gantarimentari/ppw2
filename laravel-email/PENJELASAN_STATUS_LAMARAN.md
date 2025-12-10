# Langkah-Langkah Menambahkan Fitur Status Lamaran

## Penjelasan Umum
Fitur ini memungkinkan admin untuk melihat daftar pelamar dan mengubah status lamaran (Pending, Accepted, Rejected). Implementasi menggunakan arsitektur MVC (Model-View-Controller) Laravel.

---

## 1. Database Layer (Migration)

### Tujuan
Membuat struktur tabel di database untuk menyimpan data lamaran beserta statusnya.

### File: `database/migrations/2025_11_19_074135_create_applications_table.php`

```php
Schema::create('applications', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('job_id')->constrained('job_vacancies')->onDelete('cascade');
    $table->string('cv');
    $table->string('status')->default('pending');
    $table->timestamps();
});
```

### Penjelasan:
- **user_id**: Menyimpan ID pelamar (foreign key ke tabel users)
- **job_id**: Menyimpan ID lowongan kerja (foreign key ke tabel job_vacancies)
- **cv**: Menyimpan path file CV yang diupload
- **status**: Menyimpan status lamaran dengan nilai default 'pending'
- **timestamps**: Menyimpan waktu pembuatan dan update data

### Perintah:
```bash
php artisan migrate
```

---

## 2. Model Layer

### Tujuan
Membuat model untuk berinteraksi dengan database dan mendefinisikan relasi antar tabel.

### File: `app/Models/Application.php`

```php
class Application extends Model
{
    protected $fillable = [
        'user_id',
        'job_id',
        'cv',
        'status',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function job()
    {
        return $this->belongsTo(JobVacancy::class, 'job_id');
    }
}
```

### Penjelasan:
- **$fillable**: Menentukan kolom yang boleh diisi secara mass assignment
- **user()**: Relasi ke tabel users untuk mendapatkan data pelamar
- **job()**: Relasi ke tabel job_vacancies untuk mendapatkan data lowongan

---

## 3. Controller Layer

### Tujuan
Menangani logika bisnis untuk menampilkan daftar pelamar dan mengubah status lamaran.

### File: `app/Http/Controllers/ApplicationController.php`

#### Method index() - Menampilkan Daftar Pelamar
```php
public function index(Request $request, $jobId)
{
    $applications = Application::with('user', 'job')->get();
    return view('applications.index', compact('applications'));
}
```

**Penjelasan:**
- Mengambil semua data lamaran beserta relasi user dan job menggunakan `with()`
- Mengirim data ke view `applications.index`

#### Method updateStatus() - Mengubah Status Lamaran
```php
public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:pending,accepted,rejected'
    ]);

    $application = Application::findOrFail($id);
    $application->status = $request->status;
    $application->save();

    return back()->with('success', 'Status lamaran berhasil diperbarui!');
}
```

**Penjelasan:**
- **validate()**: Memvalidasi input, memastikan status hanya boleh pending/accepted/rejected
- **findOrFail()**: Mencari data berdasarkan ID, error jika tidak ditemukan
- **save()**: Menyimpan perubahan ke database
- **back()->with()**: Redirect kembali dengan pesan sukses

---

## 4. Routes

### Tujuan
Mendefinisikan URL endpoint yang bisa diakses dan menghubungkannya dengan controller.

### File: `routes/web.php`

```php
// Menampilkan daftar pelamar (hanya admin)
Route::get('/jobs/{job}/applicants', 
    [ApplicationController::class, 'index']
)->name('applications.index')->middleware('isAdmin');

// Mengubah status lamaran (hanya admin)
Route::patch('/applications/{application}/status', 
    [ApplicationController::class, 'updateStatus']
)->name('applications.updateStatus')->middleware('isAdmin');
```

**Penjelasan:**
- **GET /jobs/{job}/applicants**: Menampilkan halaman daftar pelamar
- **PATCH /applications/{application}/status**: Endpoint untuk update status
- **middleware('isAdmin')**: Hanya admin yang bisa mengakses

---

## 5. View Layer

### Tujuan
Menampilkan antarmuka untuk admin melihat dan mengubah status pelamar.

### File: `resources/views/applications/index.blade.php`

#### Struktur Utama:
```blade
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Pelamar</th>
            <th>Email</th>
            <th>Posisi</th>
            <th>CV</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($applications as $index => $application)
        <tr>
            <!-- Data pelamar -->
        </tr>
        @endforeach
    </tbody>
</table>
```

#### Form Update Status:
```blade
<form action="{{ route('applications.updateStatus', $application->id) }}" method="POST">
    @csrf
    @method('PATCH')
    <select name="status" onchange="this.form.submit()">
        <option value="pending">Pending</option>
        <option value="accepted">Accepted</option>
        <option value="rejected">Rejected</option>
    </select>
</form>
```

**Penjelasan:**
- **@csrf**: Token keamanan Laravel
- **@method('PATCH')**: Method spoofing untuk HTTP PATCH
- **onchange="this.form.submit()"**: Auto-submit saat status diubah
- **route()**: Helper untuk generate URL berdasarkan nama route

#### Badge Status dengan Warna:
```blade
<span class="
    {{ $application->status == 'accepted' ? 'bg-green-100 text-green-800' : '' }}
    {{ $application->status == 'rejected' ? 'bg-red-100 text-red-800' : '' }}
    {{ $application->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}">
    {{ ucfirst($application->status) }}
</span>
```

**Penjelasan:**
- Menggunakan conditional class untuk memberikan warna berbeda setiap status
- **ucfirst()**: Membuat huruf pertama kapital

---

## 6. Middleware

### Tujuan
Memastikan hanya admin yang bisa mengakses fitur ini.

### File: `app/Http/Middleware/Isadmin.php`

```php
public function handle(Request $request, Closure $next)
{
    if (auth()->check() && auth()->user()->role === 'admin') {
        return $next($request);
    }
    
    abort(403, 'Unauthorized');
}
```

### Registrasi di `app/Http/Kernel.php`:

```php
protected $middlewareAliases = [
    // ... middleware lain
    'isAdmin' => \App\Http\Middleware\Isadmin::class,
];
```

**Penjelasan:**
- Mengecek apakah user sudah login dan memiliki role 'admin'
- Jika bukan admin, tampilkan error 403 (Forbidden)

---

## 7. Testing dan Seeder (Opsional)

### Membuat Data Dummy

#### User Seeder:
```php
User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => Hash::make('password'),
    'role' => 'admin',
]);
```

#### Application Seeder:
```php
Application::create([
    'user_id' => 2,
    'job_id' => 1,
    'cv' => 'cvs/dummy_cv.pdf',
    'status' => 'pending',
]);
```

### Perintah:
```bash
php artisan db:seed
```

---

## Alur Kerja Sistem

### Flow Menampilkan Daftar Pelamar:
1. Admin akses URL `/jobs/1/applicants`
2. Middleware `isAdmin` mengecek apakah user adalah admin
3. Route mengarahkan ke `ApplicationController@index`
4. Controller mengambil data dari database dengan relasi
5. Data dikirim ke view `applications.index`
6. View menampilkan tabel dengan data pelamar

### Flow Mengubah Status:
1. Admin mengubah dropdown status di halaman
2. Form auto-submit ke endpoint PATCH `/applications/{id}/status`
3. Middleware `isAdmin` mengecek autorisasi
4. Route mengarahkan ke `ApplicationController@updateStatus`
5. Controller memvalidasi input
6. Data status diupdate di database
7. Redirect kembali dengan pesan sukses
8. Halaman refresh dan menampilkan status terbaru

---

## Ringkasan Teknologi yang Digunakan

1. **Laravel Migration**: Untuk struktur database
2. **Eloquent ORM**: Untuk query dan relasi database
3. **Blade Template**: Untuk tampilan HTML
4. **Laravel Validation**: Untuk validasi input
5. **Middleware**: Untuk autorisasi
6. **Route Model Binding**: Untuk parameter URL
7. **Tailwind CSS**: Untuk styling (opsional)

---

## Kesimpulan

Fitur status lamaran ini mengimplementasikan CRUD operation (khususnya Read dan Update) dengan mengikuti arsitektur MVC Laravel. Semua layer bekerja sama:

- **Model**: Mengatur data dan relasi
- **View**: Menampilkan antarmuka
- **Controller**: Menghubungkan Model dan View
- **Middleware**: Mengamankan akses
- **Routes**: Menghubungkan URL dengan Controller

Dengan struktur ini, kode menjadi terorganisir, mudah dimaintain, dan mengikuti best practice Laravel.
