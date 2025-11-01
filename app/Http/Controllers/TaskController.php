<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // <-- Pastikan 'use' ini ada
use App\Models\Task; // <-- Nanti ini akan dipakai untuk ambil data

// 1. Pastikan 'class TaskController extends Controller' ada
class TaskController extends Controller
{ 
    // 2. Pastikan kode 'public function' ada DI DALAM kurung kurawal '{ ... }' ini

    public function index()
    {
        // (Contoh ambil data)
        // $tasks = Task::all(); 
        
        // (Contoh kirim data ke view)
        // return view('tasks.index', ['tasks' => $tasks]);

        // Versi sederhananya (yang tadi kita bahas):
        return view('tasks.index');
    }

    // Nanti fungsi-fungsi lain (create, store, edit, update, destroy)
    // juga akan diletakkan di dalam sini...

} // 3. Pastikan ada kurung kurawal penutup untuk class