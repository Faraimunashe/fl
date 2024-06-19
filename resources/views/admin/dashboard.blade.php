<x-app-layout>
    <div class="pagetitle">
        <h1>Applications</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Applications</li>
            </ol>
        </nav>
    </div>
    <section>
        <div class="row">
            <div class="col-md-12">
                @if (Session::has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ Session::get('success') }}
                    </div>
                @endif
                @if (Session::has('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ Session::get('error') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card info-card sales-card">
                            <div class="card-header">
                                <h5>Total Hunters</span></h5>
                            </div>
                            <div class="card-body text-center">
                                <div class="d-flex align-items-center mt-2">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3 mt-2">
                                        <h6>{{\DB::table('role_user')->where('role_id', 2)->count()}}</h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card info-card sales-card">
                            <div class="card-header">
                                <h5>Total Revenue</span></h5>
                            </div>
                            <div class="card-body text-center">
                                <div class="d-flex align-items-center mt-2">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-coin"></i>
                                    </div>
                                    <div class="ps-3 mt-2">
                                        <h6>{{\App\Models\Transaction::sum('amount')}}</h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card info-card sales-card">
                            <div class="card-header">
                                <h5>Total Valid Permits</span></h5>
                            </div>
                            <div class="card-body text-center">
                                <div class="d-flex align-items-center mt-2">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-file-earmark-medical"></i>
                                    </div>
                                    {{-- strtotime($permit->expiry_date) < time() --}}
                                    <div class="ps-3 mt-2">
                                        <h6>{{\App\Models\Permit::where('expiry_date', '<', time())->count()}}</h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @foreach ($applications as $app)
                            <div class="list-group mt-3">
                                <div class="list-group-item d-flex justify-content-between align-items-start">
                                    @php
                                        $img = \App\Models\Image::where('user_id', Auth::id())->first();
                                    @endphp
                                    @if (is_null($img))
                                        <img src="{{asset('images/user.png')}}" height="30" alt="Employee Image" class="rounded m-1">
                                    @else
                                        <img src="" height="30" alt="Employee Image" class="rounded m-1">
                                    @endif
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">{{$app->fname}} {{$app->lname}}</div>
                                        <div style="font-size: 13px">
                                            <strong>Gender:</strong> {{$app->sex}}
                                            <strong>Nation Id:</strong> {{$app->natid}}
                                            <strong>Paid:</strong>
                                            @if ($app->payment == 0)
                                                False
                                            @elseif($app->payment == 1)
                                                True
                                            @endif
                                            <strong>Status:</strong>
                                            @if ($app->status == 0)
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif($app->status == 1)
                                                <span class="badge bg-success">Approved</span>
                                            @endif

                                            <strong>Date:</strong> {{$app->created_at->diffForHumans()}}
                                        </div>
                                    </div>
                                    <div class="filter">
                                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></a>
                                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                            <li class="dropdown-header text-start">
                                                <h6>Options</h6>
                                            </li>

                                            <li>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#updateModal{{$app->id}}">
                                                    <i class="bi bi-pencil-square"></i>
                                                    Update
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="updateModal{{$app->id}}" tabindex="-1">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <form method="POST" action="{{route('admin-update-application')}}">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title">Add a Period</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="application_id" value="{{$app->id}}" class="form-control" required>
                                            <div class="row mb-3">
                                                <label for="inputText" class="col-sm-2 col-form-label">Decision</label>
                                                <div class="col-sm-10">
                                                    <select name="status" class="form-control" required>
                                                        <option selected disabled>Select Option</option>
                                                        <option value="1">Accept</option>
                                                        <option value="2">Reject</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                  </div>
                                </div>
                            </div>
                        @endforeach
                        @if ($applications->isEmpty())
                            <div class="alert alert-warning mt-4">
                                No applications yet!
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
