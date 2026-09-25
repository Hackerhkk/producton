<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ShortUrlController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Short URL List
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $shortUrls = ShortUrl::where(
            'user_id',
            auth()->id()
        )
        ->latest()
        ->paginate(10);

        $totalUrls = ShortUrl::where(
            'user_id',
            auth()->id()
        )->count();

        $totalClicks = ShortUrl::where(
            'user_id',
            auth()->id()
        )->sum('clicks');

        $activeUrls = ShortUrl::where(
            'user_id',
            auth()->id()
        )
        ->where('status', true)
        ->count();

        $todayClicks = ShortUrl::where(
            'user_id',
            auth()->id()
        )
        ->withCount([
            'clicks as today_clicks' => function ($query) {

                $query->whereDate(
                    'clicked_at',
                    Carbon::today()
                );

            }
        ])
        ->get()
        ->sum('today_clicks');

        return view(
            'short-url.index',
            compact(
                'shortUrls',
                'totalUrls',
                'totalClicks',
                'activeUrls',
                'todayClicks'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Create Short URL
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([

            'original_url' => [
                'required',
                'url',
                'max:2000',
            ],

            'custom_url' => [
                'nullable',
                'string',
                'min:3',
                'max:50',
                'regex:/^[A-Za-z0-9_-]+$/',
                'unique:short_urls,short_code',
            ],

            'starts_at' => [
                'nullable',
                'date',
            ],

            'expires_at' => [
                'nullable',
                'date',
                'after:starts_at',
            ],

            'click_limit' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'password' => [
                'nullable',
                'string',
                'min:4',
                'max:255',
            ],

            'qr_enabled' => [
                'nullable',
                'boolean',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Generate Short Code
        |--------------------------------------------------------------------------
        */

        if ($request->filled('custom_url')) {

            $shortCode = $request->custom_url;

        } else {

            do {

                $shortCode = Str::random(7);

            } while (
                ShortUrl::where(
                    'short_code',
                    $shortCode
                )->exists()
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Password Hash
        |--------------------------------------------------------------------------
        */

        $hashedPassword = null;

        if ($request->filled('password')) {

            $hashedPassword = Hash::make(
                $request->password
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Create Short URL
        |--------------------------------------------------------------------------
        */

        ShortUrl::create([

            'user_id' => auth()->id(),

            'original_url' =>
                $request->original_url,

            'short_code' =>
                $shortCode,

            'clicks' => 0,

            'status' => true,

            'starts_at' =>
                $request->filled('starts_at')
                    ? Carbon::parse(
                        $request->starts_at
                    )
                    : null,

            'expires_at' =>
                $request->filled('expires_at')
                    ? Carbon::parse(
                        $request->expires_at
                    )
                    : null,

            'click_limit' =>
                $request->filled('click_limit')
                    ? (int) $request->click_limit
                    : null,

            'password' =>
                $hashedPassword,

            'qr_enabled' =>
                $request->boolean('qr_enabled'),

        ]);


        return back()->with(
            'success',
            'Short URL created successfully.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Redirect Short URL
    |--------------------------------------------------------------------------
    */

    public function redirect(
        Request $request,
        string $shortCode
    ) {

        $shortUrl = ShortUrl::where(
            'short_code',
            $shortCode
        )->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Disabled URL
        |--------------------------------------------------------------------------
        */

        if (!$shortUrl->status) {

            abort(
                410,
                'This short URL has been disabled.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Start Date Check
        |--------------------------------------------------------------------------
        */

        if (
            $shortUrl->starts_at &&
            now()->lt(
                $shortUrl->starts_at
            )
        ) {

            abort(
                403,
                'This short URL is not active yet.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Expiry Check
        |--------------------------------------------------------------------------
        */

        if (
            $shortUrl->expires_at &&
            now()->gte(
                $shortUrl->expires_at
            )
        ) {

            $shortUrl->update([
                'status' => false,
            ]);

            abort(
                410,
                'This short URL has expired.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Click Limit Check
        |--------------------------------------------------------------------------
        */

        if (
            $shortUrl->click_limit !== null &&
            $shortUrl->clicks >=
                $shortUrl->click_limit
        ) {

            abort(
                410,
                'This short URL has reached its click limit.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Password Protection
        |--------------------------------------------------------------------------
        */

        if ($shortUrl->password) {

            $verified = session(
                'short_url_verified_' .
                $shortUrl->id,
                false
            );

            if (!$verified) {

                return redirect()->route(
                    'short-url.password',
                    $shortUrl->short_code
                );

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Detect Device / Browser / OS
        |--------------------------------------------------------------------------
        */

        $agent = new Agent();


        if ($agent->isTablet()) {

            $device = 'Tablet';

        } elseif ($agent->isMobile()) {

            $device = 'Mobile';

        } elseif ($agent->isDesktop()) {

            $device = 'Desktop';

        } else {

            $device = 'Other';

        }


        $browser = $agent->browser();

        if (!$browser) {

            $browser = 'Unknown';

        }


        $os = $agent->platform();

        if (!$os) {

            $os = 'Unknown';

        }


        /*
        |--------------------------------------------------------------------------
        | Save Click
        |--------------------------------------------------------------------------
        */

        DB::transaction(
            function () use (
                $request,
                $shortUrl,
                $device,
                $browser,
                $os
            ) {

                $shortUrl->increment(
                    'clicks'
                );


                $shortUrl->clicks()->create([

                    'ip_address' =>
                        $request->ip(),

                    'user_agent' =>
                        $request->userAgent(),

                    'device' =>
                        $device,

                    'browser' =>
                        $browser,

                    'os' =>
                        $os,

                    'referer' =>
                        $request
                            ->headers
                            ->get('referer'),

                    'clicked_at' =>
                        now(),

                ]);

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()->away(
            $shortUrl->original_url
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Password Page
    |--------------------------------------------------------------------------
    */

    public function passwordPage(
        string $shortCode
    ) {

        $shortUrl = ShortUrl::where(
            'short_code',
            $shortCode
        )->firstOrFail();


        if (!$shortUrl->password) {

            return redirect()->route(
                'short-url.redirect',
                $shortCode
            );

        }


        return view(
            'short-url.password',
            compact('shortUrl')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Verify Password
    |--------------------------------------------------------------------------
    */

    public function verifyPassword(
        Request $request,
        string $shortCode
    ) {

        $request->validate([

            'password' => [
                'required',
                'string',
            ],

        ]);


        $shortUrl = ShortUrl::where(
            'short_code',
            $shortCode
        )->firstOrFail();


        if (!$shortUrl->password) {

            return redirect()->route(
                'short-url.redirect',
                $shortCode
            );

        }


        if (
            !Hash::check(
                $request->password,
                $shortUrl->password
            )
        ) {

            return back()->withErrors([

                'password' =>
                    'Incorrect password.',

            ]);

        }


        session()->put(

            'short_url_verified_' .
            $shortUrl->id,

            true

        );


        return redirect()->route(
            'short-url.redirect',
            $shortCode
        );
    }


    /*
    |--------------------------------------------------------------------------
    | QR Code Page
    |--------------------------------------------------------------------------
    */

    public function qrCode(
        ShortUrl $shortUrl
    ) {

        /*
        | Make sure URL belongs to logged-in user
        */

        abort_unless(
            $shortUrl->user_id === auth()->id(),
            403
        );


        /*
        | QR must be enabled
        */

        abort_unless(
            $shortUrl->qr_enabled,
            404
        );


        $shortUrlLink = url(
            '/s/' . $shortUrl->short_code
        );


        return view(
            'short-url.qr',
            compact(
                'shortUrl',
                'shortUrlLink'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Download QR Code
    |--------------------------------------------------------------------------
    */

public function downloadQr(
    ShortUrl $shortUrl
) {
    abort_unless(
        $shortUrl->user_id === auth()->id(),
        403
    );

    abort_unless(
        $shortUrl->qr_enabled,
        404
    );

    $shortUrlLink = url(
        '/s/' . $shortUrl->short_code
    );

    $qrCode = QrCode::format('svg')
        ->size(220)
        ->margin(1)
        ->errorCorrection('H')
        ->generate(
            $shortUrlLink
        );

    return response(
        $qrCode,
        200,
        [
            'Content-Type' =>
                'image/svg+xml',

            'Content-Disposition' =>
                'attachment; filename="qr-' .
                $shortUrl->short_code .
                '.svg"',
        ]
    );
}



    /*
    |--------------------------------------------------------------------------
    | Analytics
    |--------------------------------------------------------------------------
    */

    public function analytics(
        ShortUrl $shortUrl
    ) {

        abort_unless(
            $shortUrl->user_id === auth()->id(),
            403
        );


        $totalClicks =
            $shortUrl
                ->clicks()
                ->count();


        $mobileClicks =
            $shortUrl
                ->clicks()
                ->where(
                    'device',
                    'Mobile'
                )
                ->count();


        $desktopClicks =
            $shortUrl
                ->clicks()
                ->where(
                    'device',
                    'Desktop'
                )
                ->count();


        $tabletClicks =
            $shortUrl
                ->clicks()
                ->where(
                    'device',
                    'Tablet'
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | Browser Stats
        |--------------------------------------------------------------------------
        */

        $browserStats =
            $shortUrl
                ->clicks()
                ->select(
                    'browser',
                    DB::raw(
                        'COUNT(*) as total'
                    )
                )
                ->groupBy('browser')
                ->orderByDesc('total')
                ->get();


        /*
        |--------------------------------------------------------------------------
        | OS Stats
        |--------------------------------------------------------------------------
        */

        $osStats =
            $shortUrl
                ->clicks()
                ->select(
                    'os',
                    DB::raw(
                        'COUNT(*) as total'
                    )
                )
                ->groupBy('os')
                ->orderByDesc('total')
                ->get();


        /*
        |--------------------------------------------------------------------------
        | Device Stats
        |--------------------------------------------------------------------------
        */

        $deviceStats =
            $shortUrl
                ->clicks()
                ->select(
                    'device',
                    DB::raw(
                        'COUNT(*) as total'
                    )
                )
                ->groupBy('device')
                ->orderByDesc('total')
                ->get();


        /*
        |--------------------------------------------------------------------------
        | Last 30 Days
        |--------------------------------------------------------------------------
        */

        $dailyClicks =
            $shortUrl
                ->clicks()
                ->select(

                    DB::raw(
                        'DATE(clicked_at) as date'
                    ),

                    DB::raw(
                        'COUNT(*) as total'
                    )

                )
                ->where(
                    'clicked_at',
                    '>=',
                    now()
                        ->subDays(29)
                        ->startOfDay()
                )
                ->groupBy(
                    DB::raw(
                        'DATE(clicked_at)'
                    )
                )
                ->orderBy('date')
                ->get();


        /*
        |--------------------------------------------------------------------------
        | Recent Clicks
        |--------------------------------------------------------------------------
        */

        $recentClicks =
            $shortUrl
                ->clicks()
                ->latest('clicked_at')
                ->paginate(20);


        return view(

            'short-url.analytics',

            compact(

                'shortUrl',

                'totalClicks',

                'mobileClicks',

                'desktopClicks',

                'tabletClicks',

                'browserStats',

                'osStats',

                'deviceStats',

                'dailyClicks',

                'recentClicks'

            )

        );
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Short URL
    |--------------------------------------------------------------------------
    */

    public function destroy(
        ShortUrl $shortUrl
    ) {

        abort_unless(
            $shortUrl->user_id === auth()->id(),
            403
        );


        $shortUrl->delete();


        return back()->with(
            'success',
            'Short URL deleted successfully.'
        );
    }
}
