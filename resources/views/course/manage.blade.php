@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-1">
                <a href="{{ url('/course/create') }}"><button class="btn btn-success" type="button">新增課程</button></a>
            </div>
        </div>
        <div class="row">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>編號</th>
                    <th>名稱</th>
                    <th>開課日期</th>
                    <th>結束日期</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($courses as $course)
                    <tr>
                        <td>{{ $course->serial }}</td>
                        <td>{{ $course->name }}</td>
                        <td>{{ $course->start_at }}</td>
                        <td>{{ $course->end_at }}</td>
                        <td>
                            <a href="{{ url('/course/edit/'.$course->id) }}"><button class="btn btn-info" type="button">編輯</button></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection