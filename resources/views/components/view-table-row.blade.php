@props(['member'])

<tr>
    <td>{{$member->title}}</td>
    
    <td>{{ $member->views }}</td>
    <td>
        <x-post-edit-btn text="" :member="$member" />
    </td>
</tr>