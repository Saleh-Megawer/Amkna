 @props([
     'route',
     'noRedirect' => false,
     'method' => 'POST',
     'row' => null,
     'currentTab' => null,
     'currentTabName' => null,
 ])




 <form class="form" action="{{ $route }}" method="post" enctype="multipart/form-data">
     @csrf
     <input type="hidden" name="tab" value="{{ $currentTab }}">
     @if ($noRedirect)
         <input type="hidden" name="noRedirect" value="1">
     @endif
     @if ($method !== 'POST')
         @method($method)
     @endif

     <x-panel-with-heading title="{{ $currentTabName }}">

         <div class="form-row">

             <div class="{{ $row != null ? 'col-md-6' : 'col-12' }}">
                 <x-form-group :properties="[
                     'input' => [
                         'name' => 'name',
                         'type' => 'text',
                         'value' => $row?->name,
                         'options' => ['required', 'placeholder' => 'اسم العميل'],
                     ],
                     'label' => [
                         'text' => 'اسم العميل',
                         'options' => [
                             'class' => 'required',
                         ],
                     ],
                 ]" /><!-- name -->
             </div>

             @if ($row)
                 <div class="col-md-6">
                     <x-form-group :properties="[
                         'input' => [
                             'name' => 'readonly',
                             'type' => 'text',
                             'value' => $row?->source_display,
                             'options' => ['readonly'],
                         ],
                         'label' => [
                             'text' => 'مصدر العميل',
                         ],
                     ]" /><!--  -->
                 </div>
             @endif

             <div class="col-md-12">
                 <x-dashboard.input-phone phone="{{ $row?->phone }}" code="{{ $row?->country_code }}" />
                 <!-- phone-inputs -->
             </div>

             <div class="col-md-12">
                 <x-form-group :properties="[
                     'input' => [
                         'name' => 'email',
                         'type' => 'email',
                         'value' => $row?->email,
                         'options' => ['placeholder' => 'البريد الإلكتروني (اختياري)'],
                     ],
                     'label' => [
                         'text' => 'البريد الإلكتروني',
                     ],
                 ]" />
             </div><!-- email -->


             <div class="col-md-6">
                 <x-form-group :properties="[
                     'input' => [
                         'type' => 'date',
                         'name' => 'birth_date',
                         'value' => $row?->birth_date,
                     ],
                     'label' => [
                         'text' => __('client.profile.birth_date'),
                     ],
                 ]" />
             </div>{{-- Date of Birth --}}

             <div class="col-md-6">
                 <x-form-group :properties="[
                     'input' => [
                         'type' => 'number',
                         'name' => 'national_id',
                         'value' => $row?->national_id,
                         'options' => [
                             'maxlength' => 20,
                         ],
                     ],
                     'label' => [
                         'text' => __('client.profile.national_id'),
                     ],
                 ]" />
             </div> {{-- National ID --}}

             <div class="col-12">
                 <x-form-group :properties="[
                     'input' => [
                         'type' => 'text',
                         'name' => 'national_address',
                         'value' => $row?->national_address,
                         'options' => [
                             'maxlength' => 255,
                         ],
                     ],
                     'label' => [
                         'text' => __('client.profile.national_address'),
                     ],
                 ]" />
             </div>{{-- National Address --}}




         </div><!-- end row -->

     </x-panel-with-heading> <!--  personal data -->

     <button class="btn btn-main px-5" type="submit">حفظ</button>
 </form><!-- end form -->
