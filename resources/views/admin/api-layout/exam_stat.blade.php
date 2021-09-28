<div class='row'>
    <div class='col-md-12'>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>
                        S.No
                    </th>
                    <th>Question</th>
                    <th>Total Submitted</th>
                    <th>Total Right Answer</th>
                    <th>Total Wrong Answer</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($collection->questions as $question)
                    <tr>
                        <td> {{ $loop->index+1 }} </td>
                        <td> {!! $question->question_title !!} </td>
                        <td> {{ $question->total_submit->count() }}</td>
                        <td>
                            {{ $question->right_answer->count() }}
                        </td>
                        <td>{{ $question->wrong_answer->count() }}</td>

                    </tr> 
                @endforeach
            </tbody>
        </table>
    </div>
</div>