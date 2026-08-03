@extends('dashboard.layouts.master')
@section('title', $linksMap['edit']['title'] . '#' . $client->id)
<x-dashboard.css :links="[
    [
        'link' => 'clients/edit.css',
    ],
]" />
@section('meta')
    <meta name="url-get-note" content="{{ route('crm.clients.notes.getNote', $client->uuid) }}">
    <meta name="url-edit-note" content="{{ route('crm.clients.notes.update', $client->uuid) }}">
@endsection
@section('content')

    {{-- <x-dashboard.links-bar :links="[
        [
            'name' => $linksMap['index']['title'],
            'link' => $linksMap['index']['url'],
        ],
        [
            'name' => $linksMap['edit']['title'] . '#' . $client->id,
        ],
    ]" /><!-- links bar --> --}}

    @push('after-navbar')
        <div id="tabs-bar" class="bg-white p-3">
            <div class="d-flex">
                @foreach ($tabs as $tab)
                    <a href="?tab={{ $tab['link'] }}" class="tab {{ $currentTab == $tab['link'] ? 'active-tab' : '' }}">
                        {{ $tab['name'] }}
                        @if ($tab['link'] == 'notes')
                            ({{ $notesCount }})
                        @endif

                        @if ($tab['link'] == 'logs')
                            ({{ $logsCount }})
                        @endif

                    </a>
                @endforeach
            </div>
        </div><!--  -->
    @endpush

    <main class="mb-5">





        <div class="row justify-content-center ">


            <div class="col-xl-9 col-lg-12">


                <div class="d-flex align-items-center mb-1">

                    <h4 class="mt-3 font-20 font-weight-600">
                        <a href="{{ route('crm.clients.index') }}">{{ $linksMap['index']['title'] }}</a>
                    </h4>

                    <span class="mx-2 mt-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M5 12l14 0" />
                            <path d="M5 12l6 6" />
                            <path d="M5 12l6 -6" />
                        </svg>
                    </span>

                    <h4 class="mt-3 font-16 font-weight-600">{{ $client->name }}</h4>

                </div><!-- links bar -->


                <div class="d-flex mb-4">

                    <div class="border bg-white radius font-13 px-2 text-black ml-1">

                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-hash">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M5 9l14 0" />
                            <path d="M5 15l14 0" />
                            <path d="M11 4l-4 16" />
                            <path d="M17 4l-4 16" />
                        </svg>

                        <span>رقم العميل : {{ $client->id }}</span>
                    </div><!-- id -->

                    <div class="border bg-white radius font-13 px-2 text-black">

                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-week">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                            <path d="M16 3v4" />
                            <path d="M8 3v4" />
                            <path d="M4 11h16" />
                            <path d="M7 14h.013" />
                            <path d="M10.01 14h.005" />
                            <path d="M13.01 14h.005" />
                            <path d="M16.015 14h.005" />
                            <path d="M13.015 17h.005" />
                            <path d="M7.01 17h.005" />
                            <path d="M10.01 17h.005" />
                        </svg>

                        <span>تاريخ التسجيل
                            {{ \Carbon\Carbon::parse($client->created_at)->locale('ar')->translatedFormat('d F Y') }}
                        </span>
                    </div><!-- created_at -->

                </div><!-- id + created_at -->


                @switch($currentTab)
                    @case('main')
                        @include('dashboard.crm.clients.tabs.main', [
                            'route' => route('crm.clients.update', $client->uuid),
                            'method' => 'PATCH',
                            'row' => $client,
                            'currentTab' => $currentTab,
                            'currentTabName' => $currentTabName,
                        ])
                    @break

                    @case('deals')
                        @include('dashboard.crm.clients.tabs.deals', ['deals' => $deals])
                    @break

                    @case('notes')
                        @include('dashboard.crm.clients.tabs.notes', ['notes' => $notes])
                    @break

                    @case('logs')
                        @include('dashboard.crm.clients.tabs.logs', ['logs' => $logs])
                    @break

                    @default
                        <p>This Tab Not Exists <a href="{{ route('crm.clients.index') }}">Go Back</a></p>
                @endswitch


            </div><!-- end col-lg-10 -->

            {{-- 
            <div class="col-xl-3">
                <x-panel-with-heading title="التفاصيل"
                    icon='<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user-exclamation"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4c.348 0 .686 .045 1.008 .128" /><path d="M19 16v3" /><path d="M19 22v.01" /></svg>'>

                    <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                        <span class="key font-weight-500 text-secondary">المعرف :</span>
                        <span class="val font-weight-600">#{{ $client->id }}</span>
                    </div>


                    <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                        <span class="key font-weight-500 text-secondary">الاسم :</span>
                        <span class="val font-weight-600">{{ $client->name }}</span>
                    </div>


                    <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                        <span class="key font-weight-500 text-secondary">البريد :</span>
                        <span class="val font-weight-600">{{ $client->email }}</span>
                    </div>







                </x-panel-with-heading> <!--  personal data -->
            </div> --}}


        </div><!-- end row -->
    </main><!-- section -->


    <div class="modal fade" id="addTagModal" tabindex="-1" role="dialog" aria-labelledby="addTagModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTagModalLabel">إضافة وسم جديد</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>اسم الوسم</label>
                        <input type="text" id="newTagName" class="form-control" placeholder="اسم الوسم">
                    </div>
                    <div class="form-group">
                        <label>اللون</label>
                        <input type="color" id="newTagColor" class="form-control" value="#4b7bff">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                    <button type="button" class="btn btn-primary" id="saveTag">حفظ</button>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('js')
    <script>
        // $(document).ready(function() {
        //     let tagsSelect = document.getElementById('tags');
        //     const choices = new Choices('#tags', {
        //         removeItemButton: true,
        //         shouldSort: false,
        //         searchPlaceholderValue: 'ابحث عن وسم...',
        //         itemSelectText: '',
        //         direction: 'rtl',
        //     });

        //     // 🎨 تلوين العناصر المختارة
        //     function updateTagColors() {
        //         document.querySelectorAll('.choices__list--multiple .choices__item').forEach(item => {
        //             const value = item.getAttribute('data-value');
        //             const option = document.querySelector(`#tags option[value="${value}"]`);
        //             const color = option?.dataset.color;
        //             if (color) {
        //                 item.style.backgroundColor = color;
        //                 item.style.color = '#fff';
        //                 item.style.borderColor = color;
        //             }
        //         });
        //     }

        //     // أول تحميل
        //     updateTagColors();

        //     // حدث عند التغيير أو فتح القائمة
        //     document.querySelector('#tags').addEventListener('change', () => {
        //         updateTagColors();
        //     });


        //     // فتح المودال عند اختيار "إضافة وسم جديد"
        //     tagsSelect.addEventListener('change', (event) => {
        //         const selected = event.target.value;
        //         if (selected === 'new-tag') {
        //             choices.removeActiveItemsByValue('new-tag');
        //             $('#addTagModal').modal('show');
        //         }
        //     });

        //     // حفظ الوسم الجديد
        //     $('#saveTag').on('click', function() {
        //         const name = $('#newTagName').val().trim();
        //         const color = $('#newTagColor').val();

        //         if (name !== '') {
        //             choices.setChoices(
        //                 [{
        //                     value: name,
        //                     label: name,
        //                     selected: true,
        //                     customProperties: {
        //                         color
        //                     }
        //                 }],
        //                 'value',
        //                 'label',
        //                 false
        //             );

        //             $('#addTagModal').modal('hide');
        //             $('#newTagName').val('');
        //         }
        //     });



        // });

        $(function() {

            // Select modal and important elements
            const modelEditNote = $('#modelEditNote'),
                urlGetNote = $('meta[name="url-get-note"]').attr("content"),
                urlEditNote = $('meta[name="url-edit-note"]').attr("content"),
                formEditNote = modelEditNote.find('form'),
                textareaEditNote = formEditNote.find('textarea'),
                btnSubmitEditNote = formEditNote.find('button[type="submit"]');

            let noteId = null;

            // Open the modal and load note content
            $('.btn-edit-note').on('click', function(e) {
                e.preventDefault();

                // Get the clicked note ID
                noteId = $(this).data('id');

                // Store note ID inside submit button
                btnSubmitEditNote.data('id', noteId);

                // Show edit modal
                modelEditNote.modal('show');

                // Request note content from the server
                $.post(`${urlGetNote}/${noteId}`, function(note) {

                    // Adjust textarea rows based on line count
                    const lines = note.split('\n').length;
                    textareaEditNote
                        .attr('rows', Math.min(lines + 1, 15))
                        .val(note);

                    // Set form action URL dynamically
                    formEditNote.attr('action', `${urlEditNote}/${noteId}`);

                }, 'json');
            });

            // Update note text inside the page after saving
            btnSubmitEditNote.on('click', function() {
                const id = $(this).data('id');

                // Replace rendered note text with new value
                $(`.note-${id}`).html(textareaEditNote.val());

                // Hide modal after update
                setTimeout(() => {
                    modelEditNote.modal('hide');
                }, 500);
            });

        });
    </script>
@endsection
