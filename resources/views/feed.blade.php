<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Org Feed - eKalinga Style</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.44.0/tabler-icons.min.css">

    <style>
        :root {
            /* ===== eKalinga Palette ===== */
            --sage: #5c7a6e;
            --sage-light: #8aab9c;
            --sage-pale: #d6e8e1;

            --cream: #f5f0e8;
            --warm: #e8dfd0;

            --dusk: #2e3d35;

            --gold: #c9a84c;
            --gold-pale: #f0e8d0;

            --text: #2e3d35;
            --muted: #7a8e85;

            --radius: 16px;
            --shadow: 0 6px 20px rgba(46, 61, 53, 0.08);

            font-family: 'DM Sans', sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--cream);
            color: var(--text);
        }

        /* ===== TOP NAV ===== */
        .topnav {
            height: 65px;
            display: flex;
            align-items: center;
            padding: 0 20px;
            background: rgba(245, 240, 232, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--warm);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .topnav-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            color: var(--dusk);
        }

        .topnav-logo-icon {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--sage), var(--gold));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .topnav-role-btn {
            padding: 6px 14px;
            border-radius: 20px;
            border: 1px solid var(--warm);
            background: white;
            color: var(--muted);
            cursor: pointer;
        }

        .topnav-role-btn.active {
            background: linear-gradient(135deg, var(--sage), #3d5c50);
            color: white;
        }

        /* ===== LAYOUT ===== */
        .page-wrap {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
            display: grid;
            grid-template-columns: 260px 1fr 260px;
            gap: 20px;
        }

        /* ===== SIDEBAR ===== */
        .sidebar-left,
        .sidebar-right {
            position: sticky;
            top: 85px;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .org-card,
        .widget-card {
            background: white;
            border: 1px solid var(--warm);
            border-radius: var(--radius);
            padding: 14px;
            box-shadow: var(--shadow);
        }

        /* ===== CENTER FEED ===== */
        .feed-center {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        /* FILTER */
        .filter-bar {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 8px 14px;
            border-radius: 999px;
            border: 1px solid var(--warm);
            background: white;
            color: var(--muted);
            cursor: pointer;
        }

        .filter-btn.active {
            background: linear-gradient(135deg, var(--sage), #3d5c50);
            color: white;
        }

        /* COMPOSE */
        .compose-card {
            background: white;
            border: 1px solid var(--warm);
            border-radius: var(--radius);
            padding: 14px;
            box-shadow: var(--shadow);
        }

        .compose-trigger {
            padding: 10px 14px;
            border-radius: 999px;
            background: var(--sage-pale);
            color: var(--muted);
            cursor: pointer;
        }

        .btn-primary {
            margin-top: 10px;
            background: linear-gradient(135deg, var(--sage), #3d5c50);
            color: white;
            border: none;
            padding: 9px 16px;
            border-radius: 10px;
            cursor: pointer;
        }

        /* POSTS */
        .post-card {
            background: white;
            border: 1px solid var(--warm);
            border-radius: var(--radius);
            padding: 14px;
            box-shadow: var(--shadow);
            transition: .2s;
        }

        .post-card:hover {
            transform: translateY(-2px);
        }

        /* TEXT */
        .muted {
            color: var(--muted);
            font-size: 13px;
        }

        /* RESPONSIVE */
        @media(max-width: 900px) {
            .page-wrap {
                grid-template-columns: 1fr;
            }

            .sidebar-left,
            .sidebar-right {
                display: none;
            }
        }
    </style>

</head>

<body>

    <!-- TOP NAV -->
    <nav class="topnav">
        <div class="topnav-logo">
            <div class="topnav-logo-icon">
                <i class="ti ti-leaf"></i>
            </div>
            CS Society
        </div>

        <div style="margin-left:auto;display:flex;gap:8px;">
            <button class="topnav-role-btn active">Admin</button>
            <button class="topnav-role-btn">Student</button>
        </div>
    </nav>

    <div class="page-wrap">

        <!-- LEFT -->
        <aside class="sidebar-left">
            <div class="org-card">
                <h3>Computer Society</h3>
                <p class="muted">University Organization Feed</p>
            </div>
        </aside>

        <!-- CENTER -->
        <main class="feed-center">

            <div class="filter-bar">
                <button class="filter-btn active">All</button>
                <button class="filter-btn">Announcements</button>
                <button class="filter-btn">Events</button>
                <button class="filter-btn">Updates</button>
            </div>

            <div class="compose-card">
                <div class="compose-trigger">What's happening?</div>
                <button class="btn-primary">Post</button>
            </div>

            <div class="post-card">
                <h3>Welcome Post</h3>
                <p class="muted">
                    Now fully aligned with eKalinga green-sage UI system.
                </p>
            </div>

        </main>

        <!-- RIGHT -->
        <aside class="sidebar-right">
            <div class="widget-card">
                <h4>Upcoming Events</h4>
                <p class="muted">No events yet</p>
            </div>
        </aside>

    </div>

</body>

</html>