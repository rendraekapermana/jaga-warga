@props(['title', 'subtitle' => '', 'value' => 0])

<div class="border border-gray-300 rounded-xl p-6 bg-white flex flex-col justify-center text-center">
    <div class="text-xl font-bold text-gray-900">{{ $title }}</div>
    <div class="text-sm text-gray-500 mb-2">{{ $subtitle }}</div>
    <div class="text-5xl font-extrabold text-gray-800">{{ $value }}</div>
</div>
