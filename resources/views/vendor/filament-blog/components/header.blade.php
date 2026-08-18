@props(['title' =>'Saffron Infosys Blog', 'logo' => null] )
<header @click.outside="showSearchModal = false" x-data="{ showSearchModal: false }" class="sticky top-0 z-[94035] mb-4">
    <div class="py-4 bg-white border-b">
        <div class="container mx-auto">
            <div class="flex justify-between gap-x-4">
                <div>
                    <a class="flex items-center gap-x-3" href="{{config('filamentblog.route.home.url') ?? config('app.url')}}">
                            @if($logo)
                            <img src="{{ $logo }}" alt="{{ $title }}" class="max-h-[60px]" />
                            @endif
                            
                        <div>
                            @php
                                $app_title = strip_tags($title ?: config('app.name'));
                                $split_title = explode(' ', $app_title);
                            @endphp

                            <strong class="text-lg sm:text-2xl text-{{ '['.@$site_setting->primary_color.']' ?? 'primary-800' }} text-uppercase block">
                                {{ $split_title[0] ?? '' }} {{ $split_title[1] ?? '' }}
                            </strong>

                            @if (!empty($split_title[2]))
                                <div class="text-{{ '['.@$site_setting->primary_color.']' ?? 'primary-800' }} font-semibold text-uppercase">
                                    {{ \Illuminate\Support\Str::after($app_title, $split_title[1]) }}
                                </div>
                            @endif
                        </div>
                    </a>
                </div>
                <div class="flex items-center ml-auto gap-x-10">
                    <div class="hidden gap-x-10 sm:flex">
                        <a href="{{ route('welcome') }}" class="font-semibold text-md hover:text-{{ '['.@$site_setting->primary_color.']' ?? 'primary-800' }}">
                            <span>Home</span>
                        </a>
                        <a href="{{ route('filamentblog.post.index') }}" class="font-semibold text-md hover:text-{{ '['.@$site_setting->primary_color.']' ?? 'primary-800' }}">
                            <span>Blogs</span>
                        </a>
                        <div class="relative group">
                            <button class="flex items-center justify-center font-semibold text-md hover:text-{{ '['.@$site_setting->primary_color.']' ?? 'primary-800' }} gap-x-2">
                                <span>Categories</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4" viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m19 9l-7 6l-7-6" />
                                </svg>
                            </button>
                            <div class="absolute right-1 group-hover:pointer-events-auto top-[calc(100%)] origin-left pt-1 opacity-0 pointer-events-none transition will-change-transform lg:left-[30%] lg:right-auto lg:translate-x-[-50%] group-hover:opacity-100">
                                <x-blog-header-category />
                            </div>
                        </div>
                    </div>
                <div x-data="{ open: false }" class="flex items-center ml-auto gap-x-10 relative">
                    <form action="{{ route('filamentblog.post.search') }}" method="GET" class="relative">
                        <!-- Search icon -->
                        <svg
                            @click="open = !open"
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5 cursor-pointer text-slate-500"
                            viewBox="0 0 24 24"
                        >
                            <g fill="none" stroke="currentColor" stroke-width="1.5">
                                <circle cx="11.5" cy="11.5" r="9.5" />
                                <path stroke-linecap="round" d="M18.5 18.5L22 22" />
                            </g>
                        </svg>

                        <!-- Input, toggled by open and absolutely positioned -->
                        <input
                            x-show="open"
                            x-transition
                            placeholder="Search"
                            type="text"
                            name="query"
                            value="{{ request()->get('query') }}"
                            class="absolute right-0 top-full mt-3 w-64 px-6 py-3 pl-12 text-sm font-medium text-gray-800 placeholder-gray-400 border border-gray-200 rounded-full outline-none bg-white/90 placeholder:text-slate-500 focus:ring-0 shadow-lg z-50"
                            @click.away="open = false"
                            autocomplete="off"
                            style="display: none;"
                        />

                        @error('query')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </form>
                </div>
                </div>


            </div>
        </div>
    </div>
</header>
