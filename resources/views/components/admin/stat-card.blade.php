@props(['title', 'value'])

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200">
    <div class="text-center">
        <div class="text-3xl font-bold text-gray-800 mb-2">{{ $value }}</div>
        <div class="text-sm text-gray-600">{{ $title }}</div>
    </div>
</div>