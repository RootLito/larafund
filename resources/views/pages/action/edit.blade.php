@extends('layout.app')

@section('title', 'View Project')

@section('content')
    <div class="w-full h-full flex flex-col gap-10 p-10">
        <div class="w-full h-full bg-white p-6 rounded-lg">
            <a href="javascript:history.back()" class="flex items-center text-red-400 font-bold hover:text-red-600">
                <i class="fa-solid fa-arrow-left mr-2"></i>
                Back
            </a>

            @if ($editProject)
                <h2 class="text-5xl">Selected ID is: {{ $editProject->id }}</h2>
                <p>{{ $editProject->procurement_project ?? 'N/A' }}</p>
            @else
                <h2 class="text-5xl">No Project Found</h2>
            @endif


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
                                        <option value="Completed"
                                            {{ $editProject->status == 'Completed' ? 'selected' : '' }}>
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
                                        <option value="Cancelled"
                                            {{ $editProject->status == 'Cancelled' ? 'selected' : '' }}>
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
                                class="w-full bg-gray-50 border border-gray-300 p-2 text-sm rounded mb-2"
                                value="{{ $editProject->mode_of_procurement }}" />


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
                                $date_of_bac_res_completely_signed = json_decode(
                                    $editProject->date_of_bac_res_completely_signed,
                                    true,
                                );
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
                                            <small>Post Qualification Presentation<span
                                                    class="text-red-500">*</span></small>
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
    </div>
@endsection
