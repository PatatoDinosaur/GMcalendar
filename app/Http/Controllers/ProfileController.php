<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Schedule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $schedule = $user->schedule;
        return view('profile.edit', [
            'user' => $user,
            'schedule' => $schedule,
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
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    
    
    /**
     * Update the user's ordinary schedules.
     */
    public function schedule(Request $request, Schedule $schedule): RedirectResponse
    {
        $user = $request->user();
        $input = $request->input('schedule',[
            'sunday' => false,
            'monday' => false,
            'tuesday'=> false,
            'wednesday' => false,
            'thursday' => false,
            'friday' => false,
            'saturday' => false,
            ]);
        
        $input['sunday'] = isset($input['sunday']) ? filter_var($input['sunday'], FILTER_VALIDATE_BOOLEAN) : false;
        $input['monday'] = isset($input['monday']) ? filter_var($input['monday'], FILTER_VALIDATE_BOOLEAN) : false;
        $input['tuesday'] = isset($input['tuesday']) ? filter_var($input['tuesday'], FILTER_VALIDATE_BOOLEAN) : false;
        $input['wednesday'] = isset($input['wednesday']) ? filter_var($input['wednesday'], FILTER_VALIDATE_BOOLEAN) : false;
        $input['thursday'] = isset($input['thursday']) ? filter_var($input['thursday'], FILTER_VALIDATE_BOOLEAN) : false;
        $input['friday'] = isset($input['friday']) ? filter_var($input['friday'], FILTER_VALIDATE_BOOLEAN) : false;
        $input['saturday'] = isset($input['saturday']) ? filter_var($input['saturday'], FILTER_VALIDATE_BOOLEAN) : false;
        $user->schedule()->update($input);
        
        return Redirect::route('profile.edit')->with('status', 'schedule-updated');
    }
    


}
