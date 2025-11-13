@props(['consultations'])

<div class="border border-gray-300 rounded-xl bg-white">
    <div class="p-6">
        <h3 class="text-2xl font-extrabold mb-4">Consultation Activity</h3>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b">
                    <th class="py-2">ID</th>
                    <th class="py-2">Name Patient</th>
                    <th class="py-2">Doctor</th>
                    <th class="py-2">Created Date</th>
                    <th class="py-2">Status</th>
                    <th class="py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($consultations as $consultation)
                <tr class="border-b text-sm">
                    <td class="py-2">{{ $consultation->id }}</td>
                    <td>{{ $consultation->patient_name }}</td>
                    <td>{{ $consultation->doctor_name }}</td>
                    <td>{{ now()->format('d/m/y') }}</td>
                    <td>
                        <span class="text-xs px-2 py-1 rounded-full 
                            @if($consultation->status == 'Solved') bg-green-100 text-green-700
                            @elseif($consultation->status == 'Pending') bg-yellow-100 text-yellow-700
                            @elseif($consultation->status == 'Cancelled') bg-red-100 text-red-700
                            @endif">
                            ● {{ $consultation->status }}
                        </span>
                    </td>
                    <td>
                        <button class="bg-blue-600 hover:bg-blue-700 text-white text-xs px-3 py-1 rounded">Action</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4 text-center">
            <a href="#" class="text-blue-600 text-sm font-medium hover:underline">See More</a>
        </div>
    </div>
</div>
