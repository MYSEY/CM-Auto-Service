@extends('layouts.frontend.layouts')
@section('content')
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            {{-- Using Laravel URL helper --}}
                            <li><a href="{{ url('/') }}">home</a></li>
                            <li>contact us</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="contact_page_bg">
        <div class="contact_map">
           <div class="map-area">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15632.74836696426!2d104.9152336!3d11.5563738!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3109513dc76a6003%3A0x35639b7082260193!2sPhnom%20Penh%2C%20Cambodia!5e0!3m2!1sen!2sus!4v1678886400000!5m2!1sen!2sus"  style="border:0;" allowfullscreen="" loading="lazy"></iframe>
           </div>
        </div>
        <div class="container">

            {{-- ✨ DISPLAY SUCCESS MESSAGE --}}
            @if (session('success'))
                <div class="alert alert-success mt-4">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ✨ DISPLAY GENERAL FAILURE MESSAGE --}}
            @if ($errors->has('submission'))
                <div class="alert alert-danger mt-4">
                    {{ $errors->first('submission') }}
                </div>
            @endif

            <div class="contact_area">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                       <div class="contact_message content">
                            <h3>contact us</h3>
                             <p>Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram anteposuerit litterarum formas human. qui sequitur mutationem consuetudium lectorum. Mirum est notare quam</p>
                            <ul>
                                <li><i class="fa fa-fax"></i>  Address : Your address goes here.</li>
                                <li><i class="fa fa-phone"></i> <a href="#">the.c.m.auto@gmail.com</a></li>
                                <li><i class="fa fa-envelope-o"></i> +855 31 486 6777</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                       <div class="contact_message form">
                            <h3>Tell us your project</h3>

                            {{-- ⚠️ Action URL set to the requested Admin Route --}}
                            <form action="{{ url('admins/backend-contact') }}" method="POST" novalidate>
                                @csrf

                                <p>
                                   <label> Your Name (required)</label>
                                   <input name="name" placeholder="Name *" type="text" required>
                                   {{-- Display specific validation error --}}
                                   @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                </p>
                                <p>
                                   <label> Your Email (required)</label>
                                   <input name="email" placeholder="Email *" type="email" required>
                                   @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                </p>
                                <p>
                                   <label> Your Phone</label>
                                   <input name="phone" placeholder="Phone" type="text">
                                   @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                                </p>
                                <p>
                                   <label> Subject</label>
                                   <input name="subject" placeholder="Subject *" type="text" required>
                                   @error('subject') <span class="text-danger">{{ $message }}</span> @enderror
                                </p>
                                <div class="contact_textarea">
                                   <label> Your Message (required)</label>
                                   <textarea placeholder="Message *" name="message" class="form-control2" required></textarea>
                                   @error('message') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <button type="submit"> Send</button>
                                <p class="form-messege"></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            </div>
    </div>
@endsection
