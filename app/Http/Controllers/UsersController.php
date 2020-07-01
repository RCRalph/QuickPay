<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use App\User;

class UsersController extends Controller
{
    protected $guarded = [];

    public function __construct()
    {
        $this->middleware("auth");
    }

    public function show(User $user)
    {
        if ($user->picture == null) {
            $user->picture = "default-profile-picture.png";
        }

        $transactionCount = $user->transactionsRecipient->count() + $user->transactionsSender->count();

        return view("users.show", compact("user", "transactionCount"));
    }

    public function edit(User $user)
    {
        $this->authorize("update", $user);
        return view("users.edit", compact("user"));
    }

    public function update(\Illuminate\Http\Request $request)
    {
        $this->authorize("update", auth()->user());

        if (request()->has("dataUpdate")) {
            $data = request()->validate([
                "email" => ["required", "string", "email", "max:255", "unique:users,email," . auth()->user()->id],
                "picture" => ["image"]
            ]);

            if (request()->has("picture")) {
                $picturePath = request("picture")->store("users", "public");
                $picture = Image::make("storage/" . $picturePath)->fit(400, 400)->save();
                $data = array_merge($data, ["picture" => $picturePath]);
            }

            auth()->user()->update($data);
        }
        else if (request()->has("passwordUpdate")) {
            $data = request()->validate([
                "password" => ["required", "string", "min:8", "confirmed"]
            ]);

            auth()->user()->update([
                "password" => Hash::make($data["password"])
            ]);
        }

        return redirect("/users/" . auth()->user()->id);
    }
}
