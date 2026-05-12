<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@hasSection('title')@yield('title')@else{{ $siteBranding['site_name'] }}@endif</title>
    @if (! empty($siteBranding['favicon_url']))
        <link rel="icon" href="{{ $siteBranding['favicon_url'] }}" sizes="any">
    @endif

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --bo-primary: #2563eb;
            --bo-primary-dark: #1d4ed8;
            --bo-accent: #7c3aed;
            --bo-sidebar-w: 272px;
            --bo-radius: 1rem;
            --bo-radius-sm: 0.75rem;
            --bo-shadow: 0 4px 6px -1px rgba(15, 23, 42, 0.07), 0 10px 24px -8px rgba(15, 23, 42, 0.12);
            --bo-shadow-lg: 0 20px 50px -12px rgba(15, 23, 42, 0.15);
            --bo-border: rgba(148, 163, 184, 0.22);
            --bo-surface: #ffffff;
            --bo-muted: #64748b;
        }

        body.bo-app {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background: #f1f5f9;
            color: #0f172a;
            -webkit-font-smoothing: antialiased;
        }

        /* ----- Sidebar ----- */
        .bo-sidebar {
            width: var(--bo-sidebar-w);
            min-height: 100vh;
            background: linear-gradient(165deg, #1e3a8a 0%, #312e81 42%, #4c1d95 100%);
            padding: 1.5rem 1.25rem;
            display: flex;
            flex-direction: column;
            position: relative;
            box-shadow: 4px 0 32px rgba(15, 23, 42, 0.12);
        }
        .bo-sidebar::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(120% 80% at 0% 0%, rgba(255,255,255,0.12) 0%, transparent 55%);
            pointer-events: none;
        }
        .bo-sidebar > * { position: relative; z-index: 1; }

        .bo-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            color: #fff !important;
            padding: 0.35rem 0;
            margin-bottom: 1.75rem;
        }
        .bo-brand-mark {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: linear-gradient(135deg, rgba(255,255,255,0.25), rgba(255,255,255,0.05));
            border: 1px solid rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
            letter-spacing: -0.02em;
            flex-shrink: 0;
            overflow: hidden;
        }
        .bo-brand-mark img {
            width: 100%;
            height: 100%;
            max-width: 36px;
            max-height: 36px;
            object-fit: contain;
        }
        .bo-brand-text { font-weight: 700; font-size: 1.05rem; letter-spacing: -0.02em; line-height: 1.25; }
        .bo-brand-sub { font-size: 0.7rem; font-weight: 500; color: rgba(255,255,255,0.55); text-transform: uppercase; letter-spacing: 0.08em; }

        .bo-nav-label {
            font-size: 0.65rem;
            font-weight: 600;
            letter-spacing: 0.12em;
            color: rgba(255,255,255,0.45);
            margin-bottom: 0.65rem;
            padding-left: 0.35rem;
        }
        .bo-nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.65rem 0.85rem;
            border-radius: 12px;
            color: rgba(255,255,255,0.72) !important;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.925rem;
            transition: background 0.2s, color 0.2s, transform 0.15s;
            border: 1px solid transparent;
        }
        .bo-nav-link:hover {
            background: rgba(255,255,255,0.08);
            color: #fff !important;
        }
        .bo-nav-link.active {
            background: rgba(255,255,255,0.16);
            color: #fff !important;
            border-color: rgba(255,255,255,0.12);
            box-shadow: 0 4px 16px rgba(0,0,0,0.12);
        }
        .bo-nav-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,0.08);
            flex-shrink: 0;
        }
        .bo-nav-link.active .bo-nav-icon {
            background: rgba(255,255,255,0.2);
        }
        .bo-nav-icon svg { opacity: 0.9; }

        .bo-sidebar-footer {
            margin-top: auto;
            padding-top: 1.25rem;
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        .bo-user-card {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 14px;
            padding: 0.85rem 1rem;
            margin-bottom: 0.75rem;
        }
        .bo-user-name { font-weight: 600; font-size: 0.9rem; color: #fff; }
        .bo-user-email { font-size: 0.75rem; color: rgba(255,255,255,0.55); word-break: break-all; }
        .bo-btn-logout {
            width: 100%;
            border-radius: 11px;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 0.55rem;
            border: none;
            background: #fff;
            color: #312e81 !important;
            transition: transform 0.15s, box-shadow 0.2s;
        }
        .bo-btn-logout:hover {
            background: #f8fafc;
            box-shadow: 0 6px 20px rgba(0,0,0,0.12);
            transform: translateY(-1px);
        }

        /* ----- Main shell ----- */
        .bo-shell { min-height: 100vh; display: flex; }
        .bo-main-wrap {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }
        .bo-topbar {
            background: var(--bo-surface);
            border-bottom: 1px solid var(--bo-border);
            padding: 0.85rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            box-shadow: 0 1px 0 rgba(255,255,255,0.8) inset;
        }
        .bo-topbar-title { font-weight: 700; font-size: 0.95rem; color: #0f172a; letter-spacing: -0.02em; }
        .bo-topbar-badge {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--bo-muted);
            background: #f1f5f9;
            padding: 0.35rem 0.65rem;
            border-radius: 999px;
        }

        .bo-main {
            flex: 1;
            background:
                radial-gradient(900px 400px at 100% -10%, rgba(37, 99, 235, 0.06), transparent),
                radial-gradient(600px 300px at 0% 100%, rgba(124, 58, 237, 0.05), transparent),
                #f1f5f9;
        }

        /* ----- Cards & tables (global in admin main) ----- */
        .bo-main .card {
            border: 1px solid var(--bo-border);
            border-radius: var(--bo-radius);
            box-shadow: var(--bo-shadow);
            overflow: hidden;
        }
        .bo-main .card .table-responsive { border-radius: 0; }
        .bo-main .table {
            margin-bottom: 0;
        }
        .bo-main .table thead th {
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: var(--bo-muted);
            background: #f8fafc !important;
            border-bottom: 1px solid var(--bo-border) !important;
            padding-top: 0.9rem;
            padding-bottom: 0.9rem;
            white-space: nowrap;
        }
        .bo-main .table tbody td {
            padding-top: 0.95rem;
            padding-bottom: 0.95rem;
            border-color: rgba(148, 163, 184, 0.15);
            vertical-align: middle;
        }
        .bo-main .table tbody tr:hover {
            background: rgba(37, 99, 235, 0.03);
        }

        .bo-section-head {
            padding: 1rem 1.25rem;
            background: linear-gradient(180deg, #ffffff 0%, #fafbfc 100%);
            border-bottom: 1px solid var(--bo-border);
        }
        .bo-section-head h5 { font-weight: 700; letter-spacing: -0.02em; }
        .bo-section-head p { color: var(--bo-muted); }

        .bo-table-toolbar {
            background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%) !important;
            border-color: var(--bo-border) !important;
        }
        .bo-table-toolbar .input-group-text {
            border-color: #e2e8f0;
        }
        .bo-table-toolbar .form-control {
            border-color: #e2e8f0;
        }

        /* ----- Forms ----- */
        .bo-main .form-control,
        .bo-main .form-select {
            border-radius: 11px;
            border: 1px solid #e2e8f0;
            padding: 0.6rem 0.9rem;
            font-size: 0.925rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .bo-main .form-control:focus,
        .bo-main .form-select:focus {
            border-color: var(--bo-primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }
        .bo-main .form-label { font-weight: 600; color: #334155; font-size: 0.875rem; }

        .bo-main .btn-primary {
            background: linear-gradient(135deg, var(--bo-primary) 0%, #4338ca 100%);
            border: none;
            font-weight: 600;
            border-radius: 11px;
            padding: 0.55rem 1.15rem;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35);
        }
        .bo-main .btn-primary:hover {
            background: linear-gradient(135deg, var(--bo-primary-dark) 0%, #3730a3 100%);
            transform: translateY(-1px);
        }
        .bo-main .btn-outline-primary {
            border-radius: 11px;
            font-weight: 600;
            border-width: 1.5px;
        }
        .bo-main .btn-light {
            border-radius: 11px;
            font-weight: 600;
            border: 1px solid #e2e8f0;
            background: #fff;
        }

        .bo-page-header h3 { font-weight: 800; letter-spacing: -0.03em; color: #0f172a; }

        .bo-alert {
            border-radius: var(--bo-radius-sm);
            border: none;
        }

        /* ----- Modals ----- */
        .modal-content.bo-modal-content {
            border-radius: var(--bo-radius);
            border: 1px solid var(--bo-border);
            box-shadow: var(--bo-shadow-lg);
        }
        .modal-header.bo-modal-header { border-bottom: 1px solid var(--bo-border); padding: 1.1rem 1.25rem; }
        .modal-title { font-weight: 800; letter-spacing: -0.02em; }

        /* ----- Guest ----- */
        body.bo-app-guest {
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            background: #f1f5f9;
            -webkit-font-smoothing: antialiased;
        }
        .bo-guest-nav {
            background: #fff !important;
            border-bottom: 1px solid var(--bo-border) !important;
            box-shadow: var(--bo-shadow);
        }

        .bo-hero {
            border-radius: var(--bo-radius);
            padding: 2rem 2.25rem;
            background: linear-gradient(125deg, #1e40af 0%, #5b21b6 55%, #7c3aed 100%);
            color: #fff;
            box-shadow: var(--bo-shadow-lg);
            border: 1px solid rgba(255,255,255,0.12);
        }
        .bo-hero h2 { font-weight: 800; letter-spacing: -0.03em; }
        .bo-hero p { color: rgba(255,255,255,0.78); max-width: 42rem; }

        .bo-stat-card {
            border-radius: var(--bo-radius);
            border: 1px solid var(--bo-border);
            background: var(--bo-surface);
            padding: 1.35rem 1.5rem;
            box-shadow: var(--bo-shadow);
            height: 100%;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .bo-stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--bo-shadow-lg);
        }
        .bo-stat-label {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--bo-muted);
        }
        .bo-stat-value {
            font-size: 1.85rem;
            font-weight: 800;
            letter-spacing: -0.04em;
            line-height: 1.15;
            margin-top: 0.25rem;
        }

        .bo-app .modal .form-control,
        .bo-app .modal .form-select {
            border-radius: 11px;
        }

        .bo-main .pagination .page-link {
            border-radius: 10px;
            margin: 0 2px;
            border: 1px solid var(--bo-border);
            color: #475569;
            font-weight: 500;
        }
        .bo-main .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, var(--bo-primary), #4338ca);
            border-color: transparent;
        }

        /* Guest login */
        .bo-login-card {
            border-radius: var(--bo-radius);
            border: 1px solid var(--bo-border);
            box-shadow: var(--bo-shadow-lg);
            overflow: hidden;
            background: #fff;
        }
        .bo-app-guest .form-control {
            border-radius: 11px;
            border: 1px solid #e2e8f0;
            padding: 0.65rem 1rem;
        }
        .bo-app-guest .form-control:focus {
            border-color: var(--bo-primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }
        .bo-app-guest .btn-primary {
            background: linear-gradient(135deg, var(--bo-primary) 0%, #4338ca 100%);
            border: none;
            font-weight: 600;
            border-radius: 11px;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35);
        }
        .bo-app-guest main .card {
            border-radius: var(--bo-radius);
            border: 1px solid var(--bo-border);
            box-shadow: var(--bo-shadow-lg);
            overflow: hidden;
        }
        .bo-app-guest main .card-header {
            background: linear-gradient(180deg, #f8fafc, #f1f5f9);
            border-bottom: 1px solid var(--bo-border);
            font-weight: 700;
            padding: 1rem 1.25rem;
        }
    </style>
</head>
<body class="@auth bo-app @else bo-app-guest @endauth">
    <div id="app">
        @auth
            <div class="bo-shell">
                <aside class="bo-sidebar">
                    <a class="bo-brand" href="{{ route('home') }}">
                        <span class="bo-brand-mark">
                            @if (! empty($siteBranding['logo_url']))
                                <img src="{{ $siteBranding['logo_url'] }}" alt="">
                            @else
                                {{ strtoupper(\Illuminate\Support\Str::substr($siteBranding['site_name'], 0, 1)) }}
                            @endif
                        </span>
                        <span>
                            <span class="bo-brand-text d-block">{{ $siteBranding['site_name'] }}</span>
                            <span class="bo-brand-sub d-block mt-1">Backoffice</span>
                        </span>
                    </a>

                    <p class="bo-nav-label">Menu</p>
                    <nav class="d-flex flex-column gap-1 mb-4">
                        <a class="bo-nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <span class="bo-nav-icon">
                                <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354l-6-6zM15 14.5V8.207l-5-5L2 8.207V14.5h3v-4a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4h3z"/></svg>
                            </span>
                            Dashboard
                        </a>
                        <a class="bo-nav-link {{ request()->routeIs('contacts.*') ? 'active' : '' }}" href="{{ route('contacts.index') }}">
                            <span class="bo-nav-icon">
                                <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/><path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/><path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/></svg>
                            </span>
                            Contacts
                        </a>
                        <a class="bo-nav-link {{ request()->routeIs('templates.*') ? 'active' : '' }}" href="{{ route('templates.index') }}">
                            <span class="bo-nav-icon">
                                <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z"/></svg>
                            </span>
                            Templates
                        </a>
                        <a class="bo-nav-link {{ request()->routeIs('campaigns.*') ? 'active' : '' }}" href="{{ route('campaigns.index') }}">
                            <span class="bo-nav-icon">
                                <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path d="M13 2.5a1.5 1.5 0 0 1 3 0v11a1.5 1.5 0 0 1-3 0v-.214c-2.162-1.241-4.49-1.843-6.912-2.083l.405 2.712A1 1 0 0 1 5.51 15.1h-.548a1 1 0 0 1-.916-.599l-2.005-4.094h-.001A1.5 1.5 0 0 1 1 9.42V6.58a1.5 1.5 0 0 1 1.053-1.354l6.294-2.1C8.738 2.863 10.856 2.5 13 2.5zM4.5 6.5v3a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5zm5 0v3a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5z"/></svg>
                            </span>
                            Campaigns
                        </a>
                        <a class="bo-nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}" href="{{ route('settings.edit') }}">
                            <span class="bo-nav-icon">
                                <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8.932.727c-.243-.97-1.62-.97-1.864 0l-.071.286a.96.96 0 0 1-1.622.434l-.204-.21c-.695-.73-1.889-.028-1.613.931l.08.284a.96.96 0 0 1-1.186 1.187l-.283-.081c-.96-.276-1.663.918-.931 1.613l.211.204a.96.96 0 0 1-.434 1.622l-.286.071c-.97.243-.97 1.62 0 1.864l.286.071a.96.96 0 0 1 .434 1.622l-.204.21c-.73.695-.028 1.889.931 1.613l.284-.08a.96.96 0 0 1 1.187 1.186l-.081.283c-.276.96.918 1.663 1.613.931l.204-.211a.96.96 0 0 1 1.622.434l.071.286c.243.97 1.62.97 1.864 0l.071-.286a.96.96 0 0 1 1.622-.434l.204.21c.695.73 1.889.028 1.613-.931l-.08-.284a.96.96 0 0 1 1.186-1.187l.283.081c.96.276 1.663-.918.931-1.613l-.211-.204a.96.96 0 0 1 .434-1.622l.286-.071c.97-.243.97-1.62 0-1.864l-.286-.071a.96.96 0 0 1-.434-1.622l.204-.21c.73-.695.028-1.889-.931-1.613l-.284.08a.96.96 0 0 1-1.187-1.186l.081-.283c.276-.96-.918-1.663-1.613-.931l-.204.211a.96.96 0 0 1-1.622-.434L8.932.727zM13.5 8a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/></svg>
                            </span>
                            General settings
                        </a>
                    </nav>

                    <div class="bo-sidebar-footer">
                        <p class="bo-nav-label">Account</p>
                        <div class="bo-user-card">
                            <div class="bo-user-name">{{ Auth::user()->name }}</div>
                            <div class="bo-user-email">{{ Auth::user()->email }}</div>
                        </div>
                        <a class="bo-btn-logout text-center d-block text-decoration-none" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </aside>

                <div class="bo-main-wrap">
                    <header class="bo-topbar">
                        <span class="bo-topbar-title">Bulk Email Console</span>
                        <span class="bo-topbar-badge">Admin</span>
                    </header>
                    <main class="bo-main">
                        @yield('content')
                    </main>
                </div>
            </div>
        @else
            <nav class="navbar navbar-expand-md navbar-light bo-guest-nav shadow-sm">
                <div class="container">
                    <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ url('/') }}" style="color: #1e3a8a;">
                        @if (! empty($siteBranding['logo_url']))
                            <img src="{{ $siteBranding['logo_url'] }}" alt="" height="32" style="max-height: 32px; width: auto; object-fit: contain;">
                        @endif
                        <span>{{ $siteBranding['site_name'] }}</span>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto">
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link fw-semibold" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            {{----
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link fw-semibold" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                            ----}}
                        </ul>
                    </div>
                </div>
            </nav>
            <main class="py-4">
                @yield('content')
            </main>
        @endauth
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
