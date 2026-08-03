
<form class="form" action="{{ route('crm.clients.notes.store', $client->uuid) }}" method="post"
    enctype="multipart/form-data">
    @csrf

    <x-panel-with-heading title="ملاحظة جديدة" icon='<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-note"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M13 20l7 -7" /><path d="M13 20v-6a1 1 0 0 1 1 -1h6v-7a2 2 0 0 0 -2 -2h-12a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7" /></svg>'>

        <x-form-group :properties="[
            'textarea' => [
                'name' => 'note',
                'options' => [
                    'required',
                    'rows' => 4,
                    'placeholder' => 'ضع ملاحظاتك عن العميل | تتم مشاركة الملاحظات داخليًّا فقط بين الفريق.',
                ],
            ],
            'label' => [
                'text' => 'الملاحظة',
            ],
        ]" /><!-- notes -->

        <button type="submit" class="btn btn-main">حفظ الملاحظة</button>

    </x-panel-with-heading> <!--  personal data -->

</form><!-- end form -->


@php
    $panelTitle =
        '<span class="number-of-notes text-black"> <span> الملاحظات </span>(<span class=" font-weight-700"> ' .$notesCount .' </span>)</span>';
@endphp
<x-panel-with-heading title="{!! $panelTitle !!}"
    icon='<svg class="icon icon-tabler icon-tabler-message icons-tabler-outline"fill=none height=20 stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=2 viewBox="0 0 24 24" width=20 xmlns=http://www.w3.org/2000/svg><path d="M0 0h24v24H0z"fill=none stroke=none /><path d="M8 9h8"/><path d="M8 13h6"/><path d="M18 4a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-5l-5 3v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12z"/></svg>'>


    @forelse($notes as $noteRow)
        <div class="parents {{ $loop->last ? 'mb-0' : 'mb-3' }}">

            <div class="border radius p-3">

                <div class="d-flex justify-content-between mb-1">

                    <div class="small icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-user-circle">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                            <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                            <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
                        </svg>
                        {{ optional($noteRow->creator)->full_name ?? 'النظام' }}
                    </div><!-- creator -->

                    <div class="small ltr icon">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-clock-hour-4">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                <path d="M12 12l3 2" />
                                <path d="M12 7v5" />
                            </svg>
                        </span>

                        <span>{{ $noteRow->created_at->format('Y-m-d • H:i') }}</span>
                    </div><!-- date -->

                </div>

                <div class="note-details text-muted">
                    <span style="white-space: pre-wrap;" class="note-{{ $noteRow->id }}">{{ $noteRow->note }}</span>
                </div><!-- note -->

            </div>

            <!-- Start Actions Delete + Edit -->
            <div class=" fa-pull-left">

                <button type="button" data-id="{{ $noteRow->id }}"
                    class="btn-edit-note text-primary text-decoration-underline font-12 ml-2">تعديل
                    الملاحظة</button>

                <form class="ajax-delete d-inline-block"
                    action="{{ route('crm.clients.notes.destroy', [$client->uuid, $noteRow->id]) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit" data-delete="هل تريد حذف الملاحظة ؟"
                        class="text-danger text-decoration-underline font-12">حذف
                        الملاحظة</button>
                </form><!-- delete -->

            </div>
            <div class="clearfix"></div>

        </div>
    @empty
        <p class="text-muted text-center pt-3">لا يوجد ملاحظات بعد</p>
    @endforelse

</x-panel-with-heading>



<div class="modal fade" id="modelEditNote" tabindex="-1" role="dialog" aria-labelledby="addTagModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form class="form form-edit-note" method="post">

                <div class="modal-header">
                    <h5 class="modal-title" id="addTagModalLabel">تعديل ملاحظة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <x-form-group :properties="[
                        'textarea' => [
                            'name' => 'note',
                            'options' => ['required', 'rows' => 4],
                        ],
                        'label' => [
                            'text' => 'الملاحظة',
                        ],
                    ]" /><!-- notes -->
                </div>
                <div class="modal-footer ">
                    <button type="submit" class="btn btn-submit btn-main px-4">تحديث</button>
                    <button type="button" class="btn btn-outline-main" data-dismiss="modal">رجوع</button>
                </div>
            </form><!-- end form -->
        </div>
    </div>
</div>
