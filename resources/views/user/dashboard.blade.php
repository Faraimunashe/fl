<x-app-layout>
    <div class="pagetitle">
        <h1>Permit</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Permit</li>
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
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Personal Details</h2>
                        <div class="row">
                            <div class="col-lg-2">
                                <div class="invoice-logo">
                                    @php
                                        $img = \App\Models\Image::where('user_id', Auth::id())->first();
                                    @endphp
                                    @if (is_null($img))
                                        <img width="100" src="{{asset('images/user.png')}}" alt="Invoice logo">
                                    @else
                                        <img width="150" height="180" src="{{asset('images')}}/{{$img->image}}" alt="Invoice logo" class="rounded">
                                    @endif
                                </div>
                                @if (is_null($img))
                                    <a href="#" class="text-sm" style="font-size: 11px" data-bs-toggle="modal" data-bs-target="#uploadImage">
                                        Upload image
                                    </a>
                                @else
                                    <a href="#" class="text-sm" style="font-size: 11px" data-bs-toggle="modal" data-bs-target="#uploadImage">
                                        Change image
                                    </a>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <table class="table table-bordered table-striped">
                                        <tr>
                                            <th>Full Name : </th>
                                            <td>{{$acc->fname}} {{$acc->lname}}</td>
                                        </tr>
                                        <tr>
                                            <th>National ID : </th>
                                            <td>{{$acc->natid}}</td>
                                        </tr>
                                        <tr>
                                            <th>Gender : </th>
                                            <td>{{$acc->sex}}</td>
                                        </tr>
                                        <tr>
                                            <th>Phone : </th>
                                            <td>{{$acc->phone}}</td>
                                        </tr>
                                        <tr>
                                            <th>Address : </th>
                                            <td>{{$acc->address}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-4">
                                @if (is_null($permit))
                                    @if (!is_null($application))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            Your application is being processed wait a bit!
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @else
                                        <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                            You don't have a permit, apply for one!
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endif
                                @else
                                    <div class="card-title">
                                        Permit Details
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 label ">Reference:</div>
                                        <div class="col-md-8">{{$permit->reference}}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 label ">Status:</div>
                                        <div class="col-md-8">
                                            @if (!$permit->valid)
                                                <span class="badge bg-danger">Invalid</span>
                                            @else
                                                <span class="badge bg-success">Valid</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 label ">Expiry:</div>
                                        <div class="col-md-8">
                                            @if (strtotime($permit->expiry_date) < time())
                                                <span class="badge bg-danger">{{$permit->expiry_date}}</span>
                                            @else
                                                <span class="badge bg-success">{{$permit->expiry_date}}</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-12">
                                @if (is_null($permit))
                                    <a href="{{route('user-application')}}" class="btn btn-primary m-2" style="float: right">
                                        <i class="bi bi-file"></i>
                                        Apply for permit
                                    </a>
                                @else
                                    @if (strtotime($permit->expiry_date) < time())
                                        <a href="#" class="btn btn-success m-2" style="float: right" data-bs-toggle="modal" data-bs-target="#uploadExtend">
                                            <i class="bi bi-arrow-clockwise"></i>
                                            Renew
                                        </a>
                                    @else
                                        <a href="#" class="btn btn-dark m-2" style="float: right">
                                            <i class="bi bi-arrow-clockwise"></i>
                                            Extend
                                        </a>

                                        <a href="{{route('user-download-img')}}" target="_blank" class="btn btn-secondary m-2" style="float: right">
                                            <i class="bi bi-printer"></i>
                                            Print
                                        </a>
                                    @endif

                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="uploadImage" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <form method="POST" action="{{route('user-upload-image')}}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Upload Profile Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-2 col-form-label">Image</label>
                        <div class="col-sm-10">
                            <input type="file" name="image" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Upload image</button>
                </div>
            </form>
          </div>
        </div>
    </div>

    <div class="modal fade" id="uploadExtend" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <form method="POST" action="{{route('user-extend-permit')}}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Extend Permit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-3 col-form-label">Valid for: </label>
                        <div class="col-sm-9">
                            <select name="renewal" class="form-control" required>
                                <option selected disabled>Select Option</option>
                                @foreach (\App\Models\Renewal::all() as $opt)
                                    <option value="{{$opt->id}}">{{$opt->description}} - ${{$opt->price}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-3 col-form-label">Ecocash: </label>
                        <div class="col-sm-9">
                            <input type="tel" name="phone" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-3 col-form-label">Email: </label>
                        <div class="col-sm-9">
                            <input type="email" name="email" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Upload image</button>
                </div>
            </form>
          </div>
        </div>
    </div>

</x-app-layout>
