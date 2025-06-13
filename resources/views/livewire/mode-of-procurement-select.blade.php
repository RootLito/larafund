<div>
    <select wire:model="mode_of_procurement" class="w-full bg-gray-50 border border-gray-300 p-2 text-sm rounded mb-2">
        <option value="" selected disabled>Select Mode of Procurement</option>
        <option value="Public Bidding">Public Bidding</option>
        <option value="Direct Contracting">Direct Contracting</option>
        <option value="Small Value Procurement">Small Value Procurement</option>
        <option value="Emergency Cases">Emergency Cases</option>
        <option value="others">Others</option>
    </select>

    @if($mode_of_procurement === 'others')
        <input type="text" wire:model="custom_mode" placeholder="Please specify"
               class="w-full bg-gray-50 border border-gray-300 p-2 text-sm rounded mb-2" />
    @endif
</div>
