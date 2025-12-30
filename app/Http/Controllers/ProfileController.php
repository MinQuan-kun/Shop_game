<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update the user's avatar (HÀM MỚI CẦN THÊM).
     */
    public function updateAvatar(Request $request): RedirectResponse
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        $user = $request->user();

        if ($request->hasFile('avatar')) {
            try {
                Configuration::instance(env('CLOUDINARY_URL'));

                $upload = new UploadApi();
                $result = $upload->upload($request->file('avatar')->getRealPath(), [
                    'folder' => 'Shop_Game/users',
                    'public_id' => 'user_' . $user->id,
                    'overwrite' => true,
                    'transformation' => [
                        'width' => 500,
                        'height' => 500,
                        'crop' => 'fill',
                        'gravity' => 'face'
                    ]
                ]);

                $uploadedFileUrl = $result['secure_url'];

                $user->avatar = $uploadedFileUrl;
                $user->save();

                return Redirect::route('profile.edit')->with('status', 'avatar-updated');
            } catch (\Exception $e) {
                return Redirect::route('profile.edit')->withErrors(['avatar' => 'Lỗi: ' . $e->getMessage()]);
            }
        }

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

}
