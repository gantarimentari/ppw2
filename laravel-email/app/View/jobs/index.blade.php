<form action ="{{ route('applications.store', $job->id) }}"
 method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="cv" required>
    <button type="submit" class="btn btn-primary">Lamar</button>
 </form>