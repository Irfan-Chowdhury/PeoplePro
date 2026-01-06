{{-- @extends('frontend.Layout.master')

@section('title_front','Contact')

@section('content')
<section class="jumbotron">
    <div class="container">
        <h1 class="h4">{{ __('Contact Us') }}</h1>
    </div>
</section>
<div class="container">
    {!!  html_entity_decode($contact) !!}
</div>
@endsection --}}


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
  <title>Contact | {{ $siteTitle }}</title>
  @if($logoPath)<link rel="icon" type="image/png" href="{{ $logoPath }}"/>@endif

  <!-- Tailwind (for vibe UI) -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Bootstrap (keep, because your CMS content may rely on it) -->
  <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" type="text/css">

  <!-- Optional nicer font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    html,body{font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif}
    /* Make CMS text readable on dark background (safe defaults) */
    .cms-content { color: rgba(255,255,255,.85); }
    .cms-content h1,.cms-content h2,.cms-content h3,.cms-content h4,.cms-content h5{ color:#fff; }
    .cms-content a{ color:#7dd3fc; }
    .cms-content img{ max-width:100%; border-radius:12px; }
    .cms-content table{ width:100%; }
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

  <!-- Navbar (same as Home) -->
  <header class="sticky top-0 z-50 border-b border-white/10 bg-slate-950/70 backdrop-blur">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between py-3">
        <a href="{{ route('home.front') }}" class="flex items-center gap-3">
          @if($logoPath)
            <img src="{{ $logoPath }}" alt="{{ $siteTitle }}" class="h-10 w-10 rounded-lg bg-white/5 p-1">
          @endif
          <div class="leading-tight">
            <div class="text-base font-semibold text-white">{{ $siteTitle }}</div>
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
          <a href="#contact-form"
             class="hidden sm:inline-flex items-center justify-center rounded-xl border border-white/15 bg-white/5 px-4 py-2 text-sm font-medium text-white hover:bg-white/10 transition">
            Send message
          </a>
          <a href="{{ route('login') ?? '#' }}"
             class="inline-flex items-center justify-center rounded-xl bg-white px-4 py-2 text-sm font-semibold text-slate-950 hover:bg-white/90 transition">
            Login
          </a>
        </div>
      </div>
    </div>
  </header>

  <!-- Hero -->
  <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-12 pb-8">
    <div class="grid lg:grid-cols-2 gap-8 items-start">
      <div>
        <div class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs text-white/70">
          <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
          We reply fast (usually within 24 hours)
        </div>

        <h1 class="mt-4 text-4xl sm:text-5xl font-bold leading-tight">
          Contact <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-300 to-indigo-300">PeoplePro</span>
        </h1>

        <p class="mt-3 text-white/70 max-w-xl">
          Have a question about HRM, payroll, or project features? Send us a message and our team will reach out.
        </p>

        <!-- Quick contact cards -->
        <div class="mt-6 grid sm:grid-cols-3 gap-3">
          <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
            <div class="text-xs text-white/60">Email</div>
            <div class="mt-1 text-sm font-semibold">support@yourdomain.com</div>
          </div>
          <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
            <div class="text-xs text-white/60">Phone</div>
            <div class="mt-1 text-sm font-semibold">+880 1XXX-XXXXXX</div>
          </div>
          <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
            <div class="text-xs text-white/60">Office</div>
            <div class="mt-1 text-sm font-semibold">Dhaka, Bangladesh</div>
          </div>
        </div>

        <p class="mt-4 text-xs text-white/50">
          Replace the sample email/phone/address above with your real info (or keep them inside CMS content).
        </p>
      </div>

      <!-- Form (UI only; connect to your backend route if you want) -->
      <div id="contact-form" class="rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur shadow-2xl">
        <div class="flex items-start justify-between">
          <div>
            <div class="text-lg font-bold">Send a message</div>
            <div class="text-sm text-white/60">We’ll get back to you soon.</div>
          </div>
          <div class="h-10 w-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center">
            ✉️
          </div>
        </div>

        {{-- <form class="mt-5 space-y-3" method="POST" action="{{ route('contact.send') ?? '#' }}"> --}}
        <form class="mt-5 space-y-3" method="POST" action="">
          @csrf

          <div class="grid sm:grid-cols-2 gap-3">
            <div>
              <label class="text-xs text-white/70">Full name</label>
              <input name="name" type="text" required
                     class="mt-1 w-full rounded-xl border border-white/10 bg-slate-950/40 px-4 py-3 text-sm text-white placeholder:text-white/40 focus:outline-none focus:ring-2 focus:ring-cyan-300/40"
                     placeholder="Your name">
            </div>
            <div>
              <label class="text-xs text-white/70">Email</label>
              <input name="email" type="email" required
                     class="mt-1 w-full rounded-xl border border-white/10 bg-slate-950/40 px-4 py-3 text-sm text-white placeholder:text-white/40 focus:outline-none focus:ring-2 focus:ring-cyan-300/40"
                     placeholder="you@email.com">
            </div>
          </div>

          <div>
            <label class="text-xs text-white/70">Subject</label>
            <input name="subject" type="text"
                   class="mt-1 w-full rounded-xl border border-white/10 bg-slate-950/40 px-4 py-3 text-sm text-white placeholder:text-white/40 focus:outline-none focus:ring-2 focus:ring-cyan-300/40"
                   placeholder="How can we help?">
          </div>

          <div>
            <label class="text-xs text-white/70">Message</label>
            <textarea name="message" rows="5" required
                      class="mt-1 w-full rounded-xl border border-white/10 bg-slate-950/40 px-4 py-3 text-sm text-white placeholder:text-white/40 focus:outline-none focus:ring-2 focus:ring-cyan-300/40"
                      placeholder="Write your message..."></textarea>
          </div>

          <button type="submit"
                  class="w-full rounded-2xl bg-gradient-to-r from-cyan-300 to-indigo-300 px-6 py-3 text-sm font-semibold text-slate-950 hover:opacity-95 transition">
            Send message
          </button>

          <p class="text-xs text-white/50">
            If you don’t have a backend route yet, keep the action as <code>#</code> or create a route like <code>contact.send</code>.
          </p>
        </form>
      </div>
    </div>
  </section>

  <!-- CMS content section (your existing editor content) -->
  <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pb-14">
    <div class="rounded-3xl border border-white/10 bg-white/5 p-6 sm:p-8 backdrop-blur">
      <div class="flex items-center justify-between flex-wrap gap-3">
        <div>
          <h2 class="text-xl sm:text-2xl font-bold">Contact information</h2>
          <p class="text-white/70 text-sm mt-1">This section loads from your CMS content.</p>
        </div>
        <div class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs text-white/70">
          ✨ Editable
        </div>
      </div>

      <div class="mt-5 rounded-2xl border border-white/10 bg-slate-950/40 p-5 cms-content">
        {!! html_entity_decode($contact ?? '') !!}
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="border-t border-white/10 bg-slate-950/60 backdrop-blur">
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

  <!-- Bootstrap JS (optional) -->
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
</body>
</html>
