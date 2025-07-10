@extends('layout.app')

@section('title', 'View Project')

@section('content')
    <div class="w-full h-full flex flex-col gap-10 p-10">
        <div class="w-full h-full bg-white p-6 rounded-lg">
            {{-- <a href="javascript:history.back()" class="flex items-center text-red-400 font-bold hover:text-red-600">
                <i class="fa-solid fa-arrow-left mr-2"></i>
                Back
            </a> --}}

            {{-- @if ($selectedProject)
                <h2 class="text-5xl">Selected ID is: {{ $selectedProject->id }}</h2>
                <p>{{ $selectedProject->procurement_project ?? 'N/A' }}</p>
            @else
                <h2 class="text-5xl">No Project Found</h2>
            @endif --}}


            <div style="background-color: rgba(0,0,0,0.6)"
                class="view-modal fixed inset-0 z-50 flex items-center justify-center">
                <div class="view-modal-container bg-white p-6 w-7xl overflow-y-auto max-h-[90vh]">
                    <header class="view-modal-header">
                        <h2 class="view-modal-title mb-8 text-2xl font-semibold text-gray-600">PR Details</h2>
                    </header>

                    <main class="view-modal-content overflow-auto">
                        <div class="">
                            <form action="">
                                <table
                                    class="w-full table-auto border-collapse border border-gray-300 rounded-lg overflow-hidden">
                                    <thead class="border-b border-gray-300">
                                        <tr class="bg-gray-100 text-gray-600">
                                            <th class="px-4 py-4 text-left text-sm whitespace-nowrap">Status</th>
                                            <th class="px-4 py-2 text-left text-sm whitespace-nowrap">
                                                <div class="w-52">Procurement Project</div>
                                            </th>
                                            <th class="px-4 py-2 text-left text-sm whitespace-nowrap">
                                                <div class="w-72">Lot and Description</div>
                                            </th>
                                            <th class="px-4 py-2 text-left text-sm whitespace-nowrap">ABC per Lot</th>
                                            <th class="px-4 py-2 text-left text-sm whitespace-nowrap">Total ABC</th>
                                            <th class="px-4 py-2 text-left text-sm whitespace-nowrap">End User</th>
                                            <th class="px-4 py-2 text-left text-sm whitespace-nowrap">PR Number</th>
                                            <th class="px-4 py-4 text-left text-sm whitespace-nowrap">Approved APP</th>
                                            <th class="px-4 py-4 text-left text-sm whitespace-nowrap">Date Received from
                                                Planning</th>
                                            <th class="px-4 py-4 text-left text-sm whitespace-nowrap">Date Received by the
                                                TWG
                                            </th>
                                            <th class="px-4 py-4 text-left text-sm whitespace-nowrap">TWG</th>
                                            <th class="px-4 py-4 text-left text-sm whitespace-nowrap">Date Forwarded to
                                                Budget
                                            </th>
                                            <th class="px-4 py-4 text-left text-sm whitespace-nowrap">Approved PR Received
                                            </th>
                                            <th class="px-4 py-4 text-left text-sm whitespace-nowrap">PhilGEPS Posting Date
                                            </th>
                                            <th class="px-4 py-4 text-left text-sm whitespace-nowrap">RFQ/ITB Number</th>
                                            <th class="px-4 py-4 text-left text-sm whitespace-nowrap">Bid Opening</th>
                                            <th class="px-4 py-4 text-left text-sm whitespace-nowrap">SQ Number</th>
                                            <th class="px-4 py-4 text-left text-sm whitespace-nowrap">BAC Res. Number</th>
                                            <th class="px-4 py-4 text-left text-sm whitespace-nowrap">Date of BAC Res.
                                                Completely Signed</th>
                                            <th class="px-4 py-4 text-left text-sm whitespace-nowrap">NOA No.</th>
                                            <th class="px-4 py-4 text-left text-sm whitespace-nowrap">Canvasser</th>
                                            <th class="px-4 py-4 text-left text-sm whitespace-nowrap">Name of Supplier</th>
                                            <th class="px-4 py-4 text-left text-sm whitespace-nowrap">Contract Price</th>
                                            <th class="px-4 py-4 text-left text-sm whitespace-nowrap">Date Forwarded to GSS
                                            </th>
                                            <th class="px-4 py-4 text-left text-sm whitespace-nowrap">Remarks</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>

                                            @php
                                                $statuses = json_decode($selectedProject->status ?? '[]', true);

                                                $lotDescriptions = json_decode(
                                                    $selectedProject->lot_description ?? '[]',
                                                    true,
                                                );
                                                $abcPerLots = json_decode($selectedProject->abc_per_lot ?? '[]', true);
                                                $philgepsPostingDates = json_decode(
                                                    $selectedProject->philgeps_posting_date ?? '[]',
                                                    true,
                                                );
                                                $rfqItbNumbers = json_decode(
                                                    $selectedProject->rfq_itb_number ?? '[]',
                                                    true,
                                                );
                                                $bidOpenings = json_decode($selectedProject->bid_opening ?? '[]', true);
                                                $sqNumbers = json_decode($selectedProject->sq_number ?? '[]', true);
                                                $bacResNumbers = json_decode(
                                                    $selectedProject->bac_res_number ?? '[]',
                                                    true,
                                                );
                                                $dateOfBacResCompletelySigned = json_decode(
                                                    $selectedProject->date_of_bac_res_completely_signed ?? '[]',
                                                    true,
                                                );
                                                $noaNumbers = json_decode($selectedProject->noa_number ?? '[]', true);
                                                $canvassers = json_decode($selectedProject->canvasser ?? '[]', true);
                                                $nameOfSuppliers = json_decode(
                                                    $selectedProject->name_of_supplier ?? '[]',
                                                    true,
                                                );
                                                $contractPrices = json_decode(
                                                    $selectedProject->contract_price ?? '[]',
                                                    true,
                                                );
                                                $dateForwardedToGss = json_decode(
                                                    $selectedProject->date_forwarded_to_gss ?? '[]',
                                                    true,
                                                );
                                                $remarks = json_decode($selectedProject->remarks ?? '[]', true);
                                            @endphp

                                            <td class="px-4 py-4 text-left text-sm">
                                                @forelse ($statuses as $status)
                                                    <div class="py-1">
                                                        <span
                                                            class="text-sm px-4 py-1 rounded-full text-white
                {{ $status == 'Pending'
                    ? 'bg-yellow-500'
                    : ($status == 'Completed'
                        ? 'bg-green-500'
                        : ($status == 'In Progress'
                            ? 'bg-blue-500'
                            : ($status == 'Reimbursement'
                                ? 'bg-purple-500'
                                : ($status == 'Cancelled'
                                    ? 'bg-red-500'
                                    : 'bg-gray-500')))) }}">
                                                            {{ $status }}
                                                        </span>
                                                    </div>
                                                @empty
                                                    <div class="py-1 text-gray-400">N/A</div>
                                                @endforelse
                                            </td>

                                            <td class="px-4 py-4 text-left text-sm">
                                                {{ $selectedProject->procurement_project ?? 'N/A' }}
                                            </td>

                                            <td class="px-4 py-2 text-sm">
                                                <div class="flex flex-col ">
                                                    @forelse ($lotDescriptions as $description)
                                                        <span
                                                            class="py-1 text-sm cursor-pointer overflow-hidden text-ellipsis whitespace-nowrap"
                                                            style="max-width: 18rem;" 
                                                            title="{{ $description }}"
                                                            data-fulltext="{{ $description }}"
                                                            onclick="handleDescriptionClick(this)">
                                                            {{ $description }}
                                                        </span>
                                                    @empty
                                                        <span class="text-gray-400">N/A</span>
                                                    @endforelse
                                                </div>
                                            </td>


                                            <td class="px-4 py-4 text-left text-sm">
                                                @forelse ($abcPerLots as $abc)
                                                    <div class="py-1">₱{{ number_format($abc, 2) }}</div>
                                                @empty
                                                    N/A
                                                @endforelse
                                            </td>

                                            <td class="px-4 py-4 text-left text-sm">
                                                ₱{{ number_format($selectedProject->total_abc ?? 0, 2) }}
                                            </td>

                                            <td class="px-4 py-4 text-left text-sm">
                                                {{ $selectedProject->end_user ?? 'N/A' }}
                                            </td>
                                            <td class="px-4 py-4 text-left text-sm">
                                                {{ $selectedProject->pr_number ?? 'N/A' }}
                                            </td>
                                            <td class="px-4 py-4 text-left text-sm">
                                                {{ $selectedProject->approved_app ?? 'N/A' }}</td>
                                            <td class="px-4 py-4 text-left text-sm">
                                                {{ $selectedProject->date_received_from_planning ?? 'N/A' }}</td>
                                            <td class="px-4 py-4 text-left text-sm">
                                                {{ $selectedProject->date_received_by_twg ?? 'N/A' }}</td>
                                            <td class="px-4 py-4 text-left text-sm">{{ $selectedProject->twg ?? 'N/A' }}
                                            </td>
                                            <td class="px-4 py-4 text-left text-sm">
                                                {{ $selectedProject->date_forwarded_to_budget ?? 'N/A' }}</td>
                                            <td class="px-4 py-4 text-left text-sm">
                                                {{ $selectedProject->approved_pr_received ?? 'N/A' }}</td>

                                            <td class="px-4 py-4 text-left text-sm">
                                                @forelse ($philgepsPostingDates as $date)
                                                    <div class="py-1">{{ $date ?? 'N/A' }}</div>
                                                @empty
                                                    N/A
                                                @endforelse
                                            </td>

                                            <td class="px-4 py-4 text-left text-sm">
                                                @forelse ($rfqItbNumbers as $rfq)
                                                    <div class="py-1">{{ $rfq ?? 'N/A' }}</div>
                                                @empty
                                                    N/A
                                                @endforelse
                                            </td>

                                            <td class="px-4 py-4 text-left text-sm">
                                                @forelse ($bidOpenings as $bid)
                                                    <div class="py-1">{{ $bid ?? 'N/A' }}</div>
                                                @empty
                                                    N/A
                                                @endforelse
                                            </td>

                                            <td class="px-4 py-4 text-left text-sm">
                                                @forelse ($sqNumbers as $sq)
                                                    <div class="py-1">{{ $sq ?? 'N/A' }}</div>
                                                @empty
                                                    N/A
                                                @endforelse
                                            </td>

                                            <td class="px-4 py-4 text-left text-sm">
                                                @forelse ($bacResNumbers as $bac)
                                                    <div class="py-1">{{ $bac ?? 'N/A' }}</div>
                                                @empty
                                                    N/A
                                                @endforelse
                                            </td>

                                            <td class="px-4 py-4 text-left text-sm">
                                                @forelse ($dateOfBacResCompletelySigned as $date)
                                                    <div class="py-1">{{ $date ?? 'N/A' }}</div>
                                                @empty
                                                    N/A
                                                @endforelse
                                            </td>

                                            <td class="px-4 py-4 text-left text-sm">
                                                @forelse ($noaNumbers as $noa)
                                                    <div class="py-1">{{ $noa ?? 'N/A' }}</div>
                                                @empty
                                                    N/A
                                                @endforelse
                                            </td>

                                            <td class="px-4 py-4 text-left text-sm">
                                                @forelse ($canvassers as $canvasser)
                                                    <div class="py-1">{{ $canvasser ?? 'N/A' }}</div>
                                                @empty
                                                    N/A
                                                @endforelse
                                            </td>

                                            <td class="px-4 py-4 text-left text-sm">
                                                @forelse ($nameOfSuppliers as $supplier)
                                                    <div class="py-1">{{ $supplier ?? 'N/A' }}</div>
                                                @empty
                                                    N/A
                                                @endforelse
                                            </td>

                                            <td class="px-4 py-4 text-left text-sm">
                                                @forelse ($contractPrices as $price)
                                                    <div class="py-1">₱{{ number_format($price, 2) }}</div>
                                                @empty
                                                    N/A
                                                @endforelse
                                            </td>

                                            <td class="px-4 py-4 text-left text-sm">
                                                @forelse ($dateForwardedToGss as $date)
                                                    <div class="py-1">{{ $date ?? 'N/A' }}</div>
                                                @empty
                                                    N/A
                                                @endforelse
                                            </td>

                                            <td class="px-4 py-4 text-left text-sm">
                                                @forelse ($remarks as $remark)
                                                    <div class="py-1">{{ $remark ?? 'N/A' }}</div>
                                                @empty
                                                    N/A
                                                @endforelse
                                            </td>

                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </main>

                    <footer class="view-modal-footer mb-3 mt-10 text-center">
                        <a href="{{ route('tracking') }}" class="bg-red-400 text-white px-4 py-2 rounded">Close</a>
                    </footer>
                </div>
            </div>
        </div>
        <div id="descriptionModal" class="fixed inset-0  hidden items-center justify-center z-50"
            style="background-color: rgba(0, 0, 0, 0.4);">
            <div class="bg-white w-full max-w-md rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold">Lot Description</h2>
                    <button onclick="closeDescriptionModal()"
                        class="text-gray-500 hover:text-black text-2xl cursor-pointer">&times;</button>
                </div>
                <div id="modalDescriptionContent" class="text-sm text-gray-700 whitespace-pre-wrap"></div>
            </div>
        </div>
    </div>
@endsection
<script>
    function handleDescriptionClick(element) {
        // Only open modal if content is truncated (i.e., showing "...")
        if (element.scrollWidth > element.clientWidth) {
            const fullText = element.getAttribute('data-fulltext');
            document.getElementById('modalDescriptionContent').textContent = fullText;
            document.getElementById('descriptionModal').classList.remove('hidden');
            document.getElementById('descriptionModal').classList.add('flex');
        }
    }

    function closeDescriptionModal() {
        document.getElementById('descriptionModal').classList.add('hidden');
        document.getElementById('descriptionModal').classList.remove('flex');
    }
</script>
