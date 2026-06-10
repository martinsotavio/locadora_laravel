<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>
    {{ filled($title ?? null) ? $title.' - '.config('app.name', 'Laravel') : config('app.name', 'Laravel') }}
</title>

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

@fonts

@php
try {
    // Always try to load core app assets
    echo app(\Illuminate\Foundation\Vite::class)(['resources/css/app.css','resources/js/app.js']);

    // If a build manifest exists, include locaai assets only when present
    $manifestPath = public_path('build/manifest.json');
    if (file_exists($manifestPath)) {
        $manifest = json_decode(file_get_contents($manifestPath), true) ?? [];
        if (isset($manifest['resources/css/locaai.css'])) {
            echo app(\Illuminate\Foundation\Vite::class)(['resources/css/locaai.css']);
        } else {
            // fallback to public path when not built
            echo '<link rel="stylesheet" href="' . asset('css/locaai.css') . '">';
        }
        if (isset($manifest['resources/js/locaai.js'])) {
            echo app(\Illuminate\Foundation\Vite::class)(['resources/js/locaai.js']);
        } else {
            echo '<script src="' . asset('js/locaai.js') . '"></script>';
        }
    } else {
        // no manifest: include public files so styles apply immediately
        echo '<link rel="stylesheet" href="' . asset('css/locaai.css') . '">';
        echo '<script src="' . asset('js/locaai.js') . '" defer></script>';
    }
} catch (\Throwable $e) {
    // Fallback: skip Vite assets if manifest is missing or Vite throws
}
@endphp
@fluxAppearance
