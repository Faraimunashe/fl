<x-app-layout>
    <div class="pagetitle">
        <h1>Permit Application</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Application</li>
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
                        <h2 class="card-title">Permit Application</h2>
                            <form action="{{route('user-apply')}}" method="POST">
                                @csrf
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
                                    <label for="inputText" class="col-sm-3 col-form-label">Ecocash/Onemoney: </label>
                                    <div class="col-sm-9">
                                        <input type="tel" name="phone" class="form-control" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputText" class="col-sm-3 col-form-label">Transaction Email: </label>
                                    <div class="col-sm-9">
                                        <input type="email" name="email" class="form-control" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputText" class="col-sm-3"></label>
                                    <div class="col-sm-9">
                                        <button class="btn btn-primary" type="submit" style="float: right">Proceed to payment</button>
                                    </div>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
