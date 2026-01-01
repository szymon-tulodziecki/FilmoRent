<style>
    body { font-family: 'Manrope', sans-serif; overflow-x: hidden; }
    
    .film-grain {
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        pointer-events: none; z-index: 50; opacity: 0.05;
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
    }

    @keyframes slowZoom {
        0% { transform: scale(1); }
        100% { transform: scale(1.15); }
    }
    .hero-animate { animation: slowZoom 20s infinite alternate ease-in-out; }

    .ambient-glow {
        position: absolute; width: 600px; height: 600px;
        background: radial-gradient(circle, rgba(245,158,11,0.15) 0%, rgba(0,0,0,0) 70%);
        border-radius: 50%; pointer-events: none; z-index: 0;
        filter: blur(60px);
    }

    @keyframes scroll {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    .marquee-container { overflow: hidden; white-space: nowrap; position: relative; }
    .marquee-content { display: inline-flex; animation: scroll 40s linear infinite; gap: 4rem; }
    .marquee-container:hover .marquee-content { animation-play-state: paused; }
    .marquee-mask { mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent); }

    .reveal { opacity: 0; transform: translateY(30px); transition: all 0.8s ease-out; }
    .reveal.active { opacity: 1; transform: translateY(0); }

    .card-hover { transition: all 0.3s ease; }
    .card-hover:hover { transform: translateY(-8px); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); }
    .btn-primary { background: #f59e0b; color: #000; transition: all 0.3s; }
    .btn-primary:hover { background: #d97706; transform: translateY(-2px); }
    .btn-elevated { box-shadow: 0 12px 30px -12px rgba(0,0,0,0.55); border: 1px solid rgba(148,163,184,0.25); background: linear-gradient(135deg, rgba(30,41,59,0.95), rgba(15,23,42,0.95)); transition: all 0.2s ease; }
    .btn-elevated:hover { box-shadow: 0 18px 36px -14px rgba(0,0,0,0.65); transform: translateY(-1px); }
    .btn-elevated-amber { background: linear-gradient(135deg, #f59e0b, #fbbf24); box-shadow: 0 12px 30px -12px rgba(245,158,11,0.65); border: 1px solid rgba(245,158,11,0.45); }
    .btn-elevated-amber:hover { transform: translateY(-1px); box-shadow: 0 18px 36px -14px rgba(245,158,11,0.75); }
    .chip-dark { border: 1px solid rgba(148,163,184,0.2); box-shadow: 0 10px 22px -14px rgba(0,0,0,0.65); background: rgba(15,23,42,0.9); transition: all 0.2s ease; }
    .chip-dark:hover { border-color: rgba(251,191,36,0.45); box-shadow: 0 14px 26px -16px rgba(0,0,0,0.75); transform: translateY(-1px); }
    
    @keyframes shimmer {
        0% { transform: translateX(-150%) skewX(-15deg); }
        100% { transform: translateX(150%) skewX(-15deg); }
    }
    .card-shine::after {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 50%; height: 100%;
        background: linear-gradient(to right, transparent, rgba(255,255,255,0.03), transparent);
        transform: skewX(-15deg) translateX(-150%);
        transition: transform 0.5s;
        pointer-events: none;
    }
    .group:hover .card-shine::after {
        animation: shimmer 1s ease-in-out;
    }


    .skip-to-content {
        position: absolute;
        top: -60px;
        left: 0;
        background: #f59e0b;
        color: #000;
        padding: 8px 12px;
        text-decoration: none;
        z-index: 100;
        border-radius: 0 0 4px 0;
        font-size: 14px;
        font-weight: 600;
    }
    .skip-to-content:focus {
        top: 0;
        transition: top 0.2s ease;
    }

    button:focus, a:focus, input:focus, select:focus, textarea:focus {
        outline: none;
    }
    
    button:focus-visible, a:focus-visible, input:focus-visible, select:focus-visible, textarea:focus-visible {
        outline: 2px solid #f59e0b;
        outline-offset: 2px;
    }

    @media (prefers-reduced-motion: reduce) {
        * {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }

    @media (prefers-contrast: more) {
        body {
            color: #000;
            background-color: #fff;
        }
        .bg-slate-950 {
            background-color: #000;
        }
        .text-slate-100 {
            color: #fff;
        }
    }

    body.high-contrast {
        background-color: #000 !important;
        color: #fff !important;
    }
    body.high-contrast a {
        color: #ffff00 !important;
        text-decoration: underline !important;
    }
    body.high-contrast button {
        border: 2px solid #fff !important;
        background-color: #000 !important;
        color: #fff !important;
    }
    body.high-contrast button:hover {
        background-color: #333 !important;
    }
    body.high-contrast .bg-slate-950 {
        background-color: #000 !important;
    }
    body.high-contrast .text-slate-100 {
        color: #fff !important;
    }
    body.high-contrast .text-slate-300 {
        color: #f0f0f0 !important;
    }
    body.high-contrast .border-slate-800,
    body.high-contrast .border-slate-700,
    body.high-contrast .border-slate-600 {
        border-color: #fff !important;
    }
    body.high-contrast .bg-slate-900,
    body.high-contrast .bg-slate-900\/90,
    body.high-contrast .bg-slate-900\/80,
    body.high-contrast .bg-slate-900\/70,
    body.high-contrast .bg-slate-800,
    body.high-contrast .bg-slate-800\/90,
    body.high-contrast .bg-slate-800\/80,
    body.high-contrast .bg-slate-950\/70,
    body.high-contrast .bg-slate-950\/50 {
        background-color: #000 !important;
    }
    body.high-contrast .text-slate-400,
    body.high-contrast .text-slate-500,
    body.high-contrast .text-slate-600 {
        color: #fff !important;
    }
    body.high-contrast .bg-amber-500,
    body.high-contrast .text-amber-500,
    body.high-contrast .text-amber-400 {
        color: #ffff00 !important;
    }

    body.dyslexia-font {
        font-family: 'Comic Sans MS', 'Comic Sans', cursive, 'Manrope', sans-serif;
        letter-spacing: 0.1em;
        line-height: 1.8;
        word-spacing: 0.16em;
    }
    body.dyslexia-font p {
        text-align: left !important;
        margin-bottom: 1.5em;
    }
    body.dyslexia-font h1, body.dyslexia-font h2, body.dyslexia-font h3 {
        letter-spacing: 0.05em;
        margin-bottom: 1.5em;
    }

    @media (prefers-large-text: true) {
        body { font-size: 18px; }
        h1 { font-size: 2.5rem; }
        h2 { font-size: 2rem; }
        button, a { padding: 12px 16px; }
    }

    @media (prefers-color-scheme: dark) {
        ::-webkit-scrollbar {
            background: #1e293b;
        }
        ::-webkit-scrollbar-thumb {
            background: #475569;
        }
    }
</style>
