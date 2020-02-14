<!DOCTYPE html>
<html {!! $languageAttributes !!}>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $postTitle }}</title>

    <meta name="pubdate" content="{{ $postPublished }}">
    <meta name="moddate" content="{{ $postModified }}">

    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="format-detection" content="telephone=yes">
    <meta name="HandheldFriendly" content="true" />

    <script>
        var ajaxurl = '{!! $ajaxUrl !!}';
    </script>

    {{-- Wordpress required call --}}
    {!! wp_head() !!}

</head>
<body class="{{ $bodyClass }}">

    {{-- Site header --}}
    @section('header')
        @include('partials.header')
    @show

  

    @alert(['title' => 'HEJ'])
    @endalert

    @field([
    'type' => 'datepicker',
    'value' => isset($_GET['from']) && !empty($_GET['from']) ?
                    sanitize_text_field($_GET['from']) : '',
    'label' =>  _e('Date published', 'municipio'),
    'id' => 'filter-date-from',
    'name' => 'from',
    'attributeList' => [
        'type' => 'text',
        'name' => 'text',
        'data-invalid-message' => "You need to add a valid date!",
        'readonly' => 'readonly'
    ],
    'required' => false,
    'classList' => [
        'form-control',
        'datepicker-range',
        'datepicker-range-from'
    ],
    'datepicker' => [
        'title'                 => 'Välj ett datum',
        'minDate'               => false,
        'maxDate'               => false,
        'required'              => true,
        'showResetButton'       => true,
        'showDaysOutOfMonth'    => true,
        'showClearButton'       => true,
        'hideOnBlur'            => true,
        'hideOnSelect'          => false,
    ]
])
@endfield
@field([
    'type' => 'datepicker',
    'value' => isset($_GET["to"]) && !empty($_GET["to"]) ?
                    sanitize_text_field($_GET["to"]) : '',
    'label' =>   _e('To date', 'municipio'),
    'id' => 'filter-date-from',
    'name' => 'to',
    'attributeList' => [
        'type' => 'text',
        'name' => 'text',
        'data-invalid-message' => "You need to add a valid date!",
        'readonly' => 'readonly'
    ],
    'required' => false,
    'classList' => [
        'form-control',
        'datepicker-range',
        'datepicker-range-to'
    ],
    'datepicker' => [
        'title'                 => 'Välj ett datum',
        'minDate'               => false,
        'maxDate'               => false,
        'required'              => true,
        'showResetButton'       => true,
        'showDaysOutOfMonth'    => true,
        'showClearButton'       => true,
        'hideOnBlur'            => true,
        'hideOnSelect'          => false,
    ]
])
@endfield


    <main id="main">

        {{-- Before page layout --}}
        @yield('before-layout')

        {{-- Page layout --}}
        @section('layout')
            <div class="container main-container">
                <div class="grid grid--columns">
                    {{-- Above --}}
                    @hasSection('above')
                        <div class="grid-xs-12 s-above">
                            @yield('above')
                        </div>
                    @endif

                    {{-- Sidebar left --}} {{-- TODO: RENAME TO "SIDEBAR" --}}
                    @hasSection('sidebar-left')
                        <aside class="{{$layout['sidebarLeft']}} s-sidebar-left">
                            @yield('sidebar-left')
                        </aside>
                    @endif

                    {{-- Content --}}
                    <div class="{{$layout['content']}} s-content">
                        @yield('content')
                    </div>

                    {{-- Below --}}
                    @hasSection('below')
                        <div class="grid-xs-12 s-below order-xs-5">
                            @yield('below')
                        </div>
                    @endif
                </div>
            </div>
        @show

        {{-- After page layout --}}
        @yield('after-layout')
    </main>

    {{-- Site footer --}}
    @section('footer')
        @includeIf('partials.footer')
    @show

    {{-- Wordpress required call --}}
    {!! wp_footer() !!}

</body>
</html>