<div id="viewRoleModal-{{ $role->id }}" class="hidden fixed inset-0 bg-black/50 flex justify-center items-center z-50 opacity-0 scale-95 transition-all">
    <div class="bg-white rounded-xl w-[400px] p-6 shadow-lg">
        <h2 class="text-lg font-semibold mb-2">View Details Role</h2>
        <p class="text-sm text-gray-500 mb-4">Place for see details role</p>

        <div class="space-y-3">
            <input type="text" value="{{ $role->name }}" disabled class="w-full border rounded-md px-3 py-2 bg-gray-100">
            <input type="email" value="{{ $role->email }}" disabled class="w-full border rounded-md px-3 py-2 bg-gray-100">
            <input type="password" value="••••••••" disabled class="w-full border rounded-md px-3 py-2 bg-gray-100">
            <input type="text" value="{{ $role->role }}" disabled class="w-full border rounded-md px-3 py-2 bg-gray-100">
        </div>

        <div class="mt-4 flex justify-end">
            <button type="button" onclick="closeModal('viewRoleModal-{{ $role->id }}')" class="bg-blue-600 text-white px-4 py-2 rounded-md">Done</button>
        </div>
    </div>
</div>
