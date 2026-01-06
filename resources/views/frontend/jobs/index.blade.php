{{--
@extends('frontend.Layout.master')

@section('title_front','Jobs')

@section('content')
<section class="jumbotron">
    <div class="container">
        <h1 class="h4">{{__('We found')}} {{$job_posts->count()}} {{__('active jobs')}}</h1>
    </div>
</section>
<section>
    <!-- Recent Jobs -->
    <div class="container listings-container">
        <!-- Listing -->
        <div class="row">
            <div class="col-md-9 mt-3">
                @foreach($job_posts as $job_post)
                <div class="job-listing card mb-5">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <a href="{{route('jobs.details',$job_post)}}">
                                    <h4>{{$job_post->job_title}}</h4></a>
                                <h6>{{$job_post->Company->company_name ?? ''}}</h6>
                            </div>
                            <div>
                                @if($job_post->job_type == 'full_time')
                                <span class="badge badge-primary">{{__('Full Time')}}</span>
                                @elseif($job_post->job_type == 'part_time')
                                <span class="badge badge-primary">{{__('Part Time')}}</span>
                                @elseif($job_post->job_type == 'internship')
                                <span class="badge badge-primary">{{trans('file.Internship')}}</span>
                                @elseif($job_post->job_type == 'freelance')
                                <span class="badge badge-primary">{{trans('file.Freelance')}}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <ul class="list-inline mb-0">
                            <li data-toggle="tooltip" data-placement="top" title="{{$job_post->no_of_vacancy}} {{ __('vacancy') }}"><i class="dripicons-user-group"></i> {{$job_post->no_of_vacancy}}</li>
                            <li data-toggle="tooltip" data-placement="top" title="{{$job_post->min_experience}} {{ __('of experience') }}"><i class="dripicons-calendar"></i> {{$job_post->min_experience}}</li>
                            <li data-toggle="tooltip" data-placement="top" title="{{ __('posted') }} {{$job_post->updated_at->diffForHumans()}}"><i class="dripicons-clock"></i> {{$job_post->updated_at->diffForHumans()}}</li>
                        </ul>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="col-md-3 mt-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{trans('file.Category')}}</h5>
                        @foreach($job_categories as $job_category)
                            <a href="{{route('jobs.searchByCategory',$job_category->url)}}">
                                <p class="mb-1 text-muted">{{$job_category->job_category}}</p>
                            </a>
                            <br>
                        @endforeach
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Job Type</h5>
                        @foreach($job_types as $job_type)
                        <a href="{{route('jobs.searchByJobType',$job_type->job_type)}}">
                            <p class="mb-1 text-muted">
                                @if($job_type->job_type == 'full_time')
                                    {{__('Full Time')}}
                                @elseif($job_type->job_type == 'part_time')
                                    {{__('Part Time')}}
                                @elseif($job_type->job_type == 'internship')
                                    {{trans('file.Internship')}}
                                @elseif($job_type->job_type == 'freelance')
                                    {{trans('file.Freelance')}}
                                @endif
                            </p>
                        </a>
                        <br>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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
  <title>Jobs | {{ $siteTitle }}</title>
  @if($logoPath)<link rel="icon" type="image/png" href="{{ $logoPath }}"/>@endif

  <!-- Tailwind (for vibe UI) -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Bootstrap (optional - for legacy tooltips if you still use them somewhere) -->
  <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" type="text/css">

  <!-- Font (optional) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- Dripicons (you already use it) -->
  <link rel="stylesheet" href="{{ asset('vendor/dripicons/webfont.css') }}" type="text/css">

  <style>
    html,body{font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif}
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

  <!-- Navbar (same as Home/About/Contact) -->
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

  <!-- Hero -->
  <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-12 pb-8">
    <div class="grid lg:grid-cols-2 gap-8 items-start">
      <div>
        <div class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs text-white/70">
          <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
          {{ __('We found') }} {{ $job_posts->count() }} {{ __('active jobs') }}
        </div>

        <h1 class="mt-4 text-4xl sm:text-5xl font-bold leading-tight">
          Find your next
          <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-300 to-indigo-300">opportunity</span>
        </h1>

        <p class="mt-3 text-white/70 max-w-xl">
          Browse open roles by category and job type. Click any job to view details and apply.
        </p>

        <div class="mt-6 flex flex-wrap gap-2">
          <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs text-white/70">Full time</span>
          <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs text-white/70">Part time</span>
          <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs text-white/70">Internship</span>
          <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs text-white/70">Freelance</span>
        </div>
      </div>

      <!-- Side stats card -->
      <div class="rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur shadow-2xl">
        <div class="flex items-start justify-between">
          <div>
            <div class="text-lg font-bold">Quick overview</div>
            <div class="text-sm text-white/60">Jobs at a glance</div>
          </div>
          <div class="h-10 w-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center">
            💼
          </div>
        </div>

        <div class="mt-5 grid grid-cols-2 gap-3 text-sm">
          <div class="rounded-2xl border border-white/10 bg-slate-950/40 p-4">
            <div class="text-white/60 text-xs">Active jobs</div>
            <div class="text-xl font-bold mt-1">{{ $job_posts->count() }}</div>
          </div>
          <div class="rounded-2xl border border-white/10 bg-slate-950/40 p-4">
            <div class="text-white/60 text-xs">Categories</div>
            <div class="text-xl font-bold mt-1">{{ $job_categories->count() }}</div>
          </div>
          <div class="rounded-2xl border border-white/10 bg-slate-950/40 p-4">
            <div class="text-white/60 text-xs">Job types</div>
            <div class="text-xl font-bold mt-1">{{ $job_types->count() }}</div>
          </div>
          <div class="rounded-2xl border border-white/10 bg-slate-950/40 p-4">
            <div class="text-white/60 text-xs">Updated</div>
            <div class="text-xl font-bold mt-1">Live</div>
          </div>
        </div>

        <a href="#job-list"
           class="mt-5 inline-flex w-full justify-center rounded-2xl bg-gradient-to-r from-cyan-300 to-indigo-300 px-6 py-3 text-sm font-semibold text-slate-950 hover:opacity-95 transition">
          View jobs
        </a>
      </div>
    </div>
  </section>

  <!-- Main layout -->
  <section id="job-list" class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pb-16">
    <div class="grid lg:grid-cols-12 gap-6">

      <!-- Jobs list -->
      <div class="lg:col-span-8 space-y-4">
        @forelse($job_posts as $job_post)
          <div class="rounded-3xl border border-white/10 bg-white/5 backdrop-blur p-5 hover:bg-white/10 transition">
            <div class="flex items-start justify-between gap-4">
              <div class="min-w-0">
                <a href="{{ route('jobs.details', $job_post) }}" class="block">
                  <h3 class="text-lg sm:text-xl font-bold text-white hover:text-cyan-200 transition truncate">
                    {{ $job_post->job_title }}
                  </h3>
                </a>
                <p class="mt-1 text-sm text-white/60">
                  {{ $job_post->Company->company_name ?? '' }}
                </p>
              </div>

              <div class="shrink-0">
                @if($job_post->job_type == 'full_time')
                  <span class="rounded-full border border-cyan-300/30 bg-cyan-300/10 px-3 py-1 text-xs font-semibold text-cyan-200">{{ __('Full Time') }}</span>
                @elseif($job_post->job_type == 'part_time')
                  <span class="rounded-full border border-indigo-300/30 bg-indigo-300/10 px-3 py-1 text-xs font-semibold text-indigo-200">{{ __('Part Time') }}</span>
                @elseif($job_post->job_type == 'internship')
                  <span class="rounded-full border border-emerald-300/30 bg-emerald-300/10 px-3 py-1 text-xs font-semibold text-emerald-200">{{ trans('file.Internship') }}</span>
                @elseif($job_post->job_type == 'freelance')
                  <span class="rounded-full border border-fuchsia-300/30 bg-fuchsia-300/10 px-3 py-1 text-xs font-semibold text-fuchsia-200">{{ trans('file.Freelance') }}</span>
                @endif
              </div>
            </div>

            <div class="mt-4 grid sm:grid-cols-3 gap-3 text-sm">
              <div class="rounded-2xl border border-white/10 bg-slate-950/40 p-3 flex items-center gap-2 text-white/80">
                <i class="dripicons-user-group text-white/60"></i>
                <span class="text-white/60 text-xs">{{ __('Vacancy') }}:</span>
                <span class="font-semibold">{{ $job_post->no_of_vacancy }}</span>
              </div>

              <div class="rounded-2xl border border-white/10 bg-slate-950/40 p-3 flex items-center gap-2 text-white/80">
                <i class="dripicons-calendar text-white/60"></i>
                <span class="text-white/60 text-xs">{{ __('Experience') }}:</span>
                <span class="font-semibold">{{ $job_post->min_experience }}</span>
              </div>

              <div class="rounded-2xl border border-white/10 bg-slate-950/40 p-3 flex items-center gap-2 text-white/80">
                <i class="dripicons-clock text-white/60"></i>
                <span class="text-white/60 text-xs">{{ __('Posted') }}:</span>
                <span class="font-semibold">{{ $job_post->updated_at->diffForHumans() }}</span>
              </div>
            </div>

            <div class="mt-4 flex flex-col sm:flex-row gap-3">
              <a href="{{ route('jobs.details', $job_post) }}"
                 class="inline-flex justify-center rounded-2xl bg-white px-5 py-2.5 text-sm font-semibold text-slate-950 hover:bg-white/90 transition">
                View details
              </a>
              <a href="{{ route('jobs.details', $job_post) }}"
                 class="inline-flex justify-center rounded-2xl border border-white/15 bg-white/5 px-5 py-2.5 text-sm font-semibold text-white hover:bg-white/10 transition">
                Apply now
              </a>
            </div>
          </div>
        @empty
          <div class="rounded-3xl border border-white/10 bg-white/5 p-8 text-center text-white/70">
            No jobs found right now.
          </div>
        @endforelse
      </div>

      <!-- Filters (Right sidebar) -->
      <aside class="lg:col-span-4 space-y-4">
        <!-- Category -->
        <div class="rounded-3xl border border-white/10 bg-white/5 backdrop-blur p-5">
          <h5 class="text-base font-bold mb-3">{{ trans('file.Category') }}</h5>
          <div class="space-y-2">
            @foreach($job_categories as $job_category)
              <a href="{{ route('jobs.searchByCategory', $job_category->url) }}"
                 class="flex items-center justify-between rounded-2xl border border-white/10 bg-slate-950/40 px-4 py-3 text-sm text-white/80 hover:bg-white/10 transition">
                <span>{{ $job_category->job_category }}</span>
                <span class="text-white/40">→</span>
              </a>
            @endforeach
          </div>
        </div>

        <!-- Job Type -->
        <div class="rounded-3xl border border-white/10 bg-white/5 backdrop-blur p-5">
          <h5 class="text-base font-bold mb-3">Job type</h5>
          <div class="space-y-2">
            @foreach($job_types as $job_type)
              <a href="{{ route('jobs.searchByJobType', $job_type->job_type) }}"
                 class="flex items-center justify-between rounded-2xl border border-white/10 bg-slate-950/40 px-4 py-3 text-sm text-white/80 hover:bg-white/10 transition">
                <span>
                  @if($job_type->job_type == 'full_time')
                    {{ __('Full Time') }}
                  @elseif($job_type->job_type == 'part_time')
                    {{ __('Part Time') }}
                  @elseif($job_type->job_type == 'internship')
                    {{ trans('file.Internship') }}
                  @elseif($job_type->job_type == 'freelance')
                    {{ trans('file.Freelance') }}
                  @endif
                </span>
                <span class="text-white/40">→</span>
              </a>
            @endforeach
          </div>
        </div>

        <!-- CTA -->
        <div class="rounded-3xl border border-white/10 bg-gradient-to-b from-cyan-400/15 to-indigo-400/10 p-5">
          <div class="text-sm font-semibold text-white/90">Hiring?</div>
          <div class="mt-1 text-white/70 text-sm">Post a job and find the right candidate faster.</div>
          <a href="{{ route('contact.front') }}"
             class="mt-4 inline-flex w-full justify-center rounded-2xl bg-white px-5 py-2.5 text-sm font-semibold text-slate-950 hover:bg-white/90 transition">
            Contact us
          </a>
        </div>
      </aside>

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
