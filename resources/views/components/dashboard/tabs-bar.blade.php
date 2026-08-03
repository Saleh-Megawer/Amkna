  @push('after-navbar')
      <div id="tabs-bar" class="bg-white p-3">
          <div class="d-flex">
              @foreach ($tabs as $tab)
                  @php
                      $type = $tab['link_type'] ?? 'query';
                      $href = $type === 'anchor' ? "#{$tab['link']}" : "?tab={$tab['link']}";
                  @endphp

                  <a href="{{ $href }}" class="tab {{ $activeTab == $tab['link'] ? 'active-tab' : '' }}">
                      {{ $tab['name'] }}
                  </a>
              @endforeach
          </div>
      </div>
  @endpush
