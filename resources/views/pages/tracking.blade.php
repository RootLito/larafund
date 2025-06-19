@extends('layout.app')

@section('title', 'Tracking')

@section('content')
    <div class="w-full h-full flex flex-col gap-10 p-10">
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show"
                class="text-sm bg-green-200 border border-green-500 text-green-700 p-4 rounded-lg relative">
                <button @click="show = false"
                    class="text-2xl cursor-pointer absolute top-2 right-4 text-green-700 hover:text-green-900">
                    &times;
                </button>
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div x-data="{ show: true }" x-show="show"
                class="text-sm p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg relative">
                <button @click="show = false"
                    class="text-2xl cursor-pointer absolute top-2 right-4 text-red-700 hover:text-red-900">
                    &times;
                </button>
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="md:w-full h-full bg-white p-6 rounded-lg" x-data="{
            lots: [{ description: '', abc: '' }],
            get totalABC() {
                return this.lots.reduce((sum, lot) => {
                    const val = parseFloat(lot.abc);
                    return sum + (isNaN(val) ? 0 : val);
                }, 0).toFixed(2);
            },
            addLot() {
                this.lots.push({ description: '', abc: '' });
            }
        }">

            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-700 mb-4">New PR</h2>
                <button x-on:click.prevent="addLot" class="bg-blue-400 text-white p-2 text-xs cursor-pointer rounded w-28">
                    Add Lot
                </button>
            </div>

            <form action="/pr" method="post">
                @csrf


                <small>Mode of Procurement<span class="text-red-500">*</span></small>
                <select name="mode_of_procurement" id="mode_of_procurement"
                    class="w-full bg-gray-50 border border-gray-300 p-2 text-sm rounded mb-2">
                    <option value="" selected disabled>Select Mode of Procurement</option>
                    <option value="Public Bidding">Public Bidding</option>
                    <option value="Direct Contracting">Direct Contracting</option>
                    <option value="Small Value Procurement">Small Value Procurement</option>
                    <option value="Emergency Cases">Emergency Cases</option>
                    <option value="others">Others</option>
                </select>

                <input type="text" name="custom_mode" placeholder="Please specify" id="custom_mode_input"
                    class="w-full bg-gray-50 border border-gray-300 p-2 text-sm rounded mb-2 hidden" />


                <small>Procurement Project <span class="text-red-500">*</span></small>
                <textarea name="procurement_project"
                    class="w-full h-20 p-2 border bg-gray-50 border-gray-300 rounded resize-none text-sm"></textarea>

                <div class="flex gap-2 items-end mt-1">
                    <div class="flex flex-col flex-1">
                        <small>Lot and Description <span class="text-red-500">*</span></small>
                    </div>
                    <div class="flex flex-col w-72">
                        <small>ABC per LOT <span class="text-red-500">*</span></small>
                    </div>
                </div>

                <template x-for="(lot, index) in lots" :key="index">
                    <div class="flex gap-2 items-end mt-1">
                        <div class="flex flex-col flex-1">
                            <input type="text" :name="'lot_description[]'" x-model="lot.description"
                                class="w-full bg-gray-50 border border-gray-300 p-2 text-sm rounded"
                                :id="'lot_description_' + index">
                        </div>

                        <div class="flex flex-col w-72">
                            <input type="number" step="any" :name="'abc_per_lot[]'" x-model="lot.abc"
                                class="w-full bg-gray-50 border border-gray-300 p-2 text-sm rounded"
                                :id="'abc_per_lot_' + index">
                        </div>
                    </div>
                </template>

                <div class="flex gap-2 items-end mt-3">
                    <div class="flex flex-col flex-1">
                        <small>End User <span class="text-red-500">*</span></small>
                        <input type="text" name="end_user"
                            class="w-full bg-gray-50 border border-gray-300 p-2 text-sm rounded">
                    </div>
                    <div class="flex flex-col w-72">
                        <small>Total ABC <span class="text-red-500">*</span></small>
                        <input type="text" name="total_abc" x-bind:value="totalABC" readonly
                            class="w-full bg-gray-50 border border-gray-300 p-2 text-sm rounded">
                    </div>
                </div>

                <button class="w-full bg-red-400 py-2 mt-5 text-white cursor-pointer rounded">
                    Save
                </button>
            </form>
        </div>
        @livewire('procurement-table')
    </div>



    {{-- VIEW MODAL --}}
    @if ($selectedProject)
        <div style="background-color: rgba(0,0,0,0.6)"
            class="view-modal fixed inset-0 z-50 flex items-center justify-center">
            <div class="view-modal-container bg-white p-6 w-7xl overflow-y-auto max-h-[90vh]">
                <header class="view-modal-header">
                    <h2 class="view-modal-title mb-8 text-2xl font-semibold text-gray-600">PR Details</h2>
                </header>
                <main class="view-modal-content overflow-auto">
                    <div class="h-full">
                        <form action="">
                            <table
                                class="w-full table-auto border-collapse border border-gray-300 rounded-lg overflow-hidden">
                                <thead class="border-b border-gray-300">
                                    <tr class="bg-gray-100 text-gray-600">
                                        <th class="px-4 py-4 text-left text-sm whitespace-nowrap">Status</th>
                                        <th class="px-4 py-2 text-left text-sm whitespace-nowrap">Procurement Project</th>
                                        <th class="px-4 py-2 text-left text-sm whitespace-nowrap">Lot and Description</th>
                                        <th class="px-4 py-2 text-left text-sm whitespace-nowrap">ABC per Lot</th>
                                        <th class="px-4 py-2 text-left text-sm whitespace-nowrap">Total ABC</th>
                                        <th class="px-4 py-2 text-left text-sm whitespace-nowrap">End User</th>
                                        <th class="px-4 py-2 text-left text-sm whitespace-nowrap">PR Number</th>
                                        <th class="px-4 py-4 text-left text-sm whitespace-nowrap">Approved APP</th>
                                        <th class="px-4 py-4 text-left text-sm whitespace-nowrap">Date Received from
                                            Planning</th>
                                        <th class="px-4 py-4 text-left text-sm whitespace-nowrap">Date Received by the TWG
                                        </th>
                                        <th class="px-4 py-4 text-left text-sm whitespace-nowrap">TWG</th>
                                        <th class="px-4 py-4 text-left text-sm whitespace-nowrap">Date Forwarded to Budget
                                        </th>
                                        <th class="px-4 py-4 text-left text-sm whitespace-nowrap">Approved PR Received</th>
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
                                        <td class="px-4 py-4 text-left text-sm whitespace-nowrap">
                                            <span
                                                class="text-sm px-4 py-1 rounded-full text-white
                                                {{ $selectedProject->status == 'Pending'
                                                    ? 'bg-yellow-500'
                                                    : ($selectedProject->status == 'Completed'
                                                        ? 'bg-green-500'
                                                        : ($selectedProject->status == 'In Progress'
                                                            ? 'bg-blue-500'
                                                            : ($selectedProject->status == 'Reimbursement'
                                                                ? 'bg-purple-500'
                                                                : ($selectedProject->status == 'Cancelled'
                                                                    ? 'bg-red-500'
                                                                    : 'bg-gray-500')))) }}">
                                                {{ $selectedProject->status }}
                                            </span>
                                        </td>
                                        @php
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
                                            {{ $selectedProject->procurement_project ?? 'N/A' }}
                                        </td>

                                        <td class="px-4 py-4 text-left text-sm">
                                            @forelse ($lotDescriptions as $desc)
                                                <div class="py-1">{{ $desc }}</div>
                                            @empty
                                                N/A
                                            @endforelse
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

                                        <td class="px-4 py-4 text-left text-sm">{{ $selectedProject->end_user ?? 'N/A' }}
                                        </td>
                                        <td class="px-4 py-4 text-left text-sm">{{ $selectedProject->pr_number ?? 'N/A' }}
                                        </td>
                                        <td class="px-4 py-4 text-left text-sm">
                                            {{ $selectedProject->approved_app ?? 'N/A' }}</td>
                                        <td class="px-4 py-4 text-left text-sm">
                                            {{ $selectedProject->date_received_from_planning ?? 'N/A' }}</td>
                                        <td class="px-4 py-4 text-left text-sm">
                                            {{ $selectedProject->date_received_by_twg ?? 'N/A' }}</td>
                                        <td class="px-4 py-4 text-left text-sm">{{ $selectedProject->twg ?? 'N/A' }}</td>
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
    @endif


    {{-- EDIT MODAL --}}
    @if ($editProject)
        <div style="background-color: rgba(0,0,0,0.6)"
            class="edit-modal fixed inset-0 z-50 flex items-center justify-center" id="editModal">
            <div class="edit-modal-container bg-white p-6 w-7xl overflow-y-auto max-h-[90vh]">
                <header class="edit-modal-header">
                    <h2 class="edit-modal-title mb-8 text-2xl font-semibold text-gray-600">Edit PR</h2>
                </header>
                <main class="edit-modal-content" id="edit-content">
                    <form action="{{ route('tracking.update', ['id' => $editProject->id]) }}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="flex gap-2 items-end mb-3">

                            <div class="flex flex-col flex-1">
                                <small>Status <span class="text-red-500">*</span></small>
                                <select name="status" id="status"
                                    class="w-full bg-gray-50 border border-gray-300 p-2 text-sm rounded">
                                    <option value="Pending" {{ $editProject->status == 'Pending' ? 'selected' : '' }}>
                                        Pending
                                    </option>
                                    <option value="Completed" {{ $editProject->status == 'Completed' ? 'selected' : '' }}>
                                        Completed
                                    </option>
                                    <option value="In Progress"
                                        {{ $editProject->status == 'In Progress' ? 'selected' : '' }}>
                                        In Progress
                                    </option>
                                    <option value="Reimbursement"
                                        {{ $editProject->status == 'Reimbursement' ? 'selected' : '' }}>
                                        Reimbursement
                                    </option>
                                    <option value="Cancelled" {{ $editProject->status == 'Cancelled' ? 'selected' : '' }}>
                                        Cancelled
                                    </option>
                                </select>

                            </div>

                            <div class="flex flex-col w-72">
                                <small>PR Number <span class="text-red-500">*</span></small>
                                <input type="text" name="pr_number"
                                    class="w-full bg-gray-50 border border-gray-300 p-2 text-sm rounded"
                                    value="{{ old('pr_number', $editProject->pr_number) }}">
                            </div>
                        </div>

                        <small>Mode of Procurement<span class="text-red-500">*</span></small>

                    


                        <input type="text" name="mode_of_procurement" placeholder="Please specify" 
                            class="w-full bg-gray-50 border border-gray-300 p-2 text-sm rounded mb-2" value="{{ $editProject->mode_of_procurement }}"/>


                        <small>Procurement Project <span class="text-red-500">*</span></small>
                        <textarea type="text" name="procurement_project"
                            class="w-full h-20 p-2 border bg-gray-50 border-gray-300 rounded resize-none text-sm">{{ $editProject->procurement_project }}
                        </textarea>
                        
                        @php
                            $lotDescriptions = json_decode($editProject->lot_description, true);
                            $abcPerLots = json_decode($editProject->abc_per_lot, true);
                            $philgeps_advertisement = json_decode($editProject->philgeps_advertisement, true);
                            $philgeps_posting_date = json_decode($editProject->philgeps_posting_date, true);
                            $rfq_itb_number = json_decode($editProject->rfq_itb_number, true);
                            $pre_bid_conference = json_decode($editProject->pre_bid_conference, true);
                            $bid_opening = json_decode($editProject->bid_opening, true);
                            $post_qualification = json_decode($editProject->post_qualification, true);
                            $sq_number = json_decode($editProject->sq_number, true);
                            $bac_res_number = json_decode($editProject->bac_res_number, true);
                            $date_of_bac_res_completely_signed = json_decode($editProject->date_of_bac_res_completely_signed, true);
                            $noa_number = json_decode($editProject->noa_number, true);
                            $canvasser = json_decode($editProject->canvasser, true);
                            $name_of_supplier = json_decode($editProject->name_of_supplier, true);
                            $contract_price = json_decode($editProject->contract_price, true);
                            $date_forwarded_to_gss = json_decode($editProject->date_forwarded_to_gss, true);
                            $remarks = json_decode($editProject->remarks, true);
                        @endphp



                        <div class="flex flex-col gap-1  overflow-x-auto">
                            <table class="w-full mt-2">
                                <tr>
                                    <td class="whitespace-nowrap">
                                        <small>Lot and Description <span class="text-red-500">*</span></small>
                                    </td>
                                    <td class="whitespace-nowrap">
                                        <small>ABC per LOT <span class="text-red-500">*</span></small>
                                    </td>
                                    <td class="whitespace-nowrap">
                                        <small>PhilGEPS Advertisement <span class="text-red-500">*</span></small>
                                    </td>
                                    <td class="whitespace-nowrap">
                                        <small>PhilGEPS Posting Date <span class="text-red-500">*</span></small>
                                    </td>
                                    <td class="whitespace-nowrap">
                                        <small>RFQ/ITB Number <span class="text-red-500">*</span></small>
                                    </td>
                                    <td class="whitespace-nowrap">
                                        <small>Pre Bid Conference<span class="text-red-500">*</span></small>
                                    </td>
                                    <td class="whitespace-nowrap">
                                        <small>Bid Opening <span class="text-red-500">*</span></small>
                                    </td>
                                    <td class="whitespace-nowrap">
                                        <small>Post Qualification Presentation<span class="text-red-500">*</span></small>
                                    </td>
                                    <td class="whitespace-nowrap">
                                        <small>SQ Number <span class="text-red-500">*</span></small>
                                    </td>
                                    <td class="whitespace-nowrap">
                                        <small>BAC Res. Number <span class="text-red-500">*</span></small>
                                    </td>
                                    <td class="whitespace-nowrap">
                                        <small>Date of BAC Res. Completely Signed <span
                                                class="text-red-500">*</span></small>
                                    </td>
                                    <td class="whitespace-nowrap">
                                        <small>NOA No. <span class="text-red-500">*</span></small>
                                    </td>
                                    <td class="whitespace-nowrap">
                                        <small>Canvasser <span class="text-red-500">*</span></small>
                                    </td>
                                    <td class="whitespace-nowrap">
                                        <small>Name of Supplier <span class="text-red-500">*</span></small>
                                    </td>
                                    <td class="whitespace-nowrap">
                                        <small>Contract Price <span class="text-red-500">*</span></small>
                                    </td>
                                    <td class="whitespace-nowrap">
                                        <small>Date Forwarded to GSS <span class="text-red-500">*</span></small>
                                    </td>
                                    <td class="whitespace-nowrap">
                                        <small>Remarks <span class="text-red-500">*</span></small>
                                    </td>
                                </tr>
                                @if (is_array($lotDescriptions) && is_array($abcPerLots))
                                    @foreach ($lotDescriptions as $index => $lotDescription)
                                        <tr>
                                            <td class="whitespace-nowrap py-1 pr-1">
                                                <input type="text" name="lot_description[]"
                                                    class=" bg-gray-50 border border-gray-300 p-2 text-sm rounded w-[500px]"
                                                    :id="'lot_description_' + {{ $index }}"
                                                    value="{{ old('lot_description.' . $index, $lotDescription) }}">
                                            </td>

                                            <td class="whitespace-nowrap pr-1">
                                                <input type="text" name="abc_per_lot[]"
                                                    class="w-[150px] bg-gray-50 border border-gray-300 p-2 text-sm rounded"
                                                    :id="'abc_per_lot_' + {{ $index }}"
                                                    value="{{ old('abc_per_lot.' . $index, $abcPerLots[$index] ?? '') }}">
                                            </td>





                                            <td class="whitespace-nowrap pr-1">
                                                <input type="date" name="philgeps_advertisement[]"
                                                    class="w-[150px] bg-gray-50 border border-gray-300 p-2 text-sm rounded"
                                                    id="philgeps_advertisement_{{ $index }}"
                                                    value="{{ old('philgeps_advertisement.' . $index, $philgeps_advertisement[$index] ?? '') }}">
                                            </td>

                                            <td class="whitespace-nowrap pr-1">
                                                <input type="date" name="philgeps_posting_date[]"
                                                    class="w-[150px] bg-gray-50 border border-gray-300 p-2 text-sm rounded"
                                                    id="philgeps_posting_date_{{ $index }}"
                                                    value="{{ old('philgeps_posting_date.' . $index, $philgeps_posting_date[$index] ?? '') }}">
                                            </td>






                                            <td class="whitespace-nowrap pr-1">
                                                <input type="text" name="rfq_itb_number[]"
                                                    class="w-[150px] bg-gray-50 border border-gray-300 p-2 text-sm rounded"
                                                    id="rfq_itb_number_{{ $index }}"
                                                    value="{{ old('rfq_itb_number.' . $index, $rfq_itb_number[$index] ?? '') }}">
                                            </td>






                                            <td class="whitespace-nowrap pr-1">
                                                <input type="date" name="pre_bid_conference[]"
                                                    class="w-[150px] bg-gray-50 border border-gray-300 p-2 text-sm rounded"
                                                    id="pre_bid_conference_{{ $index }}"
                                                    value="{{ old('pre_bid_conference.' . $index, $pre_bid_conference[$index] ?? '') }}">
                                            </td>

                                            <td class="whitespace-nowrap pr-1">
                                                <input type="date" name="bid_opening[]"
                                                    class="w-[150px] bg-gray-50 border border-gray-300 p-2 text-sm rounded"
                                                    id="bid_opening_{{ $index }}"
                                                    value="{{ old('bid_opening.' . $index, $bid_opening[$index] ?? '') }}">
                                            </td>

                                            <td class="whitespace-nowrap pr-1">
                                                <input type="date" name="post_qualification[]"
                                                    class="w-[150px] bg-gray-50 border border-gray-300 p-2 text-sm rounded"
                                                    id="post_qualification_{{ $index }}"
                                                    value="{{ old('post_qualification.' . $index, $post_qualification[$index] ?? '') }}">
                                            </td>






                                            <td class="whitespace-nowrap pr-1">
                                                <input type="text" name="sq_number[]"
                                                    class="w-[150px] bg-gray-50 border border-gray-300 p-2 text-sm rounded"
                                                    id="sq_number_{{ $index }}"
                                                    value="{{ old('sq_number.' . $index, $sq_number[$index] ?? '') }}">
                                            </td>

                                            <td class="whitespace-nowrap pr-1">
                                                <input type="text" name="bac_res_number[]"
                                                    class="w-[150px] bg-gray-50 border border-gray-300 p-2 text-sm rounded"
                                                    id="bac_res_number_{{ $index }}"
                                                    value="{{ old('bac_res_number.' . $index, $bac_res_number[$index] ?? '') }}">
                                            </td>

                                            <td class="whitespace-nowrap pr-1">
                                                <input type="date" name="date_of_bac_res_completely_signed[]"
                                                    class="w-[250px] bg-gray-50 border border-gray-300 p-2 text-sm rounded"
                                                    id="date_of_bac_res_completely_signed_{{ $index }}"
                                                    value="{{ old('date_of_bac_res_completely_signed.' . $index, $date_of_bac_res_completely_signed[$index] ?? '') }}">
                                            </td>

                                            <td class="whitespace-nowrap pr-1">
                                                <input type="text" name="noa_number[]"
                                                    class="w-[150px] bg-gray-50 border border-gray-300 p-2 text-sm rounded"
                                                    id="noa_number_{{ $index }}"
                                                    value="{{ old('noa_number.' . $index, $noa_number[$index] ?? '') }}">
                                            </td>

                                            <td class="whitespace-nowrap pr-1">
                                                <input type="text" name="canvasser[]"
                                                    class="w-[250px] bg-gray-50 border border-gray-300 p-2 text-sm rounded"
                                                    id="canvasser_{{ $index }}"
                                                    value="{{ old('canvasser.' . $index, $canvasser[$index] ?? '') }}">
                                            </td>

                                            <td class="whitespace-nowrap pr-1">
                                                <input type="text" name="name_of_supplier[]"
                                                    class="w-[350px] bg-gray-50 border border-gray-300 p-2 text-sm rounded"
                                                    id="name_of_supplier_{{ $index }}"
                                                    value="{{ old('name_of_supplier.' . $index, $name_of_supplier[$index] ?? '') }}">
                                            </td>

                                            <td class="whitespace-nowrap pr-1">
                                                <input type="text" name="contract_price[]"
                                                    class="w-[150px] bg-gray-50 border border-gray-300 p-2 text-sm rounded"
                                                    id="contract_price_{{ $index }}"
                                                    value="{{ old('contract_price.' . $index, $contract_price[$index] ?? '') }}">
                                            </td>

                                            <td class="whitespace-nowrap pr-1">
                                                <input type="date" name="date_forwarded_to_gss[]"
                                                    class="w-[150px] bg-gray-50 border border-gray-300 p-2 text-sm rounded"
                                                    id="date_forwarded_to_gss_{{ $index }}"
                                                    value="{{ old('date_forwarded_to_gss.' . $index, $date_forwarded_to_gss[$index] ?? '') }}">
                                            </td>

                                            <td class="whitespace-nowrap pr-1">
                                                <input type="text" name="remarks[]"
                                                    class="w-[150px] bg-gray-50 border border-gray-300 p-2 text-sm rounded"
                                                    id="remarks_{{ $index }}"
                                                    value="{{ old('remarks.' . $index, $remarks[$index] ?? '') }}">
                                            </td>

                                        </tr>
                                    @endforeach
                                @else
                                    <p>Data is not in the expected array format.</p>
                                @endif
                            </table>
                        </div>
                        <div class="flex gap-2 items-end mt-5">
                            <div class="flex flex-col flex-1">
                                <small>End User <span class="text-red-500">*</span></small>
                                <input type="text" name="end_user"
                                    class="w-full bg-gray-50 border border-gray-300 p-2 text-sm rounded"
                                    value="{{ old('end_user', $editProject->end_user ?? '') }}">
                            </div>
                            <div class="flex flex-col w-72">
                                <small>Total ABC <span class="text-red-500">*</span></small>
                                <input type="text" name="total_abc"
                                    class="w-full bg-gray-50 border border-gray-300 p-2 text-sm rounded"
                                    value="{{ old('total_abc', $editProject->total_abc ?? '') }}" disabled>
                            </div>
                        </div>

                        <div class="flex gap-2 items-end mt-3">
                            <div class="flex flex-col flex-1">
                                <small>Approved APP <span class="text-red-500">*</span></small>
                                <select name="approved_app"
                                    class="w-full bg-gray-50 border border-gray-300 p-2 text-sm rounded">
                                    <option value="" disabled
                                        {{ old('approved_app', $editProject->approved_app ?? '') === null ? 'selected' : '' }}>
                                        - - Select - -
                                    </option>
                                    <option value="Pending"
                                        {{ old('approved_app', $editProject->approved_app ?? '') === 'Pending' ? 'selected' : '' }}>
                                        PENDING
                                    </option>
                                    <option value="APP Approved"
                                        {{ old('approved_app', $editProject->approved_app ?? '') === 'APP Approved' ? 'selected' : '' }}>
                                        APP APPROVED
                                    </option>
                                </select>
                            </div>
                            <div class="flex flex-col w-72">
                                <small>Date Received from Planning <span class="text-red-500">*</span></small>
                                <input type="date" name="date_received_from_planning"
                                    class="w-full bg-gray-50 border border-gray-300 p-2 text-sm rounded"
                                    value="{{ old('date_received_from_planning', $editProject->date_received_from_planning ?? '') }}">
                            </div>
                        </div>

                        <div class="flex gap-2 items-end mt-3">
                            <div class="flex flex-col flex-1">
                                <small>TWG<span class="text-red-500">*</span></small>
                                <input type="text" name="twg"
                                    class="w-full bg-gray-50 border border-gray-300 p-2 text-sm rounded"
                                    value="{{ old('twg', $editProject->twg ?? '') }}">
                            </div>
                            <div class="flex flex-col w-72">
                                <small>Date Received by the TWG<span class="text-red-500">*</span></small>
                                <input type="date" name="date_received_by_twg"
                                    class="w-full bg-gray-50 border border-gray-300 p-2 text-sm rounded"
                                    value="{{ old('date_received_by_twg', $editProject->date_received_by_twg ?? '') }}">
                            </div>
                        </div>

                        <div class="flex gap-2 items-end mt-3">
                            <div class="flex flex-col flex-1">
                                <small>Approved PR Received<span class="text-red-500">*</span></small>
                                <input type="date" name="approved_pr_received"
                                    class="w-full bg-gray-50 border border-gray-300 p-2 text-sm rounded"
                                    value="{{ old('approved_pr_received', $editProject->approved_pr_received ?? '') }}">
                            </div>

                            <div class="flex flex-col w-72">
                                <small>Date Forwarded to Budget<span class="text-red-500">*</span></small>
                                <input type="date" name="date_forwarded_to_budget"
                                    class="w-full bg-gray-50 border border-gray-300 p-2 text-sm rounded"
                                    value="{{ old('date_forwarded_to_budget', $editProject->date_forwarded_to_budget ?? '') }}">
                            </div>
                        </div>


                        {{-- <hr class="mt-10 mb-8 border-t border-gray-300"> --}}

                        <div class="w-full flex gap-2 mt-6 mb-2 justify-center">
                            <button
                                class=" bg-green-400 text-white cursor-pointer text-sm rounded py-2 w-1/2">Update</button>
                            <a href="{{ route('tracking') }}"
                                class="modal__btn bg-red-400 text-center text-white cursor-pointer text-sm rounded py-2 w-1/2"
                                data-micromodal-close>Close</a>
                        </div>
                    </form>
                </main>

            </div>
        </div>
        </div>
    @endif

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('mode_of_procurement');
        const input = document.getElementById('custom_mode_input');

        function toggleInput() {
            if (select.value === 'others') {
                input.classList.remove('hidden');
            } else {
                input.classList.add('hidden');
                input.value = ''; // Optional: clear input
            }
        }

        select.addEventListener('change', toggleInput);
        toggleInput(); // Run on page load in case it's pre-selected
    });
</script>
