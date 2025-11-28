@extends('layouts.admin')

@section('content')

<div class="mx-5 relative">
    <!-- Main Order Detail -->
    <div class="px-24 bg-white shadow-md rounded-md mt-2">
        <!-- Header Logo and Rany-E_Commerce -->
        <div class="flex justify-center">
            <div>
                <div class="flex items-center justify-center w-28 h-28 ml-5 -mb-4 bg-yellow-500 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" class="w-20 h-20 text-white">
                        <rect x="20" y="30" width="60" height="50" rx="4" fill="currentColor"/>
                        <path d="M 30 30 L 30 25 Q 30 20 35 20 L 65 20 Q 70 20 70 25 L 70 30" stroke="currentColor" stroke-width="3" fill="none"/>
                        <circle cx="40" cy="50" r="3" fill="white"/>
                        <circle cx="60" cy="50" r="3" fill="white"/>
                    </svg>
                </div>
                <span class="text-center font-semibold text-gray-900 dark:text-white">
                    <span class="text-yellow-600">{{ __('Rany') }}-</span>{{ __('E-Commerce') }}
                </span>
            </div>
        </div>
        <div class="flex justify-between py-3">
            <div class="text-left">
                <h1 class="font-bold">{{ __('Order ID') }}: {{ $order->id }}</h1>
                <h1 class="font-bold">{{ __('Bill To') }}</h1>
                <p>+855 8767 2382</p>
                <p class="w-80 pr-1"># {{ __('Location Shop') }}</p>
            </div>
            <div class="text-right mt-14">
                <div class="font-bold">{{ __('Customer') }}:
                    <span class="font-normal capitalize">{{ optional($order->createdBy)->name ?? 'N/A' }}</span>
                </div>
                <div class="font-bold">{{ __('Phone') }}:
                    <span class="font-normal capitalize">{{ optional($order->userAddress)->phone ?? 'N/A' }}</span>
                </div>
                <div class="font-bold">{{ __('Date') }}:
                    <span class="font-normal capitalize">{{ $order->updated_date }}</span>
                </div>
            </div>
        </div>
        <!-- End Header -->
        <!-- Table Order Detail -->
        <table class="w-full text-sm text-left mb-8 rtl:text-right text-gray-800 dark:text-gray-400">
            <thead>
                <tr class="bg-gray-200 rounded-lg">
                    <th>{{ __('No') }}</th>
                    <th class="text-center">{{ __('Product') }}</th>
                    <th class="text-center">{{ __('Quantity') }}</th>
                    <th class="text-center">{{ __('Unit Price') }}</th>
                    <th class="text-center">{{ __('Total') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($order->orderItems as $i => $item)
                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 overflow-auto">
                    {{-- <td>{{ $i + 1 }}</td> --}}
                    {{-- <td>
                        @if($item->product->productImages->count() > 0)
                            <img class="w-10 h-10 rounded" src="{{ asset($item->product->productImages[0]->image) }}" alt=""/>
                        @else
                            <img class="w-10 h-10 rounded" src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/1665px-No-Image-Placeholder.svg.png" alt=""/>
                        @endif
                    </td> --}}
                    <td class="text-center">{{ $item->id }}</td>
                    <td class="text-center">{{ $item->product->title }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-center">${{ $item->product->price }}</td>
                    <td class="text-center">${{ $item->quantity * $item->product->price }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">{{ __('No order items found.') }}</td>
                </tr>
                @endforelse
                <tr>
                    <td colspan="4"></td>
                    <td class="text-right font-bold bg-gray-200">{{ __('SubTotal') }}:</td>
                    <td class="text-center bg-gray-200">${{ $order->total_price }}</td>
                </tr>
            </tbody>
        </table>
        <!-- End Table Order Detail -->
        <div class="pb-28">
            <div class="flex justify-between pb-8 border-b-8">
                <div class="text-left">
                    <h1 class="font-bold">{{ __('Payment Info') }}</h1>
                    <h1 class="font-bold">{{ __('Type') }}: <span class="font-normal">{{ optional($order->payment)->type ?? 'N/A' }}</span></h1>
                    <h1 class="font-bold">{{ __('Status') }}:
                        <span class="font-normal">
                            @if(optional($order->payment)->status == 0)
                                <span class="bg-red-100 text-red-800 text-sm font-medium px-2.5 py-0.5 rounded-full -mt-2 -mb-2">{{ __('Unpaid') }}</span>
                            @else
                                <span class="bg-green-100 text-green-800 text-sm font-medium px-2.5 py-0.5 -mt-2 -mb-2 rounded-full">{{ __('Paid') }}</span>
                            @endif
                        </span>
                    </h1>
                    <h1 class="font-bold">{{ __('Address') }}:
                        <span class="font-normal">{{ optional($order->userAddress)->address ?? 'N/A' }}</span>
                    </h1>
                </div>
                <div class="mt-14 mr-20">
                    <div class="text-center">
                        <div class="font-bold">{{ __('Shop Name') }}</div>
                        <div class="text-xs">{{ __('Shop Owner') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
