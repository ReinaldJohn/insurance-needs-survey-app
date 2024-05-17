<x-layout :currentYear="$currentYear" :title="$title">
    <div class="min-vh-100 d-flex flex-column">
        <x-header></x-header>

        <section class="parallax_window_in" data-parallax="scroll" data-image-src="{{ asset('img/bg.jpg') }}"
            data-natural-width="1400" data-natural-height="800">
            <div id="sub_content_in">
                <h1>Disclaimer</h1>
                {{-- <p class="mb-2">"Usu habeo equidem sanctus no ex melius labitur"</p> --}}
            </div>
        </section>
        <!-- /section -->

        <div class="bg_color_gray">
            <div class="container">
                <div class="row justify-content-between p-3">
                    <div class="col-lg-12">
                        <div name="termly-embed" data-id="c9c05419-a25b-4a65-874e-004a4def4eba"></div>
                        <script type="text/javascript">
                            (function(d, s, id) {
                                var js, tjs = d.getElementsByTagName(s)[0];
                                if (d.getElementById(id)) return;
                                js = d.createElement(s);
                                js.id = id;
                                js.src = "https://app.termly.io/embed-policy.min.js";
                                tjs.parentNode.insertBefore(js, tjs);
                            }(document, 'script', 'termly-jssdk'));
                        </script>
                    </div>
                </div>
                <!-- End row -->
            </div>
        </div>
        <!-- End container -->

        <footer>
            <div class="container-fluid">
                <div class="row align-items-center text-center">
                    <div class="col-sm-12">
                        <p class="mb-2">© {{ $currentYear }} Pascal Burke Insurance Brokerage Inc.</p>
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
</x-layout>
