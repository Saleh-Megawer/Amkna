@extends('main.layouts.master')
@section('title', $pageTitle)
@section('content')

    <main id="page-owner-associations-polls-index">
        <div class="container mb-5">
            <div class="row">

                <div class="col-12">
                    <h1 class="page-title">{{ $pageTitle }}</h1>
                </div><!-- page title -->

                @include('clients.includes.aside')

                <x-client-content>

                    <x-client-breadcrumb :items="[
                        ['title' => __('client.profile.title'), 'url' => clientUrl()],
                        [
                            'title' => __('client.polls.page_title'),
                            'url' => route('main.clients.owner-association.polls.index'),
                        ],
                        ['title' => Str::limit($poll->title,25)],
                    ]" />


                    <div class="box p-0 mb-4">
                        <div class="px-4 pt-4 mb-4">

                            <div class="d-flex align-items-center">

                                <div class="me-3">

                                    <div class="rounded d-flex align-items-center justify-content-center text-accent"
                                        style="width: 60px; height: 60px; background: var(--accent-soft);">
                                        <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 256 256">
                                            <rect width="256" height="256" fill="none" />
                                            <path d="M160,80V200.67a8,8,0,0,0,3.56,6.65l11,7.33a8,8,0,0,0,12.2-4.72L200,160"
                                                fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="20" />
                                            <path
                                                d="M40,200a8,8,0,0,0,13.15,6.12C105.55,162.16,160,160,160,160h40a40,40,0,0,0,0-80H160S105.55,77.84,53.15,33.89A8,8,0,0,0,40,40Z"
                                                fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="20" />
                                        </svg>
                                    </div>

                                </div>


                                <h2 class="mb-2 font-weight-600 font-18 ">
                                    {{ $poll->title }}

                                    <div class=" font-12 mt-1 font-weight-500">
                                        <strong>{{ __('client.polls.created_at') }}:</strong>
                                        {{ $poll->created_at->format('d M Y, h:i A') }}
                                    </div>
                                </h2>

                                {{-- 
                                    <div class="d-flex align-items-center gap-3 flex-wrap">
                                        <span class="badge bg-light text-dark">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <rect x="3" y="3" width="7" height="7"></rect>
                                                <rect x="14" y="3" width="7" height="7"></rect>
                                                <rect x="14" y="14" width="7" height="7"></rect>
                                                <rect x="3" y="14" width="7" height="7"></rect>
                                            </svg>
                                            {{ $poll->ownerAssociation->name }}
                                        </span>
                                        <span class="text-muted small">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="12" cy="7" r="4"></circle>
                                            </svg>
                                            {{ $totalVotes }} {{ __('client.polls.votes') }}
                                        </span>
                                        @if ($poll->is_active)
                                            <span class="badge bg-success bg-opacity-10 text-success">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <polyline points="12 6 12 12 16 14"></polyline>
                                                </svg>
                                                {{ __('client.polls.active') }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                                {{ __('client.polls.closed') }}
                                            </span>
                                        @endif
                                    </div> --}}



                            </div>

                            @if ($poll->description)
                                <p class="text-muted mb-2 mt-3 font-14">
                                    {!! nl2br(e($poll->description)) !!}
                                </p>
                            @endif

                        </div><!-- info header -->
                    </div>



                    {{-- Voting Form / Results --}}
                    @if ($hasVoted || !$poll->is_active)


                        @if ($hasVoted)
                            <div class="box p-4 mb-4">

                                <div class="alert alert-success mb-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                    </svg>
                                    {{ __('client.polls.thank_you') }}
                                </div>

                                @if ($clientVote->notes)
                                    <div class="alert alert-light mt-3 mb-0 text-dark border">
                                        <strong>{{ __('client.polls.your_notes') }}:</strong>
                                        <p class="mb-0 mt-2 text-secondary font-15">{{ $clientVote->notes }}</p>
                                    </div>
                                @endif
                            </div><!-- box -->
                        @endif


                        <div class="box p-0">
                            {{-- Show Results --}}
                            <div class="poll-results p-4">
                                <h5 class="mb-4">{{ __('client.polls.results') }}</h5>

                                {{-- نعم --}}
                                <div class="poll-option-result mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="fw-medium fs-5">
                                            @if ($hasVoted && $clientVote->vote === 'yes')
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="text-success">
                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                </svg>
                                            @endif
                                            {{ __('client.polls.yes') }}
                                        </span>
                                        <span class="text-muted">
                                            {{ $yesVotes }} {{ __('client.polls.votes') }}
                                            ({{ $yesPercentage }}%)
                                        </span>
                                    </div>
                                    <div class="progress" style="height: 40px;">
                                        <div class="progress-bar bg-success" role="progressbar"
                                            style="width: {{ $yesPercentage }}%;" aria-valuenow="{{ $yesPercentage }}"
                                            aria-valuemin="0" aria-valuemax="100">
                                            <strong>{{ $yesPercentage }}%</strong>
                                        </div>
                                    </div>
                                </div>

                                {{-- لا --}}
                                <div class="poll-option-result mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="fw-medium fs-5">
                                            @if ($hasVoted && $clientVote->vote === 'no')
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="text-danger">
                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                </svg>
                                            @endif
                                            {{ __('client.polls.no') }}
                                        </span>
                                        <span class="text-muted">
                                            {{ $noVotes }} {{ __('client.polls.votes') }}
                                            ({{ $noPercentage }}%)
                                        </span>
                                    </div>
                                    <div class="progress" style="height: 40px;">
                                        <div class="progress-bar bg-danger" role="progressbar"
                                            style="width: {{ $noPercentage }}%;" aria-valuenow="{{ $noPercentage }}"
                                            aria-valuemin="0" aria-valuemax="100">
                                            <strong>{{ $noPercentage }}%</strong>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div><!-- box -->
                    @else
                        <div class="box p-0">
                            <div class="p-4">
                                <form action="{{ route('main.clients.owner-association.polls.vote', $poll->uuid) }}"
                                    method="POST">
                                    @csrf
                                    <h5 class="mb-4">{{ __('client.polls.select_option') }}</h5>

                                    <div class="form-row mb-2">

                                        {{-- نعم --}}
                                        <div class="col-6">
                                            <input type="radio" class="btn-check" name="vote" id="vote-yes"
                                                value="yes" {{ old('vote') === 'yes' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-success w-100 py-4 fs-4" for="vote-yes">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="mb-3">
                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                </svg>
                                                <div>{{ __('client.polls.yes') }}</div>
                                            </label>
                                        </div>

                                        {{-- لا --}}
                                        <div class="col-6">
                                            <input type="radio" class="btn-check" name="vote" id="vote-no"
                                                value="no" {{ old('vote') === 'no' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-danger w-100 py-4 fs-4" for="vote-no">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="mb-3">
                                                    <line x1="18" y1="6" x2="6" y2="18">
                                                    </line>
                                                    <line x1="6" y1="6" x2="18" y2="18">
                                                    </line>
                                                </svg>
                                                <div>{{ __('client.polls.no') }}</div>
                                            </label>
                                        </div>

                                    </div>

                                    @error('vote')
                                        <div class="text-danger small mb-3">{{ $message }}</div>
                                    @enderror

                                    {{-- Notes Field --}}
                                    <div class="mb-4">
                                        {{-- <label for="notes"
                                            class="form-label">{{ __('client.polls.notes_optional') }}</label>

                                        <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="4"
                                            placeholder="{{ __('client.polls.notes_placeholder') }}">{{ old('notes') }}</textarea> --}}


                                        <x-form-group :properties="[
                                            'textarea' => [
                                                'name' => 'notes',
                                                'options' => [
                                                    'placeholder' => __('client.polls.notes_placeholder'),
                                                    'rows' => 4,
                                                    'id' => 'notes',
                                                ],
                                            ],
                                            'label' => [
                                                'text' => __('client.polls.notes_optional'),
                                            ],
                                        ]" />

                                        @error('notes')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-second btn-lg w-100">
                                        {{ __('client.polls.submit_vote') }}
                                    </button>



                                </form>
                            </div> {{-- Voting Form --}}
                        </div><!-- box -->
                    @endif





                </x-client-content>{{-- End Client Col Content --}}

            </div>
        </div>
    </main>


@endsection
@section('js')

    <script>
        $(document).ready(function() {
            // عند الضغط على أي زر تصويت
            $('.btn-check').on('change', function() {
                // إزالة active من كل الأزرار
                $('.btn-outline-success, .btn-outline-danger').removeClass('active');

                // إضافة active للزر المختار
                if ($(this).is(':checked')) {
                    $(this).next('label').addClass('active');
                }
            });

            // لو في زر محدد مسبقاً (old value)
            $('.btn-check:checked').next('label').addClass('active');
        });
    </script>

@endsection
