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
  <title>{{ $job_post->job_title }} | {{ $siteTitle }}</title>
  @if($logoPath)<link rel="icon" type="image/png" href="{{ $logoPath }}"/>@endif

  <!-- Tailwind (vibe UI) -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Bootstrap (needed for modal) -->
  <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" type="text/css">

  <!-- Dripicons + FontAwesome (optional) -->
  <link rel="stylesheet" href="{{ asset('vendor/dripicons/webfont.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}" type="text/css">

  <!-- jQuery + Bootstrap JS (modal) -->
  <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('vendor/popper.js/umd/popper.min.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>

  <!-- TinyMCE (you already have local) -->
  <script src="{{ asset('vendor/tinymce/js/tinymce/tinymce.min.js') }}"></script>

  <!-- Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    html,body{font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif}
    /* Make decoded HTML readable on dark background */
    .job-content { color: rgba(255,255,255,.86); }
    .job-content h1,.job-content h2,.job-content h3,.job-content h4,.job-content h5{ color:#fff; }
    .job-content a{ color:#7dd3fc; }
    .job-content img{ max-width:100%; border-radius:12px; }
    .job-content table{ width:100%; }
    /* Bootstrap modal on dark page */
    .modal-content{ border-radius:16px; border:1px solid rgba(255,255,255,.12); }
    .modal-header{ border-bottom:1px solid rgba(0,0,0,.08); }
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

  <!-- Navbar (same as previous pages) -->
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
          <button id="apply_job_top"
                  class="hidden sm:inline-flex items-center justify-center rounded-xl border border-white/15 bg-white/5 px-4 py-2 text-sm font-medium text-white hover:bg-white/10 transition">
            {{ trans('file.Apply') }}
          </button>
          <a href="{{ route('login') ?? '#' }}"
             class="inline-flex items-center justify-center rounded-xl bg-white px-4 py-2 text-sm font-semibold text-slate-950 hover:bg-white/90 transition">
            Login
          </a>
        </div>
      </div>
    </div>
  </header>

  <!-- Hero -->
  <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-10 pb-8">
    <div class="rounded-3xl border border-white/10 bg-white/5 p-6 sm:p-8 backdrop-blur shadow-2xl">
      <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
        <div class="min-w-0">
          <a href="{{ route('jobs') }}" class="text-sm text-white/60 hover:text-white transition">← Back to jobs</a>

          <h1 class="mt-2 text-3xl sm:text-4xl font-bold leading-tight">
            {{ $job_post->job_title }}
          </h1>

          <p class="mt-2 text-white/70">
            {{ $job_post->Company->company_name ?? '' }}
          </p>

          <div class="mt-4 flex flex-wrap gap-2 text-xs">
            @if($job_post->job_type == 'full_time')
              <span class="rounded-full border border-cyan-300/30 bg-cyan-300/10 px-3 py-1 font-semibold text-cyan-200">{{ __('Full Time') }}</span>
            @elseif($job_post->job_type == 'part_time')
              <span class="rounded-full border border-indigo-300/30 bg-indigo-300/10 px-3 py-1 font-semibold text-indigo-200">{{ __('Part Time') }}</span>
            @elseif($job_post->job_type == 'internship')
              <span class="rounded-full border border-emerald-300/30 bg-emerald-300/10 px-3 py-1 font-semibold text-emerald-200">{{ trans('file.Internship') }}</span>
            @elseif($job_post->job_type == 'freelance')
              <span class="rounded-full border border-fuchsia-300/30 bg-fuchsia-300/10 px-3 py-1 font-semibold text-fuchsia-200">{{ trans('file.Freelance') }}</span>
            @endif

            <span class="rounded-full border border-white/10 bg-slate-950/40 px-3 py-1 text-white/70">
              <i class="dripicons-user-group"></i> {{ $job_post->no_of_vacancy }} {{ __('vacancy') }}
            </span>
            <span class="rounded-full border border-white/10 bg-slate-950/40 px-3 py-1 text-white/70">
              <i class="dripicons-clock"></i> {{ __('posted') }} {{ $job_post->updated_at->diffForHumans() }}
            </span>
          </div>
        </div>

        <div class="shrink-0 flex flex-col gap-2 w-full lg:w-auto">
          <button class="rounded-2xl bg-gradient-to-r from-cyan-300 to-indigo-300 px-6 py-3 text-sm font-semibold text-slate-950 hover:opacity-95 transition"
                  id="apply_job">
            {{ trans('file.Apply') }} <i class="dripicons-arrow-thin-right"></i>
          </button>

          <a href="#overview"
             class="rounded-2xl border border-white/15 bg-white/5 px-6 py-3 text-center text-sm font-semibold text-white hover:bg-white/10 transition">
            View overview
          </a>
        </div>
      </div>

      @if(!empty($job_post->short_description))
        <div class="mt-6 rounded-2xl border border-white/10 bg-slate-950/40 p-5 text-white/80">
          {{ $job_post->short_description }}
        </div>
      @endif
    </div>
  </section>

  <!-- Content -->
  <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pb-16">
    <div class="grid lg:grid-cols-12 gap-6">

      <!-- Left: Details -->
      <div class="lg:col-span-7 space-y-4">
        <div class="rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur">
          <h2 class="text-xl font-bold mb-3">{{ trans('file.Details') }}</h2>

          <div class="job-content">
            {!! html_entity_decode($job_post->long_description) !!}
          </div>
        </div>
      </div>

      <!-- Right: Overview -->
      <aside id="overview" class="lg:col-span-5 space-y-4">
        <div class="rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur">
          <div class="flex items-start justify-between">
            <div>
              <h3 class="text-xl font-bold">{{ trans('file.Overview') }}</h3>
              <p class="text-sm text-white/60 mt-1">Quick info about this role</p>
            </div>
            <div class="h-10 w-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center">📌</div>
          </div>

          <div class="mt-5 space-y-3 text-sm">
            <div class="rounded-2xl border border-white/10 bg-slate-950/40 p-4">
              <div class="text-xs text-white/60">{{ __('Job Title') }}</div>
              <div class="font-semibold mt-1">{{ $job_post->job_title }}</div>
            </div>

            @if(!empty($job_post->Company->company_name))
              <div class="rounded-2xl border border-white/10 bg-slate-950/40 p-4">
                <div class="text-xs text-white/60">{{ __('Company') }}</div>
                <div class="font-semibold mt-1">{{ $job_post->Company->company_name }}</div>
              </div>
            @endif

            <div class="grid sm:grid-cols-2 gap-3">
              <div class="rounded-2xl border border-white/10 bg-slate-950/40 p-4">
                <div class="text-xs text-white/60">{{ trans('file.Experience') }}</div>
                <div class="font-semibold mt-1">{{ $job_post->jobExperience->title ?? '-' }}</div>
              </div>

              <div class="rounded-2xl border border-white/10 bg-slate-950/40 p-4">
                <div class="text-xs text-white/60">{{ trans('file.Vacancy') }}</div>
                <div class="font-semibold mt-1">{{ $job_post->no_of_vacancy }}</div>
              </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-3">
              <div class="rounded-2xl border border-white/10 bg-slate-950/40 p-4">
                <div class="text-xs text-white/60">{{ __('Apply Before') }}</div>
                <div class="font-semibold mt-1">{{ $job_post->closing_date }}</div>
              </div>

              <div class="rounded-2xl border border-white/10 bg-slate-950/40 p-4">
                <div class="text-xs text-white/60">{{ __('Posted') }}</div>
                <div class="font-semibold mt-1">{{ $job_post->updated_at->diffForHumans() }}</div>
              </div>
            </div>
          </div>

          <button class="mt-5 w-full rounded-2xl bg-white px-6 py-3 text-sm font-semibold text-slate-950 hover:bg-white/90 transition"
                  id="apply_job_side">
            {{ trans('file.Apply') }} <i class="dripicons-arrow-thin-right"></i>
          </button>
        </div>

        <div class="rounded-3xl border border-white/10 bg-gradient-to-b from-cyan-400/15 to-indigo-400/10 p-6">
          <div class="text-sm font-semibold text-white/90">Need help?</div>
          <div class="mt-1 text-sm text-white/70">If you have any questions about applying, contact us.</div>
          <a href="{{ route('contact.front') }}"
             class="mt-4 inline-flex w-full justify-center rounded-2xl border border-white/15 bg-white/5 px-5 py-2.5 text-sm font-semibold text-white hover:bg-white/10 transition">
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

  <!-- Apply Modal (same logic, redesigned a bit) -->
  <div id="applyModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 id="exampleModalLabel" class="modal-title">{{ __('Apply For This Job') }}</h5>
          <button type="button" data-dismiss="modal" id="close" aria-label="Close" class="close">
            <span aria-hidden="true">×</span>
          </button>
        </div>

        <div class="px-4 pt-3">
          <span id="form_result"></span>
        </div>

        <form autocomplete="off" method="post" id="apply_form" class="form-horizontal mb-0" enctype="multipart/form-data">
          @csrf
          <div class="modal-body">

            <div class="row">
              <div class="col-md-6 form-group">
                <label for="full_name">{{ __('Full Name') }} *</label>
                <input type="text" name="full_name" id="full_name" placeholder="{{ __('Full Name') }}" required class="form-control">
              </div>

              <div class="col-md-6 form-group">
                <label for="email">{{ trans('file.Email') }} *</label>
                <input type="email" name="email" id="email" placeholder="{{ trans('file.Email') }}" required class="form-control">
              </div>

              <div class="col-md-6 form-group">
                <label for="phone">{{ trans('file.Phone') }} *</label>
                <input type="text" name="phone" id="phone" placeholder="{{ trans('file.Phone') }}" required class="form-control">
              </div>

              <div class="col-md-12 form-group">
                <label for="address">{{ trans('file.Address') }}</label>
                <textarea name="address" id="address" placeholder="{{ trans('file.Address') }}" class="form-control" cols="30" rows="3"></textarea>
              </div>

              <div class="col-md-12 form-group">
                <label for="cover_letter">{{ __('Cover Letter/Message') }}</label>
                <textarea class="form-control" required id="cover_letter" name="cover_letter" rows="3"></textarea>
              </div>

              <div class="col-md-6 form-group">
                <label for="fb_id">{{ __('Facebook Profile') }} ({{ trans('file.Optional') }})</label>
                <input type="text" name="fb_id" id="fb_id" placeholder="{{ __('Facebook Profile') }}" class="form-control">
              </div>

              <div class="col-md-6 form-group">
                <label for="linkedin_id">{{ __('Linkedin Profile') }} ({{ trans('file.Optional') }})</label>
                <input type="text" name="linkedin_id" id="linkedin_id" placeholder="{{ __('Linkedin Profile') }}" class="form-control">
              </div>

              <div class="col-md-12 form-group">
                <label for="cv">{{ __('Upload your cv') }}</label>
                <input type="file" name="cv" id="cv" class="form-control" accept="image/*,.pdf,.doc,.docs">
              </div>
            </div>

          </div>

          <input type="submit" name="action_button" id="action_button"
                 class="btn btn-warning btn-block btn-lg"
                 value="{{ trans('file.Apply') }}"/>
        </form>
      </div>
    </div>
  </div>

  <script>
    (function($){
      "use strict";

      $(document).ready(function () {

        function openApplyModal(){
          $('#applyModal').modal('show');
        }

        $('#apply_job, #apply_job_side, #apply_job_top').on('click', function () {
          openApplyModal();
        });

        $('#apply_form').on('submit', function (event) {
          event.preventDefault();

          $.ajax({
            url: "{{ route('jobs.apply', $job_post->id) }}",
            method: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            success: function (data) {
              var html = '';
              if (data.errors) {
                html = '<div class="alert alert-danger">';
                for (var count = 0; count < data.errors.length; count++) {
                  html += '<p>' + data.errors[count] + '</p>';
                }
                html += '</div>';
              }
              if (data.success) {
                html = '<div class="alert alert-success">' + data.success + '</div>';
                $('#apply_form')[0].reset();
              }
              $('#form_result').html(html).slideDown(300).delay(5000).slideUp(300);
            }
          });
        });
      });

      tinymce.init({
        selector: '#cover_letter',
        setup: function (editor) {
          editor.on('change', function () { editor.save(); });
        },
        height: 130,
        image_title: true,
        automatic_uploads: true,
        file_picker_types: 'image',
        file_picker_callback: function (cb, value, meta) {
          var input = document.createElement('input');
          input.setAttribute('type', 'file');
          input.setAttribute('accept', 'image/*');

          input.onchange = function () {
            var file = this.files[0];
            var reader = new FileReader();
            reader.onload = function () {
              var id = 'blobid' + (new Date()).getTime();
              var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
              var base64 = reader.result.split(',')[1];
              var blobInfo = blobCache.create(id, file, base64);
              blobCache.add(blobInfo);
              cb(blobInfo.blobUri(), { title: file.name });
            };
            reader.readAsDataURL(file);
          };

          input.click();
        },
        plugins: [
          'advlist autolink lists link image charmap print preview anchor textcolor',
          'searchreplace visualblocks code fullscreen',
          'insertdatetime media table contextmenu paste code wordcount'
        ],
        toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat',
        branding: false
      });

    })(jQuery);
  </script>

</body>
</html>
