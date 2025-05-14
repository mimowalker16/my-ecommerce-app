@component('mail::message')
# Thank you for your order, {{ $user->first_name }}!

Your order (ID: {{ $order->id }}) has been placed successfully on {{ $order->order_date }}.

## Order Summary
@component('mail::table')
| Product       | Quantity     | Price   |
| ------------- |:-----------:| -------:|
@if($order->items)
@foreach($order->items as $item)
| {{ $item->product ? $item->product->name : 'Unknown Product' }} | {{ $item->quantity }} | ${{ number_format($item->price, 2) }} |
@endforeach
@endif
@endcomponent

**Total Paid:** ${{ number_format($order->total_amount, 2) }}

We appreciate your business!

Thanks,<br>
{{ config('app.name') }}
@endcomponent
