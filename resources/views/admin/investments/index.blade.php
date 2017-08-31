@extends('layouts.admin')

@section('content')
    <div class="widget">
        <div class="widget-head">
            <div class="clearfix">
                <h1>需求</h1>
            </div>
        </div>
        <div class="widget-content">
            <div class="table-responsive">
                <table class="table table-stripped table-bordered">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>投资需求</th>
                        <th>项目类型</th>
                        <th>回报需求</th>
                        <th>上线时间段</th>
                        <th>资金预算</th>
                        <th>相似匹配</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($clients as $client)
                        <tr>
                            <td>{{ $client->id }}</td>
                            <td>{{ $client->invest_types}}</td>
                            <td>{{ $client->movie_types}}</td>
                            <td>{{ $client->reward_types}}</td>
                            <td>
                                <p>开始时间: {{ $client->start_date->toDateString() }}</p>
                                <p>结束时间: {{ $client->end_date->toDateString() }}</p>
                            </td>
                            <td>
                                <p>下限: {{ $client->budget_bottom}} (元)</p>
                                <p>上限: {{ $client->budget_top}} (元)</p>
                            </td>
                            <td>
                                <div class="table-responsive">
                                    <table class="table table-stripped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>投资需求相似度</th>
                                            <th>项目类型相似度</th>
                                            <th>汇报需求相似度</th>
                                            <th>上线时间相似度</th>
                                            <th>预算相似度</th>
                                            <th>总相似度</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($client['movies_data'] as $movieData)
                                            <tr>
                                                <td>{{ ($movieData['movie']->id) }}</td>
                                                <td>{{ $movieData['invest_similarity'] }}</td>
                                                <td>{{ $movieData['movie_similarity'] }}</td>
                                                <td>{{ $movieData['reward_similarity'] }}</td>
                                                <td>{{ $movieData['date_similarity'] }}</td>
                                                <td>{{ $movieData['budget_similarity'] }}</td>
                                                <td>{{ $movieData['total_similarity'] }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $clients->links() }}
            </div>
        </div>
    </div>
@endsection
