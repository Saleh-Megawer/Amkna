{{-- 
|--------------------------------------------------------------------------
| Delete Form Component – Usage Examples
|--------------------------------------------------------------------------
|
| Basic usage with model name (default confirm message):
|
| <x-delete-form 
|     :action="route('crm.clients.destroy', $row)" 
|     :name="$row->name" 
| />
|
|--------------------------------------------------------------------------
|
| Icon only (no text label):
|
| <x-delete-form 
|     :action="route('crm.clients.destroy', $row)" 
|     icon-only 
| />
|
|--------------------------------------------------------------------------
|
| Custom confirm message:
|
| <x-delete-form 
|     :action="route('crm.clients.destroy', $row)" 
|     confirm="هل تريد حذف هذا العنصر نهائياً؟" 
| />
|
|--------------------------------------------------------------------------
|
| Custom button text using slot:
|
| <x-delete-form :action="route('crm.clients.destroy', $row)">
|     إزالة
| </x-delete-form>
|
|--------------------------------------------------------------------------
|
| Full control (name + custom message + icon only):
|
| <x-delete-form 
|     :action="route('crm.clients.destroy', $row)" 
|     :name="$row->name"
|     confirm="سيتم حذف العميل نهائياً!"
|     icon-only
| />
|--------------------------------------------------------------------------
| Dropdown / custom form & button classes:
|
| <x-delete-form
|     form-class="dropdown-item ajax-delete"
|     button-class="p-0 bg-transparent text-danger"
|     :action="route('owner-associations.requests.destroy', [$ownerAssociation->uuid, $request->id])"
|     :name="$request->title"
| />
|--------------------------------------------------------------------------
| Notes:
| - name is optional
| - confirm overrides default message
| - icon-only hides text label
| - slot replaces default "حذف" text
|--------------------------------------------------------------------------
--}}

@props([
    'action',
    'name' => null,
    'confirm' => null,
    'iconOnly' => false,
    'iconSize' => 16,
    'formClass' => '',
    'ajax' => true,
    'buttonClass' => 'p-0 font-16 bg-transparent text-danger',
])

@php
    $message = $confirm ?? ($name ? "هل أنت متأكد من حذف: $name" : 'هل أنت متأكد من الحذف؟');

    // This Use Swal Ajax Or Go to page
    $formClass .= $ajax ? ' ajax-delete' : ' delete';

@endphp

<form class="{{ $formClass }}" action="{{ $action }}" method="POST">
    @method('DELETE')
    @csrf

    <button type="submit" data-delete="{{ $message }}" class="{{ $buttonClass }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="{{ $iconSize }}" height="{{ $iconSize }}" viewBox="0 0 24 24"
            fill="none" stroke="currentColor" stroke-width="2">
            <path d="M4 7h16" />
            <path d="M10 11v6" />
            <path d="M14 11v6" />
            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
            <path d="M9 7V4h6v3" />
        </svg>

        @unless ($iconOnly)
            {{ trim($slot) !== '' ? $slot : 'حذف' }}
        @endunless

    </button>
</form>
