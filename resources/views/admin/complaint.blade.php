<x-app-layout>
    <div class="pagetitle">
        <h1>Complaints</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Complaints</li>
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
                        <h2 class="card-title">Complaints</h2>
                        @foreach ($complaints as $complaint)
                            <div class="alert alert-primary fade show" role="alert">
                                <h4 class="alert-heading">{{\App\Models\User::find($complaint->user_id)->name}}</h4>
                                <p>{{$complaint->message}}</p>
                                <hr>
                                <p class="mb-0">{{$complaint->created_at->diffForHumans()}}</p>
                            </div>
                        @endforeach
                        @if ($complaints->isEmpty())
                            <div class="alert alert-warning" role="alert">
                                There are no complaints at the moment!
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
