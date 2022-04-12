<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\SendPushNotification;
use Illuminate\Http\Request;

use Kutia\Larafirebase\Facades\Larafirebase;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        // $fcmTokens = User::whereNotNull('fcm_token')->pluck('fcm_token')->toArray();

        $fcmTokens = array();

        // auth()->user()->update(['fcm_token' => null]);

        // array_push($fcmTokens, auth()->user()->fcm_token);
        // $user =    User::where('email', 'aniltest60@gmail.com')->first();
        // array_push($fcmTokens, $user->fcm_token);

        // dd($fcmTokens);

        Larafirebase::withTitle('hello title')
            ->withBody('hello body')
            ->sendMessage($fcmTokens);
        return view('home');
    }
    public function updateToken(Request $request)
    {
        try {
            $request->user()->update(['fcm_token' => $request->token]);
            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            report($e);
            return response()->json([
                'success' => false
            ], 500);
        }
    }

    public function notification(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'message' => 'required'
        ]);

        try {
            $fcmTokens = User::whereNotNull('fcm_token')->pluck('fcm_token')->toArray();

            // dd($fcmTokens);

            //Notification::send(null,new SendPushNotification($request->title,$request->message,$fcmTokens));

            /* or */

            $title = $request->title;
            $message = $request->message;

            // auth()->user()->notify(new SendPushNotification($title, $message, $fcmTokens));

            /* or */

            Larafirebase::withTitle($request->title)
                ->withBody($request->message)
                ->sendMessage($fcmTokens);

            return redirect()->back()->with('success', 'Notification Sent Successfully!!');
        } catch (\Exception $e) {
            report($e);
            return redirect()->back()->with('error', 'Something goes wrong while sending notification.');
        }
    }
}
