<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class UserController extends Controller
{
    public function index()
    {
        return view('backend.users.index');
    }


    public function user_list()
    {
        $users = User::orderBy('created_at', 'DESC')
        ->where('id', '!=', Auth::user()->id)
        ->paginate(12);
        return response()->json(['users' => $users], 200);
    }

    public function rank_update(Request $request, User $user)
    {
        if (!empty($request->select_rank)) {
            $rank = $request->select_rank;
        } else {
            $rank = 0;
        }

        $user->update(['rank' => $rank]);
        return response()->json(['success' => Lang::get('translate.duzelish_edildi')]);
    }

    public function profile(User $user)
    {
        return view('backend.users.profile');
    }

    public function profile_data(User $user)
    {
        return response()->json(['user' => $user], 200);
    }

    public function profile_update(UserRequest $request, User $user)
    {
        if ($request->hasFile('photo')) {
            $photoName = Str::slug($user->name).time().'.'.$request->photo->extension();
            $path = 'users/photos';
            $request->photo->move(public_path($path), $photoName);
        } else {
            $photoName = $user->photo;
        }

        $user->update([
         'email' => $request->email,
         'name' => $request->name,
         'photo' => $photoName
        ]);


        return response()->json(['success' => Lang::get('translate.duzelish_edildi')], 200);
    }

    public function user_delete(User $user)
    {
        $user->delete();
        return response()->json(['success', Lang::get('translate.istifadechi_silindi')], 200);
    }

    public function photo_delete(User $user)
    {
        $user->update([
         'photo' => null
        ]);

        return response()->json(['success' => Lang::get('translate.profil_shekili_silindi')], 200);
    }
}
