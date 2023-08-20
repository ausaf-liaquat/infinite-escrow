@extends($activeTemplate.'layouts.frontend')

@section('content')
@include($activeTemplate.'partials.breadcrumb')
    <div class="section privacy-policy-section">
        <div class="container">
        <div class="row gy-5">

            <div class="col-lg-12">
                <div class="privacy-policy-section__content" data-bs-spy="scroll" data-bs-target="#navbar-example3" data-bs-offset="0" tabindex="0">
                    <div id="overview">
                        <h4 class="mt-0">{{__(@$policyDetails->data_values->title)}}</h4>
                        <p class="privacy-policy-section__content-text">
                            @php echo @$policyDetails->data_values->details @endphp
                        </p>
                    </div>

                </div>
            </div>
        </div>
        </div>
    </div>
@endsection
