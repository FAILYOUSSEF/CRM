<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name','CRM') }} — @yield('title','Dashboard')</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        /* ── Design tokens ── */
        :root {
            --sidebar-w: 256px;
            --topbar-h: 60px;
            --bg:        #0f172a;
            --bg2:       #1a2849;
            --bg3:       #243456;
            --surface:   #2d4263;
            --border:    rgba(148, 163, 184, 0.12);
            --accent:    #3b82f6;
            --accent2:   #0ea5e9;
            --accent-g:  linear-gradient(135deg,#3b82f6 0%,#0ea5e9 100%);
            --text:      #f1f5f9;
            --muted:     #94a3b8;
            --success:   #10b981;
            --warning:   #f59e0b;
            --danger:    #ef4444;
            --font:      'DM Sans', sans-serif;
            --mono:      'DM Mono', monospace;
            --radius:    10px;
            --radius-lg: 16px;
            --shadow:    0 4px 24px rgba(0,0,0,0.4);
        }

        /* ── Reset & base ── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; }
        body {
            font-family: var(--font);
            background: var(--bg);
            color: var(--text);
            font-size: 14px;
            line-height: 1.6;
            display: flex;
            overflow: hidden;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: var(--sidebar-w);
            height: 100vh;
            background: var(--bg2);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            position: relative;
            z-index: 40;
        }
        .sidebar-logo {
            height: var(--topbar-h);
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 20px;
            border-bottom: 1px solid var(--border);
        }
        .sidebar-logo-icon {
            width: 30px; height: 30px;
            background: var(--accent-g);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; font-weight: 600; color: #fff;
            flex-shrink: 0;
        }
        .sidebar-logo-text {
            font-size: 15px; font-weight: 600; letter-spacing: -0.3px; color: var(--text);
        }

        .sidebar-section {
            padding: 20px 12px 4px;
        }
        .sidebar-label {
            font-size: 10px; font-weight: 600; letter-spacing: 1px;
            text-transform: uppercase; color: var(--muted);
            padding: 0 8px; margin-bottom: 6px;
        }

        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 12px; border-radius: var(--radius);
            color: var(--muted); text-decoration: none;
            font-size: 13.5px; font-weight: 400;
            transition: background 0.15s, color 0.15s;
            margin-bottom: 2px;
            position: relative;
        }
        .nav-item:hover { background: var(--bg3); color: var(--text); }
        .nav-item.active {
            background: rgba(59, 130, 246, 0.12);
            color: var(--accent);
            font-weight: 500;
        }
        .nav-item.active::before {
            content: '';
            position: absolute; left: 0; top: 20%; bottom: 20%;
            width: 3px; border-radius: 0 3px 3px 0;
            background: var(--accent);
        }
        .nav-icon {
            width: 18px; height: 18px; flex-shrink: 0; opacity: 0.9;
        }
        .nav-badge {
            margin-left: auto;
            background: var(--accent); color: #fff;
            font-size: 10px; font-weight: 600;
            padding: 1px 6px; border-radius: 20px;
        }
        .nav-badge.danger { background: var(--danger); }

        .sidebar-bottom {
            margin-top: auto;
            padding: 12px;
            border-top: 1px solid var(--border);
        }
        .user-card {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px; border-radius: var(--radius);
            background: var(--bg3); cursor: pointer;
            transition: background 0.15s;
        }
        .user-card:hover { background: var(--surface); }
        .user-avatar {
            width: 32px; height: 32px;
            border-radius: 50%;
            background: var(--accent-g);
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 700; color: #fff;
            flex-shrink: 0;
        }
        .user-info { flex: 1; min-width: 0; }
        .user-name { font-size: 13px; font-weight: 500; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .user-role { font-size: 11px; color: var(--muted); }
        .logout-btn {
            background: none; border: none; color: var(--muted);
            cursor: pointer; padding: 4px; border-radius: 6px;
            transition: color 0.15s, background 0.15s;
            display: flex; align-items: center;
        }
        .logout-btn:hover { color: var(--danger); background: rgba(239,68,68,0.1); }

        /* ── Main content area ── */
        .main {
            flex: 1; min-width: 0;
            display: flex; flex-direction: column;
            height: 100vh; overflow: hidden;
        }

        /* ── Top bar ── */
        .topbar {
            height: var(--topbar-h);
            background: var(--bg2);
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center;
            padding: 0 28px; gap: 16px;
            flex-shrink: 0;
        }
        .topbar-title {
            font-size: 16px; font-weight: 600; letter-spacing: -0.3px;
            color: var(--text); flex: 1;
        }
        .topbar-search {
            display: flex; align-items: center; gap: 8px;
            background: var(--bg3); border: 1px solid var(--border);
            border-radius: 8px; padding: 6px 12px;
            width: 220px; transition: border-color 0.15s;
        }
        .topbar-search:focus-within { border-color: var(--accent); }
        .topbar-search input {
            background: none; border: none; outline: none;
            color: var(--text); font-family: var(--font); font-size: 13px;
            width: 100%;
        }
        .topbar-search input::placeholder { color: var(--muted); }
        .topbar-btn {
            width: 36px; height: 36px;
            border-radius: 8px; background: var(--bg3);
            border: 1px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; transition: background 0.15s, border-color 0.15s;
            color: var(--muted);
        }
        .topbar-btn:hover { background: var(--surface); border-color: rgba(255,255,255,0.15); color: var(--text); }

        /* ── Page content ── */
        .page-content {
            flex: 1; overflow-y: auto;
            padding: 28px;
            scrollbar-width: thin;
            scrollbar-color: var(--surface) transparent;
        }
        .page-content::-webkit-scrollbar { width: 6px; }
        .page-content::-webkit-scrollbar-track { background: transparent; }
        .page-content::-webkit-scrollbar-thumb { background: var(--surface); border-radius: 3px; }

        /* ── Flash messages ── */
        .flash {
            display: flex; align-items: center; gap: 10px;
            padding: 12px 16px; border-radius: var(--radius);
            font-size: 13.5px; margin-bottom: 20px;
            animation: slideIn 0.25s ease;
        }
        .flash.success { background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.25); color: #6ee7b7; }
        .flash.error   { background: rgba(239,68,68,0.1);  border: 1px solid rgba(239,68,68,0.25);  color: #fca5a5; }
        @keyframes slideIn { from { opacity:0; transform:translateY(-8px); } to { opacity:1; transform:translateY(0); } }

        /* ── Cards ── */
        .card {
            background: var(--bg2);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
        }
        .card-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 18px 22px;
            border-bottom: 1px solid var(--border);
        }
        .card-title { font-size: 14px; font-weight: 600; color: var(--text); }
        .card-body { padding: 22px; }

        /* ── Stat cards ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        .stat-card {
            background: var(--bg2);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 20px 22px;
            position: relative; overflow: hidden;
        }
        .stat-card::after {
            content: '';
            position: absolute; top: 0; right: 0;
            width: 80px; height: 80px;
            border-radius: 50%;
            background: var(--accent-color, var(--accent));
            opacity: 0.06;
            transform: translate(20px,-20px);
        }
        .stat-label { font-size: 12px; color: var(--muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; }
        .stat-value { font-size: 28px; font-weight: 600; color: var(--text); letter-spacing: -1px; }
        .stat-sub   { font-size: 12px; color: var(--muted); margin-top: 4px; }
        .stat-icon  {
            position: absolute; top: 18px; right: 18px;
            width: 36px; height: 36px; border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            background: rgba(255,255,255,0.05);
        }

        /* ── Table ── */
        .table-wrap {
            background: var(--bg2);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            overflow: hidden;
        }
        .table-top {
            display: flex; align-items: center; justify-content: space-between;
            padding: 16px 22px; border-bottom: 1px solid var(--border);
        }
        table { width: 100%; border-collapse: collapse; }
        thead th {
            padding: 10px 20px;
            font-size: 11px; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.6px;
            color: var(--muted);
            background: var(--bg3);
            text-align: left; white-space: nowrap;
        }
        tbody tr {
            border-top: 1px solid var(--border);
            transition: background 0.1s;
        }
        tbody tr:hover { background: rgba(255,255,255,0.02); }
        td {
            padding: 13px 20px;
            font-size: 13.5px; color: var(--text);
            vertical-align: middle;
        }
        td.muted { color: var(--muted); }
        .empty-row td { padding: 48px; text-align: center; color: var(--muted); }

        /* ── Badges ── */
        .badge {
            display: inline-flex; align-items: center;
            padding: 3px 10px; border-radius: 20px;
            font-size: 11px; font-weight: 600; white-space: nowrap;
        }
        .badge-blue    { background: rgba(79,125,255,0.15);  color: #93b4ff; }
        .badge-green   { background: rgba(16,185,129,0.15);  color: #6ee7b7; }
        .badge-red     { background: rgba(239,68,68,0.15);   color: #fca5a5; }
        .badge-amber   { background: rgba(245,158,11,0.15);  color: #fcd34d; }
        .badge-purple  { background: rgba(124,58,237,0.15);  color: #c4b5fd; }
        .badge-gray    { background: rgba(107,114,128,0.15); color: #9ca3af; }

        /* ── Priority dots ── */
        .priority { display: flex; align-items: center; gap: 6px; }
        .priority-dot {
            width: 7px; height: 7px; border-radius: 50%;
        }
        .priority-dot.haute   { background: var(--danger); box-shadow: 0 0 6px var(--danger); }
        .priority-dot.moyenne { background: var(--warning); }
        .priority-dot.faible  { background: var(--success); }

        /* ── Buttons ── */
        .btn {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 8px 16px; border-radius: 8px;
            font-family: var(--font); font-size: 13px; font-weight: 500;
            cursor: pointer; border: none; text-decoration: none;
            transition: all 0.15s; white-space: nowrap;
        }
        .btn-primary {
            background: var(--accent); color: #fff;
        }
        .btn-primary:hover { background: #3d6ae6; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(79,125,255,0.4); }
        .btn-ghost {
            background: transparent; color: var(--muted);
            border: 1px solid var(--border);
        }
        .btn-ghost:hover { background: var(--bg3); color: var(--text); border-color: rgba(255,255,255,0.15); }
        .btn-danger { background: rgba(239,68,68,0.12); color: #fca5a5; border: 1px solid rgba(239,68,68,0.2); }
        .btn-danger:hover { background: rgba(239,68,68,0.22); }
        .btn-sm { padding: 5px 12px; font-size: 12px; }

        /* ── Form elements ── */
        .form-group { margin-bottom: 18px; }
        .form-label {
            display: block; margin-bottom: 6px;
            font-size: 12.5px; font-weight: 500; color: var(--muted);
        }
        .form-control {
            width: 100%; padding: 9px 13px;
            background: var(--bg3); border: 1px solid var(--border);
            border-radius: 8px; color: var(--text);
            font-family: var(--font); font-size: 13.5px;
            outline: none; transition: border-color 0.15s, box-shadow 0.15s;
            appearance: none;
        }
        .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(79,125,255,0.15);
        }
        .form-control::placeholder { color: var(--muted); }
        textarea.form-control { resize: vertical; min-height: 100px; }
        select.form-control {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 36px;
        }

        /* checkbox grid */
        .checkbox-grid {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(180px,1fr));
            gap: 8px;
            padding: 12px;
            background: var(--bg3); border: 1px solid var(--border);
            border-radius: 8px; max-height: 160px; overflow-y: auto;
        }
        .checkbox-item {
            display: flex; align-items: center; gap: 8px;
            font-size: 13px; color: var(--text); cursor: pointer;
        }
        .checkbox-item input[type=checkbox] { accent-color: var(--accent); width: 14px; height: 14px; }

        /* ── Page header ── */
        .page-header {
            display: flex; align-items: flex-start; justify-content: space-between;
            margin-bottom: 24px; gap: 16px;
        }
        .page-header-left h1 {
            font-size: 22px; font-weight: 600; letter-spacing: -0.5px; color: var(--text);
        }
        .page-header-left p { color: var(--muted); font-size: 13px; margin-top: 2px; }

        /* ── Pagination ── */
        .pagination { display: flex; gap: 4px; margin-top: 16px; }
        .page-link {
            padding: 6px 11px; border-radius: 7px;
            background: var(--bg3); border: 1px solid var(--border);
            color: var(--muted); font-size: 13px; text-decoration: none;
            transition: all 0.15s;
        }
        .page-link:hover, .page-link.active { background: var(--accent); color: #fff; border-color: var(--accent); }

        /* ── Action links ── */
        .action-link {
            font-size: 12.5px; font-weight: 500; text-decoration: none;
            padding: 4px 8px; border-radius: 6px; transition: background 0.1s;
        }
        .action-link.edit   { color: #fcd34d; }
        .action-link.edit:hover   { background: rgba(245,158,11,0.1); }
        .action-link.view   { color: #93b4ff; }
        .action-link.view:hover   { background: rgba(79,125,255,0.1); }
        .action-link.delete { color: #fca5a5; }
        .action-link.delete:hover { background: rgba(239,68,68,0.1); }

        /* ── Detail page grid ── */
        .detail-grid { display: grid; grid-template-columns: 1fr 320px; gap: 20px; }
        @media (max-width: 960px) { .detail-grid { grid-template-columns: 1fr; } }
        .dl-row { display: flex; padding: 10px 0; border-bottom: 1px solid var(--border); gap: 12px; }
        .dl-row:last-child { border-bottom: none; }
        .dl-label { font-size: 12px; color: var(--muted); min-width: 110px; padding-top: 2px; }
        .dl-value { font-size: 13.5px; color: var(--text); font-weight: 500; }

        /* ── Reply box ── */
        .reply-box {
            background: rgba(79,125,255,0.06);
            border: 1px solid rgba(79,125,255,0.2);
            border-radius: var(--radius-lg);
            padding: 20px;
        }
        .reply-box-title { font-size: 13px; font-weight: 600; color: var(--accent); margin-bottom: 12px; }
        .response-block {
            background: rgba(16,185,129,0.08);
            border: 1px solid rgba(16,185,129,0.2);
            border-radius: var(--radius);
            padding: 14px 16px;
            color: #6ee7b7; font-size: 13.5px;
        }

        /* ── Task card (employee view) ── */
        .task-card {
            background: var(--bg2);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 20px 22px;
            transition: border-color 0.15s;
            margin-bottom: 12px;
        }
        .task-card:hover { border-color: rgba(79,125,255,0.3); }
        .task-card-top { display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; margin-bottom: 12px; }
        .task-card-title { font-size: 15px; font-weight: 600; color: var(--text); }
        .task-card-meta  { font-size: 12.5px; color: var(--muted); margin-top: 2px; }
        .task-update-row { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }

        /* ── Tailwind compat helpers ── */
        .grid-cols-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .mt-1 { margin-top: 4px; }
        .mt-2 { margin-top: 8px; }
        .mt-3 { margin-top: 12px; }
        .mt-4 { margin-top: 16px; }
        .mb-3 { margin-bottom: 12px; }
        .mb-4 { margin-bottom: 16px; }
        .mb-5 { margin-bottom: 20px; }
        .flex { display: flex; }
        .items-center { align-items: center; }
        .gap-2 { gap: 8px; }
        .gap-3 { gap: 12px; }
        .w-full { width: 100%; }
        .text-sm { font-size: 13px; }
        .font-semibold { font-weight: 600; }
    </style>
</head>
<body>

@auth
{{-- ══════════════════════════════════════════════════════════ --}}
{{-- SIDEBAR                                                    --}}
{{-- ══════════════════════════════════════════════════════════ --}}
<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="sidebar-logo-icon">C</div>
    </div>

    @if(auth()->user()->isAdmin())
    <div class="sidebar-section">
        <div class="sidebar-label">Main</div>

        <a href="{{ route('admin.projects.index') }}"
           class="nav-item {{ request()->routeIs('admin.projects*') ? 'active' : '' }}">
            <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"/>
            </svg>
            Projects
        </a>

        <a href="{{ route('admin.tasks.index') }}"
           class="nav-item {{ request()->routeIs('admin.tasks*') ? 'active' : '' }}">
            <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2M9 5h6m-3 8l2 2 4-4"/>
            </svg>
            Tasks
        </a>

        <a href="{{ route('admin.tickets.index') }}"
           class="nav-item {{ request()->routeIs('admin.tickets*') ? 'active' : '' }}">
            <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a1 1 0 001 1h1a1 1 0 011 1v3a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 011-1h1a1 1 0 001-1V7a2 2 0 00-2-2H5z"/>
            </svg>
            Tickets
        </a>

        <a href="{{ route('admin.reclamations.index') }}"
           class="nav-item {{ request()->routeIs('admin.reclamations*') ? 'active' : '' }}">
            <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
            </svg>
            Reclamations
        </a>
    </div>

    <div class="sidebar-section">
        <div class="sidebar-label">Settings</div>
        <a href="{{ route('admin.users.index') }}"
           class="nav-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
            <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-1a3 3 0 00-5.356-1.857M17 20H7m10 0v-1c0-.656-.126-1.283-.356-1.857M7 20H2v-1a3 3 0 015.356-1.857M7 20v-1c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Users
        </a>
        <a href="{{ route('admin.categories.index') }}"
           class="nav-item {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
            <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
            </svg>
            Categories
        </a>
    </div>

    @elseif(auth()->user()->isEmployee())
    <div class="sidebar-section">
        <div class="sidebar-label">My Work</div>
        <a href="{{ route('employee.tasks.index') }}"
           class="nav-item {{ request()->routeIs('employee.tasks*') ? 'active' : '' }}">
            <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2M9 5h6m-3 8l2 2 4-4"/>
            </svg>
            My Tasks
        </a>
        <a href="{{ route('employee.reclamations.index') }}"
           class="nav-item {{ request()->routeIs('employee.reclamations*') ? 'active' : '' }}">
            <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
            </svg>
            Reclamations
        </a>
    </div>

    @elseif(auth()->user()->isClient())
    <div class="sidebar-section">
        <div class="sidebar-label">My Account</div>
        <a href="{{ route('client.tickets.index') }}"
           class="nav-item {{ request()->routeIs('client.tickets*') ? 'active' : '' }}">
            <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a1 1 0 001 1h1a1 1 0 011 1v3a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 011-1h1a1 1 0 001-1V7a2 2 0 00-2-2H5z"/>
            </svg>
            My Tickets
        </a>
        <a href="{{ route('client.reclamations.index') }}"
           class="nav-item {{ request()->routeIs('client.reclamations*') ? 'active' : '' }}">
            <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
            </svg>
            Reclamations
        </a>
    </div>
    @endif

    {{-- User card at bottom --}}
    <div class="sidebar-bottom">
        <div class="user-card">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
            <div class="user-info">
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">{{ ucfirst(auth()->user()->type_client) }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn" title="Logout">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h6a2 2 0 012 2v1"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>

{{-- ══════════════════════════════════════════════════════════ --}}
{{-- MAIN AREA                                                   --}}
{{-- ══════════════════════════════════════════════════════════ --}}
<div class="main">
    {{-- Top bar --}}
    <div class="topbar">
        <div class="topbar-title">@yield('title','Dashboard')</div>
        <div class="topbar-search">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color:var(--muted);flex-shrink:0">
                <circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="M21 21l-4.35-4.35"/>
            </svg>
            <input type="text" placeholder="Search...">
        </div>
        <div class="topbar-btn" title="Notifications">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
        </div>
    </div>

    {{-- Page content --}}
    <div class="page-content">
        @if(session('success'))
            <div class="flash success">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="flash error">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                </svg>
                <div>
                    @foreach($errors->all() as $e) <div>{{ $e }}</div> @endforeach
                </div>
            </div>
        @endif

        @yield('content')
    </div>
</div>

@else
{{-- Not logged in — just render page (login/register) --}}
<div style="width:100%;min-height:100vh;display:flex;align-items:center;justify-content:center;background:var(--bg)">
    @yield('content')
</div>
@endauth

</body>
</html>
