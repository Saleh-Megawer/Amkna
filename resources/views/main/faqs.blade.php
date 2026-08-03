@section('title', __('main.faqs.meta_title'))
@section('description', __('main.faqs.meta_desc'))
@section('head')

@endsection
@section('body-class', 'faqs-body')
@extends('main.layouts.master')
@section('content')

    <main class="faqs-page" role="main" aria-labelledby="faqs-title">

        <!-- Hero Section -->
        <header class="faqs-hero mt-space-navbar">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center">
                        <div
                            class="faqs-hero__icon rounded-circle bg-white shadow-sm mx-auto mb-4 d-flex align-items-center justify-content-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="48"
                                height="48">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H8c0-2.21 1.79-4 4-4s4 1.79 4 4c0 .88-.36 1.68-.93 2.25z" />
                            </svg>
                        </div>
                        <h1 id="faqs-title" class="display-4 text-white font-weight-bold mb-3">
                            {{ __('main.faqs.title') }}
                        </h1>
                        <p class="text-white lead mb-0">
                            {{ __('main.faqs.subtitle') }}
                        </p>
                    </div>
                </div>
            </div>
        </header>

        <!-- FAQs Content -->
        <section class="py-5 bg-gray-200">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">

                        <!-- Search Box -->
                        <div class="box mb-5">
                            <x-form-group class="mb-0" :properties="[
                                'input' => [
                                    'type' => 'text',
                                    'name' => 'faq_q',
                                    'options' => [
                                        'id' => 'faqSearch',
                                        'placeholder' => ' 🔍︎ ' . __('main.faqs.search_placeholder'),
                                        'aria-label' => __('main.faqs.search_placeholder'),
                                    ],
                                ],
                            ]" /> <!-- name -->
                        </div>


                        <div class="accordion faqs-accordion" id="accordionAll">
                            @foreach ($rows as $faq)
                                <div class="box mb-3 faq-item">
                                    <div class="bg-white border-0">
                                        <button
                                            class="px-0 btn btn-link btn-block text-left d-flex align-items-center justify-content-between collapsed "
                                            type="button" data-toggle="collapse" data-target="#collapse{{ $loop->index }}"
                                            aria-expanded="false" aria-controls="collapse{{ $loop->index }}">
                                            <span class="font-weight-600 text-dark">{{ $faq->title }}</span>
                                            <svg class="faq-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor" width="24" height="24">
                                                <path d="M16.59 8.59L12 13.17 7.41 8.59 6 10l6 6 6-6z" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div id="collapse{{ $loop->index }}" class="collapse"
                                        aria-labelledby="heading{{ $loop->index }}" data-parent="#accordionAll">
                                        <div class="pt-0 ">
                                            <p class="text-muted mb-0">{{ $faq->desc }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Still Have Questions -->
                        <div class="card border-0 shadow-sm mt-5 faqs-contact">
                            <div class="card-body text-center p-5">
                                <div
                                    class="faqs-contact__icon rounded-circle bg-light mx-auto mb-4 d-flex align-items-center justify-content-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        width="40" height="40">
                                        <path
                                            d="M21 6h-2v9H6v2c0 .55.45 1 1 1h11l4 4V7c0-.55-.45-1-1-1zm-4 6V3c0-.55-.45-1-1-1H3c-.55 0-1 .45-1 1v14l4-4h10c.55 0 1-.45 1-1z" />
                                    </svg>
                                </div>
                                <h3 class="h4 font-weight-bold mb-3">{{ __('main.faqs.still_questions.title') }}</h3>
                                <p class="text-muted mb-4">{{ __('main.faqs.still_questions.subtitle') }}</p>
                                <a href="{{ route('main.contact-us') }}" class="btn btn-lg rounded-pill px-5"
                                    style="background: var(--accent); color: var(--accent-1); border: none;">
                                    {{ __('main.faqs.still_questions.button') }}
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

    </main>

@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // Search functionality
            $('#faqSearch').on('keyup', function() {
                const searchTerm = $(this).val().toLowerCase();

                $('.faq-item').each(function() {
                    const question = $(this).find('.btn-link span').text().toLowerCase();
                    const answer = $(this).find('.collapse p').text().toLowerCase();

                    if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            // Rotate icon on collapse toggle
            $('[data-toggle="collapse"]').on('click', function() {
                const $icon = $(this).find('.faq-icon');
                const currentRotation = $icon.css('transform');

                if (currentRotation === 'none' || currentRotation === 'matrix(1, 0, 0, 1, 0, 0)') {
                    $icon.css('transform', 'rotate(180deg)');
                } else {
                    $icon.css('transform', 'rotate(0deg)');
                }
            });

            // Reset icon on collapse events
            $('.collapse').on('hidden.bs.collapse', function() {
                const collapseId = $(this).attr('id');
                $('[data-target="#' + collapseId + '"]').find('.faq-icon').css('transform', 'rotate(0deg)');
            });

            $('.collapse').on('shown.bs.collapse', function() {
                const collapseId = $(this).attr('id');
                $('[data-target="#' + collapseId + '"]').find('.faq-icon').css('transform',
                    'rotate(180deg)');
            });
        });
    </script>
@endsection
