<?php

use App\Models\Content;

?>
<x-layout>
    <div class="row">

        <!-- Sale & Revenue Start -->
        <div class="container-fluid pt-4 px-4">
            <div class="row g-4">
                <div class="col-sm-6 col-xl-4">
                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                        <i class="fa fa-eye fa-3x text-primary"></i>
                        <div class="ms-3">
                            <p class="mb-2 fw-bold">Today Views</p>
                            <h6 class="mb-0 text-right">{{$todayStats["views"]}}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-4">
                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                        <i class="fa fa-share fa-3x text-primary"></i>
                        <div class="ms-3">
                            <p class="mb-2 fw-bold">Today Shares</p>
                            <h6 class="mb-0 text-right">{{$todayStats["shares"]}}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-4">
                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                        <i class="fa fa-download fa-3x text-primary"></i>
                        <div class="ms-3">
                            <p class="mb-2 fw-bold">Today Downloads</p>
                            <h6 class="mb-0 text-right">{{$todayStats["downloads"]}}</h6>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- Sale & Revenue End -->

        <!-- Sale & Revenue Start -->
        <div class="container-fluid pt-4 px-4">
            <div class="row g-4">
                <div class="col-sm-6 col-xl-4">
                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                        <i class="fa fa-eye fa-3x text-success"></i>
                        <div class="ms-3">
                            <p class="mb-2">Total Views</p>
                            <h6 class="mb-0 text-right">{{$totalStats->views}}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-4">
                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                        <i class="fa fa-share fa-3x text-success"></i>
                        <div class="ms-3">
                            <p class="mb-2">Total Shares</p>
                            <h6 class="mb-0 text-right">{{$totalStats->shares}}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-4">
                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                        <i class="fa fa-download fa-3x text-success"></i>
                        <div class="ms-3">
                            <p class="mb-2">Total Downloads</p>
                            <h6 class="mb-0 text-right">{{$totalStats->downloads}}</h6>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- Sale & Revenue End -->

        <div class="container-fluid pt-4 px-4">
            <div class="row g-4">
                <div class="col-sm-6 col-xl-4">
                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                        <i class="fa fa-regular fa-mobile fa-3x text-warning"></i>
                        <div class="ms-3">
                            <p class="mb-2">Today App Installs</p>
                            <h6 class="mb-0 text-right">{{$appInstalls["today"]}}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-4">
                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                        <i class="fa fa-regular fa-mobile fa-3x text-warning"></i>
                        <div class="ms-3">
                            <p class="mb-2">This Week App Installs</p>
                            <h6 class="mb-0 text-right">{{$appInstalls["thisWeek"]}}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-4">
                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                        <i class="fa fa-regular fa-mobile fa-3x text-warning"></i>
                        <div class="ms-3">
                            <p class="mb-2">This Month App Installs</p>
                            <h6 class="mb-0 text-right">{{$appInstalls["thisMonth"]}}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <!-- Sales Chart Start -->
        <div class="container-fluid pt-4 px-4">
            <div class="row g-4">
                <div class="col-sm-12 col-xl-4">
                    <div class="bg-light text-center rounded p-4">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h6 class="mb-0">Today's Hadith</h6>
                        </div>
                        <x-post-card classes="col-md-12" :member="$recentItems[0]" />
                    </div>
                </div>
                <div class="col-sm-12 col-xl-8">
                    <div class="bg-light text-center rounded p-4">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h6 class="mb-0">Recently Posted Ahadith</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Title</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Stats</th>
                                        <th scope="col">Posted at</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($recentItems as $k=>$member)
                                    <x-dashboard-table-row :member="$member" />
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid pt-4 px-4">
            <div class="row g-4">
                <div class="col-sm-12 col-xl-12">
                    <div class="bg-light text-center rounded p-4">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h6 class="mb-0">Today Total Views ({{ $groupedStats["totalViews"]  }}) </h6>
                        </div>

                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h6 class="mb-0">Today Unique Viewed Items ({{ $groupedStats["unique_items"]  }}) </h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Title</th>
                                        <th scope="col">Views</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($groupedStats["data"] as $k=>$v)
                                    @php
                                    $member=Content::findOrFail($v->content_id);
                                    $member->views=$v->views;
                                    @endphp
                                    <x-view-table-row :member="$member" />
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
          
        </div>
        <!-- Sales Chart End -->


        <!-- Recent Sales Start -->

        <!-- Recent Sales End -->


        <!-- Widgets Start -->

    </div>
</x-layout>