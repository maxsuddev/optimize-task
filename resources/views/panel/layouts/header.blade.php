<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
        <a href="index.html" class="logo d-flex align-items-center">
            <img src="" alt="Logo">
            <span class="d-none d-lg-block">Test</span>
        </a>
        {{-- <i class="bi bi-list toggle-sidebar-btn"></i> --}}
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
                    <!-- Language Selector -->
        <li class="nav-item dropdown pe-3">
            @php
                $locales = ['uz' => 'UZ', 'ru' => 'RU', 'en' => 'ENG'];
                $currentLocale = app()->getLocale();
            @endphp

            <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                <span class="d-none d-md-block dropdown-toggle ps-2">{{ strtoupper($currentLocale) }}</span>
            </a>

            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                @foreach($locales as $locale => $label)
                    @if($locale !== $currentLocale)
                        <li>
                            <a class="dropdown-item" href="{{ route('locale.switch', $locale) }}">
                                {{ $label }}
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </li><!-- End Language Selector -->
         
            <!-- User Profile -->
            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    {{-- <img src="" alt="Profile" class="rounded-circle"> --}}
                    <span class="d-none d-md-block dropdown-toggle ps-2">{{ auth()->user()->name }}</span>
                </a><!-- End Profile Image Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>{{__('pageText.logout')}}</span>
                        </a>
                        <!-- Logout Form -->
                        <form id="logout-form" action="{{ route('logout') }}" method="GET" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->
        </ul>
    </nav><!-- End Icons Navigation -->
</header><!-- End Header -->
