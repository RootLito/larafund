<div class="md:w-full h-full bg-white p-6 rounded-lg">
    <div class="w-full flex items-center justify-between mb-6 ">
        <h2 class="text-xl font-bold text-gray-700">PR Lists</h2>
        <button class="bg-green-400 text-white text-sm w-28 py-2 rounded cursor-pointer"><i
                class="fa-solid fa-file-excel mr-1"></i> Export</button>
    </div>
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
                <th class="px-4 py-4 text-left text-sm w-36">Status</th>
                <th class="px-4 py-2 text-left text-sm w-32">PR Number</th>
                <th class="px-4 py-2 text-left text-sm w-46">Mode of Procurement</th>
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
                            {{-- <a href="{{ url()->current() }}?selected_id={{ $project->id }}"
                                class="px-4 py-2 text-white bg-blue-400 rounded-md cursor-pointer">
                                <i class="fa-solid fa-eye"></i>
                            </a> --}}


                            {{-- <a href="{{ url()->current() }}?edit_id={{ $project->id }}"
                                class="px-4 py-2 text-white bg-green-400 rounded-md cursor-pointer">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a> --}}

                            <a href="{{ route('project.action.view', ['selected_id' => $project->id]) }}"
                                class="px-4 py-2 text-white bg-blue-400 rounded-md cursor-pointer">
                                <i class="fa-solid fa-eye"></i>
                            </a>

                            <a href="{{ route('project.action.edit', ['edit_id' => $project->id]) }}"
                                class="px-4 py-2 text-white bg-green-400 rounded-md cursor-pointer">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>


                            <button type="button" class="px-4 py-2 text-white bg-red-400 rounded-md cursor-pointer"
                                data-micromodal-trigger="modal-delete" data-project-id="{{ $project->id }}">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
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

    <div class="modal micromodal-slide" id="modal-delete" aria-hidden="true">
        <div class="modal__overlay fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
            tabindex="-1" data-micromodal-close>
            <div class="modal__container bg-white rounded-lg shadow-lg p-6 w-full max-w-md relative" role="dialog"
                aria-modal="true" aria-labelledby="modal-delete-title">
                <header class="modal__header mb-6 flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-600" id="modal-delete-title">
                        Confirm Deletion
                    </h2>
                </header>
                <main class="modal__content mb-6 text-gray-700">
                    <p>Are you sure you want to delete this project?</p>
                </main>
                <footer class="modal__footer flex justify-end space-x-3">
                    <form id="delete-form" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 text-white text-sm cursor-pointer bg-red-400 rounded-md hover:bg-red-700 transition">
                            Yes, Delete
                        </button>
                        <button type="button"
                            class="px-4 py-2 bg-gray-300 text-sm cursor-pointer rounded-md hover:bg-gray-400 transition"
                            data-micromodal-close>
                            Cancel
                        </button>
                    </form>
                </footer>
            </div>
        </div>
    </div>

</div>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('[data-micromodal-trigger="modal-delete"]').forEach(button => {
            button.addEventListener('click', function() {
                const projectId = this.getAttribute('data-project-id');
                const form = document.getElementById('delete-form');
                form.setAttribute('action',
                    `/tracking/${projectId}`);
                MicroModal.show('modal-delete');
            });
        });
    });
</script>
