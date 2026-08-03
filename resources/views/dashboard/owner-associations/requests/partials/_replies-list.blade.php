<div class="replies-chat">
    @forelse($replies as $reply)
        <div class="parents media {{ $reply->isFromClient() ? 'flex-row-reverse' : '' }}"
            data-reply-id="{{ $reply->id }}">

            {{-- الصورة الرمزية مع المسافة --}}
            <div
                class="reply-avatar {{ $reply->isFromClient() ? 'mr-3' : 'ml-3' }} 
                        {{ $reply->isFromClient() ? 'bg-gradient-purple' : 'bg-gradient-pink' }}">
                {{ mb_substr($reply->replier_name, 0, 1) }}
            </div>

            {{-- المحتوى --}}
            <div class="media-body">
                <div class="card border-0 {{ $reply->isFromClient() ? 'client-bubble' : 'admin-bubble' }}">
                    <div class="card-body">
                        {{-- Header --}}
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="flex-grow-1">
                                <h6 class="mb-1 font-weight-bold" style="font-size: 0.95rem;">
                                    {{ $reply->replier_name }}
                                    <span class="badge badge-light badge-pill font-weight-500 px-2 py-1"
                                        style="font-size: 0.7rem;">
                                        {{ $reply->replier_role }}
                                    </span>
                                </h6>
                                <div class="d-flex align-items-center flex-wrap">

                                    <small class="text-muted" style="font-size: 0.75rem;">
                                        {{ $reply->created_at->diffForHumans() }}
                                    </small>
                                </div>
                            </div>

                            @if ($reply->canBeDeleted())
                                <div class="p-0 ml-2 btn-delete-reply">
                                    <x-dashboard.delete-form :action="route('owner-associations.requests.replies.destroy', [
                                        $ownerAssociation->uuid,
                                        $request->id,
                                        $reply->id,
                                    ])" icon-only icon-size="18"
                                        confirm="هل تريد حذف الرسالة : {{ Str::limit($reply->message, 40) }}" />

                                </div>
                            @endif
                        </div>

                        {{-- الرسالة --}}
                        <p class="mb-0" style="line-height: 1.6; color: #495057; word-wrap: break-word;">
                            {{ $reply->message }}
                        </p>

                        {{-- نوع الرد --}}
                        @if ($reply->type !== 'comment')
                            <span class="badge badge-secondary  mt-2" style="font-size: 0.7rem;">
                                {{ $reply->type }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-5">
            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="1.5" class="text-muted mb-3" style="opacity: 0.3;">
                <path d="M3 20l1.3 -3.9a9 8 0 1 1 3.4 2.9l-4.7 1" />
                <path d="M12 12l0 .01" />
                <path d="M8 12l0 .01" />
                <path d="M16 12l0 .01" />
            </svg>
            <h6 class="text-muted">لا توجد ردود بعد</h6>
            <p class="text-muted small mb-0">كن أول من يضيف تعليق على هذا الطلب</p>
        </div>
    @endforelse
</div>
