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
                input.value = '';
            }
        }

        select.addEventListener('change', toggleInput);
        toggleInput(); 
    });
</script>
