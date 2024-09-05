<div class="menu">
    <div class="menu-header">Navigation</div>
    <div class="menu-item {{ request()->is('home') ? ' active' : '' }}">
        <a href="{{ route('home') }}" class="menu-link">
            <span class="menu-icon"><i class="fas fa-lg fa-fw me-2 fa-home"></i></span>
            <span class="menu-text">{{ __('Dashboard') }}</span>
        </a>
    </div>
    <div class="menu-item {{ request()->is('*domain*') ? ' active' : '' }}">
        <a href="{{ route('domain.index') }}" class="menu-link">
            <span class="menu-icon"><i class="fas fa-lg fa-fw me-2 fa-server"></i></span>
            <span class="menu-text">{{ __('Domain') }}</span>
        </a>
    </div>
    <div
        class="menu-item {{ \Request::route()->getName() == 'googleadskeyword.index' || \Request::route()->getName() == 'googleadskeyword.filter' || \Request::route()->getName() == 'googleadskeyword.show' ? ' active' : '' }}">
        <a href="{{ route('googleadskeyword.index') }}" class="menu-link">
            <span class="menu-icon"><i class="fas fa-lg fa-fw me-2 fa-keyboard"></i></span>
            <span class="menu-text">{{ __('Analytics Keyword') }}</span>
        </a>
    </div>

    <div
        class="menu-item {{ \Request::route()->getName() == 'index-campaign' || \Request::route()->getName() == 'create-campaign' || \Request::route()->getName() == 'edit-campaign' || \Request::route()->getName() == 'campaign.filter' || \Request::route()->getName() == 'generate-headlines-show' || \Request::route()->getName() == 'generate-imageUpload' ? ' active' : '' }}">
        <a href="{{ route('index-campaign') }}" class="menu-link">
            <span class="menu-icon"><i class="fas fa-laptop fa-lg fa-fw me-2 fa-laptop"></i></span>
            <span class="menu-text">{{ __('Campaigns') }}</span>
        </a>
    </div>
    <div
        class="menu-item {{ \Request::route()->getName() == 'countries.index' || \Request::route()->getName() == 'create.countries' || \Request::route()->getName() == 'edit.countries' || \Request::route()->getName() == 'countries.filter' ? ' active' : '' }}">
        <a href="{{ route('countries.index') }}" class="menu-link">
            <span class="menu-icon"><i class="fas fa-globe fa-lg fa-fw me-2 fa-globe"></i></span>
            <span class="menu-text">{{ __('Countries') }}</span>
        </a>
    </div>

    <div
        class="menu-item {{ \Request::route()->getName() == 'campaign.show' || \Request::route()->getName() == 'ads-filter' ? ' active' : '' }}">
        <a href="{{ route('campaign.show') }}" class="menu-link">
            <span class="menu-icon"><i class="fa fa-lg fa-fw me-2 fa-facebook"></i></span>
            <span class="menu-text">{{ __('Facebook Accounts') }}</span>
        </a>
    </div>

    <div
        class="menu-item {{ \Request::route()->getName() == 'campaign-reporting' || \Request::route()->getName() == 'campaign-reporting.filter' || \Request::route()->getName() == 'campaign-reporting.show' || \Request::route()->getName() == 'campaign.filter' || \Request::route()->getName() == 'generate-headlines-show' || \Request::route()->getName() == 'generate-imageUpload' ? ' active' : '' }}">
        <a href="{{ route('campaign-reporting') }}" class="menu-link">
            <span class="menu-icon"><i class="fa fa-lg fa-fw me-2 fa-line-chart"></i> </span>
            <span class="menu-text">{{ __('Ads Reporting') }}</span>
        </a>
    </div>

    <div
        class="menu-item {{ \Request::route()->getName() == 'new-campaign-manually.index' || \Request::route()->getName() == 'new-campaign-manually.create' || \Request::route()->getName() == 'new-campaign-manually.edit' || \Request::route()->getName() == 'new-campaign-manually.adcreative' || \Request::route()->getName() == 'suboffer.index' || \Request::route()->getName() == 'suboffer.create' || \Request::route()->getName() == 'sub-offer.edit' || \Request::route()->getName() == 'AdsCreationOption.show' ? ' active' : '' }}">
        <a href="{{ route('new-campaign-manually.index') }}" class="menu-link">
            {{-- <i class="fa-solid fa-megaphone"></i> --}}
            <span class="menu-icon"><i class="fa fa-lg fa-fw me-2 fa-bullhorn"></i></span>
            <span class="menu-text">{{ __('Offer') }}</span>
        </a>
    </div>

    <div
        class="menu-item {{ \Request::route()->getName() == 'new-campaign-manually.index' || \Request::route()->getName() == 'new-campaign-manually.create' || \Request::route()->getName() == 'new-campaign-manually.edit' || \Request::route()->getName() == 'new-campaign-manually.adcreative' || \Request::route()->getName() == 'suboffer.index' || \Request::route()->getName() == 'suboffer.create' || \Request::route()->getName() == 'sub-offer.edit' || \Request::route()->getName() == 'AdsCreationOption.show' ? ' active' : '' }}">
        <a href="{{ route('new-campaign-manually.index') }}" class="menu-link">
            {{-- <i class="fa-solid fa-megaphone"></i> --}}
            <span class="menu-icon"><i class="fa fa-lg fa-fw me-2 fa-bullhorn"></i></span>
            <span class="menu-text">{{ __('Ads Library') }}</span>
        </a>
    </div>

    <div
        class="menu-item {{ \Request::route()->getName() == 'setting.index' || \Request::route()->getName() == 'add-campaign-name' ? ' active' : '' }}">
        <a href="{{ route('setting.index') }}" class="menu-link">
            <span class="menu-icon"><i class="fas fa-lg fa-fw me-2 fa-cog"></i></span>
            <span class="menu-text">{{ __('Settings') }}</span>
        </a>
    </div>

    {{-- adaccounts --}}

    <div class="menu-divider"></div>
</div>
