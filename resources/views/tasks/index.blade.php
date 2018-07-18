@extends('layouts.app')


@section('content')
<div class="row">
        <!-- Display Validation Errors -->

        <div class="error_section">
            @include('common.errors')
        </div>
        <!-- Current Tasks -->
        @if ($tasks)
            <table class="table table-striped task_table">
                <thead>
                    <tr>
                        <th class="text-truncate">Task Name</th>
                        <th class="">Due Date</th> 
                        <th class="btn_add_th">
                            <!-- Button trigger modal - placed at the bottom of the page -->
                            <button type="button" class="btn btn-success" id="add_task_btn" data-toggle="modal" data-target="#add_task_modal">
                                <i class="fas fa-plus"></i>
                            </button>
                        </th>
                    </tr>
                </thead>
                <!-- Table Body -->
                <tbody>
                    @foreach ($tasks as $task)
                    <tr>
                        <!-- Task Name -->
                        <td class="text-truncate data" id="td-task-name-{{$task->id}}" value="{{ $task->task_name }}">
                            {{ $task->task_name }}
                        </td>
                        <td class="data" id="td-task-due-date-{{$task->id}}" value="{{ $task->due_date }}">
                            {{ $task->due_date }}
                        </td>
                        <!-- Delete Button -->
                        <td class="">
                            <button type="button" id="detele-task-{{ $task->id }}" class="btn btn-danger">
                                <i class="far fa-trash-alt"></i>
                            </button>
                            <button type="button" id="edit-task-{{ $task->id }}" data-target="#add_task_modal" class="btn btn-info" data-toggle="modal">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>                            
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            </br>
            <strong class="custom_strong">No Tasks Yet.</strong>
            <table class="table table-striped task_table">
                <thead>
                    <tr class="">
                        <th class="">Task Name</th>
                        <th class="">Due Date</th> 
                        <th class="">
                            <!-- Button trigger modal - placed at the bottom of the page -->
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add_task_modal">
                                <i class="fas fa-plus"></i>
                            </button>
                        </th>
                    </tr>
                </thead>
                <!-- Table Body -->
                <tbody>
            </table>
            @endif
    <!--end of col-8-->
</div>
<!--end of row-->


<!-- Modal for adding new tasks-->
<div class="modal fade" id="add_task_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_heading">Create new task here</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- New Task Form -->
                {{ csrf_field() }}

                <!-- Task Name -->
                <div class="form-group">
                    <input type="text" name="task_name" id="task_name" class="form-control" placeholder="enter new task here">  
                </div>
                <div class="form-group">
                    <input type="date" name="due_date" id="due_date" class="form-control">
                </div>
                <input type="text" hidden="true" name="task_id" id="task_id" class="form-control" value="">
                <!-- Add Task Button -->
                <button type="button" id='submit_task_btn' class="btn btn-default">
                    <i class="fas fa-plus"></i> Add Task
                </button>
                <button type="button" id='edit_task_btn' class="btn btn-default">
                    <i class="fas fa-check"></i> Edit Task
                </button>
                <button type="button" id='btn_today' class="btn btn-default" value="">
                    <i class="far fa-calendar-alt"></i> Today
                </button>              
            </div>
        </div>
    </div>
</div>
<!--end of Modal -->

@section('javascript')
<script type="text/javascript" src="{{ URL::asset('js/todo_js_crud.js') }}"></script>
@endsection
@endsection
