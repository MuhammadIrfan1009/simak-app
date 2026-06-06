<x-guest-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap');

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            background: #fff;
            display: flex;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* ── LEFT PANEL ── */
        .lp {
            width: 420px;
            flex-shrink: 0;
            background: #1E1B3A;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
        }

        .lp-svg {
            position: absolute;
            inset: 0;
            width: 100%; height: 100%;
        }

        .lp-content {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            height: 100%;
            padding: 2.5rem 2.25rem;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .brand-icon {
            width: 40px; height: 40px;
            background: #4F46C8;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .brand-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: #fff;
            letter-spacing: 0.06em;
        }

        .brand-sub {
            font-size: 0.62rem;
            color: rgba(255,255,255,0.35);
            letter-spacing: 0.18em;
            text-transform: uppercase;
            margin-top: 1px;
        }

        .lp-middle {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 2rem 0;
        }

        .lp-tagline {
            font-size: 1.6rem;
            font-weight: 600;
            color: #fff;
            line-height: 1.35;
            letter-spacing: -0.01em;
            max-width: 240px;
        }

        .lp-tagline span {
            color: #7C6FF7;
        }

        .lp-desc {
            font-size: 0.82rem;
            color: rgba(255,255,255,0.38);
            line-height: 1.65;
            margin-top: 1rem;
            max-width: 220px;
        }

        .lp-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 2rem;
        }

        .pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 99px;
            font-size: 0.72rem;
            font-weight: 500;
            border: 1px solid rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.55);
            background: rgba(255,255,255,0.05);
        }

        .pill-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .lp-footer {
            font-size: 0.68rem;
            color: rgba(255,255,255,0.2);
            letter-spacing: 0.04em;
        }

        /* ── RIGHT PANEL ── */
        .rp {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: #fff;
            padding: 2.5rem 2rem;
        }

        .form-box {
            width: 100%;
            max-width: 380px;
        }

        .form-eyebrow {
            font-size: 0.68rem;
            font-weight: 600;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: #4F46C8;
            margin-bottom: 8px;
        }

        .form-title {
            font-size: 1.6rem;
            font-weight: 600;
            color: #1E1B3A;
            line-height: 1.2;
        }

        .form-sub {
            font-size: 0.82rem;
            color: #9CA3AF;
            margin-top: 6px;
            margin-bottom: 2rem;
        }

        .field { margin-bottom: 1rem; }

        .field label {
            display: block;
            font-size: 0.75rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 6px;
        }

        .iw { position: relative; }

        .ico {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #C4C9D4;
            pointer-events: none;
            display: flex;
            align-items: center;
        }

        .field input[type=email],
        .field input[type=password] {
            width: 100%;
            padding: 11px 12px 11px 38px;
            border: 1.5px solid #EAECF0;
            border-radius: 10px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.875rem;
            color: #1E1B3A;
            background: #FAFAFA;
            outline: none;
            transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
            -webkit-appearance: none;
        }

        .field input:focus {
            border-color: #4F46C8;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(79,70,200,0.1);
        }

        .field input::placeholder { color: #D1D5DB; }

        .field-error {
            font-size: 0.73rem;
            color: #EF4444;
            margin-top: 4px;
        }

        .row-mid {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 0.25rem 0 1.5rem;
        }

        .ck-label {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 0.8rem;
            color: #6B7280;
            cursor: pointer;
        }

        .ck-label input[type=checkbox] {
            appearance: none;
            -webkit-appearance: none;
            width: 16px; height: 16px;
            border: 1.5px solid #D1D5DB;
            border-radius: 4px;
            background: #fff;
            cursor: pointer;
            position: relative;
            flex-shrink: 0;
            transition: all 0.15s;
        }

        .ck-label input[type=checkbox]:checked {
            background: #4F46C8;
            border-color: #4F46C8;
        }

        .ck-label input[type=checkbox]:checked::after {
            content: '';
            position: absolute;
            left: 4px; top: 1px;
            width: 5px; height: 9px;
            border: 1.5px solid #fff;
            border-left: none; border-top: none;
            transform: rotate(45deg);
        }

        .forgot {
            font-size: 0.78rem;
            font-weight: 500;
            color: #4F46C8;
            text-decoration: none;
            transition: color 0.15s;
        }

        .forgot:hover { color: #3730A3; }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: #4F46C8;
            border: none;
            border-radius: 10px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.875rem;
            font-weight: 600;
            color: #fff;
            cursor: pointer;
            letter-spacing: 0.02em;
            transition: background 0.2s, transform 0.1s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-login:hover { background: #3730A3; }
        .btn-login:active { transform: scale(0.99); }

        .status-ok {
            background: #ECFDF5;
            border: 1px solid #6EE7B7;
            color: #065F46;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.8rem;
            margin-bottom: 1.25rem;
        }

        .form-footer {
            margin-top: 1.5rem;
            text-align: center;
            font-size: 0.75rem;
            color: #C4C9D4;
        }

        @media (max-width: 700px) { .lp { display: none; } }
    </style>

    <div style="display:flex;min-height:100vh;width:100%;">

        <!-- LEFT -->
        <div class="lp">
            <!-- Abstract geometric SVG background -->
            <svg class="lp-svg" viewBox="0 0 420 700" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice">
                <!-- Hexagon grid pattern -->
                <defs>
                    <pattern id="hex" x="0" y="0" width="60" height="52" patternUnits="userSpaceOnUse">
                        <polygon points="30,2 58,17 58,47 30,62 2,47 2,17" fill="none" stroke="rgba(255,255,255,0.055)" stroke-width="1"/>
                    </pattern>
                </defs>
                <rect width="420" height="700" fill="url(#hex)"/>

                <!-- Large circle accent top-right -->
                <circle cx="370" cy="80" r="120" fill="none" stroke="rgba(124,111,247,0.18)" stroke-width="1"/>
                <circle cx="370" cy="80" r="80" fill="none" stroke="rgba(124,111,247,0.12)" stroke-width="1"/>
                <circle cx="370" cy="80" r="40" fill="rgba(124,111,247,0.1)" stroke="none"/>

                <!-- Teal accent bottom-left -->
                <circle cx="30" cy="620" r="100" fill="none" stroke="rgba(29,158,117,0.15)" stroke-width="1"/>
                <circle cx="30" cy="620" r="55" fill="rgba(29,158,117,0.07)" stroke="none"/>

                <!-- Diagonal line cluster -->
                <line x1="0" y1="200" x2="420" y2="420" stroke="rgba(124,111,247,0.08)" stroke-width="1"/>
                <line x1="0" y1="240" x2="420" y2="460" stroke="rgba(124,111,247,0.06)" stroke-width="1"/>
                <line x1="0" y1="280" x2="420" y2="500" stroke="rgba(124,111,247,0.04)" stroke-width="1"/>

                <!-- Small accent dots -->
                <circle cx="80" cy="160" r="3" fill="rgba(124,111,247,0.5)"/>
                <circle cx="200" cy="310" r="2" fill="rgba(29,158,117,0.6)"/>
                <circle cx="340" cy="480" r="3" fill="rgba(124,111,247,0.4)"/>
                <circle cx="120" cy="540" r="2" fill="rgba(29,158,117,0.4)"/>

                <!-- Corner bracket top-left -->
                <path d="M20,20 L20,50" stroke="rgba(255,255,255,0.15)" stroke-width="1.5" fill="none"/>
                <path d="M20,20 L50,20" stroke="rgba(255,255,255,0.15)" stroke-width="1.5" fill="none"/>

                <!-- Corner bracket bottom-right -->
                <path d="M400,680 L400,650" stroke="rgba(255,255,255,0.1)" stroke-width="1.5" fill="none"/>
                <path d="M400,680 L370,680" stroke="rgba(255,255,255,0.1)" stroke-width="1.5" fill="none"/>
            </svg>

            <div class="lp-content">
                <!-- Brand -->
                <div class="brand">
                    <div class="brand-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                            <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                        </svg>
                    </div>
                    <div>
                        <div class="brand-name">SIMAK</div>
                        <div class="brand-sub">Academic Portal</div>
                    </div>
                </div>

                <!-- Center text -->
                <div class="lp-middle">
                    <div class="lp-tagline">
                        Manage academics<br>with <span>more precision</span>
                    </div>
                    <p class="lp-desc">
                        One platform for student data, schedules, grades, and academic records — all in one place.
                    </p>
                    <div class="lp-pills">
                        <div class="pill">
                            <div class="pill-dot" style="background:#1D9E75;"></div>
                            Student Data
                        </div>
                        <div class="pill">
                            <div class="pill-dot" style="background:#7C6FF7;"></div>
                            Grade Entry
                        </div>
                        <div class="pill">
                            <div class="pill-dot" style="background:#A78BFA;"></div>
                            Reports & Recap
                        </div>
                    </div>
                </div>

                <div class="lp-footer">© {{ date('Y') }} SIMAK · Academic Information System</div>
            </div>
        </div>

        <!-- RIGHT -->
        <div class="rp">
            <div class="form-box">
                <div class="form-eyebrow">Welcome back</div>
                <div class="form-title">Sign in to your account</div>
                <p class="form-sub">Enter your credentials to continue</p>

                @if (session('status'))
                    <div class="status-ok">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="field">
                        <label for="email">Email</label>
                        <div class="iw">
                            <span class="ico">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="4" width="20" height="16" rx="2"/>
                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                                </svg>
                            </span>
                            <input id="email" type="email" name="email" value="{{ old('email') }}"
                                placeholder="admin@simak.ac.id" required autofocus autocomplete="username"/>
                        </div>
                        @error('email')<p class="field-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="field">
                        <label for="password">Password</label>
                        <div class="iw">
                            <span class="ico">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2"/>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                </svg>
                            </span>
                            <input id="password" type="password" name="password"
                                placeholder="••••••••" required autocomplete="current-password"/>
                        </div>
                        @error('password')<p class="field-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="row-mid">
                        <label class="ck-label" for="remember_me">
                            <input id="remember_me" type="checkbox" name="remember">
                            <span>Remember me</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a class="forgot" href="{{ route('password.request') }}">Forgot password?</a>
                        @endif
                    </div>

                    <button type="submit" class="btn-login">
                        <span>Sign in</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </button>
                </form>

                <p class="form-footer">Contact your administrator if you are having trouble signing in.</p>
            </div>
        </div>

    </div>
</x-guest-layout>
