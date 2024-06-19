<x-app-layout>
    <div class="pagetitle">
        <h1>Park Officers</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Park Officers</li>
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
                        <h2 class="card-title">Park Officers</h2>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="justify-right" style="justify-content: right;">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTask">
                                        <i class="bi bi-plus"></i>
                                        New
                                    </button>
                                </div>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Officer</th>
                                            <th>Task</th>
                                            <th>Date</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $count = 0;
                                        @endphp
                                        @foreach ($tasks as $task)
                                            @php
                                                $count++;
                                            @endphp
                                            <tr>
                                                <td>{{$count}}</td>
                                                <td>{{\App\Models\User::find($task->user_id)->name}}</td>
                                                <td>{{$task->message}}</td>
                                                <td>{{$task->created_at}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="addTask" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <form method="POST" action="{{route('admin-add-task')}}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-3 col-form-label">Officer </label>
                        <div class="col-sm-9">
                            <select name="user_id" class="form-control" required>
                                <option selected disabled>Select Park Officer</option>
                                @foreach ($roles as $officer)
                                    <option value="{{$officer->user_id}}">{{\App\Models\User::find($officer->user_id)->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-3 col-form-label">Task: </label>
                        <div class="col-sm-9">
                            <input type="text" name="message" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Assign task</button>
                </div>
            </form>
          </div>
        </div>
    </div>

</x-app-layout>
