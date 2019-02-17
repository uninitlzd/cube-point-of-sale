@component('mail::message')
# Laporan Harian Penjualan
##### {{ $date }}
## {{ $user->shop->name }}

@component('mail::table')
    | Judul                     | Besaran           |
    | ------------------------- |:-----------------:|
    | Keuntungan Kotor          | <b>Rp{{ $report['total_gross_profit'] }}</b>  |
    | Produk Terjual            | <b>{{ $report['total_product_sold'] }}</b> |
@endcomponent

##### Produk paling laku
@if($report['most_selling'] !== null)
## {{ $report['most_selling']['name'] }}
<p>Terjual {{ $report['most_selling']['quantity_sum'] }} Produk</p>
@else
## -
@endif
<br>
##### Produk paling sedikit terjual
@if($report['least_selling'] !== null)
## {{ $report['least_selling']['name'] }}
<p>Terjual {{ $report['least_selling']['quantity_sum'] }} Produk</p>
@else
## -
@endif
<br><br>
Thanks,<br>
{{ config('app.name') }}
@endcomponent
