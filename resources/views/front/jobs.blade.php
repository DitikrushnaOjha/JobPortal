@extends('front.layout.app')

@section('main')
<section class="section-3 py-5 bg-2">
    <div class="container">
        <div class="row">
            <div class="col-6 col-md-10">
                <h2>Find Jobs</h2>
            </div>
            <div class="col-6 col-md-2">
                <div class="align-end">
                    <select name="sort" id="sort" class="form-control">
                        <option value="latest">Latest</option>
                        <option value="oldest">Oldest</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row pt-5">
            <!-- Sidebar -->
            <div class="col-md-4 col-lg-3 sidebar mb-4">
                <form action="{{ route('jobs.index') }}" method="GET" id="searchForm">
                    <div class="card border-0 shadow p-4">
                        <div class="mb-4">
                            <h2>Keywords</h2>
                            <input type="text" name="keyword" id="keyword" placeholder="Keywords" class="form-control">
                        </div>

                        <div class="mb-4">
                            <h2>Location</h2>
                            <input type="text" name="location" id="location" placeholder="Location" class="form-control">
                        </div>

                        <div class="mb-4">
                            <h2>Category</h2>
                            <select name="catagory" id="catagory" class="form-control">
                                <option value="">Select Category</option>
                                @foreach ($catagories as $catagory)
                                    <option value="{{ $catagory->id }}">{{ $catagory->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <h2>Job Type</h2>
                            @foreach ($jobTypes as $jobType)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" name="job_type[]" type="checkbox"
                                           value="{{ $jobType->id }}" id="job-type-{{ $jobType->id }}">
                                    <label class="form-check-label" for="job-type-{{ $jobType->id }}">
                                        {{ $jobType->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <div class="mb-4">
                            <h2>Experience</h2>
                            <select name="experience" id="experience" class="form-control">
                                <option value="">Select Experience</option>
                                @for ($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}">{{ $i }} Year{{ $i > 1 ? 's' : '' }}</option>
                                @endfor
                                <option value="10+">10+ Years</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Search</button>
                    </div>
                </form>
            </div>

            <!-- Job Listings -->

            <div class="col-md-8 col-lg-9">
                <div class="job_listing_area">
                    <div class="job_lists">
                        <div class="row">
                            @if ($jobs->count() > 0)
                                @foreach ($jobs as $job)
                                    <div class="col-md-4">
                                        <div class="card border-0 p-3 shadow mb-4">
                                            <div class="card-body">
                                                <h3 class="border-0 fs-5 pb-2 mb-0">{{ $job->tittle }}</h3>
                                                <p>{{ Str::limit($job->description, 50) }}</p>
                                                <div class="bg-light p-3 border">
                                                    <p class="mb-0">
                                                        <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                                        <span class="ps-1">{{ $job->location }}</span>
                                                    </p>
                                                    <p class="mb-0">
                                                        <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                                        <span class="ps-1">{{ $job->jobType->name ?? 'N/A' }}</span>
                                                    </p>

                                                    @if (!empty($job->salary))
                                                        <p class="mb-0">
                                                            <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                                            <span class="ps-1">{{ $job->salary }}</span>
                                                        </p>
                                                    @endif
                                                </div>

                                                <div class="d-grid mt-3">
                                                    <a href="{{ route('jobs.show', $job->id) }}"
                                                       class="btn btn-primary btn-lg">Details</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <!-- Pagination -->
                                <div class="col-12 mt-4">
                                    {{ $jobs->links() }}
                                </div>
                            @else
                                <div class="col-md-12">No jobs found. </div>
                                <p> i love u SONY DRLING ......jkbkhjbgug </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('customJs')
@endsection
