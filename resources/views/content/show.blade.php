@section('title',$content->title)
<x-layout>
    <div class="row">
        <div class="col-md-5 m-2">
            <a href="{{ $content->url }}" data-lightbox="photos">
                <img style="width:450px;" class="img-fluid" src="{{ $content->url }}">
            </a>
        </div>
        <div class="col-md-6">
            <ul class="m-2">
                <li>
                    <h3>{{ $content->title}}</h3><span>
                        <x-post-update-btn text="" :member="$content" />
                    </span>
                </li>
                <li>
                    Approved:
                    <x-boolean-badge :boolean="$content->approved" />
                </li>
                <li>
                    Posted:
                    <x-boolean-badge :boolean="$content->posted" />
                </li>
                <li>
                    Created:
                    {{$content->created_at->diffForHumans() }}
                </li>
                @if($content->post)
                <li>
                    Posted:
                    {{$content->post->created_at->diffForHumans() }}
                </li>
                @endif
                @if(count($content->tags)>0)
                <li>
                    <x-post-tags-badges :member="$content" />
                </li>
                @endif
                <li>
                    <x-post-stats-badges :member="$content" />
                </li>
                @if($content->explaination)
                <li class="p-2">
                    Explaination:
                    @php
                    echo $content->explaination
                    @endphp
                </li>
                @endif
            </ul>
        </div>
    </div>
</x-layout>