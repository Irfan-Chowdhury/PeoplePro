<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LocaleController extends Controller
{
	public function languageSwitch($locale)
	{
		setcookie('language', $locale, time() + (86400 * 365), "/");
		return back();
	}

    
    public function languageDelete(Request $request)
    {
		if (!env('USER_VERIFIED')) {
			return response()->json(['error' => 'This feature is disabled for demo!']);
		}

        $path = base_path('resources/lang/'.$request->langVal);
        if(File::exists($path)) {
            File::deleteDirectory($path);
            return response()->json('success');
        }
    }
}
