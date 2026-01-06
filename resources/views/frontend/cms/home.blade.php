@extends('frontend.Layout.master')

@section('content')
  <!-- Hero -->
  <section class="relative">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-14 pb-10 lg:pt-20">
      <div class="grid lg:grid-cols-2 gap-10 items-center">
        <div>
          <div class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs text-white/70">
            <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
            All-in-one workforce + project control center
          </div>

          <h1 class="mt-5 text-4xl sm:text-5xl font-bold leading-tight">
            Run HR, Payroll, and Projects
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-300 to-indigo-300">in one clean dashboard</span>
          </h1>

          <p class="mt-4 text-base sm:text-lg text-white/70 max-w-xl">
            PeoplePro helps your team manage employees, attendance, leave, performance, payroll,
            and projects — faster, clearer, and with fewer mistakes.
          </p>

          <div class="mt-7 flex flex-col sm:flex-row gap-3">
            <a href="#pricing"
               class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-cyan-300 to-indigo-300 px-6 py-3 text-sm font-semibold text-slate-950 hover:opacity-95 transition">
              Get started
            </a>
            <a href="#features"
               class="inline-flex items-center justify-center rounded-2xl border border-white/15 bg-white/5 px-6 py-3 text-sm font-semibold text-white hover:bg-white/10 transition">
              Explore features
            </a>
          </div>

          <div class="mt-6 grid grid-cols-3 gap-3 max-w-md text-xs text-white/60">
            <div class="rounded-xl border border-white/10 bg-white/5 p-3">
              <div class="text-white font-semibold">Accurate</div>
              Payroll + tax calculations
            </div>
            <div class="rounded-xl border border-white/10 bg-white/5 p-3">
              <div class="text-white font-semibold">Faster</div>
              Attendance → salary
            </div>
            <div class="rounded-xl border border-white/10 bg-white/5 p-3">
              <div class="text-white font-semibold">Clear</div>
              Reports & analytics
            </div>
          </div>
        </div>

        <!-- Right side “product card” -->
        <div class="relative">
          <div class="rounded-3xl border border-white/10 bg-white/5 p-5 glass shadow-2xl">
            <div class="flex items-center justify-between">
              <div>
                <div class="text-sm font-semibold">PeoplePro overview</div>
                <div class="text-xs text-white/60">Live snapshot</div>
              </div>
              <div class="flex gap-2">
                <span class="h-2.5 w-2.5 rounded-full bg-emerald-400"></span>
                <span class="h-2.5 w-2.5 rounded-full bg-yellow-400"></span>
                <span class="h-2.5 w-2.5 rounded-full bg-rose-400"></span>
              </div>
            </div>

            <div class="mt-5 grid grid-cols-2 gap-3 text-sm">
              <div class="rounded-2xl border border-white/10 bg-slate-950/40 p-4">
                <div class="text-white/70 text-xs">Employees</div>
                <div class="text-xl font-bold mt-1">1,248</div>
                <div class="text-xs text-emerald-300 mt-1">+12 this week</div>
              </div>
              <div class="rounded-2xl border border-white/10 bg-slate-950/40 p-4">
                <div class="text-white/70 text-xs">Payroll run</div>
                <div class="text-xl font-bold mt-1">2m 14s</div>
                <div class="text-xs text-cyan-300 mt-1">Auto calculations</div>
              </div>
              <div class="rounded-2xl border border-white/10 bg-slate-950/40 p-4">
                <div class="text-white/70 text-xs">Projects</div>
                <div class="text-xl font-bold mt-1">36</div>
                <div class="text-xs text-indigo-300 mt-1">Progress tracking</div>
              </div>
              <div class="rounded-2xl border border-white/10 bg-slate-950/40 p-4">
                <div class="text-white/70 text-xs">Reports</div>
                <div class="text-xl font-bold mt-1">120+</div>
                <div class="text-xs text-fuchsia-300 mt-1">Export ready</div>
              </div>
            </div>

            <div class="mt-4 rounded-2xl border border-white/10 bg-slate-950/40 p-4">
              <div class="text-xs text-white/60">Today’s highlights</div>
              <ul class="mt-2 space-y-2 text-sm text-white/80">
                <li class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-emerald-400"></span> Attendance synced</li>
                <li class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-cyan-400"></span> Leave approvals pending: 7</li>
                <li class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-indigo-400"></span> Milestones due: 3</li>
              </ul>
            </div>
          </div>

          <div class="absolute -bottom-6 -left-6 hidden md:block rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-xs text-white/70 glass">
            Tip: Keep everything in one system → fewer errors ✅
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Features -->
  <section id="features" class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex items-end justify-between gap-6 flex-wrap">
      <div>
        <h2 class="text-2xl sm:text-3xl font-bold">Everything you need, in one place</h2>
        <p class="mt-2 text-white/70 max-w-2xl">
          Clean workflows for HR teams, managers, and employees — from hiring to salary to project delivery.
        </p>
      </div>
      <a href="#demo" class="text-sm font-semibold text-cyan-200 hover:text-cyan-100 transition">See it in action →</a>
    </div>

    <div class="mt-8 grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
      @php
        $features = [
          ["Employee management","Central employee profiles, history, evaluations, and records."],
          ["Payroll processing","Automated salary, tax, deductions, benefits, and payroll reports."],
          ["Recruitment & onboarding","Job posts, applicant tracking, interviews, and onboarding steps."],
          ["Performance management","Goals, appraisals, feedback, skill gaps, and improvement plans."],
          ["Time & attendance","Clock-in/out, breaks, shifts, overtime, and attendance insights."],
          ["Leave management","Leave requests, approvals, balances, accruals, and absence tracking."],
          ["Project management","Tasks, milestones, progress tracking, resource allocation, teamwork."],
          ["Document management","Secure storage for contracts, certificates, reviews, versioning."],
          ["Reports & analytics","HR + project metrics to support smarter decisions."],
        ];
      @endphp

      @foreach($features as $f)
        <div class="rounded-3xl border border-white/10 bg-white/5 p-5 hover:bg-white/10 transition">
          <div class="text-sm font-semibold">{{ $f[0] }}</div>
          <div class="mt-2 text-sm text-white/70">{{ $f[1] }}</div>
          <div class="mt-4 h-px bg-white/10"></div>
          <div class="mt-3 text-xs text-white/60">Built for speed • Built for teams</div>
        </div>
      @endforeach
    </div>
  </section>

  <!-- Demo / content section (your $home content can live here) -->
  <section id="demo" class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pb-14">
    <div class="rounded-3xl border border-white/10 bg-white/5 p-6 sm:p-8 glass">
      <div class="flex flex-col lg:flex-row gap-8 lg:items-start lg:justify-between">
        <div class="max-w-2xl">
          <h3 class="text-xl sm:text-2xl font-bold">Your custom content</h3>
          <p class="mt-2 text-white/70">
            This area renders your existing <code class="text-white/80">html_entity_decode($home)</code> content.
            You can replace it with screenshots, a video embed, or a live demo link.
          </p>
        </div>

        <div class="flex gap-3">
          <a href="{{ route('contact.front') }}"
             class="inline-flex items-center justify-center rounded-2xl border border-white/15 bg-white/5 px-5 py-2.5 text-sm font-semibold text-white hover:bg-white/10 transition">
            Talk to sales
          </a>
          <a href="#pricing"
             class="inline-flex items-center justify-center rounded-2xl bg-white px-5 py-2.5 text-sm font-semibold text-slate-950 hover:bg-white/90 transition">
            View plans
          </a>
        </div>
      </div>

      <div class="mt-6 rounded-2xl border border-white/10 bg-slate-950/40 p-5">
        {!! html_entity_decode($home ?? '') !!}
      </div>
    </div>
  </section>

  <!-- Pricing -->
  <section id="pricing" class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pb-16">
    <div class="text-center">
      <h2 class="text-2xl sm:text-3xl font-bold">Simple plans that scale</h2>
      <p class="mt-2 text-white/70">Pick a plan, start clean, grow fast.</p>
    </div>

    <div class="mt-8 grid lg:grid-cols-3 gap-4">
      <!-- Starter -->
      <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
        <div class="text-sm font-semibold">Starter</div>
        <div class="mt-2 text-3xl font-bold">৳0</div>
        <div class="text-sm text-white/60">For testing & small teams</div>
        <ul class="mt-4 space-y-2 text-sm text-white/75">
          <li>• Core HR</li>
          <li>• Attendance</li>
          <li>• Basic reports</li>
        </ul>
        <a href="{{ route('contact.front') }}" class="mt-6 inline-flex w-full justify-center rounded-2xl border border-white/15 bg-white/5 px-5 py-2.5 text-sm font-semibold hover:bg-white/10 transition">
          Request setup
        </a>
      </div>

      <!-- Pro (highlight) -->
      <div class="rounded-3xl border border-cyan-300/30 bg-gradient-to-b from-cyan-400/15 to-indigo-400/10 p-6 shadow-2xl">
        <div class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs text-white/80">
          Most popular
        </div>
        <div class="mt-3 text-sm font-semibold">Pro</div>
        <div class="mt-2 text-3xl font-bold">Custom</div>
        <div class="text-sm text-white/70">Best for growing companies</div>
        <ul class="mt-4 space-y-2 text-sm text-white/80">
          <li>• HR + Payroll</li>
          <li>• Leave workflows</li>
          <li>• Performance</li>
          <li>• Project management</li>
        </ul>
        <a href="{{ route('contact.front') }}" class="mt-6 inline-flex w-full justify-center rounded-2xl bg-white px-5 py-2.5 text-sm font-semibold text-slate-950 hover:bg-white/90 transition">
          Get a quote
        </a>
      </div>

      <!-- Enterprise -->
      <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
        <div class="text-sm font-semibold">Enterprise</div>
        <div class="mt-2 text-3xl font-bold">Custom</div>
        <div class="text-sm text-white/60">For large orgs & compliance</div>
        <ul class="mt-4 space-y-2 text-sm text-white/75">
          <li>• Advanced analytics</li>
          <li>• Custom roles</li>
          <li>• Dedicated support</li>
          <li>• SLA / security</li>
        </ul>
        <a href="{{ route('contact.front') }}" class="mt-6 inline-flex w-full justify-center rounded-2xl border border-white/15 bg-white/5 px-5 py-2.5 text-sm font-semibold hover:bg-white/10 transition">
          Contact us
        </a>
      </div>
    </div>
  </section>
@endsection
