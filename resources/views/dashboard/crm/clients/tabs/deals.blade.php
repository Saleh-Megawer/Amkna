 <x-panel-with-heading title="{{ $currentTabName }}">
     <div class="table-responsive">
         <table class="table table-bordered text-center table-striped  table-inverse">
             <thead>
                 <tr>
                     <th>#</th>
                     <th>تاريخ الإنشاء</th>
                     <th>نوع الصفقة</th>
                     <th>الحالة</th>
                     <th>المكلّف</th>
                     <th>قيمة الصفقة</th>
                 </tr>
             </thead>

             <tbody>
                 @forelse ($deals as $deal)
                     <tr class="parents pointer" onclick="window.location='{{ route('crm.deals.edit', $deal->uuid) }}'">

                         <td>{{ $deal->id }}</td>

                         {{-- Created At --}}
                         <td class="ltr">{{ $deal->created_at->format('Y-m-d • H:i') }}</td>

                         <td>
                             @if ($deal->purpose === 'buy')
                                 شراء
                             @elseif($deal->purpose === 'rent')
                                 إيجار
                             @else
                                 -
                             @endif
                             /
                             {{ optional($deal->propertyType)->name ?? '-' }}
                         </td>

                         {{-- Status --}}
                         <td>{{ optional($deal->status)->name ?? '-' }}</td>

                         {{-- Assigned Admin --}}
                         <td>{{ optional($deal->assignedTo)->full_name ?? '-' }}</td>

                         {{-- Amount --}}
                         <td>
                             @if ($deal->amount)
                                 {{ number_format($deal->amount) }}
                                 {!! currency_icon('sm') !!}
                             @else
                                 -
                             @endif
                         </td>

                     </tr>

                 @empty
                     <tr>
                         <td colspan="11" class="text-center pt-4 text-muted">لا توجد بيانات بعد</td>
                     </tr>
                 @endforelse
             </tbody>
         </table>
     </div>
 </x-panel-with-heading> <!--  personal data -->
