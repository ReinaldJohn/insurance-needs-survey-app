<x-layout :title="$title">
    <div class="min-vh-100 d-flex flex-column">
        {{-- Start Header --}}
        <x-header></x-header>
        {{-- End Header --}}

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
                                <p>By completing a short questionnaire, the “Insurance Needs Survey will provide you
                                    with a detailed report of the types of insurance, including limits, key
                                    endorsements, and other details you will need to protect your business. This is
                                    an excellent tool to help you when shopping for contractors’ insurance.</p>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-md-10 mb-3">
                                    <div class="form-floating">
                                        <select class="form-select required" id="business_location"
                                            name="business_location" aria-label="Business Location">
                                            <option value selected>Please select</option>
                                            @foreach ($states as $state)
                                                <option value="{{ $state['id'] }}">{{ $state['statesname'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="business_location">What state is your business located?</label>
                                    </div>
                                </div>
                                <div class="col-md-10 mb-3">
                                    <div class="form-floating">
                                        <select class="form-select required" id="trades_performed"
                                            name="trades_performed[]" aria-label="Trades Performed" multiple="multiple">
                                            @foreach ($professions as $profession)
                                                <option value="{{ $profession['id'] }}">
                                                    {{ $profession['tradename'] }}</option>
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
                            <div class="row justify-content-center d-flex">
                                <div class="col-md-12 mb-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control required" id="company_name"
                                            name="company_name" placeholder="Company Name">
                                        <label for="company_name">Company Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control required" id="first_name"
                                            name="first_name" placeholder="First Name">
                                        <label for="first_name">First Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control required" id="last_name"
                                            name="last_name" placeholder="Last Name">
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
                                        <input type="text" class="form-control required" id="city"
                                            name="city" placeholder="City">
                                        <label for="city">City</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control required" id="zipcode"
                                            name="zipcode" placeholder="Zip Code">
                                        <label for="zipcode">Zip Code</label>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="form-floating">
                                        <input type="email" id="email" name="email"
                                            class="form-control required" placeholder="Email">
                                        <label for="email">Email Address</label>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control required" id="phone_no"
                                            name="phone_no" placeholder="Phone Number">
                                        <label for="phone_no">Phone Number</label>
                                    </div>
                                </div>
                                <div class="terms">
                                    <label class="container_check">
                                        By clicking "Next" I agree to receive emails, text message, and phone calls,
                                        which may be recorded
                                        and/or emailing equipment or software unless I opt-out from such
                                        communications.
                                        <br />
                                        -Purpose of the message: To send a follow-up text message regarding
                                        insurance proposal we forwarded to
                                        you once you completed this form.
                                        <br />
                                        -It's great to know that you can opt out of receiving these SMS texts at any
                                        time simply answering STOP.
                                        You can get more information by just answering HELP. We do not sell or share
                                        your information with third
                                        parties. You may always check our company's <b>privacy policy</b> <a
                                            href="#" target="_blank">here</a> and <b>terms
                                            and conditions</b> <a href="#" target="_blank">here</a>.
                                        Finally, data charges may apply to any SMS texts you receive. Thank you.
                                        <br />
                                        -Subsequent follow-ups can take place 10 days and a month after the initial
                                        quote transmission.
                                        <br />
                                        -No mobile information will be shared with third parties/affiliates for
                                        marketing/promotional purposes.

                                        <input type="checkbox" name="terms" id="dialpadTermsCheckbox"
                                            value="Yes" class="">
                                        <span class="checkmark"></span>
                                    </label>
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
                                                    <input type="checkbox" id="question_1_opt_1" name="question_1[]"
                                                        class="required" value="">
                                                    <label class="checkbox" for="question_1_opt_1"></label>
                                                    <label for="question_1_opt_1" class="wrapper">Do you perform
                                                        any residential work?</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="checkbox_radio_container">
                                                    <input type="checkbox" id="question_1_opt_2" name="question_1[]"
                                                        class="required" value="">
                                                    <label class="checkbox" for="question_1_opt_2"></label>
                                                    <label for="question_1_opt_2" class="wrapper">Do you perform
                                                        any commercial work?</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="checkbox_radio_container">
                                                    <input type="checkbox" id="question_1_opt_3" name="question_1[]"
                                                        class="required" value="">
                                                    <label class="checkbox" for="question_1_opt_3"></label>
                                                    <label for="question_1_opt_3" class="wrapper">Do you have
                                                        employees?</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="checkbox_radio_container">
                                                    <input type="checkbox" id="question_1_opt_4" name="question_1[]"
                                                        class="required" value="">
                                                    <label class="checkbox" for="question_1_opt_4"></label>
                                                    <label for="question_1_opt_4" class="wrapper">Do you use a
                                                        vehicle in your work, or do your employees, if any, use
                                                        their own vehicle for their work?</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="checkbox_radio_container">
                                                    <input type="checkbox" id="question_1_opt_5" name="question_1[]"
                                                        class="required" value="">
                                                    <label class="checkbox" for="question_1_opt_5"></label>
                                                    <label for="question_1_opt_5" class="wrapper">Do you work on
                                                        property with a value greater than $1,000,000?</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="checkbox_radio_container">
                                                    <input type="checkbox" id="question_1_opt_6" name="question_1[]"
                                                        class="required" value="">
                                                    <label class="checkbox" for="question_1_opt_6"></label>
                                                    <label for="question_1_opt_6" class="wrapper">Do you rent
                                                        equipment or do your tools and equipment add up to more than
                                                        $10,000?</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="checkbox_radio_container">
                                                    <input type="checkbox" id="question_1_opt_7" name="question_1[]"
                                                        class="required" value="">
                                                    <label class="checkbox" for="question_1_opt_7"></label>
                                                    <label for="question_1_opt_7" class="wrapper">Do you own or
                                                        rent an office, warehouse, or yard facility other than your
                                                        home?</label>
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
                                                    <input type="checkbox" id="question_2_opt_1" name="question_2[]"
                                                        class="" value="">
                                                    <label class="checkbox" for="question_2_opt_1"></label>
                                                    <label for="question_2_opt_1" class="wrapper">Do you maintain
                                                        all licenses as required by any local or state authorities
                                                        for providing contracting services?</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="checkbox_radio_container">
                                                    <input type="checkbox" id="question_2_opt_2" name="question_2[]"
                                                        class="" value="">
                                                    <label class="checkbox" for="question_2_opt_2"></label>
                                                    <label for="question_2_opt_2" class="wrapper">Are you a
                                                        General Contractor that performs remodeling or additions, or
                                                        new ground up construction for residential or commercial
                                                        building?</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="checkbox_radio_container">
                                                    <input type="checkbox" id="question_2_opt_3" name="question_2[]"
                                                        class="" value="">
                                                    <label class="checkbox" for="question_2_opt_3"></label>
                                                    <label for="question_2_opt_3" class="wrapper">Do you transport
                                                        materials, and or store them at your facility or jobsite,
                                                        with a value greater than $10,000?</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="checkbox_radio_container">
                                                    <input type="checkbox" id="question_2_opt_4" name="question_2[]"
                                                        class="" value="">
                                                    <label class="checkbox" for="question_2_opt_4"></label>
                                                    <label for="question_2_opt_4" class="wrapper">Do you perform
                                                        any of the following services: Design Build, architectural,
                                                        engineering services or construction management for a
                                                        fee?</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="checkbox_radio_container">
                                                    <input type="checkbox" id="question_2_opt_5" name="question_2[]"
                                                        class="" value="">
                                                    <label class="checkbox" for="question_2_opt_5"></label>
                                                    <label for="question_2_opt_5" class="wrapper">Do directly or
                                                        through your website collect any personal information from
                                                        your customers; credit card information, phone number,
                                                        address, checking account, drivers license, social security,
                                                        date of birth?</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="checkbox_radio_container">
                                                    <input type="checkbox" id="question_2_opt_6" name="question_2[]"
                                                        class="" value="">
                                                    <label class="checkbox" for="question_2_opt_6"></label>
                                                    <label for="question_2_opt_6" class="wrapper">Do you store,
                                                        transport, or use on the jobsite any pollutants?</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="checkbox_radio_container">
                                                    <input type="checkbox" id="question_2_opt_7" name="question_2[]"
                                                        class="" value="">
                                                    <label class="checkbox" for="question_2_opt_7"></label>
                                                    <label for="question_2_opt_7" class="wrapper">Do you use
                                                        subcontractors?</label>
                                                </div>
                                            </li>
                                        </ul>
                                        <small><em>Multiple selections *</em></small>
                                    </div>
                                </div>
                            </div>
                            <!-- /row -->

                            <div class="terms mt-4">
                                <label class="container_check">Please accept our <a href="#"
                                        data-bs-toggle="modal" data-bs-target="#terms-txt">Terms and
                                        conditions</a>
                                    <input type="checkbox" name="terms" id="termsCheckbox" value="Yes"
                                        class="required">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="modal fade" id="terms-txt" tabindex="-1" role="dialog"
                                aria-labelledby="termsLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="termsLabel">Terms and conditions
                                            </h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>
                                                By opting-in, you agree to receive newsletters, updates, and
                                                promotional offers from Pascal Burke Insurance Brokerage Inc.
                                                Your privacy is important to us. We will never share, sell, or
                                                disclose your email address to third parties without your
                                                explicit consent. You have the right to unsubscribe from our
                                                newsletter and email communications at any time by clicking on
                                                the "unsubscribe" link at the bottom of any of our emails. By
                                                continuing with the opt-in process, you confirm that you have
                                                read, understood, and agreed to these terms.
                                            </p>
                                            <p>
                                                You can also view our Policies by following this
                                                link.
                                                <a href="https://pbibins.com/terms-and-conditions/">Terms and
                                                    Conditions</a> |
                                                <a href="https://pbibins.com/privacy-policy/">Privacy
                                                    Policy</a> |
                                                <a href="https://pbibins.com/cookie-policy/">Cookie Policy</a>
                                            </p>
                                        </div>
                                    </div>
                                    <!-- /modal-content -->
                                </div>
                                <!-- /modal-dialog -->
                            </div>
                        </div>
                        <!-- /Step -->
                        <input type="hidden" name="utm_source" value="{{ app('request')->input('utm_source') }}">
                        <input type="hidden" name="utm_medium" value="{{ app('request')->input('utm_medium') }}">
                        <input type="hidden" name="utm_campaign"
                            value="{{ app('request')->input('utm_campaign') }}">
                        <input type="hidden" name="utm_term" value="{{ app('request')->input('utm_term') }}">
                        <input type="hidden" name="utm_content" value="{{ app('request')->input('utm_content') }}">

                    </div>
                    <!-- /middle-wizard -->

                    <div id="bottom-wizard">
                        <button type="button" name="backward" class="backward btn_1">Previous</button>
                        <button type="button" name="forward" class="forward btn_1">Next</button>
                        <button type="submit" name="process" id="process" class="submit btn_1">Submit</button>
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
                        <p>© {{ $currentYear }} Pascal Burke Insurance Brokerage Inc.</p>
                    </div>
                    <div class="col-sm-12">
                        <p><a href="{{ route('pp-index') }}">Privacy Policy</a> | <a
                                href="{{ route('cp-index') }}">Cookie
                                Policy</a> | <a href="{{ route('tc-index') }}">Terms and
                                Conditions</a> | <a href="{{ route('d-index') }}">Disclaimer</a> | <a
                                href="{{ route('ap-index') }}">Acceptable Use Policy</a> </p>
                    </div>
                </div>
                <!-- /Row -->
            </div>
            <!-- /Container -->
        </footer>
        <!-- /Footer -->
    </div>
    <!-- /flex-column -->
</x-layout>
