@php
    $general_settings = \App\Models\GeneralSetting::latest()->first();
    $siteTitle = $general_settings->site_title ?? "PeoplePro";
  $logoPath  = ($general_settings->site_logo ?? null) ? asset('/images/logo/'.$general_settings->site_logo) : null;
@endphp

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>About | {{$general_settings->site_title ?? "PeoplePro"}}</title>
    <link rel="icon" type="image/png" href="{{asset('/images/logo/'.$general_settings->site_logo)}}"/>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap-datepicker.min.css') }}" type="text/css">

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('vendor/dripicons/webfont.css') }}" type="text/css">

    <!-- Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">

    <!-- Other CSS -->
    <link rel="stylesheet" href="{{ asset('css/grasp_mobile_progress_circle-1.0.0.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('vendor/keyboard/css/keyboard.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('vendor/daterange/css/daterangepicker.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/style.default.css') }}" id="theme-stylesheet" type="text/css">

    <!-- JS -->
    <script type="text/javascript" src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/jquery/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/jquery/bootstrap-datepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/popper.js/umd/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/jquery.cookie/jquery.cookie.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/jquery-validation/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/front.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/daterange/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Vibe styling without breaking Bootstrap */
        body{background:#0b1220;}
        .pp-hero{
            background: radial-gradient(900px 400px at 20% 20%, rgba(70,160,255,.22), transparent 55%),
                        radial-gradient(700px 420px at 90% 10%, rgba(155,81,224,.18), transparent 55%),
                        linear-gradient(180deg, #0b1220 0%, #0b1220 50%, #0d172a 100%);
            color:#fff;
            border-bottom:1px solid rgba(255,255,255,.08);
        }
        .pp-card{
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.10);
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,.35);
        }
        .pp-muted{color:rgba(255,255,255,.75);}
        .pp-pill{
            display:inline-flex; align-items:center; gap:8px;
            padding:6px 12px;
            border-radius:999px;
            background: rgba(255,255,255,.08);
            border:1px solid rgba(255,255,255,.12);
            font-size:12px;
        }
        .pp-icon{
            width:42px;height:42px;border-radius:12px;
            display:flex;align-items:center;justify-content:center;
            background: rgba(255,255,255,.08);
            border:1px solid rgba(255,255,255,.12);
        }
        .pp-content{
            color: rgba(255,255,255,.85);
        }
        .pp-content h1,.pp-content h2,.pp-content h3,.pp-content h4,.pp-content h5{
            color:#fff;
        }
        .pp-content a{color:#8fd3ff;}
        .pp-content img{max-width:100%; border-radius:12px;}
        .pp-divider{
            height:1px;
            background: rgba(255,255,255,.10);
            margin: 18px 0;
        }
    </style>
</head>

<body class="d-flex flex-column h-100">

<!-- Navbar (keep same structure) -->
<!-- Background vibe (optional, but makes it match perfectly) -->
<div class="fixed inset-0 -z-10">
  <div class="absolute inset-0 bg-gradient-to-b from-slate-950 via-slate-950 to-slate-900"></div>
  <div class="absolute -top-40 left-1/2 h-[480px] w-[480px] -translate-x-1/2 rounded-full bg-indigo-500/20 blur-[120px]"></div>
  <div class="absolute top-52 -left-40 h-[420px] w-[420px] rounded-full bg-cyan-500/15 blur-[120px]"></div>
  <div class="absolute bottom-0 right-0 h-[520px] w-[520px] rounded-full bg-fuchsia-500/10 blur-[140px]"></div>
</div>

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
<section class="pp-hero py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="pp-pill mb-3">
                    <span class="fa fa-star text-warning"></span>
                    Built for modern HR teams
                </div>

                <h1 class="display-4 mb-2" style="font-weight:700; letter-spacing:-.5px;">
                    About {{$general_settings->site_title ?? "PeoplePro"}}
                </h1>

                <p class="lead pp-muted mb-4">
                    We help organizations manage people, payroll, and projects in one clean system —
                    so teams can work faster, with fewer mistakes, and better visibility.
                </p>

                <div class="d-flex flex-wrap" style="gap:10px;">
                    <div class="pp-pill"><span class="fa fa-users"></span> Employee management</div>
                    <div class="pp-pill"><span class="fa fa-money"></span> Payroll automation</div>
                    <div class="pp-pill"><span class="fa fa-tasks"></span> Project tracking</div>
                    <div class="pp-pill"><span class="fa fa-bar-chart"></span> Reports & insights</div>
                </div>
            </div>

            <div class="col-lg-5 mt-4 mt-lg-0">
                <div class="pp-card p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-white" style="font-weight:700;">Our promise</div>
                            <div class="pp-muted" style="font-size:13px;">Simple, secure, scalable</div>
                        </div>
                        <div class="pp-icon">
                            <span class="fa fa-shield text-info"></span>
                        </div>
                    </div>

                    <div class="pp-divider"></div>

                    <div class="row">
                        <div class="col-6 mb-3">
                            <div class="pp-muted" style="font-size:12px;">Accuracy</div>
                            <div class="text-white" style="font-weight:700;">Payroll-ready</div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="pp-muted" style="font-size:12px;">Speed</div>
                            <div class="text-white" style="font-weight:700;">Less manual work</div>
                        </div>
                        <div class="col-6">
                            <div class="pp-muted" style="font-size:12px;">Visibility</div>
                            <div class="text-white" style="font-weight:700;">Real reports</div>
                        </div>
                        <div class="col-6">
                            <div class="pp-muted" style="font-size:12px;">Support</div>
                            <div class="text-white" style="font-weight:700;">Team-friendly</div>
                        </div>
                    </div>

                    <div class="pp-divider"></div>

                    <a href="{{ route('contact.front') }}"
                       class="btn btn-light btn-block"
                       style="border-radius:12px; font-weight:600;">
                        Contact us
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quick highlights -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="pp-card p-4 h-100">
                    <div class="pp-icon mb-3"><span class="fa fa-users text-primary"></span></div>
                    <h5 class="text-white" style="font-weight:700;">People first</h5>
                    <p class="pp-muted mb-0">Central profiles, attendance, leave, and performance in one place.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="pp-card p-4 h-100">
                    <div class="pp-icon mb-3"><span class="fa fa-money text-success"></span></div>
                    <h5 class="text-white" style="font-weight:700;">Payroll done right</h5>
                    <p class="pp-muted mb-0">Accurate calculations, fewer errors, and clean payroll reports.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="pp-card p-4 h-100">
                    <div class="pp-icon mb-3"><span class="fa fa-tasks text-info"></span></div>
                    <h5 class="text-white" style="font-weight:700;">Projects in control</h5>
                    <p class="pp-muted mb-0">Tasks, milestones, and progress tracking that teams actually use.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="pp-card p-4 h-100">
                    <div class="pp-icon mb-3"><span class="fa fa-bar-chart text-warning"></span></div>
                    <h5 class="text-white" style="font-weight:700;">Insights</h5>
                    <p class="pp-muted mb-0">Data-driven reports to improve workforce and project decisions.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Your About content -->
<section class="pb-5">
    <div class="container">
        <div class="pp-card p-4 p-md-5">
            <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap:12px;">
                <div>
                    <h2 class="text-white mb-1" style="font-weight:800;">Who we are</h2>
                    <div class="pp-muted">This content is editable from your CMS / admin.</div>
                </div>
                <div class="pp-pill">
                    <span class="fa fa-pencil"></span> Editable section
                </div>
            </div>

            <div class="pp-divider"></div>

            <div class="pp-content">
                {!! html_entity_decode($about ?? '') !!}
            </div>
        </div>
    </div>
</section>

<footer class="footer mt-auto py-3 bg-dark text-center">
    <div class="container">
        <p class="mb-0 text-light">&copy; {{$general_settings->footer}} {{ date('Y')}}</p>
    </div>
</footer>

</body>
</html>
