<div class="flex justify-between items-center mb-4">
    <h2 class="text-lg font-semibold text-gray-800">Role Management</h2>
    <button 
        class="bg-blue-600 text-white text-sm px-4 py-2 rounded-md hover:bg-blue-700"
        onclick="openModal('addRoleModal')">
        Add Role +
    </button>
</div>

<div class="bg-white rounded-lg border border-gray-300 p-6">
    <table class="w-full text-sm text-left border-t border-gray-200">
        <thead class="text-gray-600 font-semibold border-b">
            <tr>
                <th class="py-3 px-4">ID</th>
                <th class="py-3 px-4">Name</th>
                <th class="py-3 px-4">Email</th>
                <th class="py-3 px-4">Created Date</th>
                <th class="py-3 px-4">Role</th>
                <th class="py-3 px-4">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach ($roles as $role)
                <tr>
                    <td class="py-3 px-4">{{ $role->id }}</td>
                    <td class="py-3 px-4">{{ $role->name }}</td>
                    <td class="py-3 px-4">{{ $role->email }}</td>
                    <td class="py-3 px-4">{{ $role->created_at->format('d/m/y') }}</td>
                    <td class="py-3 px-4">
                        <span class="
                            px-3 py-1 rounded-md text-xs font-medium
                            @if($role->role === 'SuperAdmin') bg-blue-100 text-blue-700
                            @elseif($role->role === 'Psychologist') bg-yellow-100 text-yellow-700
                            @else bg-gray-100 text-gray-700 @endif">
                            {{ $role->role }}
                        </span>
                    </td>
                    <td class="py-3 px-4 relative">
                        <button 
                            class="bg-blue-600 text-white text-xs px-3 py-2 rounded-md"
                            onclick="toggleDropdown(event, 'dropdown-{{ $role->id }}')">
                            Action ▾
                        </button>
                        <div id="dropdown-{{ $role->id }}" 
                             class="hidden absolute right-0 mt-2 w-36 bg-white border rounded-md shadow-lg z-10">
                            <button 
                                class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100"
                                onclick="openModal('viewRoleModal-{{ $role->id }}')">View</button>
                            <button 
                                class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100"
                                onclick="openModal('editRoleModal-{{ $role->id }}')">Edit</button>
                            <button 
                                class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100"
                                onclick="openModal('deleteRoleModal-{{ $role->id }}')">
                                Delete
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    function toggleDropdown(event, id) {
        event.stopPropagation();
        document.querySelectorAll('[id^="dropdown-"]').forEach(el => el.classList.add('hidden'));
        document.getElementById(id).classList.toggle('hidden');
    }

    window.addEventListener('click', () => {
        document.querySelectorAll('[id^="dropdown-"]').forEach(el => el.classList.add('hidden'));
    });

    function openModal(id) {
        const modal = document.getElementById(id);
        if (!modal) return;

        modal.classList.remove('hidden');

        setTimeout(() => {
            modal.classList.remove('opacity-0', 'scale-95');
            modal.classList.add('opacity-100', 'scale-100');
        }, 10);
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (!modal) return;

        modal.classList.remove('opacity-100', 'scale-100');
        modal.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 150);
    }

    document.addEventListener('click', (e) => {
        document.querySelectorAll('[id^="addRoleModal"],[id^="editRoleModal-"],[id^="viewRoleModal-"],[id^="deleteRoleModal-"]').forEach(modal => {
            if (!modal.classList.contains('hidden') && e.target === modal) {
                closeModal(modal.id);
            }
        });
    });
</script>

