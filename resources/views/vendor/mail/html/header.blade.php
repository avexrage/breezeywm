@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (!empty($logoUrl))
    <img src="{{ $logoUrl }}" alt="Logo" style="height: 100px;">
@endif
{{ $slot }}
</a>
</td>
</tr>
    
