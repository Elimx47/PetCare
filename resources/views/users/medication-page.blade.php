<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetCare - Medications</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        .navbar {
            background-color: #f7f7f7;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 1rem 2rem;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        }

        .nav-link {
            color: #666;
            transition: color 0.2s ease;
        }

        .nav-link:hover {
            color: #333;
        }

        .hero-section {
            background: url('https://images.unsplash.com/photo-1512069772995-ec65ed45afd6?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80') no-repeat center center;
            background-size: cover;
            height: 300px;
            position: relative;
        }

        .hero-content {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 2rem;
            border-radius: 10px;
        }

        .medication-card {
            transition: transform 0.3s ease-in-out;
        }

        .medication-card:hover {
            transform: translateY(-5px);
        }

        .medication-img {
            height: 200px;
            object-fit: cover;
        }

        .dropdown-menu {
            padding: 0.5rem;
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
            border-radius: 4px;
        }

        .dropdown-item:hover {
            background-color: lightgreen;
        }
    </style>
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="https://cdn-icons-png.flaticon.com/128/14029/14029433.png" alt="PetCare Logo" width="40" height="40" class="d-inline-block align-text-top me-2">
                PetCare
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link " href="{{ route('welcome') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pet-adopt') }}">Adoption</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('medication') }}">Medication</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    @if (Route::has('login'))
                    @auth
                    <li class="nav-item me-2">
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="badge bg-danger ms-1">{{ $cartItemCount }}</span>
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <!-- Profile Page Link -->
                            <a class="dropdown-item" href="{{ route('userProfile') }}">
                                <i class="fas fa-user me-2"></i> Profile
                            </a>

                            <a class="dropdown-item" href="{{ route('userPets') }}">
                                <i class="fa-solid fa-paw me-2"></i> Pets
                            </a>

                            <a class="dropdown-item" href="{{ route('user.orders') }}">
                                <i class="fas fa-receipt me-2"></i> My Orders
                            </a>

                            <!-- Logout Button -->
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Log in</a>
                    </li>
                    @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                    @endif
                    @endauth
                    @endif
                </ul>


            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero-section d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="hero-content">
                        <h1 class="display-4 fw-bold">Pet Medications</h1>
                        <p class="lead">Find the right medications for your furry friends. Quality products for their health and well-being.</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Medication Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Available Medications</h2>

            <!-- Filter -->
            <div class="row mb-4">
                <div class="col-md-6 mx-auto">
                    <select class="form-select" id="medicationFilter">
                        <option selected value="all">All Medications</option>
                        <option value="heartworm">Heartworm Prevention</option>
                        <option value="flea-tick">Flea & Tick Treatment</option>
                        <option value="antibiotic">Antibiotics</option>
                        <option value="anti-inflammatory">Anti-inflammatory</option>
                    </select>
                </div>
            </div>

            <!-- Medication Cards -->
            <div class="row g-4" id="medicationCards">
                <!-- Heartgard Plus -->
                <div class="col-md-4 medication-card" data-type="heartworm">
                    <div class="card h-100 shadow">
                        <img src="https://bi-animalhealth.com/pets/sites/default/files/styles/2400x900_scale/public/2024-01/Heartgard%20Plus_Product%20Detailer.jpg?itok=qUnBV_z6" class="card-img-top medication-img" alt="Heartgard Plus">
                        <div class="card-body">
                            <h5 class="card-title">Heartgard Plus</h5>
                            <p class="card-text">Heartworm preventative for dogs</p>
                            <p class="card-text"><strong>Price:</strong> Php 300.00</p>
                            <a href="#" class="btn btn-success" onclick="event.preventDefault(); document.getElementById('add-to-cart-heartgard').submit();">Add to Cart</a>
                            <form id="add-to-cart-heartgard" action="{{ route('cart.add') }}" method="POST" style="display: none;">
                                @csrf
                                <input type="hidden" name="medication_name" value="Heartgard Plus">
                                <input type="hidden" name="price" value="300.00">
                                <input type="hidden" name="medication_type" value="heartworm">
                                <input type="hidden" name="image_url" value="https://bi-animalhealth.com/pets/sites/default/files/styles/2400x900_scale/public/2024-01/Heartgard%20Plus_Product%20Detailer.jpg?itok=qUnBV_z6">
                                <input type="hidden" name="quantity" value="1">
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Amoxicillin -->
                <div class="col-md-4 medication-card" data-type="antibiotic">
                    <div class="card h-100 shadow">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSR7OO51ctn4ORv9sGN_yIQz5m6yT_H2Aiu8Q&s" class="card-img-top medication-img" alt="Amoxicillin">
                        <div class="card-body">
                            <h5 class="card-title">Amoxicillin</h5>
                            <p class="card-text">Antibiotic for various bacterial infections</p>
                            <p class="card-text"><strong>Price:</strong> Php 125.00</p>
                            <a href="#" class="btn btn-success" onclick="event.preventDefault(); document.getElementById('add-to-cart-amoxicillin').submit();">Add to Cart</a>
                        <form id="add-to-cart-amoxicillin" action="{{ route('cart.add') }}" method="POST" style="display: none;">
                            @csrf
                            <input type="hidden" name="medication_name" value="Amoxicillin">
                            <input type="hidden" name="price" value="125.00">
                            <input type="hidden" name="medication_type" value="amoxicillin">
                            <input type="hidden" name="image_url" value="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSR7OO51ctn4ORv9sGN_yIQz5m6yT_H2Aiu8Q&s">
                            <input type="hidden" name="quantity" value="1">
                        </form>
                        </div>
                    </div>
                </div>
                <!-- Bravecto -->
                <div class="col-md-4 medication-card" data-type="flea-tick">
                    <div class="card h-100 shadow">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR6gK8wU3NuUNZqgpe2XvdY3-jUnC865G1xHw&s" class="card-img-top medication-img" alt="Bravecto">
                        <div class="card-body">
                            <h5 class="card-title">Bravecto</h5>
                            <p class="card-text">Flea and tick treatment for dogs</p>
                            <p class="card-text"><strong>Price:</strong> Php 245.00</p>
                            <a href="#" class="btn btn-success" onclick="event.preventDefault(); document.getElementById('add-to-cart-bravecto').submit();">Add to Cart</a>
                        <form id="add-to-cart-bravecto" action="{{ route('cart.add') }}" method="POST" style="display: none;">
                            @csrf
                            <input type="hidden" name="medication_name" value="Bravecto">
                            <input type="hidden" name="price" value="245.00">
                            <input type="hidden" name="medication_type" value="bravecto">
                            <input type="hidden" name="image_url" value="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR6gK8wU3NuUNZqgpe2XvdY3-jUnC865G1xHw&s">
                            <input type="hidden" name="quantity" value="1">
                        </form>
                        </div>
                    </div>
                </div>
                <!-- Frontline Plus -->
                <div class="col-md-4 medication-card" data-type="flea-tick">
                    <div class="card h-100 shadow">
                        <img src="https://frontlinepetcare.com.ph/sites/default/files/2022-11/product-frontline-dogs_3.jpg" class="card-img-top medication-img" alt="Frontline Plus">
                        <div class="card-body">
                            <h5 class="card-title">Frontline Plus</h5>
                            <p class="card-text">Flea and tick treatment for cats and dogs</p>
                            <p class="card-text"><strong>Price:</strong> Php 335.00</p>
                            <a href="#" class="btn btn-success" onclick="event.preventDefault(); document.getElementById('add-to-cart-frontlineplus').submit();">Add to Cart</a>
                        <form id="add-to-cart-frontlineplus" action="{{ route('cart.add') }}" method="POST" style="display: none;">
                            @csrf
                            <input type="hidden" name="medication_name" value="Frontline Plus">
                            <input type="hidden" name="price" value="335.00">
                            <input type="hidden" name="medication_type" value="frontlineplus">
                            <input type="hidden" name="image_url" value="https://frontlinepetcare.com.ph/sites/default/files/2022-11/product-frontline-dogs_3.jpg">
                            <input type="hidden" name="quantity" value="1">
                        </form>
                        </div>
                    </div>
                </div>
                <!-- Doxycycline -->
                <div class="col-md-4 medication-card" data-type="antibiotic">
                    <div class="card h-100 shadow">
                        <img src="https://supertails.com/cdn/shop/files/Pharmacy_91_162a28e8-daa5-4476-bd04-143b9835efa5.png?v=1696448979" class="card-img-top medication-img" alt="Doxycycline">
                        <div class="card-body">
                            <h5 class="card-title">Doxycycline</h5>
                            <p class="card-text">Antibiotic for bacterial infections</p>
                            <p class="card-text"><strong>Price:</strong> Php 128.00</p>
                            <a href="#" class="btn btn-success" onclick="event.preventDefault(); document.getElementById('add-to-cart-doxycycline').submit();">Add to Cart</a>
                        <form id="add-to-cart-doxycycline" action="{{ route('cart.add') }}" method="POST" style="display: none;">
                            @csrf
                            <input type="hidden" name="medication_name" value="Doxycycline">
                            <input type="hidden" name="price" value="128.00">
                            <input type="hidden" name="medication_type" value="doxycycline">
                            <input type="hidden" name="image_url" value="https://supertails.com/cdn/shop/files/Pharmacy_91_162a28e8-daa5-4476-bd04-143b9835efa5.png?v=1696448979">
                            <input type="hidden" name="quantity" value="1">
                        </form>
                        </div>
                    </div>
                </div>
                <!-- Prednisone -->
                <div class="col-md-4 medication-card" data-type="anti-inflammatory">
                    <div class="card h-100 shadow">
                        <img src="https://cdn.mos.cms.futurecdn.net/m8xQaU8ZnvPfq8xiiU5RtW-1200-80.jpg" class="card-img-top medication-img" alt="Prednisone">
                        <div class="card-body">
                            <h5 class="card-title">Prednisone</h5>
                            <p class="card-text">Anti-inflammatory and immunosuppressant</p>
                            <p class="card-text"><strong>Price:</strong> Php 220.00</p>
                            <a href="#" class="btn btn-success" onclick="event.preventDefault(); document.getElementById('add-to-cart-prednisons').submit();">Add to Cart</a>
                        <form id="add-to-cart-prednisons" action="{{ route('cart.add') }}" method="POST" style="display: none;">
                            @csrf
                            <input type="hidden" name="medication_name" value="Prednisons">
                            <input type="hidden" name="price" value="220.00">
                            <input type="hidden" name="medication_type" value="prednisons">
                            <input type="hidden" name="image_url" value="https://cdn.mos.cms.futurecdn.net/m8xQaU8ZnvPfq8xiiU5RtW-1200-80.jpg">
                            <input type="hidden" name="quantity" value="1">
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQs Section -->
    <section class="bg-light py-5">
        <div class="container">
            <h2 class="text-center mb-4">Frequently Asked Questions (FAQs)</h2>
            <div class="accordion" id="faqsAccordion">
                <!-- Heartgard Plus FAQ -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingHeartgard">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseHeartgard" aria-expanded="true" aria-controls="collapseHeartgard">
                            Heartgard Plus
                        </button>
                    </h2>
                    <div id="collapseHeartgard" class="accordion-collapse collapse show" aria-labelledby="headingHeartgard" data-bs-parent="#faqsAccordion">
                        <div class="accordion-body">
                            Heartgard Plus is a chewable tablet that prevents heartworm disease in dogs. It should be administered monthly, ideally on the same date each month. Give the tablet to your dog with or without food. Consult your veterinarian for the appropriate dosage based on your dog's weight.
                        </div>
                    </div>
                </div>
                <!-- Amoxicillin FAQ -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingAmoxicillin">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAmoxicillin" aria-expanded="false" aria-controls="collapseAmoxicillin">
                            Amoxicillin
                        </button>
                    </h2>
                    <div id="collapseAmoxicillin" class="accordion-collapse collapse" aria-labelledby="headingAmoxicillin" data-bs-parent="#faqsAccordion">
                        <div class="accordion-body">
                            Amoxicillin is an antibiotic used to treat various bacterial infections in pets. It should be administered as prescribed by your veterinarian. Typically, it is given with food to prevent stomach upset. Complete the full course of treatment as directed, even if your pet seems to be improving.
                        </div>
                    </div>
                </div>
                <!-- Bravecto FAQ -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingBravecto">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBravecto" aria-expanded="false" aria-controls="collapseBravecto">
                            Bravecto
                        </button>
                    </h2>
                    <div id="collapseBravecto" class="accordion-collapse collapse" aria-labelledby="headingBravecto" data-bs-parent="#faqsAccordion">
                        <div class="accordion-body">
                            Bravecto is a chewable tablet that provides up to 12 weeks of protection against fleas and ticks in dogs. Administer the tablet with or without food. Ensure that the entire tablet is consumed. Consult your veterinarian if you have any questions about the dosage or administration.
                        </div>
                    </div>
                </div>
                <!-- Frontline Plus FAQ -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFrontline">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFrontline" aria-expanded="false" aria-controls="collapseFrontline">
                            Frontline Plus
                        </button>
                    </h2>
                    <div id="collapseFrontline" class="accordion-collapse collapse" aria-labelledby="headingFrontline" data-bs-parent="#faqsAccordion">
                        <div class="accordion-body">
                            Frontline Plus is a topical solution that treats and prevents flea and tick infestations in cats and dogs. Apply the solution directly to your pet's skin, between the shoulder blades. Avoid bathing or allowing your pet to swim for 48 hours after application. Follow the dosage instructions based on your pet's weight.
                        </div>
                    </div>
                </div>
                <!-- Doxycycline FAQ -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingDoxycycline">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDoxycycline" aria-expanded="false" aria-controls="collapseDoxycycline">
                            Doxycycline
                        </button>
                    </h2>
                    <div id="collapseDoxycycline" class="accordion-collapse collapse" aria-labelledby="headingDoxycycline" data-bs-parent="#faqsAccordion">
                        <div class="accordion-body">
                            Doxycycline is an antibiotic used to treat various bacterial infections in pets. It is typically given with food to minimize gastrointestinal upset. Follow your veterinarian's instructions for dosage and administration. Ensure the full course of treatment is completed.
                        </div>
                    </div>
                </div>
                <!-- Prednisone FAQ -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingPrednisone">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePrednisone" aria-expanded="false" aria-controls="collapsePrednisone">
                            Prednisone
                        </button>
                    </h2>
                    <div id="collapsePrednisone" class="accordion-collapse collapse" aria-labelledby="headingPrednisone" data-bs-parent="#faqsAccordion">
                        <div class="accordion-body">
                            Prednisone is a corticosteroid used to reduce inflammation and suppress the immune system. It is usually given orally with food to minimize side effects. Follow your veterinarian's dosage instructions and consult them if any adverse reactions occur.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>About PetCare</h5>
                    <p>PetCare is dedicated to connecting loving homes with pets in need and providing top-quality pet care products and services.</p>
                </div>
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('welcome') }}" class="text-white">Home</a></li>
                        <li><a href="{{ route('pet-adopt') }}" class="text-white">Adoption</a></li>
                        <li><a href="{{ route('medication') }}" class="text-white">Medication</a></li>
                        <li><a href="{{ route('about') }}" class="text-white">About</a></li>
                        <li><a href="{{ route('contact') }}" class="text-white">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contact Us</h5>
                    <address>
                        <p><i class="fas fa-map-marker-alt me-2"></i> 123 Pet Street, Anytown, ST 12345</p>
                        <p><i class="fas fa-phone me-2"></i> (123) 456-7890</p>
                        <p><i class="fas fa-envelope me-2"></i> info@petcare.com</p>
                    </address>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p>&copy; 2024 PetCare. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <!-- Custom JavaScript for filtering -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterSelect = document.getElementById('medicationFilter');
            const medicationCards = document.querySelectorAll('.medication-card');

            filterSelect.addEventListener('change', function() {
                const selectedType = this.value;

                medicationCards.forEach(card => {
                    if (selectedType === 'all' || card.dataset.type === selectedType) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>

</html>
