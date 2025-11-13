<div id="addRoleModal" class="hidden fixed inset-0 bg-black/50 flex justify-center items-center z-50 opacity-0 scale-95 transition-all">
    <div class="bg-white rounded-xl w-[400px] p-6 shadow-lg">
        <h2 class="text-lg font-semibold mb-2">Add Role</h2>
        <p class="text-sm text-gray-500 mb-4">Place for add role</p>

        <form method="POST" action="{{ route('admin.role.store') }}">
            @csrf
            <div class="space-y-3">
                <input type="text" name="name" placeholder="Your Name" class="w-full border rounded-md px-3 py-2">
                <input type="email" name="email" placeholder="Your Email" class="w-full border rounded-md px-3 py-2">
                <input type="password" name="password" placeholder="Password" class="w-full border rounded-md px-3 py-2">
                <select name="role" class="w-full border rounded-md px-3 py-2">
                    <option value="User">User</option>
                    <option value="Psychologist">Psychologist</option>
                    <option value="SuperAdmin">SuperAdmin</option>
                </select>
            </div>
            <div class="mt-4 flex justify-end space-x-2">
                <button type="button" onclick="closeModal('addRoleModal')" class="px-4 py-2 text-gray-500 border rounded-md">Cancel</button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Save</button>
            </div>
        </form>
    </div>
</div>
