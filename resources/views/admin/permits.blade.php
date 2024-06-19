<x-app-layout>
    <div class="pagetitle">
        <h1>Permits</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Permits</li>
            </ol>
        </nav>
    </div>
    <section class="section">
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
                <div class="table-responsive text-nowrap">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Permits</h5>
                            <form class="" style="float: right;" action="{{route('admin-search-permit')}}" method="POST">
                                @csrf
                                <input type="text" class="form-control" name="search" placeholder="Search">
                            </form>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Reference</th>
                                        <th>Fullname</th>
                                        <th>Status</th>
                                        <th>Expiry</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $count = 0;
                                    @endphp
                                    @foreach ($permits as $permit)
                                        @php
                                            $count++;
                                        @endphp
                                        <tr>
                                            <td>{{$count}}</td>
                                            <td>{{$permit->reference}}</td>
                                            <td>{{$permit->fname}} {{$permit->lname}}</td>
                                            <td>
                                                @if (!$permit->valid)
                                                    <span class="badge bg-danger">
                                                        Invalid
                                                    </span>
                                                @else
                                                    <span class="badge bg-success">
                                                        Valid
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (strtotime($permit->expiry_date) < time())
                                                    <span class="badge bg-danger">{{$permit->expiry_date}}</span>
                                                @else
                                                    <span class="badge bg-success">{{$permit->expiry_date}}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#updateModal{{$permit->id}}">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="updateModal{{$permit->id}}" tabindex="-1">
                                            <div class="modal-dialog">
                                              <div class="modal-content">
                                                <form method="POST" action="{{route('admin-update-permit')}}">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Validate/Invalidate permit</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="permit_id" value="{{$permit->id}}" class="form-control" required>
                                                        <div class="row mb-3">
                                                            <label for="inputText" class="col-sm-2 col-form-label">Action</label>
                                                            <div class="col-sm-10">
                                                                <select name="option" class="form-control" required>
                                                                    <option selected disabled>Select Option</option>
                                                                    <option value="0">Revoke</option>
                                                                    <option value="1">Validate</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Validate</button>
                                                    </div>
                                                </form>
                                              </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
