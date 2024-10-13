<x-layout>
    <div>
        <h1>{{ $title }}</h1>
        <div class="bg-light rounded h-100 p-4">
            <div class="row">
                @foreach($data as $k=>$member)
                <x-post-card classes="col-md-3" :member="$member" />
                @endforeach
            </div>
            @php
            if(Route::currentRouteName()=="adminrecomended"):
            @endphp
            <div class="row">
                <div class="col-md-2 m-2 col-md-offset-3">
                    <form method="post" action="{{ route('adminstoreschedule') }}">
                        @csrf
                        <input type="submit" value="Save Schedule" class="btn btn-success">
                    </form>
                </div>
                <div class="col-md-2 m-2">
                    <form method="post" action="{{ route('adminresetschedule') }}">
                        @csrf
                        <input type="submit" value="Reset Schedule" class="btn btn-warning">
                    </form>
                </div>
            </div>
            @php
            endif;
            @endphp
        </div>
</x-layout>