@php($appProps = $page['props']['app'])

{{-- Inertia Meta Tags --}}
<meta
    inertia
    head-key="description"
    name="description"
    content="{{ $appProps['meta']['description'] }}">
<meta
    inertia
    head-key="og:type"
    property="og:type"
    content="{{ $appProps['meta']['type'] }}">
<meta
    inertia
    head-key="og:title"
    property="og:title"
    content="{{ $appProps['meta']['title']['default'] }}">
<meta
    inertia
    head-key="og:description"
    property="og:description"
    content="{{ $appProps['meta']['description'] }}">
<meta
    inertia
    head-key="og:site_name"
    property="og:site_name"
    content="{{ $appProps['name'] }}">
<meta
    inertia
    head-key="og:image"
    property="og:image"
    content="{{ $appProps['meta']['image'] }}">
<meta
    inertia
    head-key="twitter:card"
    property="twitter:card"
    content="{{ $appProps['meta']['twitter_card'] }}">
<meta
    inertia
    head-key="twitter:title"
    property="twitter:title"
    content="{{ $appProps['name'] }}">
<meta
    inertia
    head-key="twitter:description"
    property="twitter:description"
    content="{{ $appProps['meta']['description'] }}">
<meta
    inertia
    head-key="twitter:site"
    property="twitter:site"
    content="{{ $appProps['social']['twitter']['at'] }}">
<meta
    inertia
    head-key="twitter:image"
    property="twitter:image"
    content="{{ $appProps['meta']['image'] }}">
<meta
    inertia
    head-key="theme-color:light"
    name="theme-color"
    content="{{ $appProps['meta']['theme']['light'] }}"
    media="(prefers-color-scheme: light)">
<meta
    inertia
    head-key="theme-color:dark"
    name="theme-color"
    content="{{ $appProps['meta']['theme']['dark'] }}"
    media="(prefers-color-scheme: dark)">
<link
    head-key="favicon"
    rel="icon"
    href="/favicon.png"
    sizes="32x32">
<link
    head-key="favicon-128"
    rel="icon"
    href="/images/icons/icon-128x128.png"
    sizes="128x128">
<link
    head-key="favicon-180"
    rel="icon"
    href="/images/icons/icon-180x180.png"
    sizes="180x180">
<link
    head-key="favicon-192"
    rel="icon"
    href="/images/icons/icon-192x192.png"
    sizes="192x192">
