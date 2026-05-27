@if ($message = Session::get('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-start gap-3">
        <span class="text-2xl">✅</span>
        <div>
            <p class="font-semibold text-green-900">Berhasil!</p>
            <p class="text-green-800 text-sm">{{ $message }}</p>
        </div>
    </div>
@endif

@if ($message = Session::get('error'))
    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-start gap-3">
        <span class="text-2xl">❌</span>
        <div>
            <p class="font-semibold text-red-900">Error!</p>
            <p class="text-red-800 text-sm">{{ $message }}</p>
        </div>
    </div>
@endif

@if ($message = Session::get('warning'))
    <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg flex items-start gap-3">
        <span class="text-2xl">⚠️</span>
        <div>
            <p class="font-semibold text-yellow-900">Perhatian!</p>
            <p class="text-yellow-800 text-sm">{{ $message }}</p>
        </div>
    </div>
@endif
