{{-- resources/views/feed/index.blade.php --}}
@extends('dashboard.layout')

@section('title', 'Organization Feed')

@section('content')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.44.0/tabler-icons.min.css" />

    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --forest: #1a3d2b;
            --forest-mid: #2d6a4f;
            --forest-light: #52b788;
            --forest-pale: #d8f3dc;
            --mint: #b7e4c7;
            --sage: #74c69d;
            --cream: #f0faf3;
            --white: #ffffff;
            --bark: #1b2d22;
            --text: #1b2d22;
            --text-mid: #4a6358;
            --text-soft: #7a9e8a;
            --border: rgba(45, 106, 79, 0.13);
            --shadow-sm: 0 2px 12px rgba(26, 61, 43, 0.08);
            --shadow-md: 0 6px 28px rgba(26, 61, 43, 0.13);
            --shadow-lg: 0 16px 48px rgba(26, 61, 43, 0.18);
            --radius: 14px;
            --radius-sm: 8px;
            --font-body: 'DM Sans', system-ui, sans-serif;
        }

        /* ── KEYFRAMES ─────────────────────────────────────────── */
        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(22px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes popIn {
            0% {
                opacity: 0;
                transform: scale(.82);
            }

            70% {
                transform: scale(1.06);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes pulse-dot {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(82, 183, 136, .55);
            }

            50% {
                box-shadow: 0 0 0 7px rgba(82, 183, 136, 0);
            }
        }

        @keyframes leaf-drift {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            90% {
                opacity: .6;
            }

            100% {
                transform: translateY(-100vh) rotate(720deg);
                opacity: 0;
            }
        }

        @keyframes ripple {
            to {
                transform: scale(3.5);
                opacity: 0;
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes toastIn {
            from {
                opacity: 0;
                transform: translateY(20px) scale(.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes toastOut {
            from {
                opacity: 1;
                transform: translateY(0) scale(1);
            }

            to {
                opacity: 0;
                transform: translateY(20px) scale(.95);
            }
        }

        @keyframes commentSlideIn {
            from {
                opacity: 0;
                transform: translateX(-12px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* ── LEAF PARTICLES ─────────────────────────────────────── */
        .leaf-canvas {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }

        .leaf {
            position: absolute;
            bottom: -40px;
            font-size: 18px;
            opacity: 0;
            animation: leaf-drift linear infinite;
        }

        /* ── LAYOUT ─────────────────────────────────────────────── */
        .feed-shell {
            position: relative;
            z-index: 1;
            font-family: var(--font-body);
            background: var(--cream);
            min-height: 100vh;
        }

        /* ── TOP ORG BANNER ─────────────────────────────────────── */
        .org-topbar {
            background: linear-gradient(135deg, var(--forest) 0%, var(--forest-mid) 60%, var(--forest-light) 100%);
            padding: 18px 28px;
            display: flex;
            align-items: center;
            gap: 16px;
            position: relative;
            overflow: hidden;
            animation: fadeIn .5s ease both;
        }

        .org-topbar::before {
            content: '';
            position: absolute;
            inset: 0;
            background: repeating-linear-gradient(45deg, transparent, transparent 18px,
                    rgba(255, 255, 255, .03) 18px, rgba(255, 255, 255, .03) 36px);
        }

        .org-topbar-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: rgba(255, 255, 255, .18);
            backdrop-filter: blur(8px);
            border: 1.5px solid rgba(255, 255, 255, .28);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 800;
            font-size: 16px;
            letter-spacing: .04em;
            flex-shrink: 0;
            box-shadow: 0 4px 16px rgba(0, 0, 0, .18);
        }

        .org-topbar-info {
            flex: 1;
        }

        .org-topbar-name {
            color: #fff;
            font-size: 18px;
            font-weight: 700;
            line-height: 1.2;
        }

        .org-topbar-sub {
            color: rgba(255, 255, 255, .65);
            font-size: 12px;
            margin-top: 2px;
        }

        .org-topbar-stats {
            display: flex;
            gap: 20px;
        }

        .org-stat {
            text-align: center;
        }

        .org-stat-num {
            color: #fff;
            font-size: 20px;
            font-weight: 800;
            line-height: 1;
        }

        .org-stat-lbl {
            color: rgba(255, 255, 255, .6);
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .08em;
            margin-top: 2px;
        }

        /* ── PAGE GRID ──────────────────────────────────────────── */
        .page-wrap {
            max-width: 1160px;
            margin: 0 auto;
            padding: 24px 16px;
            display: grid;
            grid-template-columns: 220px 1fr 220px;
            gap: 20px;
            align-items: start;
        }

        /* ── SIDEBAR PANELS ─────────────────────────────────────── */
        .side-panel {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            animation: fadeSlideUp .5s ease both;
        }

        .nav-list {
            padding: 8px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 10px;
            color: var(--text-mid);
            font-size: 13.5px;
            font-weight: 500;
            text-decoration: none;
            transition: all .2s ease;
            position: relative;
            overflow: hidden;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            inset: 0;
            background: var(--forest-pale);
            opacity: 0;
            transition: opacity .2s;
            border-radius: 10px;
        }

        .nav-link:hover::after {
            opacity: 1;
        }

        .nav-link:hover {
            color: var(--forest-mid);
            transform: translateX(3px);
        }

        .nav-link.active {
            background: linear-gradient(135deg, var(--forest-mid), var(--forest-light));
            color: #fff;
            box-shadow: 0 4px 14px rgba(45, 106, 79, .35);
        }

        .nav-link.active::after {
            display: none;
        }

        .nav-link i {
            font-size: 17px;
            position: relative;
            z-index: 1;
        }

        .nav-link span {
            position: relative;
            z-index: 1;
        }

        .widget-title {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--text-soft);
            padding: 16px 16px 8px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 4px;
        }

        .widget-body {
            padding: 12px 16px 16px;
        }

        .event-row {
            display: flex;
            gap: 10px;
            align-items: flex-start;
            padding: 10px 0;
            border-bottom: 1px dashed var(--border);
            animation: fadeSlideUp .4s ease both;
        }

        .event-row:last-child {
            border-bottom: none;
        }

        .event-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--forest-light);
            margin-top: 5px;
            flex-shrink: 0;
            animation: pulse-dot 2s infinite;
        }

        .event-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--text);
        }

        .event-meta {
            font-size: 11px;
            color: var(--text-soft);
            margin-top: 2px;
        }

        .no-data {
            font-size: 13px;
            color: var(--text-soft);
            padding: 12px 0;
            text-align: center;
        }

        /* ── FEED CENTER ────────────────────────────────────────── */
        .feed-center {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        /* ── FLASH ──────────────────────────────────────────────── */
        .flash {
            padding: 12px 16px;
            background: var(--forest-pale);
            color: var(--forest);
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 500;
            border-left: 4px solid var(--forest-light);
            animation: slideDown .35s ease both;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ── TOAST NOTIFICATION ─────────────────────────────────── */
        #toast-container {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            pointer-events: none;
        }

        .toast {
            padding: 12px 18px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 9px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .15);
            pointer-events: all;
            animation: toastIn .3s ease both;
            min-width: 220px;
            max-width: 340px;
        }

        .toast.success {
            background: linear-gradient(135deg, var(--forest-mid), var(--forest-light));
            color: #fff;
        }

        .toast.error {
            background: #fff0f0;
            color: #c0392b;
            border: 1px solid #ffc0c0;
        }

        .toast.hiding {
            animation: toastOut .3s ease both;
        }

        .toast i {
            font-size: 16px;
            flex-shrink: 0;
        }

        /* ── FILTER BAR ─────────────────────────────────────────── */
        .filter-bar {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            animation: fadeSlideUp .4s ease both;
        }

        .filter-btn {
            border: 1.5px solid var(--border);
            background: var(--white);
            padding: 7px 16px;
            border-radius: 24px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-mid);
            transition: all .2s ease;
            position: relative;
            overflow: hidden;
            font-family: var(--font-body);
        }

        .filter-btn::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, var(--forest-mid), var(--forest-light));
            opacity: 0;
            transition: opacity .2s;
        }

        .filter-btn span {
            position: relative;
            z-index: 1;
        }

        .filter-btn:hover {
            border-color: var(--forest-light);
            color: var(--forest-mid);
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        .filter-btn.active {
            border-color: transparent;
            color: #fff;
            box-shadow: 0 4px 14px rgba(45, 106, 79, .35);
        }

        .filter-btn.active::before {
            opacity: 1;
        }

        /* ── COMPOSE CARD ───────────────────────────────────────── */
        .compose-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 18px;
            box-shadow: var(--shadow-sm);
            animation: fadeSlideUp .45s ease both;
            position: relative;
            overflow: hidden;
        }

        .compose-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--forest), var(--forest-light), var(--sage));
        }

        .compose-top {
            display: flex;
            gap: 12px;
            align-items: center;
            margin-bottom: 14px;
        }

        .user-av {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            flex-shrink: 0;
            background: linear-gradient(135deg, var(--forest-mid), var(--forest-light));
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 13px;
            box-shadow: 0 4px 12px rgba(45, 106, 79, .3);
        }

        .compose-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--text);
        }

        .compose-role {
            font-size: 11px;
            color: var(--text-soft);
        }

        .compose-field {
            width: 100%;
            background: var(--cream);
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 13px;
            color: var(--text);
            font-family: var(--font-body);
            outline: none;
            transition: border-color .2s, box-shadow .2s;
            margin-bottom: 10px;
            display: block;
        }

        .compose-field:focus {
            border-color: var(--forest-light);
            box-shadow: 0 0 0 3px rgba(82, 183, 136, .15);
        }

        textarea.compose-field {
            resize: none;
            min-height: 96px;
        }

        .event-fields {
            display: none;
        }

        .event-fields.visible {
            display: block;
            animation: slideDown .25s ease;
        }

        .compose-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 4px;
        }

        .btn {
            padding: 9px 20px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            font-family: var(--font-body);
            transition: all .2s ease;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--forest-mid), var(--forest-light));
            color: #fff;
            box-shadow: 0 4px 14px rgba(45, 106, 79, .35);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(45, 106, 79, .4);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-primary:disabled {
            opacity: .6;
            cursor: not-allowed;
            transform: none;
        }

        .btn-ghost {
            background: var(--cream);
            color: var(--text-mid);
            border: 1.5px solid var(--border);
        }

        .btn-ghost:hover {
            background: var(--forest-pale);
            color: var(--forest-mid);
        }

        .ripple-el {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, .35);
            width: 10px;
            height: 10px;
            animation: ripple .55s linear;
            pointer-events: none;
            transform: scale(1);
        }

        /* ── POST CARD ──────────────────────────────────────────── */
        .post-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: transform .25s ease, box-shadow .25s ease;
            animation: fadeSlideUp .5s ease both;
            position: relative;
        }

        .post-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        .post-card::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
        }

        .post-card[data-type="announcement"]::before {
            background: var(--forest-mid);
        }

        .post-card[data-type="event"]::before {
            background: var(--forest-light);
        }

        .post-card[data-type="update"]::before {
            background: var(--sage);
        }

        .post-header {
            display: flex;
            gap: 12px;
            padding: 16px 16px 8px 20px;
            align-items: flex-start;
        }

        .post-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            flex-shrink: 0;
            background: linear-gradient(135deg, var(--forest-mid), var(--forest-light));
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            box-shadow: 0 3px 10px rgba(45, 106, 79, .25);
        }

        .post-meta {
            flex: 1;
        }

        .post-author {
            font-size: 14px;
            font-weight: 700;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .post-time {
            font-size: 12px;
            color: var(--text-soft);
            margin-top: 2px;
        }

        .type-badge {
            font-size: 10px;
            font-weight: 700;
            padding: 2px 9px;
            border-radius: 20px;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .type-badge.announcement {
            background: #e8f4ec;
            color: var(--forest-mid);
        }

        .type-badge.event {
            background: var(--forest-pale);
            color: #1a5c3a;
        }

        .type-badge.update {
            background: #f0faf3;
            color: var(--forest-light);
            border: 1px solid var(--mint);
        }

        .post-body {
            padding: 0 16px 12px 20px;
        }

        .post-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 6px;
        }

        .post-text {
            font-size: 14px;
            color: var(--text-mid);
            line-height: 1.75;
            white-space: pre-line;
        }

        .event-block {
            margin-top: 12px;
            padding: 10px 14px;
            background: var(--forest-pale);
            border-radius: 10px;
            font-size: 13px;
            color: var(--forest);
            border-left: 3px solid var(--forest-light);
        }

        .event-block div {
            margin-bottom: 4px;
        }

        .event-block div:last-child {
            margin-bottom: 0;
        }

        /* ── REACTIONS ──────────────────────────────────────────── */
        .reactions-bar {
            display: flex;
            gap: 6px;
            padding: 10px 16px 8px 20px;
            flex-wrap: wrap;
        }

        .reaction-btn {
            border: 1.5px solid var(--border);
            background: var(--white);
            padding: 5px 12px;
            border-radius: 24px;
            cursor: pointer;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: all .2s ease;
            position: relative;
            overflow: hidden;
            font-family: var(--font-body);
        }

        .reaction-btn:hover {
            border-color: var(--forest-light);
            background: var(--forest-pale);
            transform: translateY(-2px) scale(1.06);
            box-shadow: 0 4px 12px rgba(45, 106, 79, .18);
        }

        .reaction-btn.reacted {
            background: linear-gradient(135deg, var(--forest-pale), var(--mint));
            border-color: var(--forest-light);
            color: var(--forest);
            box-shadow: 0 3px 10px rgba(45, 106, 79, .2);
            animation: popIn .3s ease both;
        }

        .reaction-count {
            font-size: 12px;
            font-weight: 700;
            color: var(--text-mid);
        }

        .reaction-btn.reacted .reaction-count {
            color: var(--forest);
        }

        /* ── POST ACTIONS ───────────────────────────────────────── */
        .post-actions {
            display: flex;
            gap: 4px;
            padding: 8px 12px 8px 16px;
            border-top: 1px solid var(--border);
        }

        .action-btn {
            border: none;
            background: transparent;
            cursor: pointer;
            color: var(--text-soft);
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 500;
            padding: 7px 12px;
            border-radius: 9px;
            transition: all .18s ease;
            font-family: var(--font-body);
            position: relative;
            overflow: hidden;
        }

        .action-btn:hover {
            background: var(--forest-pale);
            color: var(--forest-mid);
            transform: translateY(-1px);
        }

        .action-btn i {
            font-size: 16px;
        }

        /* ── COMMENTS ───────────────────────────────────────────── */
        .comments-section {
            display: none;
            padding: 0 16px 16px 20px;
            border-top: 1px solid var(--border);
        }

        .comments-section.open {
            display: block;
            animation: slideDown .25s ease both;
        }

        .comment-form {
            display: flex;
            gap: 10px;
            margin: 14px 0 12px;
            align-items: center;
        }

        .comment-av-sm {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            flex-shrink: 0;
            background: linear-gradient(135deg, var(--forest-mid), var(--sage));
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .comment-input {
            flex: 1;
            background: var(--cream);
            border: 1.5px solid var(--border);
            border-radius: 24px;
            padding: 9px 16px;
            font-size: 13px;
            font-family: var(--font-body);
            outline: none;
            transition: border-color .2s, box-shadow .2s;
            color: var(--text);
        }

        .comment-input:focus {
            border-color: var(--forest-light);
            box-shadow: 0 0 0 3px rgba(82, 183, 136, .12);
        }

        .comment-input:disabled {
            opacity: .6;
            cursor: not-allowed;
        }

        .comment-submit {
            background: linear-gradient(135deg, var(--forest-mid), var(--forest-light));
            color: #fff;
            border: none;
            border-radius: 24px;
            padding: 9px 18px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            white-space: nowrap;
            font-family: var(--font-body);
            transition: all .2s;
            box-shadow: 0 3px 10px rgba(45, 106, 79, .28);
        }

        .comment-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 14px rgba(45, 106, 79, .35);
        }

        .comment-submit:disabled {
            opacity: .6;
            cursor: not-allowed;
            transform: none;
        }

        .comment-item {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
            align-items: flex-start;
            animation: commentSlideIn .3s ease both;
        }

        .comment-av {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            flex-shrink: 0;
            background: linear-gradient(135deg, var(--forest-mid), var(--sage));
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .comment-bubble {
            background: var(--cream);
            padding: 9px 13px;
            border-radius: 0 12px 12px 12px;
            flex: 1;
            border: 1px solid var(--border);
        }

        .comment-author {
            font-size: 12px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 3px;
        }

        .comment-text {
            font-size: 13px;
            color: var(--text-mid);
            line-height: 1.6;
        }

        .comment-time {
            font-size: 11px;
            color: var(--text-soft);
            margin-top: 4px;
        }

        .no-comments {
            font-size: 13px;
            color: var(--text-soft);
            padding: 10px 0;
            text-align: center;
        }

        /* ── EMPTY STATE ────────────────────────────────────────── */
        .empty-state {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 56px 24px;
            text-align: center;
            box-shadow: var(--shadow-sm);
            animation: fadeSlideUp .5s ease both;
        }

        .empty-icon {
            width: 72px;
            height: 72px;
            border-radius: 20px;
            margin: 0 auto 18px;
            background: var(--forest-pale);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: var(--forest-light);
        }

        .empty-title {
            font-size: 17px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 6px;
        }

        .empty-sub {
            font-size: 14px;
            color: var(--text-soft);
        }

        /* ── STAGGER DELAYS ─────────────────────────────────────── */
        .post-card:nth-child(1) {
            animation-delay: .05s;
        }

        .post-card:nth-child(2) {
            animation-delay: .10s;
        }

        .post-card:nth-child(3) {
            animation-delay: .15s;
        }

        .post-card:nth-child(4) {
            animation-delay: .20s;
        }

        .post-card:nth-child(5) {
            animation-delay: .25s;
        }

        .side-panel:nth-child(1) {
            animation-delay: .08s;
        }

        .side-panel:nth-child(2) {
            animation-delay: .14s;
        }

        /* ── RESPONSIVE ─────────────────────────────────────────── */
        @media(max-width:1020px) {
            .page-wrap {
                grid-template-columns: 200px 1fr;
            }

            .sidebar-right {
                display: none;
            }
        }

        @media(max-width:720px) {
            .page-wrap {
                grid-template-columns: 1fr;
            }

            .sidebar-left {
                display: none;
            }

            .org-topbar-stats {
                display: none;
            }
        }
    </style>

    <!-- TOAST CONTAINER -->
    <div id="toast-container"></div>

    <!-- LEAF PARTICLES -->
    <div class="leaf-canvas" id="leafCanvas"></div>

    <div class="feed-shell">

        <!-- ORG TOP BANNER -->
        <div class="org-topbar">
            <div class="org-topbar-icon">EK</div>
            <div class="org-topbar-info">
                <div class="org-topbar-name">E-KALINGA</div>
                <div class="org-topbar-sub">University Student Organization</div>
            </div>
            <div class="org-topbar-stats">
                <div class="org-stat">
                    <div class="org-stat-num">{{ $posts->count() }}</div>
                    <div class="org-stat-lbl">Posts</div>
                </div>
                <div class="org-stat">
                    <div class="org-stat-num">248</div>
                    <div class="org-stat-lbl">Members</div>
                </div>
                <div class="org-stat">
                    <div class="org-stat-num">{{ $posts->where('type', 'event')->count() }}</div>
                    <div class="org-stat-lbl">Events</div>
                </div>
            </div>
        </div>

        <div class="page-wrap">

            <!-- LEFT SIDEBAR -->
            <aside class="sidebar-left" style="display:flex;flex-direction:column;gap:14px;">
                <div class="side-panel">
                    <div class="nav-list">
                        <a href="#" class="nav-link active">
                            <i class="ti ti-layout-list"></i><span>Feed</span>
                        </a>
                        <a href="#" class="nav-link">
                            <i class="ti ti-calendar-event"></i><span>Events</span>
                        </a>
                        <a href="#" class="nav-link">
                            <i class="ti ti-users"></i><span>Members</span>
                        </a>
                        <a href="#" class="nav-link">
                            <i class="ti ti-photo"></i><span>Gallery</span>
                        </a>
                    </div>
                </div>
            </aside>

            <!-- CENTER FEED -->
            <main class="feed-center">

                @if(session('success'))
                    <div class="flash">
                        <i class="ti ti-circle-check" style="font-size:16px;"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <!-- FILTER BAR -->
                <div class="filter-bar">
                    <button class="filter-btn active" data-filter="all"><span>All Posts</span></button>
                    <button class="filter-btn" data-filter="announcement"><span>📢 Announcements</span></button>
                    <button class="filter-btn" data-filter="event"><span>📅 Events</span></button>
                    <button class="filter-btn" data-filter="update"><span>🔄 Updates</span></button>
                </div>

                <!-- COMPOSE — ADMIN ONLY -->
                @if(Auth::user()->role == 'admin')
                    <div class="compose-card">
                        <div class="compose-top">
                            <div class="user-av">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                            <div>
                                <div class="compose-name">{{ Auth::user()->name }}</div>
                                <div class="compose-role">Organization Admin</div>
                            </div>
                        </div>

                        <form action="{{ route('feed.store') }}" method="POST">
                            @csrf
                            <input type="text" name="title" class="compose-field" placeholder="Post title (optional)">
                            <textarea name="body" class="compose-field" placeholder="Share an announcement, event, or update…"
                                required></textarea>

                            <select name="type" class="compose-field" id="postTypeSelect" required style="cursor:pointer;">
                                <option value="" disabled selected>Select post type…</option>
                                <option value="announcement">📢 Announcement</option>
                                <option value="event">📅 Event</option>
                                <option value="update">🔄 Update</option>
                            </select>

                            <div class="event-fields" id="eventFields">
                                <input type="text" name="event_date" class="compose-field"
                                    placeholder="Event date (e.g. June 28, 2025)">
                                <input type="text" name="event_location" class="compose-field"
                                    placeholder="Event location (e.g. Auditorium)">
                            </div>

                            <div class="compose-actions">
                                <button type="reset" class="btn btn-ghost"
                                    onclick="document.getElementById('eventFields').classList.remove('visible')">
                                    Cancel
                                </button>
                                <button type="submit" class="btn btn-primary" onclick="addRipple(event,this)">
                                    <i class="ti ti-send"></i> Publish
                                </button>
                            </div>
                        </form>
                    </div>
                @endif

                <!-- POSTS -->
                @forelse($posts as $post)
                    @php
                        $userReactions = $post->reactions->where('user_id', Auth::id())->pluck('emoji')->toArray();
                        $reactionCounts = $post->reactions->groupBy('emoji')->map->count();
                        $commentCount = $post->comments->count();
                    @endphp

                    <div class="post-card" id="post-{{ $post->id }}" data-type="{{ $post->type }}">

                        <div class="post-header">
                            <div class="post-avatar">{{ strtoupper(substr($post->user->name, 0, 2)) }}</div>
                            <div class="post-meta">
                                <div class="post-author">
                                    {{ $post->user->name }}
                                    <span class="type-badge {{ $post->type }}">{{ ucfirst($post->type) }}</span>
                                </div>
                                <div class="post-time">{{ $post->created_at->diffForHumans() }}</div>
                            </div>
                        </div>

                        <div class="post-body">
                            @if($post->title)
                                <div class="post-title">{{ $post->title }}</div>
                            @endif
                            <div class="post-text">{{ $post->body }}</div>

                            @if($post->event_date || $post->event_location)
                                <div class="event-block">
                                    @if($post->event_date)
                                    <div>📅 {{ $post->event_date }}</div>@endif
                                    @if($post->event_location)
                                    <div>📍 {{ $post->event_location }}</div>@endif
                                </div>
                            @endif
                        </div>

                        <!-- REACTIONS -->
                        <div class="reactions-bar" id="reactions-{{ $post->id }}">
                            @foreach(['👍', '❤️', '🎉', '👏', '🔥'] as $emoji)
                                @php
                                    $count = $reactionCounts[$emoji] ?? 0;
                                    $reacted = in_array($emoji, $userReactions);
                                @endphp
                                <button class="reaction-btn {{ $reacted ? 'reacted' : '' }}" data-post="{{ $post->id }}"
                                    data-emoji="{{ $emoji }}" onclick="toggleReaction(this)">
                                    {{ $emoji }}
                                    <span class="reaction-count">{{ $count > 0 ? $count : '' }}</span>
                                </button>
                            @endforeach
                        </div>

                        <!-- ACTIONS -->
                        <div class="post-actions">
                            <button class="action-btn" onclick="toggleComments({{ $post->id }})">
                                <i class="ti ti-message-circle"></i>
                                Comments
                                <span id="comment-count-{{ $post->id }}">
                                    {{ $commentCount > 0 ? "($commentCount)" : '' }}
                                </span>
                            </button>
                        </div>

                        <!-- COMMENTS SECTION -->
                        <div class="comments-section" id="comments-{{ $post->id }}">
                            <form class="comment-form" onsubmit="submitComment(event, {{ $post->id }})">
                                @csrf
                                <div class="comment-av-sm">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                                <input type="text" class="comment-input" id="comment-input-{{ $post->id }}"
                                    placeholder="Write a comment…" autocomplete="off" required>
                                <button type="submit" class="comment-submit" id="comment-btn-{{ $post->id }}">
                                    Send
                                </button>
                            </form>

                            <div id="comment-list-{{ $post->id }}">
                                @forelse($post->comments as $comment)
                                    <div class="comment-item">
                                        <div class="comment-av">{{ strtoupper(substr($comment->user->name, 0, 2)) }}</div>
                                        <div class="comment-bubble">
                                            <div class="comment-author">{{ $comment->user->name }}</div>
                                            <div class="comment-text">{{ $comment->comment }}</div>
                                            <div class="comment-time">{{ $comment->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="no-comments" id="no-comments-{{ $post->id }}">No comments yet. Be the first!</p>
                                @endforelse
                            </div>
                        </div>

                    </div>
                @empty

                    <div class="empty-state">
                        <div class="empty-icon"><i class="ti ti-inbox"></i></div>
                        <div class="empty-title">No posts available</div>
                        <div class="empty-sub">
                            @if(Auth::user()->role == 'admin')
                                Create your first organization post above.
                            @else
                                No posts have been published yet.
                            @endif
                        </div>
                    </div>

                @endforelse

            </main>

            <!-- RIGHT SIDEBAR -->
            <aside class="sidebar-right" style="display:flex;flex-direction:column;gap:14px;">
                <div class="side-panel">
                    <div class="widget-title">Upcoming Events</div>
                    <div class="widget-body">
                        @php
                            $upcomingEvents = $posts->where('type', 'event')->sortByDesc('created_at')->take(5);
                        @endphp
                        @forelse($upcomingEvents as $ev)
                            <div class="event-row">
                                <div class="event-dot"></div>
                                <div>
                                    <div class="event-name">{{ $ev->title ?? $ev->body }}</div>
                                    <div class="event-meta">
                                        @if($ev->event_date) 📅 {{ $ev->event_date }} @endif
                                        @if($ev->event_location) · 📍 {{ $ev->event_location }} @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="no-data">No upcoming events.</p>
                        @endforelse
                    </div>
                </div>
            </aside>

        </div>
    </div>

    <script>
        // ── CSRF ──────────────────────────────────────────────────────
        const CSRF = document.querySelector('meta[name="csrf-token"]')?.content ?? '{{ csrf_token() }}';

        // ── TOAST ─────────────────────────────────────────────────────
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            toast.innerHTML = type === 'success'
                ? `<i class="ti ti-circle-check"></i> ${escHtml(message)}`
                : `<i class="ti ti-alert-circle"></i> ${escHtml(message)}`;
            container.appendChild(toast);
            setTimeout(() => {
                toast.classList.add('hiding');
                setTimeout(() => toast.remove(), 320);
            }, 3500);
        }

        // ── LEAF PARTICLES ────────────────────────────────────────────
        (function spawnLeaves() {
            const canvas = document.getElementById('leafCanvas');
            const emojis = ['🌿', '🍃', '🌱', '🍀', '🌾'];
            function spawn() {
                const el = document.createElement('span');
                el.className = 'leaf';
                el.textContent = emojis[Math.floor(Math.random() * emojis.length)];
                el.style.left = Math.random() * 100 + 'vw';
                el.style.fontSize = (12 + Math.random() * 14) + 'px';
                const dur = 14 + Math.random() * 18;
                el.style.animationDuration = dur + 's';
                el.style.animationDelay = (Math.random() * 8) + 's';
                canvas.appendChild(el);
                setTimeout(() => el.remove(), (dur + 8) * 1000);
            }
            for (let i = 0; i < 10; i++) spawn();
            setInterval(spawn, 3500);
        })();

        // ── RIPPLE ───────────────────────────────────────────────────
        function addRipple(e, btn) {
            const r = document.createElement('span');
            r.className = 'ripple-el';
            const rect = btn.getBoundingClientRect();
            r.style.left = (e.clientX - rect.left - 5) + 'px';
            r.style.top = (e.clientY - rect.top - 5) + 'px';
            btn.appendChild(r);
            setTimeout(() => r.remove(), 600);
        }

        // ── FILTER ───────────────────────────────────────────────────
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                const filter = btn.dataset.filter;
                document.querySelectorAll('.post-card').forEach(card => {
                    card.style.display = (filter === 'all' || card.dataset.type === filter) ? '' : 'none';
                });
            });
        });

        // ── TYPE SELECT ───────────────────────────────────────────────
        const typeSelect = document.getElementById('postTypeSelect');
        if (typeSelect) {
            typeSelect.addEventListener('change', () => {
                document.getElementById('eventFields')
                    .classList.toggle('visible', typeSelect.value === 'event');
            });
        }

        // ── TOGGLE COMMENTS ───────────────────────────────────────────
        function toggleComments(postId) {
            const sec = document.getElementById('comments-' + postId);
            sec.classList.toggle('open');
            if (sec.classList.contains('open'))
                document.getElementById('comment-input-' + postId)?.focus();
        }

        // ── SUBMIT COMMENT ────────────────────────────────────────────
        async function submitComment(e, postId) {
            e.preventDefault();

            const input = document.getElementById('comment-input-' + postId);
            const btn = document.getElementById('comment-btn-' + postId);
            const text = input.value.trim();
            if (!text) return;

            // Loading state
            input.disabled = true;
            btn.disabled = true;
            btn.textContent = '…';

            try {
                const res = await fetch(`/feed/${postId}/comment`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ comment: text }),
                });

                const data = await res.json();

                if (!res.ok || !data.success) {
                    throw new Error(data.message ?? 'Server error ' + res.status);
                }

                // Remove "no comments" placeholder if present
                document.getElementById('no-comments-' + postId)?.remove();

                // Build and append new comment with animation
                const list = document.getElementById('comment-list-' + postId);
                const initials = (data.comment.user?.name ?? '??').substring(0, 2).toUpperCase();
                const div = document.createElement('div');
                div.className = 'comment-item';
                div.innerHTML = `
                    <div class="comment-av">${initials}</div>
                    <div class="comment-bubble">
                        <div class="comment-author">${escHtml(data.comment.user.name)}</div>
                        <div class="comment-text">${escHtml(data.comment.comment)}</div>
                        <div class="comment-time">${escHtml(data.comment.created_at)}</div>
                    </div>
                `;
                list.appendChild(div);

                // Update comment count badge
                const cEl = document.getElementById('comment-count-' + postId);
                if (cEl) {
                    const cur = parseInt(cEl.textContent.replace(/\D/g, '')) || 0;
                    cEl.textContent = `(${cur + 1})`;
                }

                // Clear input
                input.value = '';

                // Success toast
                showToast('Comment posted!', 'success');

            } catch (err) {
                console.error('Comment error:', err);
                showToast(err.message ?? 'Could not post comment. Please try again.', 'error');
            } finally {
                input.disabled = false;
                btn.disabled = false;
                btn.textContent = 'Send';
                input.focus();
            }
        }

        // ── TOGGLE REACTION ───────────────────────────────────────────
        async function toggleReaction(btn) {
            const postId = btn.dataset.post;
            const emoji = btn.dataset.emoji;
            try {
                const res = await fetch(`/feed/${postId}/react`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ emoji }),
                });
                const data = await res.json();
                if (!data.success) throw new Error();

                btn.classList.toggle('reacted', data.reacted);
                const cEl = btn.querySelector('.reaction-count');
                const cur = parseInt(cEl.textContent) || 0;
                const next = data.reacted ? cur + 1 : Math.max(0, cur - 1);
                cEl.textContent = next > 0 ? next : '';
            } catch (err) {
                console.error('Reaction error:', err);
            }
        }

        // ── UTIL ──────────────────────────────────────────────────────
        function escHtml(str) {
            return String(str ?? '')
                .replace(/&/g, '&amp;').replace(/</g, '&lt;')
                .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
        }
    </script>

@endsection