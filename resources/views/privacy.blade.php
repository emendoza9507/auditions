<x-layouts.app.land>
    <style>
        body {
            margin: 0;
            font-family: 'Source Code Pro', 'Arial', sans-serif;
            background: linear-gradient(135deg, #1a1a1a, #333333);
            color: #ffffff;
            line-height: 1.6;
            /*display: flex;*/
            /*justify-content: center;*/
            /*align-items: center;*/
            min-height: 100vh;
        }
        h1 {
            font-size: 36px;
            color: #FFD700;
            text-align: center;
            text-shadow: 0 0 10px #FFD700;
            margin-bottom: 20px;
        }
        h2 {
            font-size: 24px;
            color: #FFD700;
            margin-top: 20px;
            border-bottom: 2px solid #FFD700;
            padding-bottom: 5px;
        }
        .container p {
            font-size: 16px;
            margin-bottom: 15px;
        }
        ul {
            margin: 15px 0;
            padding-left: 20px;
        }
        li {
            margin-bottom: 10px;
        }
        .contact {
            text-align: center;
            margin-top: 30px;
            font-size: 16px;
        }
        .contact a {
            color: #FFD700;
            text-decoration: none;
        }
        .contact a:hover {
            text-decoration: underline;
        }
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .container {
            animation: fadeIn 1s ease-in;
        }
    </style>
    <section class="bg-gradient-to-b from-black-[70] to-[#000d00]">
        <div class="container ">
            <h1>Terms of Use for Auditions 2025</h1>
            <p><strong>Sponsored by JHarts Foundation</strong><br>
                <strong>Date:</strong> July 26, 2025<br>
                <strong>Location:</strong> Southeast Branch Library, 5575 S Semoran Blvd, Orlando, FL 32822</p>

            <p>By participating in the Youth Orchestra Auditions 2025, organized by JHarts Foundation, participants and their legal guardians (if applicable) agree to the following terms and conditions:</p>

            <h2>1. Participation and Eligibility</h2>
            <ul>
                <li>The auditions are open to individuals aged 10 to 17 years.</li>
                <li>Participants under 18 must have the consent of a parent or legal guardian to participate.</li>
                <li>Participation in the auditions implies acceptance of these Terms of Use.</li>
            </ul>

            <h2>2. Use of Images and Materials</h2>
            <ul>
                <li>By participating, you grant JHarts Foundation permission to capture, record, and use photographs, videos, audio recordings, and other materials (collectively, "Materials") created during the auditions, presentations and concerts.</li>
                <li>These Materials may be used for promotional and marketing purposes, including but not limited to:
                    <ul>
                        <li>Social media posts and campaigns (Facebook, YouTube, Twitter, TikTok, ...).</li>
                        <li>Jazz Harts Foundation’s website (jhartsfoundation.org).</li>
                        <li>Printed materials such as flyers, posters, impressions, or brochures.</li>
                        <li>Publicity for future events organized by JHarts Foundation.</li>
                    </ul>
                </li>
                <li>The Materials will be used solely for non-commercial purposes to promote the mission and activities of JHarts Foundation.</li>
                <li>JHarts Foundation will not sell or distribute the Materials to third parties for commercial use.</li>
            </ul>

            <h2>3. Consent for Minors</h2>
            <ul>
                <li>For participants under 18, a parent or legal guardian must provide written consent for the use of Materials as described above.</li>
                <li>Consent will be collected via a signed form provided at registration or prior to the audition.</li>
                <li>Without this consent, the participant’s Materials will not be used for marketing purposes.</li>
            </ul>

            <h2>4. Opt-Out Option</h2>
            <ul>
                <li>Participants or their legal guardians may request that their Materials not be used for marketing by submitting a written request to JHarts Foundation at auditions@jhartsfoundation.org before or during the audition.</li>
                <li>Once notified, JHarts Foundation will make reasonable efforts to exclude the participant’s Materials from marketing activities.</li>
            </ul>

            <h2>5. Ownership and Rights</h2>
            <ul>
                <li>JHarts Foundation retains ownership of the Materials captured during the auditions.</li>
                <li>Participants will not receive compensation for the use of Materials in marketing efforts.</li>
                <li>JHarts Foundation reserves the right to edit, crop, or modify the Materials for promotional purposes, provided such edits maintain the integrity of the participant’s image and performance.</li>
            </ul>

            <h2>6. Privacy</h2>
            <ul>
                <li>JHarts Foundation will not disclose personal information (e.g., names, contact details) in marketing Materials without explicit consent, except where participants are identified as part of the audition process (e.g., winner announcements, if applicable).</li>
                <li>Personal information collected during registration will be handled in accordance with JHarts Foundation’s privacy policy, available at auditions.jhartsfoundation.org/privacy.</li>
            </ul>

            <h2>7. Liability</h2>
            <ul>
                <li>JHarts Foundation is not responsible for any loss, damage, or injury incurred during participation in the auditions, except as required by law.</li>
                <li>Participants and their guardians assume responsibility for their conduct and safety during the event.</li>
            </ul>

            <h2>8. Contact Information</h2>
            <p class="contact">For questions about these Terms of Use or to opt out of marketing use, contact:<br>
                <strong>Jazz Harts Foundation</strong><br>
                Email: <a href="mailto:auditions@jhartsfoundation.org">auditions@jhartsfoundation.org</a><br>
                Website: <a href="https://jhartsfoundation.org">jhartsfoundation.org</a></p>

            <p>By participating in the Auditions 2025, you acknowledge that you have read, understood, and agree to be bound by these Terms of Use.</p>

            <p class="contact"><em>Last updated: July 12, 2025</em></p>
        </div>
    </section>
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
