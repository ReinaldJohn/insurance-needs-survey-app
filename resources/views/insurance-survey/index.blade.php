<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Contractor Insurance Needs Survey | Pascal Burke Insurance Brokerage Inc.">
        <meta name="author" content="Pascal Burke">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>Contractor Insurance Needs Survey | Pascal Burke Insurance Brokerage Inc.</title>

        <!-- Favicons-->
        <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">

        <!-- GOOGLE WEB FONT -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css" rel="stylesheet" />

        <!-- BASE CSS -->
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('css/vendors.css') }}" rel="stylesheet">

        <!-- YOUR CUSTOM CSS -->
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

        {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}

    </head>

    <body class="bg_color_gray">

        {{-- <div id="preloader">
            <div data-loader="circle-side"></div>
        </div><!-- /Preload -->

        <div id="loader_form">
            <div data-loader="circle-side-2"></div>
        </div><!-- /loader_form --> --}}

        <div class="min-vh-100 d-flex flex-column">
            <header>
                <div class="container-fluid">
                    <div class="row d-flex align-items-center">
                        <div class="col-4">
                            <a data-bs-toggle="offcanvas" href="#offcanvasNav" role="button" class="btn_nav"><i class="bi bi-list"></i></a>
                        </div>
                        <div class="col-4 text-center">
                            <a href="https://pbibins.com" target="_blank"><img src="{{ asset('img/PBIB Logo.png') }}" alt="" class="img-fluid" width="350" height="350"></a>
                        </div>
                        <div class="col-4">
                            <div id="social">
                                <ul>
                                    <li><a href="#0"><i class="bi bi-facebook"></i></a></li>
                                </ul>
                            </div>
                            <!-- /social -->
                        </div>
                    </div>
                </div>
                <!-- /container -->
            </header>
            <!-- /header -->

            <div class="container-fluid d-flex flex-column my-auto">
                <div id="wizard_container">
                    <div id="top-wizard">
                        <div id="progressbar"></div>
                    </div>
                    <!-- /top-wizard -->
                    <form id="wrapped">
                    @csrf
                    <input id="website" name="website" type="text" value="">
                    <!-- Leave input above for security protection, read docs for details -->
                        <div id="middle-wizard">

                            <div class="step">
                                <div class="question_title">
                                    <h3>Contractors’ Insurance Needs Survey</h3>
                                    <p>By completing a short questionnaire, the “Insurance Needs Survey will provide you with a detailed report of the types of insurance, including limits, key endorsements, and other details you will need to protect your business. This is an excellent tool to help you when shopping for contractors’ insurance.</p>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-md-10 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select " id="business_location" name="business_location" aria-label="Business Location">
                                                <option value selected>Please select</option>
                                                @foreach($states as $state)
                                                <option value="{{ $state['id'] }}">{{ $state['statesname'] }}</option>
                                                @endforeach
                                            </select>
                                            <label for="business_location">What state is your business located?</label>
                                        </div>
                                    </div>
                                    <div class="col-md-10 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select " id="trades_performed" name="trades_performed[]" aria-label="Trades Performed" multiple="multiple">
                                                @foreach($professions as $profession)
                                                <option value="{{ $profession['id'] }}">{{ $profession['tradename'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- /row -->
                            </div>
                            <!-- /Step -->

                            <div class="step">
                                <div class="question_title">
                                    <h3>Contractor's Insurance Needs Survey</h3>
                                    <p>Please signed up to complete insurance calculator form.</p>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control required" id="company_name" name="company_name" placeholder="Company Name">
                                            <label for="company_name">Company Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control required" id="first_name" name="first_name" placeholder="First Name">
                                            <label for="first_name">First Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control required" id="last_name" name="last_name" placeholder="Last Name">
                                            <label for="last_name">Last Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-floating">
                                            <textarea style="resize: none;" class="form-control required" id="address" name="address" placeholder="Address"></textarea>
                                            <label for="address">Address</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control required" id="city" name="city" placeholder="City">
                                            <label for="city">City</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control required" id="zipcode" name="zipcode" placeholder="Zip Code">
                                            <label for="zipcode">Zip Code</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-floating">
                                            <input type="email" id="email" name="email" class="form-control " placeholder="Email">
                                            <label for="email">Email Address</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control required" id="phone_no" name="phone_no" placeholder="Phone Number">
                                            <label for="phone_no">Phone Number</label>
                                        </div>
                                    </div>
                                </div>
                                <!-- /row -->
                            </div>
                            <!-- /Step -->

                            <div class="step">
                                <div class="question_title">
                                    <h3>Contractor's Insurance Needs Survey</h3>
                                    <p>Please signed up to complete insurance calculator form.</p>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-md-12">
                                        <div class="list_block">
                                            <ul>
                                                <li>
                                                    <div class="checkbox_radio_container">
                                                        <input type="checkbox" id="question_1_opt_1" name="question_1[]" class="required" value="">
                                                        <label class="checkbox" for="question_1_opt_1"></label>
                                                        <label for="question_1_opt_1" class="wrapper">Do you perform any residential work?</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox_radio_container">
                                                        <input type="checkbox" id="question_1_opt_2" name="question_1[]" class="required" value="">
                                                        <label class="checkbox" for="question_1_opt_2"></label>
                                                        <label for="question_1_opt_2" class="wrapper">Do you perform any commercial work?</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox_radio_container">
                                                        <input type="checkbox" id="question_1_opt_3" name="question_1[]" class="required" value="">
                                                        <label class="checkbox" for="question_1_opt_3"></label>
                                                        <label for="question_1_opt_3" class="wrapper">Do you have employees?</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox_radio_container">
                                                        <input type="checkbox" id="question_1_opt_4" name="question_1[]" class="required" value="">
                                                        <label class="checkbox" for="question_1_opt_4"></label>
                                                        <label for="question_1_opt_4" class="wrapper">Do you use a vehicle in your work, or do your employees, if any, use their own vehicle for their work?</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox_radio_container">
                                                        <input type="checkbox" id="question_1_opt_5" name="question_1[]" class="required" value="">
                                                        <label class="checkbox" for="question_1_opt_5"></label>
                                                        <label for="question_1_opt_5" class="wrapper">Do you work on property with a value greater than $1,000,000?</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox_radio_container">
                                                        <input type="checkbox" id="question_1_opt_6" name="question_1[]" class="required" value="">
                                                        <label class="checkbox" for="question_1_opt_6"></label>
                                                        <label for="question_1_opt_6" class="wrapper">Do you rent equipment or do your tools and equipment add up to more than $10,000?</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox_radio_container">
                                                        <input type="checkbox" id="question_1_opt_7" name="question_1[]" class="required" value="">
                                                        <label class="checkbox" for="question_1_opt_7"></label>
                                                        <label for="question_1_opt_7" class="wrapper">Do you own or rent an office, warehouse, or yard facility other than your home?</label>
                                                    </div>
                                                </li>
                                            </ul>
                                            <small><em>Multiple selections *</em></small>
                                        </div>
                                    </div>
                                </div>
                                <!-- /row -->
                            </div>
                            <!-- /Step -->

                            <div class="submit step">
                                <div class="question_title">
                                    <h3>Contractor's Insurance Needs Survey</h3>
                                    <p>Please signed up to complete insurance calculator form.</p>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-md-12">
                                        <div class="list_block">
                                            <ul>
                                                <li>
                                                    <div class="checkbox_radio_container">
                                                        <input type="checkbox" id="question_2_opt_1" name="question_2[]" class="required" value="">
                                                        <label class="checkbox" for="question_2_opt_1"></label>
                                                        <label for="question_2_opt_1" class="wrapper">Are you a General Contractor that performs remodeling or additions, or new ground up construction for residential or commercial building?</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox_radio_container">
                                                        <input type="checkbox" id="question_2_opt_2" name="question_2[]" class="required" value="">
                                                        <label class="checkbox" for="question_2_opt_2"></label>
                                                        <label for="question_2_opt_2" class="wrapper">Do you transport materials, and or store them at your facility or jobsite, with a value greater than $10,000?</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox_radio_container">
                                                        <input type="checkbox" id="question_2_opt_3" name="question_2[]" class="required" value="">
                                                        <label class="checkbox" for="question_2_opt_3"></label>
                                                        <label for="question_2_opt_3" class="wrapper">Do you perform any of the following services: Design Build, architectural, engineering services or construction management for a fee?</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox_radio_container">
                                                        <input type="checkbox" id="question_2_opt_4" name="question_2[]" class="required" value="">
                                                        <label class="checkbox" for="question_2_opt_4"></label>
                                                        <label for="question_2_opt_4" class="wrapper">Do directly or through your website collect any personal information from your customers; credit card information, phone number, address, checking account, drivers license, social security, date of birth?</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox_radio_container">
                                                        <input type="checkbox" id="question_2_opt_5" name="question_2[]" class="required" value="">
                                                        <label class="checkbox" for="question_2_opt_5"></label>
                                                        <label for="question_2_opt_5" class="wrapper">Do you store, transport, or use on the jobsite any pollutants?</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox_radio_container">
                                                        <input type="checkbox" id="question_2_opt_6" name="question_2[]" class="required" value="">
                                                        <label class="checkbox" for="question_2_opt_6"></label>
                                                        <label for="question_2_opt_6" class="wrapper">Do you use subcontractors?</label>
                                                    </div>
                                                </li>
                                            </ul>
                                            <small><em>Multiple selections *</em></small>
                                        </div>
                                    </div>
                                </div>
                                <!-- /row -->
                            </div>
                            <!-- /Step -->

                        </div>
                        <!-- /middle-wizard -->

                        <div id="bottom-wizard">
                            <button type="button" name="backward" class="backward btn_1">Previous</button>
                            <button type="button" name="forward" class="forward btn_1">Next</button>
                            <button type="submit" name="process" class="submit btn_1">Submit</button>
                        </div>
                        <!-- /bottom-wizard -->
                    </form>
                </div>
                <!-- /Wizard container -->
            </div>
            <!-- /Container -->

            <footer>
                <div class="container-fluid">
                    <div class="row align-items-center text-center">
                        <div class="col-sm-12">
                            <p>© 2023 Pascal Burke Insurance Brokerage Inc.</p>
                        </div>
                    </div>
                    <!-- /Row -->
                </div>
                <!-- /Container -->
            </footer>
            <!-- /Footer -->
        </div>
        <!-- /flex-column -->
    </body>

    <!-- COMMON SCRIPTS -->
    <script src="{{ asset('js/common_scripts.min.js') }}"></script>
    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    {{-- <script src="{{ mix('js/app.js') }}"></script> --}}
    <script src="{{ asset('js/common_functions.js') }}"></script>
    <script src="{{ asset('assets/validate.js') }}"></script>

</html>
