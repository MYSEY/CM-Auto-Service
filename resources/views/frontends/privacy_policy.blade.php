@extends('layouts.frontend.layouts')

@section('content')
<div class="breadcrumbs_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li><a href="/">home</a></li>
                        <li>privacy policy</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="privacy_policy_area py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm p-4 p-md-5 rounded-4 bg-white">
                    <h2 class="fw-bold mb-4 text-primary">Privacy Policy</h2>
                    <p class="text-muted">Last updated: August 16, 2026</p>
                    
                    <hr class="my-4">

                    <h4 class="fw-bold mt-4 mb-3">1. Information We Collect</h4>
                    <p class="text-secondary leading-relaxed">
                        At CM Auto Service, we collect information to provide better services to our users. This includes account credentials, order history, contact details, and technical device specifications required for ECU file tuning and vehicle diagnostic support.
                    </p>

                    <h4 class="fw-bold mt-4 mb-3">2. How We Use Information</h4>
                    <p class="text-secondary leading-relaxed">
                        We use the collected information to process orders, deliver original ECU files and file services, provide customer support, and communicate important service updates or push notifications.
                    </p>

                    <h4 class="fw-bold mt-4 mb-3">3. Data Security & Protection</h4>
                    <p class="text-secondary leading-relaxed">
                        We implement industry-standard encryption and security measures to protect your personal data and uploaded vehicle files against unauthorized access, alteration, or disclosure.
                    </p>

                    <h4 class="fw-bold mt-4 mb-3">4. Third-Party Services</h4>
                    <p class="text-secondary leading-relaxed">
                        We do not sell or rent your personal information to third parties. Data is shared only with essential service providers necessary for payment processing, storage, and notification delivery.
                    </p>

                    <h4 class="fw-bold mt-4 mb-3">5. Contact Us</h4>
                    <p class="text-secondary leading-relaxed">
                        If you have any questions or concerns regarding this Privacy Policy, please contact us via phone at <strong>+855 031 48 66 777</strong> or email at <strong>the.c.m.auto@gmail.com</strong>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
