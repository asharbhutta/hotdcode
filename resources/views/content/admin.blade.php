@section('title',"All Ahadiths")
<x-layout>
    <div>
        <h1>{{ $title }}</h1>
        <div class="bg-light rounded h-100 p-4">
            <h6 class="mb-4"> Ahadith found ({{ $data->total() }}) </h6>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Image</th>
                            <th scope="col">Tags</th>
                            <th scope="col">Approved</th>
                            <th scope="col">Posted</th>
                            <th scope="col">Explaination</th>
                            <th scope="col">Stats</th>
                            <th scope="col">Actions</th>
                        </tr>
                        <tr>
                            <x-post-search-form />
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($data as $k=>$member)
                        <x-content-admin-table-row :member="$member" />
                        @endforeach
                    </tbody>
                </table>
                {{ $data->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</x-layout>