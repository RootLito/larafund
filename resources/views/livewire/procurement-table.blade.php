<div class="md:w-full h-full bg-white p-6 rounded-lg">
    <h2 class="text-xl font-bold text-gray-700 mb-6">PR Lists</h2>

    <div class="w-full flex flex-col md:flex-row mb-4 justify-between items-center gap-4">
        <input type="search" wire:model.live.debounce.500ms="search" placeholder="Search PR Number, Project, or End User"
            class="w-full md:w-1/3 bg-gray-50 border border-gray-300 p-2 text-sm rounded focus:ring-blue-500 focus:border-blue-500">

        <div class="flex flex-col md:flex-row gap-2 w-full md:w-2/3 justify-end">
            <select wire:model.live="status"
                class="text-sm w-full md:w-52 bg-gray-50 border border-gray-300 text-gray-700 rounded p-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">All Status</option>
                <option value="Pending">Pending</option>
                <option value="Completed">Completed</option>
                <option value="In Progress">In Progress</option>
                <option value="Reimbursement">Reimbursement</option>
                <option value="Cancelled">Cancelled</option>
            </select>


            <select wire:model.live="mode"
                class="text-sm w-full md:w-52 bg-gray-50 border border-gray-300 text-gray-700 rounded p-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">All Modes</option>
                <option value="Public Bidding">Public Bidding</option>
                <option value="Direct Contracting">Direct Contracting</option>
                <option value="Small Value Procurement">Small Value Procurement</option>
                <option value="Emergency Cases">Emergency Cases</option>
                <option value="others">Others</option> 
            </select>


        </div>
    </div>

    <div wire:loading.flex class="justify-center items-center text-gray-600 font-semibold mb-4">
        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
            </circle>
            <path class="opacity-75" fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
            </path>
        </svg>
        Loading projects...
    </div>

    <table class="w-full table-auto border-collapse border-t border-b p-1  border-gray-300 rounded-lg ">
        <thead class="border-b border-gray-300">
            <tr class="bg-gray-100 text-gray-600">
                <th class="px-4 py-4 text-left text-sm">Status</th>
                <th class="px-4 py-2 text-left text-sm">PR Number</th>
                <th class="px-4 py-2 text-left text-sm">Mode of Procurement</th>
                <th class="px-4 py-2 text-left text-sm">Procurement Project</th>
                <th class="px-4 py-2 text-left text-sm">Total ABC</th>
                <th class="px-4 py-2 text-left text-sm">End User</th>
                <th class="px-4 py-2 text-left text-sm">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($projects as $project)
                <tr class="border-b border-gray-300">
                    <td class="px-4 py-2 text-sm text-gray-600">
                        <span
                            class="text-sm px-4 py-1 rounded-full text-white
                                {{ $project->status == 'Pending' ? 'bg-yellow-500' : '' }}
                                {{ $project->status == 'Completed' ? 'bg-green-500' : '' }}
                                {{ $project->status == 'In Progress' ? 'bg-blue-500' : '' }}
                                {{ $project->status == 'Reimbursement' ? 'bg-purple-500' : '' }}
                                {{ $project->status == 'Cancelled' ? 'bg-red-500' : '' }}
                                {{ !in_array($project->status, ['Pending', 'Completed', 'In Progress', 'Reimbursement', 'Cancelled']) ? 'bg-gray-500' : '' }}">
                            {{ $project->status }}
                        </span>
                    </td>
                    <td class="px-4 py-2 text-sm text-gray-600">
                        {{ $project->pr_number ? $project->pr_number : 'N/A' }}
                    </td>
                    <td class="px-4 py-2 text-sm text-gray-600">{{ $project->mode_of_procurement }}</td>
                    <td class="px-4 py-2 text-sm text-gray-600">{{ $project->procurement_project }}</td>
                    <td class="px-4 py-2 text-sm text-gray-600">₱{{ number_format($project->total_abc, 2) }}</td>
                    <td class="px-4 py-2 text-sm text-gray-600">{{ $project->end_user }}</td>
                    <td class="px-4 py-2 text-sm text-gray-600 w-auto whitespace-nowrap">
                        <div class="flex gap-2 flex-nowrap">
                            <a href="{{ url()->current() }}?selected_id={{ $project->id }}"
                                class="px-4 py-2 text-white bg-blue-400 rounded-md cursor-pointer">
                                <i class="fa-solid fa-eye"></i>
                            </a>

                            <a href="{{ url()->current() }}?edit_id={{ $project->id }}"
                                class="px-4 py-2 text-white bg-green-400 rounded-md cursor-pointer">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>




                            <form action="{{ route('tracking.delete', $project->id) }}" method="POST"
                                class="inline-block"
                                onsubmit="return confirm('Are you sure you want to delete this project?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-4 py-2 text-white bg-red-400 rounded-md cursor-pointer">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-4 text-center text-gray-500">No projects found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $projects->links() }}
    </div>
</div>
