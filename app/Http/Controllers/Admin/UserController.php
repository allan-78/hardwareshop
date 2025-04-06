<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends AdminController
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::query();
            
            return DataTables::of($users)
                ->addColumn('action', function ($user) {
                    return view('admin.users.actions', compact('user'));
                })
                ->editColumn('status', function ($user) {
                    return view('admin.users.status', compact('user'));
                })
                ->editColumn('created_at', function ($user) {
                    return $user->created_at->format('M d, Y');
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        // Add this line to fetch users for non-AJAX requests
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function updateStatus(Request $request, User $user)
    {
        $request->validate(['status' => 'required|boolean']);
        $user->update(['status' => $request->status]);
        return response()->json(['success' => true]);
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate(['role' => 'required|in:user,admin']);
        $user->update(['role' => $request->role]);
        return response()->json(['success' => true]);
    }
}