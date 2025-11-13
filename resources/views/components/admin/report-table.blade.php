@props(['reports'])

<div class="border border-gray-300 rounded-xl bg-white">
    <div class="p-6">
        <h3 class="text-2xl font-extrabold mb-4">Form Report</h3>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b">
                    <th class="py-2">ID</th>
                    <th class="py-2">Name</th>
                    <th class="py-2">Created Date</th>
                    <th class="py-2">Type of Incident</th>
                    <th class="py-2">Location</th>
                    <th class="py-2">Status</th>
                    <th class="py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reports as $report)
                <tr class="border-b text-sm">
                    <td class="py-2">{{ $report->id }}</td>
                    <td>{{ $report->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($report->created_date)->format('d/m/y') }}</td>
                    <td>{{ $report->type }}</td>
                    <td>{{ $report->location }}</td>
                    <td>
                        <span class="text-xs px-2 py-1 rounded-full 
                            @if($report->status == 'Solved') bg-green-100 text-green-700
                            @elseif($report->status == 'Pending') bg-yellow-100 text-yellow-700
                            @elseif($report->status == 'Deleted') bg-red-100 text-red-700
                            @endif">
                            ● {{ $report->status }}
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
