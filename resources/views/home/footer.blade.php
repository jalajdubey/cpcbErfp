<footer class="landing-footer">
    <div class="container position-relative">

        {{-- Partner Logos --}}
        <ul class="client list-unstyled d-flex flex-wrap justify-content-center align-items-center mb-4">
            <li class="m-2">
                <a href="#" target="_blank" rel="noopener">
                    <img src="{{ asset('images/G20.png') }}" alt="G20" class="footer-logo">
                </a>
            </li>
            <li class="m-2">
                <a href="#" target="_blank" rel="noopener">
                    <img src="{{ asset('images/meity.svg') }}" alt="MeitY" class="footer-logo">
                </a>
            </li>
            <li class="m-2">
                <a href="#" target="_blank" rel="noopener">
                    <img src="{{ asset('images/digitalIndia.png') }}" alt="Digital India" class="footer-logo">
                </a>
            </li>
            <li class="m-2">
                <a href="#" target="_blank" rel="noopener">
                    <img src="{{ asset('images/indiaGov.png') }}" alt="India Gov" class="footer-logo">
                </a>
            </li>
            <li class="m-2">
                <a href="#" target="_blank" rel="noopener">
                    <img src="{{ asset('images/swacchBharat.png') }}" alt="Swachh Bharat" class="footer-logo">
                </a>
            </li>
            <li class="m-2">
                <a href="#" target="_blank" rel="noopener">
                    <img src="{{ asset('images/Mygov.svg') }}" alt="MyGov" class="footer-logo">
                </a>
            </li>
        </ul>

        {{-- Contact & Write to Us Section --}}
        <h4 class="text-center mb-4">Do you have any query?</h4>

        <div class="row g-4">
            {{-- Contact Info --}}
            <div class="col-md-6">
                <h5>Contact us:</h5>
                <p class="mb-1">
                    <strong>Office:</strong><br>
                    Parivesh Bhawan, East Arjun Nagar, Delhi - 110032
                </p>
                <p>
                    <strong>Email:</strong><br>
                    ewaste2[dot]cpcb[at]gov[dot]in
                </p>
            </div>

            {{-- Write to Us Form --}}
            <div class="col-md-6">
                <h5>Write to us:</h5>
                <form id="contactForm" autocomplete="off">
                    <div class="row">
                        <div class="mb-2 col-md-6">
                            <input type="text" class="form-control" maxlength="250" placeholder="Name" name="name" required>
                        </div>
                        <div class="mb-2 col-md-6">
                            <input type="email" class="form-control" maxlength="50" placeholder="Email" name="email" required>
                        </div>
                        <div class="mb-2 col-md-12">
                            <input type="text" class="form-control" maxlength="250" placeholder="Subject" name="subject">
                        </div>
                        <div class="mb-3 col-md-12">
                            <textarea class="form-control" rows="3" maxlength="250" placeholder="Message" name="message"></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Send</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Bottom Footer --}}
    <div class="footer-bottom bg-dark text-white text-center mt-4 py-3">
        <div class="container">
            <p class="mb-0 small">
                © 2025 | <a href="#" target="_blank" class="text-white text-decoration-underline">MoEF&amp;CC</a> |
                Developed & Managed by <a href="#" target="_blank" class="text-white text-decoration-underline">CPCB</a> | IT Division
            </p>
        </div>
    </div>
</footer>
