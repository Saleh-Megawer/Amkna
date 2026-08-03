<div class="dropdown d-inline-block dropdown-basic  w-100">
    <button class="btn btn-sm btn-secondary btn-block  dropdown-toggle" 
            type="button" 
            id="dropdownStatus{{ $interest->id }}" 
            data-toggle="dropdown" 
            aria-haspopup="true" 
            aria-expanded="false">
        تحديث الحالة
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownStatus{{ $interest->id }}">
        <form class="form-interests-status" method="POST" action="{{ route('crm.interests.update-status') }}">
            @csrf
            <input type="hidden" name="interest_id" value="{{ $interest->id }}">
            
            @foreach($options as $option)
                <button type="submit" 
                        name="status" 
                        value="{{ $option['status'] }}" 
                        class="dropdown-item">
                     {!! $option['icon'] !!}
                    {{ $option['label'] }}
                </button>
            @endforeach
        </form>
    </div>
</div>
