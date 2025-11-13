<div id="editRoleModal-{{ $role->id }}" class="hidden fixed inset-0 bg-black/50 flex justify-center items-center z-50 opacity-0 scale-95 transition-all">
    <div class="bg-white rounded-xl w-[400px] p-6 shadow-lg">
        <h2 class="text-lg font-semibold mb-2">Edit Role</h2>
        <p class="text-sm text-gray-500 mb-4">Place for edit role</p>

        <form method="POST" action="{{ route('admin.role.update', $role->id) }}">
            @csrf
            @method('PUT')
            <div class="space-y-3">
                <input type="text" name="name" value="{{ $role->name }}" class="w-full border rounded-md px-3 py-2">
                <input type="email" name="email" value="{{ $role->email }}" class="w-full border rounded-md px-3 py-2">
                <input type="password" name="password" placeholder="••••••••" class="w-full border rounded-md px-3 py-2">
                <select name="role" class="w-full border rounded-md px-3 py-2">
                    <option value="User" @selected($role->role == 'User')>User</option>
                    <option value="Psychologist" @selected($role->role == 'Psychologist')>Psychologist</option>
                    <option value="SuperAdmin" @selected($role->role == 'SuperAdmin')>SuperAdmin</option>
                </select>
            </div>
            <div class="mt-4 flex justify-end space-x-2">
                <button type="button" onclick="closeModal('editRoleModal-{{ $role->id }}')" class="px-4 py-2 text-gray-500 border rounded-md">Cancel</button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Save</button>
            </div>
        </form>
    </div>
</div>
