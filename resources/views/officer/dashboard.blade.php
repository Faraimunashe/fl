<x-app-layout>
    <div class="pagetitle">
        <h1>Assigned</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Assigned</li>
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
                        <h2 class="card-title">Task</h2>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Task</th>
                                            <th>Date</th>
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
                                                <td>{{$task->message}}</td>
                                                <td>{{$task->created_at}}</td>
                                                <td>
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateTask{{$task->id}}">
                                                        Update
                                                    </button>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="updateTask{{$task->id}}" tabindex="-1">
                                                <div class="modal-dialog">
                                                  <div class="modal-content">
                                                    <form method="POST" action="{{route('officer-update-task')}}">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Update Task</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="task_id" value="{{$task->id}}" required>
                                                            <div class="row mb-3">
                                                                <label for="inputText" class="col-sm-3 col-form-label">Officer </label>
                                                                <div class="col-sm-9">
                                                                    <select name="status" class="form-control" required>
                                                                        <option value="1">Done</option>
                                                                        <option value="0">Pending</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Update task</button>
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
        </div>
    </section>



</x-app-layout>
