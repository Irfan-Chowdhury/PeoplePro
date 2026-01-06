{{-- @php
    $general_settings = \App\Models\GeneralSetting::latest()->first();
@endphp

<html lang="en">
<head>
    @include('frontend.Layout.header')
</head>
<body class="d-flex flex-column h-100">
	@include('frontend.Layout.navigation')

	<div class="frontend">
	    @yield('content')
	</div>
	<footer class="footer mt-auto py-3 bg-dark text-center">
		<div class="container">
			<p class="mb-0 text-light">&copy; {{$general_settings->footer}} {{ date('Y')}}</p>
		</div>
	</footer>
</body>
</html> --}}





@php
    $general_settings = \App\Models\GeneralSetting::latest()->first();
    $siteTitle = $general_settings->site_title ?? "PeoplePro";
    $logoPath  = ($general_settings->site_logo ?? null) ? asset('/images/logo/'.$general_settings->site_logo) : null;
@endphp

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $siteTitle }} | Home</title>
  @if($logoPath)<link rel="icon" type="image/png" href="{{ $logoPath }}"/>@endif

  <!-- Tailwind CDN (no install needed) -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Optional: nicer font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    html,body{font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif}
    /* tiny glow + smooth */
    .glass{backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);}
  </style>
</head>

<body class="min-h-screen bg-slate-950 text-white">

  <!-- Background vibe -->
  <div class="fixed inset-0 -z-10">
    <div class="absolute inset-0 bg-gradient-to-b from-slate-950 via-slate-950 to-slate-900"></div>
    <div class="absolute -top-40 left-1/2 h-[480px] w-[480px] -translate-x-1/2 rounded-full bg-indigo-500/20 blur-[120px]"></div>
    <div class="absolute top-52 -left-40 h-[420px] w-[420px] rounded-full bg-cyan-500/15 blur-[120px]"></div>
    <div class="absolute bottom-0 right-0 h-[520px] w-[520px] rounded-full bg-fuchsia-500/10 blur-[140px]"></div>
  </div>

  <!-- Top bar -->
  <header class="sticky top-0 z-50 border-b border-white/10 bg-slate-950/70 glass">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between py-3">
        <a href="{{ route('home.front') }}" class="flex items-center gap-3">
          @if($logoPath)
            <img src="{{ $logoPath }}" alt="{{ $siteTitle }}" class="h-10 w-10 rounded-lg bg-white/5 p-1">
          @endif
          <div class="leading-tight">
            <div class="text-base font-semibold">{{ $siteTitle }}</div>
            <div class="text-xs text-white/60">HRM • Payroll • Projects</div>
          </div>
        </a>

        <nav class="hidden md:flex items-center gap-6 text-sm text-white/70">
          <a class="hover:text-white transition" href="{{ route('home.front') }}">{{ trans('file.Home') }}</a>
          <a class="hover:text-white transition" href="{{ route('jobs') }}">{{ trans('file.Jobs') }}</a>
          <a class="hover:text-white transition" href="{{ route('about.front') }}">{{ trans('file.About') }}</a>
          <a class="hover:text-white transition" href="{{ route('contact.front') }}">{{ trans('file.Contact') }}</a>
        </nav>

        <div class="flex items-center gap-2">
          <a href="https://codecanyon.net/item/peoplepro-hrm-payroll-project-management/29169229?s_rank=7"
             class="hidden sm:inline-flex items-center justify-center rounded-xl border border-white/15 bg-white/5 px-4 py-2 text-sm font-medium text-white hover:bg-white/10 transition">
            See Codecanyon
          </a>
          <a href="{{ route('login') ?? '#' }}"
             class="inline-flex items-center justify-center rounded-xl bg-white px-4 py-2 text-sm font-semibold text-slate-950 hover:bg-white/90 transition">
            Login
          </a>
        </div>
      </div>
    </div>
  </header>

  @yield('content')

  <!-- Footer -->
  <footer class="border-t border-white/10 bg-slate-950/60 glass">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
      <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="text-sm text-white/70">
          © {{ $general_settings->footer ?? $siteTitle }} {{ date('Y') }}
        </div>
        <div class="flex gap-5 text-sm text-white/60">
          <a class="hover:text-white transition" href="{{ route('about.front') }}">About</a>
          <a class="hover:text-white transition" href="{{ route('contact.front') }}">Contact</a>
          <a class="hover:text-white transition" href="{{ route('jobs') }}">Jobs</a>
        </div>
      </div>
    </div>
  </footer>

</body>
</html>

