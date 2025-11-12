@props(['consultations'])

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Consultation Activity</h3>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Patient</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Doctor</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($consultations as $consultation)
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $consultation->id }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $consultation->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $consultation->patient }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $consultation->doctor }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $consultation->created_date }}</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="px-2 py-1 text-xs rounded-full 
                                @if($consultation->status == 'Solved') bg-green-100 text-green-800
                                @elseif($consultation->status == 'Pending') bg-yellow-100 text-yellow-800
                                @elseif($consultation->status == 'Cancelled') bg-red-100 text-red-800
                                @endif">
                                {{ $consultation->status }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex space-x-2">
                                <button class="text-blue-600 hover:text-blue-900 text-xs">Chat Now</button>
                                <button class="text-red-600 hover:text-red-900 text-xs">Cancel</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-4 text-center">
            <button class="text-blue-600 hover:text-blue-900 text-sm font-medium">See More</button>
        </div>
    </div>
</div>