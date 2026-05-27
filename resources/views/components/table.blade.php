@props(['headers' => [], 'rows' => []])

<div class="card table-container">
    <table class="w-full">
        <thead class="bg-gray-50 border-b">
            <tr>
                @foreach ($headers as $header)
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">
                        {{ $header }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody class="divide-y">
            {{ $slot }}
        </tbody>
    </table>
</div>
