<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <header class="hero">
            <div class="overlay">
                <div id="countdown" style="margin-top:0.5rem;color:red; font-size:1.5rem; font-weight:bold;  padding: 0.5rem 0; border-radius: 5px; letter-spacing: 1px;">
                    Loading countdown...
                </div>
                <h1><span><a href="/">JH</a></span>arts Foundation</h1>
                <p><i>Presents:</i></p>
                <h2 class="!text-[#FFD700]">Auditions</h2>
                <p>{{ $audition->date->format('d F Y')  }}</p>
                <p>Southeast Branch Library</p>
                <p style="margin-top:-6px; font-size:16px;">5575 S Semoran Blvd, Orlando FL 32822</p><!-- <a href="#registration" class="btn">Register Now</a> -->
            </div>

            @if(request()->is('/'))
            <a href="#registration" class="floating-button" title="Register Now">
                <flux:icon.user-round-plus class="size-8"/>
            </a>
            @endif
        </header>

        {{ $slot }}

        <footer>
            <p>&copy; 2025 Jazz Hamilton Foundation. All rights reserved.</p>
            <div style="display: flex; flex-direction: column">
                <a style="color:white" href="mailto:  auditions@jhartsfoundation.org">auditions@jhartsfoundation.org</a>
                <a style="color:white" href="tel: +1 407-513-2292">407-513-2292</a>
            </div>
        </footer>
    </body>
</html>
