@props([
    'title' => null,
    'description' => null,
    'canonical' => null,
    'ogImage' => null,
    'ogType' => 'website',
    'twitterCard' => 'summary_large_image',
    'noindex' => false,
])

@php
$siteName = config('app.name', 'Shop');
$pageTitle = $title ? "{$title} | {$siteName}" : $siteName;
$canonicalUrl = $canonical ?? url()->current();
@endphp

<title>{{ $pageTitle }}</title>
<meta name="description" content="{{ $description ?? 'Discover amazing products at great prices. Fast shipping, secure checkout, and friendly support.' }}">
<link rel="canonical" href="{{ $canonicalUrl }}">

<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:title" content="{{ $title ?? $siteName }}">
<meta property="og:description" content="{{ $description ?? 'Discover amazing products at great prices.' }}">
<meta property="og:type" content="{{ $ogType }}">
<meta property="og:url" content="{{ $canonicalUrl }}">
@if ($ogImage)
    <meta property="og:image" content="{{ $ogImage }}">
@endif

<meta name="twitter:card" content="{{ $twitterCard }}">
<meta name="twitter:title" content="{{ $title ?? $siteName }}">
<meta name="twitter:description" content="{{ $description ?? 'Discover amazing products at great prices.' }}">
@if ($ogImage)
    <meta name="twitter:image" content="{{ $ogImage }}">
@endif

@if ($noindex)
    <meta name="robots" content="noindex, nofollow">
@else
    <meta name="robots" content="index, follow">
@endif
