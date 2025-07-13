<x-layouts.app.land>

    @foreach($audition->contents()->orderBy('order')->get() as $content)
        {!! str($content->content)->sanitizeHtml() !!}
    @endforeach


    <section id="registration" class="form-section">
        <h2 class="text-sky-700">Registration Form</h2>
        <form id="auditionForm" action="{{ route('audition_registration.store') }}" method="POST">
            @csrf
            <input type="hidden" name="audition_id" value="{{ $audition->id }}"/>

            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" required />

            <label for="age">Age</label>
            <input type="number" id="age" name="age" min="10" required />

            <label id="parentname-label" for="parentname" style="display: none;">Parent or Tutor Name if required</label>
            <input type="text" id="parentname" name="parentname" style="display: none;" />

            <label for="instrument">Instrument</label>
            <input type="text" id="instrument" name="instrument" required />

            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" required />

            <label for="phone">Phone</label>
            <input type="phone" id="phone" name="phone" required />

            <label for="schedule">Schedule</label>
            <select name="audition_slot_id" id="schedule"></select>

            <span class="text-xl bold">Audition fee: $35</span>

            <label><input type="checkbox"  id="agreed_terms" name="agreed_terms"/> I accept the <a href="/privacy" class="underline">terms of use</a> </label>

            <div id="paypal-button-container"></div>

            {{--            <button type="submit">Submit Registration</button>--}}
        </form>
        <div id="formMessage" class="form-message"></div>
    </section>

    <script>
        const age = document.getElementById("age");
        const parentName = document.getElementById("parentname");
        const parentNameLabel = document.getElementById("parentname-label");
        age.addEventListener('change', function() {
            if(age.value < 18) {
                parentName.style.display = "block";
                parentName.required = true;
                parentNameLabel.style.display = "block";
            } else {
                parentName.style.display = "none";
                parentName.required = false;
                parentNameLabel.style.display = "none";
            }
        })

        document.getElementById("auditionForm").addEventListener("submit", function (e) {
            e.preventDefault();

            const age = parseInt(document.getElementById("age").value);
            const messageEl = document.getElementById("formMessage");

            if (age < 10) {
                messageEl.style.color = "red";
                messageEl.textContent = "Age must be between 10 and 17 years.";
                return;
            }

            this.submit()

            messageEl.style.color = "green";
            messageEl.textContent = "Registration successfully submitted! We will contact you soon.";

            this.reset();
        });

    </script>
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
    {{--  Generar Boton de Pago  --}}
    <script>
        paypal.Buttons({
            createOrder: function(data, actions) {
                const name = document.getElementById('name').value.trim();
                const age = document.getElementById('age').value.trim();
                const instrument = document.getElementById('instrument').value.trim();
                const email = document.getElementById('email').value.trim();
                const schedule = document.getElementById('schedule').value;
                const agreed_terms = document.getElementById('agreed_terms').checked;

                if(!name || !age || !instrument || !email || !schedule || !agreed_terms) {
                    document.getElementById('formMessage').innerHTML = "Please complete all fields in the form before paying."
                    return Promise.reject(new Error("Incomplete form"));
                }

                if(age < 18 && !document.getElementById('parentname').value.trim()) {
                    document.getElementById('formMessage').innerHTML = "Please the name of parent is required."
                    return Promise.reject(new Error("Incomplete form"));
                }

                return actions.order.create({
                    purchase_units: [{
                        amount: { value: @json($audition->price) }
                    }]
                })
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    const form = document.getElementById('auditionForm');
                    const formData = new FormData(form);
                    formData.append("payment_order_id", data.orderID)

                    fetch("/api/audition_registrations", {
                        method: "POST",
                        headers: {
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: formData
                    })
                        .then(res => res.json())
                        .then(data => {
                            document.getElementById('formMessage').innerHTML = 'You have successfully registered';
                        })
                        .catch(err => {
                            console.error("Error registrando: ", err)
                            document.getElementById('formMessage').innerHTML = `Error saving registration, please save this ID: ${data.orderID} for future payment refunds. `
                        })
                })
            }
        }).render('#paypal-button-container')
    </script>
    {{--  Cargar Horas disponibles  --}}
    <script>
        async function loadAvailableTimes() {
            const select = document.getElementById('schedule');
            select.innerHTML = '<option value="">Loading...</option>';

            try {
                const res = await fetch('/api/audition-slots');
                const data = await res.json();

                const available = data.filter(slot => slot.available);
                if(available.length === 0) {
                    select.innerHTML = '<option value="">No slots available</option>'
                }

                select.innerHTML = '';
                available.forEach(slot => {
                    const opt = document.createElement('option');
                    opt.value = slot.id;
                    opt.textContent = `${slot.time} (${slot.remaining} spots left)`;
                    select.appendChild(opt);
                })

            } catch (err) {
                console.error('Error loading slots:', err);
                select.innerHTML = '<option value="">Error loading slots</option>'
            }
        }

        document.addEventListener('DOMContentLoaded', loadAvailableTimes);
    </script>
</x-layouts.app.land>
