<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class ProfessorController extends Controller
{
    //
    public function index() {
        // $users = User::orderBy('id')->paginate(5);
        $users = User::select('id','email','name','class','sid','current_team_id')
        ->orderBy('current_team_id','asc')
        ->orderBy('sid','asc')
        ->orderBy('id','asc')
        // ->paginate(5);
        ->get();
        // dd($users);
        return Inertia::render('DashboardProfessor',['users'=>$users]);
        // return Inertia::render('Dashboard');
    }
}
