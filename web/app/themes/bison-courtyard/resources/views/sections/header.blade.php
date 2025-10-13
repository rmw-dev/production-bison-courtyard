<header
  x-data="{ open: false }"
  x-cloak
  class="banner text-white font-bold w-full {{ $pageSettings['solid_header'] === true ? 'bg-white relative' : 'absolute z-50' }}"
  @keydown.escape.window="open = false"
>
  {{-- HEADER BAR --}}
  <div class="max-w-[1920px] mx-auto p-4 lg:p-16 flex items-center justify-between {{ $pageSettings['solid_header'] === true ? 'bg-white' : '' }}">
    {{-- Logo --}}
    <a class="brand" href="{{ home_url('/') }}">
      <img
        src="{{ $pageSettings['solid_header'] === true ? Vite::asset('resources/images/logo-full-colour.svg') : Vite::asset('resources/images/logo-white.svg') }}"
        class="w-32 md:w-38 lg:w-64"
        alt="{!! $siteName !!}">
    </a>

    <!-- Toggle button -->
    <button
      type="button"
      class="z-100 hover:cursor-pointer outline-none focus:outline-none {{ $pageSettings['solid_header'] === true ? 'text-black solid' : 'text-white' }}"
      @click="open = !open"
      :aria-expanded="open.toString()"
      aria-controls="site-menu"
      aria-label="Toggle menu"
      x-bind:class="open ? 'open' : ''"
    >
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="64" height="64" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="butt" stroke-linejoin="miter">
        <line x1="1" y1="12" x2="23" y2="12"
              class="transition-all duration-200 ease-out"
              :style="open ? 'transform: rotate(45deg); transform-origin: 50% 50%;' : 'transform: translateY(-4px); transform-origin: 50% 50%;'" />
        <line x1="1" y1="12" x2="23" y2="12"
              class="transition-all duration-150 ease-out"
              :style="open ? 'opacity:0;' : 'opacity:1;'" />
        <line x1="1" y1="12" x2="23" y2="12"
              class="transition-all duration-200 ease-out"
              :style="open ? 'transform: rotate(-45deg); transform-origin: 50% 50%;' : 'transform: translateY(4px); transform-origin: 50% 50%;'" />
      </svg>
    </button>
  </div>

  @if (has_nav_menu('primary_navigation'))
    @php
      $top_items = array_filter($siteMenu, fn($i) => $i->menu_item_parent === '0');
      $firstId = $top_items ? reset($top_items)->db_id : null;

      $tree = [];
      foreach ($siteMenu as $item) {
        if ($item->menu_item_parent === '0') {
          $tree[$item->db_id] = ['item' => $item, 'children' => []];
        } else {
          $tree[$item->menu_item_parent]['children'][] = $item;
        }
      }
    @endphp

    {{-- DESKTOP OVERLAY --}}
    <div class="max-w-[1920px] mx-auto px-4 lg:px-16 relative hidden lg:block">
      <div class="absolute top-full left-0 right-0 z-50 pointer-events-none">
        <div class="{{ $pageSettings['solid_header'] ? 'px-24' : 'px-16' }}">
          <div
            x-data="{
              underline: { left: 0, width: 0 },
              active: '{{ $firstId }}',
              next: null,
              swapping: false,
              initialized: false,
              switchTo(id) { 
                if (id === this.active || this.swapping) return; 
                this.next = id; 
                this.swapping = true; 
              },
              onSwapEnd() {
                if (this.next !== null) {
                  this.active = this.next; this.next = null;
                  requestAnimationFrame(() => { this.swapping = false; });
                }
              }
            }"
            @resize.window="underline.left = 0; underline.width = 0; initialized = false"
            class="relative"
          >
            <div
              x-show="open"
              x-cloak
              @click.outside="open = false"
              x-init="$watch('open', v => {
                if (v && !initialized && $refs.first) {
                  requestAnimationFrame(() => {
                    underline.left = $refs.first.offsetLeft;
                    underline.width = $refs.first.offsetWidth;
                    initialized = true; // only set the first time
                  });
                }
              })"
              class="pointer-events-auto relative rounded-xl p-8 lg:p-16 bg-white/80 backdrop-blur-xl supports-[backdrop-filter]:bg-white/60 transition duration-200 ease-out will-change-transform shadow-xl/20"
              x-transition:enter="transition duration-250 ease-out"
              x-transition:enter-start="opacity-0 -translate-y-2"
              x-transition:enter-end="opacity-100 translate-y-0"
              x-transition:leave="transition duration-150 ease-in"
              x-transition:leave-start="opacity-100 translate-y-0"
              x-transition:leave-end="opacity-0 -translate-y-2"
            >
              <div class="absolute inset-x-0 -top-2 h-2 pointer-events-auto"></div>

              {{-- TOP LEVEL NAV --}}
              <nav id="site-menu" class="nav-primary relative flex justify-evenly">
                <span
                  class="absolute -bottom-2 h-[4px] transition-all duration-200 ease-out bg-theme-light-blue"
                  :style="`left:${underline.left}px; width:${underline.width}px;`"
                ></span>

                @foreach ($siteMenu as $item)
                  @if ($item->menu_item_parent === '0')
                    <a
                      href="{{ $item->url ?? '#' }}"
                      x-ref="{{ $loop->first ? 'first' : 'link' }}"
                      class="relative text-black font-normal text-3xl !decoration-none py-1"
                      @mouseenter.prevent="
                        switchTo('{{ $item->db_id }}');
                        underline.left = $el.offsetLeft;
                        underline.width = $el.offsetWidth;
                      "
                    >
                      {{ $item->title }}
                    </a>
                  @endif
                @endforeach
              </nav>

              {{-- RIGHT PANELS --}}
              <div
                class="relative w-full transition duration-150 ease-out will-change-transform"
                :class="swapping ? 'opacity-0 -translate-y-1' : 'opacity-100 translate-y-0'"
                @transitionend.self="onSwapEnd()"
              >
                @foreach ($siteMenu as $top_item)
                  @php 
                    $subMenuCount = count(array_filter($siteMenu, fn($i) => $i->menu_item_parent === $top_item->db_id));
                  @endphp
                  @if ($top_item->menu_item_parent === '0' && $subMenuCount > 0)
                    <template x-if="active === '{{ $top_item->db_id }}'">
                      <div class="w-full flex flex-col items-center menu-panel mt-16 ">
                        <h2 class="text-center text-black text-4xl font-[800]">{{ $top_item->title }}</h2>
                        <p class="text-center text-black font-normal text-2xl mt-8">{{ $top_item->description }}</p>

                        <div class="flex justify-center items-center mt-8 gap-8 w-full">
                          @foreach ($siteMenu as $item)
                            @if ($item->menu_item_parent === $top_item->db_id)
                              <a href="{{ $item->url ?? '#' }}" class="flex flex-col gap-4 w-1/5 text-black font-[800] text-3xl hover:-translate-y-2 duration-300 ease-out">
                                {!! wp_get_attachment_image($item->thumbnail, 'large', false, ['class' => 'w-full rounded-xl aspect-square object-cover', 'fetchpriority' => 'high']) !!}
                                <h3 class="!text-2xl no-underline">{{ $item->title }}</h3>
                              </a>
                            @endif
                          @endforeach
                        </div>
                      </div>
                    </template>
                  @endif
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endif

  @if (has_nav_menu('primary_navigation'))
    <div
      x-show="open"
      x-transition:enter="transition ease-out duration-200"
      x-transition:enter-start="opacity-0 translate-y-2"
      x-transition:enter-end="opacity-100 translate-y-0"
      x-transition:leave="transition ease-in duration-150"
      x-transition:leave-start="opacity-100 translate-y-0"
      x-transition:leave-end="opacity-0 translate-y-2"
      class="lg:hidden fixed inset-0 top-[calc(var(--header-height,0px))] z-50 bg-white/95 backdrop-blur-xl supports-[backdrop-filter]:bg-white/80 z-0"
      @click.outside="open = false"
      x-trap.noscroll="open"
    >
      <div class="p-6 pt-4 min-h-full flex flex-col justify-center">
        <nav
          class="flex flex-col gap-2 text-black text-2xl font-[800]"
          x-data="{ openIndex: null }"
        >
          @foreach ($tree as $idx => $parent)
            <div class="border-b border-gray-200 pb-2">
              <button
                type="button"
                class="w-full flex justify-between items-center py-2 text-left"
                @click="openIndex = (openIndex === {{ $idx }}) ? null : {{ $idx }}"
                :aria-expanded="openIndex === {{ $idx }}"
                aria-controls="submenu-{{ $idx }}"
              >
                <span>{{ $parent['item']->title }}</span>
                @if (!empty($parent['children']))
                  <svg xmlns="http://www.w3.org/2000/svg"
                      class="h-5 w-5 transition-transform duration-200"
                      :class="openIndex === {{ $idx }} ? 'rotate-180' : ''"
                      viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 9l-7 7-7-7" />
                  </svg>
                @endif
              </button>

              @if (!empty($parent['children']))
                <div
                  id="submenu-{{ $idx }}"
                  x-show="openIndex === {{ $idx }}"
                  x-collapse.duration.200ms
                  x-cloak
                  class="ml-4 flex flex-col gap-2 text-lg font-normal"
                >
                  @foreach ($parent['children'] as $child)
                    <a href="{{ $child->url ?? '#' }}" class="block py-1">{{ $child->title }}</a>
                  @endforeach
                </div>
              @endif
            </div>
          @endforeach
        </nav>
      </div>
    </div>
  @endif

</header>
