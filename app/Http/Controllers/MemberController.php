<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
{
    $members = User::where('role', 'mahasiswa')->get(); // Mengambil data
    return view('members.index', compact('members'));   // Mengirim $members ke view
}
}