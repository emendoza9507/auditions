<x-layouts.app.land>
    <style>

        .success-box {
            border: 2px solid #a67c52;
            padding: 2rem;
            border-radius: 10px;
            background-color: #fff8ee;
            max-width: 500px;
            margin: 10px auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .success-box h1 {
            color: #4a3f35;
            margin-bottom: 1rem;
        }

        .success-box p {
            font-size: 1.2rem;
        }

        .success-box a {
            display: inline-block;
            margin-top: 2rem;
            text-decoration: none;
            color: white;
            background-color: #a67c52;
            padding: 0.8rem 1.5rem;
            border-radius: 5px;
        }

        .success-box a:hover {
            background-color: #8b6c43;
        }
    </style>
    <div class="success-box">
        <h1>🎉 Registration successful!</h1>
        <p>Thank you for completing your registration and payment.</p>
        <p>We will contact you with more details about the audition.</p>
        <a href="{{ url('/') }}">Return to the beginning</a>
    </div>
    <script>
        const countdownEl = document.getElementById('countdown');
        const targetDate = new Date(@json($audition->date)).getTime();

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = targetDate - now;

            if (distance < 0) {
                countdownEl.textContent = "The audition date has passed.";
                clearInterval(interval);
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            countdownEl.textContent = `${days}d ${hours}h ${minutes}m ${seconds}s`;
        }

        updateCountdown();
        const interval = setInterval(updateCountdown, 1000);
    </script>
</x-layouts.app.land>
