<table class="table col-12">
    <thead>
    <tr>
        <th class="text-center">
            Стало
        </th>
        <th class="text-center">
            Было
        </th>
    </tr>
    </thead>
    <tbody>
    @if($queryCurrentMap->mapStatus->title != $queryPreviousMap->mapStatus->title)
        <tr>
            <td class="text-center">{{$queryCurrentMap->mapStatus->title}}</td>
            <td class="text-center">{{$queryPreviousMap->mapStatus->title}}</td>
        </tr>
    @endif
    @if($queryCurrentMap->data->client_name != $queryPreviousMap->data->client_name)
        <tr>
            <td class="text-center">{{$queryCurrentMap->data->client_name}}</td>
            <td class="text-center">{{$queryPreviousMap->data->client_name}}</td>
        </tr>
    @endif
    @if($queryCurrentMap->data->phone != $queryPreviousMap->data->phone)
        <tr>
            <td class="text-center">{{$queryCurrentMap->data->departure_date}}</td>
            <td class="text-center">{{$queryPreviousMap->data->departure_date}}</td>
        </tr>
    @endif
    @if($queryCurrentMap->data->phone != $queryPreviousMap->data->phone)
        <tr>
            <td class="text-center">{{$queryCurrentMap->data->phone}}</td>
            <td class="text-center">{{$queryPreviousMap->data->phone}}</td>
        </tr>
    @endif
    @if($queryCurrentMap->data->address != $queryPreviousMap->data->address)
        <tr>
            <td class="text-center">{{$queryCurrentMap->data->address}}</td>
            <td class="text-center">{{$queryPreviousMap->data->address}}</td>
        </tr>
    @endif
    @if($queryCurrentMap->data->price != $queryPreviousMap->data->price)
        <tr>
            <td class="text-center">{{$queryCurrentMap->data->price}}</td>
            <td class="text-center">{{$queryPreviousMap->data->price}}</td>
        </tr>
    @endif
    @if($queryCurrentMap->data->weight != $queryPreviousMap->data->weight)
        <tr>
            <td class="text-center">{{$queryCurrentMap->data->weight}}</td>
            <td class="text-center">{{$queryPreviousMap->data->weight}}</td>
        </tr>
    @endif
    @if($queryCurrentMap->data->cutters_count != $queryPreviousMap->data->cutters_count)
        <tr>
            <td class="text-center">{{$queryCurrentMap->data->cutters_count}}</td>
            <td class="text-center">{{$queryPreviousMap->data->cutters_count}}</td>
        </tr>
    @endif
    @if($queryCurrentMap->data->loaders_count != $queryPreviousMap->data->loaders_count)
        <tr>
            <td class="text-center">{{$queryCurrentMap->data->loaders_count}}</td>
            <td class="text-center">{{$queryPreviousMap->data->loaders_count}}</td>
        </tr>
    @endif
    @if($queryCurrentMap->data->oxygen_count != $queryPreviousMap->data->oxygen_count)
        <tr>
            <td class="text-center">{{$queryCurrentMap->data->oxygen_count}}</td>
            <td class="text-center">{{$queryPreviousMap->data->oxygen_count}}</td>
        </tr>
    @endif
    @if($queryCurrentMap->data->base_address != $queryPreviousMap->data->base_address)
        <tr>
            <td class="text-center">{{$queryCurrentMap->data->base_address}}</td>
            <td class="text-center">{{$queryPreviousMap->data->base_address}}</td>
        </tr>
    @endif
    @if($queryCurrentMap->data->comment != $queryPreviousMap->data->comment)
        <tr>
            <td class="text-center">{{$queryCurrentMap->data->comment ?? '-'}}</td>
            <td class="text-center">{{$queryPreviousMap->data->comment ?? '-'}}</td>
        </tr>
    @endif
    </tbody>
</table>