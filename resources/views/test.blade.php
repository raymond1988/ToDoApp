@extends('layouts.app')

@section('stylesheets')
<style>
    .custom_form{
        padding: 2%;
    }

    .delete_form{
        margin-bottom: 0%;
        margin-top: 0%;
    }

    .table td{
        vertical-align: middle;
        padding-top: 3px;
        padding-bottom: 3px;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-2">

    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <strong>Dashboard</strong>
            </div>
            <div class="card-body">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif

                You are logged in !
            </div>
        </div>
        </br>
        <div class="card">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
                <i class="fas fa-plus"></i>
            </button>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create new task here</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- New Task Form -->
                        <form action="{{ url('task') }}" method="POST" class="custom_form">
                            {{ csrf_field() }}

                            <!-- Task Name -->
                            <div class="form-group">
                                <input type="text" name="task_name" id="task_name" class="form-control" placeholder="enter new task here">  
                            </div>
                            <div class="form-group">
                                <input type="date" name="due_date" id="due_date" class="form-control">
                            </div>
                            <!-- Add Task Button -->
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-plus"></i> Add Task
                            </button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Display Validation Errors -->

        <div class="error_section">
            @include('common.errors')
        </div>
        </br>
        <!-- Current Tasks -->
        @if (!($tasks)->isEmpty())
        @if (count($tasks) > 0)
        <div class="card">
            <table class="table table-striped task_table">
                <thead>
                    <tr>
                        <th>Task Name</th>
                        <th>Due Date</th> 
                        <th>Action</th>
                    </tr>
                </thead>
                <!-- Table Body -->
                <tbody>
                    @foreach ($tasks as $task)
                    <tr>
                        <!-- Task Name -->
                        <td>
                            <div>{{ $task->task_name }}</div>
                        </td>
                        <td>
                            <div>{{ $task->due_date }}</div>
                        </td>
                        <!-- Delete Button -->
                        <td>
                            <form action="{{ url('task/'.$task->id) }}" method="POST" class="form delete_form">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <button type="submit" id="delete-task-{{ $task->id }}" class="btn btn-danger">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>                            
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
        @else
        </br>
        <div class="card">
            <div class="card-header">
                <strong>No Tasks Yet.</strong>
            </div>
        </div>
        @endif
    </div>
    <!--end of col-8-->
</div>
<!--end of row-->
<div class="col-md-2"></div>
</div>
@endsection
