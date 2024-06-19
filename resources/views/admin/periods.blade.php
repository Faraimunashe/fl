<x-app-layout>
    <div class="pagetitle">
        <h1>Periods</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Periods</li>
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
                            <h5 class="card-title">Periods</h5>
                            <div class="justify-right" style="justify-content: right;">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                                    <i class="bi bi-plus"></i>
                                    New
                                </button>
                            </div>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Length</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $count = 0;
                                    @endphp
                                    @foreach ($periods as $period)
                                        @php
                                            $count++;
                                        @endphp
                                        <tr>
                                            <td>{{$count}}</td>
                                            <td>{{$period->length}}</td>
                                            <td>{{$period->description}}</td>
                                            <td>{{$period->price}}</td>
                                            <td>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#updateModal{{$period->id}}">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="updateModal{{$period->id}}" tabindex="-1">
                                            <div class="modal-dialog">
                                              <div class="modal-content">
                                                <form method="POST" action="{{route('admin-update-period')}}">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Add a Period</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="period_id" value="{{$period->id}}" class="form-control" required>
                                                        <div class="row mb-3">
                                                            <label for="inputText" class="col-sm-2 col-form-label">Length</label>
                                                            <div class="col-sm-10">
                                                                <input type="number" name="length" value="{{$period->length}}" class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="inputText" class="col-sm-2 col-form-label">Description</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" name="description" value="{{$period->description}}" class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="inputText" class="col-sm-2 col-form-label">Price</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" name="price" value="{{$period->price}}" class="form-control" required>
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
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="basicModal" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <form method="POST" action="{{route('admin-add-period')}}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add a Period</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-2 col-form-label">Length</label>
                        <div class="col-sm-10">
                            <input type="number" name="length" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10">
                            <input type="text" name="description" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-2 col-form-label">Price</label>
                        <div class="col-sm-10">
                            <input type="text" name="price" class="form-control" required>
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
</x-app-layout>
