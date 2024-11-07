<div class="dashboard__left__main">
    <div class="dashboard__left__close close-bars"><i class="fa-solid fa-times"></i></div>
    <div class="dashboard__top">
        <div class="dashboard__top__logo">
            <a href="index.html">
                <img class="main_logo" src="{{ asset('assets/img/logo.webp') }}" alt="logo">
                <img class="iocn_view__logo" src="{{ asset('assets/img/logo.webp') }}" alt="logo_icon">
            </a>
        </div>
    </div>
    <div class="dashboard__bottom mt-5">
        <ul class="dashboard__bottom__list dashboard-list">
            <li class="dashboard__bottom__list__item has-children {{ Route::is('home') ? 'active' : '' }}">
                <a href="{{ route('home') }}">
                    <i class="material-symbols-outlined">
                        dashboard
                    </i>
                    <span class="icon_title">Dashboard</span>
                </a>
            </li>
            <li class="dashboard__bottom__list__item has-children">
                <a href="{{ route('country') }}">
                    <span class="icon_title">Country</span>
                </a>
            </li>
            <li class="dashboard__bottom__list__item has-children">
                <a href="{{ route('state') }}">
                    <span class="icon_title">State</span>
                </a>
            </li>
            <li class="dashboard__bottom__list__item has-children">
                <a href="{{ route('city') }}">
                    <span class="icon_title">City</span>
                </a>
            </li>
            <li class="dashboard__bottom__list__item">
                <a href="javascript:void(0)" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
                    <i class="material-symbols-outlined">
                        logout
                    </i>
                    <span class="icon_title">
                        Log Out
                    </span>
                </a>
                <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</div>
